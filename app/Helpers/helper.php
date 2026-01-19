<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Revolution\Google\Sheets\Facades\Sheets;
use Illuminate\Http\UploadedFile;


// Models
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;
use Nnjeim\World\Models\City;


if (!function_exists('normalizePhoneNumber')) {
    /**
     * Normalize a phone number to international format (E.164).
     *
     * @param string $phone
     * @param string $countryCode Default: '91' for India
     * @return string Normalized phone number (e.g., 919876543210)
     */
    function normalizePhoneNumber($phone, $countryCode = '91')
    {
        // Remove non-numeric characters
        $phone = preg_replace('/\D/', '', $phone);

        // if phone is greater then 10 digits then get only last 10 digits
        if (strlen($phone) > 10) {
            $phone = substr($phone, -10);
        }

        // If number starts with 0 or local, remove leading 0
        if (strlen($phone) === 10) {
            return $countryCode . $phone;
        }

        // If number starts with +91 or 91
        if (strpos($phone, $countryCode) === 0) {
            return $phone;
        }

        // Fallback
        return $countryCode . ltrim($phone, '0');
    }
}

if (!function_exists('handle_model_exception')) {
    /**
     * Handle exception and redirect with model-specific error message.
     *
     * @param \Throwable $th
     * @param string $modelClass
     * @param string|null $action (optional custom action, like "deleting", "updating")
     * @return \Illuminate\Http\RedirectResponse
     */
    function handle_model_exception(Throwable $th, string $modelClass, ?string $action = null)
    {
        Log::error($th);

        $modelName = class_basename($modelClass);  // e.g., 'Customer'
        $key = strtolower($modelName) . '_error';  // e.g., 'customer_error'

        $message = 'Something went wrong';
        if ($action) {
            $message .= " while {$action} {$modelName}";
        } else {
            $message .= " with {$modelName}";
        }

        return redirect()->back()->with($key, $message);
    }
}

/**
 * Set new env value
 */
if (!function_exists('setEnvValue')) {
    function setEnvValue($key, $value)
    {
        $envPath = base_path('.env');

        if (!File::exists($envPath)) {
            return false;
        }

        $escaped = preg_quote("{$key}=", '/');

        $envContents = File::get($envPath);

        // If key already exists, replace it
        if (preg_match("/^{$escaped}.*/m", $envContents)) {
            $envContents = preg_replace("/^{$escaped}.*/m", "{$key}=\"{$value}\"", $envContents);
        } else {
            // Append new key-value pair
            $envContents .= "\n{$key}=\"{$value}\"";
        }

        File::put($envPath, $envContents);

        return true;
    }
}

/**
 * Remove env key
 */
if (!function_exists('removeEnvKey')) {
    function removeEnvKey($key)
    {
        $envPath = base_path('.env');

        if (!File::exists($envPath)) {
            return false;
        }

        $envContents = File::get($envPath);

        // Remove the line with the given key
        $escaped = preg_quote("{$key}=", '/');
        $envContents = preg_replace("/^{$escaped}.*(\r?\n)?/m", '', $envContents);

        File::put($envPath, trim($envContents) . PHP_EOL); // Clean up and add trailing newline

        return true;
    }
}


/**
 * Upload a file to public folder
 */
function uploadFile($file, $path)
{
    // Ensure path ends with slash
    if (!str_ends_with($path, '/')) {
        $path .= '/';
    }

    // Create directory if not exists
    if (!file_exists(public_path($path))) {
        mkdir(public_path($path), 0777, true);
    }

    // Unique filename
    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

    // Move file
    $file->move(public_path($path), $fileName);

    // Return stored relative path
    return $path . $fileName;
}

/**
 * Upload image from url
 */
function uploadImageFromUrlV1($url, $path)
{
    // download image
    $contents = file_get_contents($url);

    // temporary file create
    $tmpFile = tempnam(sys_get_temp_dir(), 'img_');
    file_put_contents($tmpFile, $contents);

    // make UploadedFile object
    $uploadedFile = new UploadedFile(
        $tmpFile,
        basename($url),
        mime_content_type($tmpFile),
        null,
        true
    );

    // use your existing helper
    return uploadFile($uploadedFile, $path);
}

/**
 * Download image from a URL and upload using existing uploadFile() helper.
 * Returns stored relative path on success, or null on failure.
 *
 * Handles:
 * - cURL with timeout & retries
 * - mime type detection
 * - returns null if everything fails
 */
function uploadImageFromUrl($url, $path, $maxRetries = 2, $timeout = 10)
{
    // Basic validation
    if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
        return null;
    }

    $attempt = 0;
    $lastErr = null;
    $contents = false;

    while ($attempt <= $maxRetries) {
        $attempt++;

        // Initialize cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        // set a common browser UA to avoid some servers blocking
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; SeederBot/1.0)');
        // accept compressed responses
        curl_setopt($ch, CURLOPT_ENCODING, '');

        $data = curl_exec($ch);
        $errno = curl_errno($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($errno === 0 && $data !== false && $httpCode >= 200 && $httpCode < 300) {
            $contents = $data;
            $detectedMime = $contentType ?: null;
            break;
        }

        $lastErr = "attempt {$attempt} failed: errno={$errno}, http={$httpCode}, err=\"{$error}\"";
        // small backoff
        sleep(1);
    }

    if ($contents === false) {
        // All attempts failed
        Log::warning("uploadImageFromUrl: failed to download {$url}. last error: {$lastErr}");
        return null;
    }

    // create temporary file
    $tmpFile = tempnam(sys_get_temp_dir(), 'img_');
    if ($tmpFile === false) {
        return null;
    }

    file_put_contents($tmpFile, $contents);

    // try to detect extension from mime
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = $finfo ? finfo_file($finfo, $tmpFile) : null;
    if ($finfo) {
        finfo_close($finfo);
    }

    $extension = null;
    if ($mime) {
        $map = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/gif'  => 'gif',
            'image/webp' => 'webp',
        ];
        $extension = $map[$mime] ?? null;
    }

    // fallback extension if not detected
    if (!$extension) {
        // try to get from URL path
        $pathParts = pathinfo(parse_url($url, PHP_URL_PATH) ?? '');
        $extFromUrl = $pathParts['extension'] ?? null;
        $extension = $extFromUrl ?: 'jpg';
    }

    // build a filename
    $basename = time() . '_' . uniqid() . '.' . $extension;

    // Create a Symfony UploadedFile instance (last param $test = true for local files)
    try {
        $uploadedFile = new UploadedFile(
            $tmpFile,
            $basename,
            $mime ?: null,
            null,
            true
        );

        // call your existing uploadFile() helper which moves file to public path
        $storedPath = uploadFile($uploadedFile, $path);

        // cleanup temp file (uploadFile duplicates/moves it; ensure removal)
        if (file_exists($tmpFile)) {
            @unlink($tmpFile);
        }

        return $storedPath;
    } catch (\Exception $e) {
        Log::warning("uploadImageFromUrl: exception creating UploadedFile for {$url}. " . $e->getMessage());
        if (file_exists($tmpFile)) {
            @unlink($tmpFile);
        }
        return null;
    }
}


/**
 * Delete file
 */
function deleteFile($path)
{
    if (File::exists(public_path($path))) {
        File::delete(public_path($path));
    }
    // unlink(public_path($template->media_file));
}

/**
 * Get Day Suffix
 */
function getDaySuffix($day)
{
    $lastDigit = $day % 10;
    $lastTwoDigits = $day % 100;

    if ($lastTwoDigits >= 11 && $lastTwoDigits <= 13) {
        return 'th';
    }

    switch ($lastDigit) {
        case 1:
            return 'st';
        case 2:
            return 'nd';
        case 3:
            return 'rd';
        default:
            return 'th';
    }
}


/**
 * Write code on Method
 *
 * @return response()
 */

if (! function_exists('convertYmdToMdy')) {

    function convertYmdToMdy($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('m-d-Y');
    }
}


/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('convertMdyToYmd')) {

    function convertMdyToYmd($date)
    {
        return Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
    }
}
