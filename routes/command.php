<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


// Controllers
use App\Http\Controllers\DevController;

//===============================================================================//
//                                  Command Routes                                     //
//===============================================================================//
// This file contains routes for various Artisan commands.
// These routes are intended for development and debugging purposes only.
// They should not be used in production environments.
//===============================================================================//

Route::group(['middleware' => 'auth', 'prefix' => 'dev', 'as' => 'dev.'], function () {
    // Generate a new migration for the session table
    Route::get('/generate-session-table', function () {
        Artisan::call('session:table');
        return "Session table migration generated!";
    })->name('generate-session-table');

    // seed specific class name data
    Route::get('/seed-data/{data}', function ($data) {
        Artisan::call('db:seed', ['--class' => $data, '--force' => true]);
        return "Seeders have been run!";
    })->name('seed-data');

    // Migration command
    Route::get('/run-migrations', function () {
        Artisan::call('migrate', ["--force" => true]);
        return "Migrations have been run!";
    })->name('run-migrations');

    // Clear application cache
    Route::get('/clear-cache', function () {
        Artisan::call('cache:clear');
        return "Application cache cleared!";
    })->name('clear-cache');

    // Clear route cache
    Route::get('/clear-route', function () {
        Artisan::call('route:clear');
        return "Route cache cleared!";
    })->name('clear-route');

    // Clear config cache
    Route::get('/clear-config', function () {
        Artisan::call('config:clear');
        return "Config cache cleared!";
    })->name('clear-config');

    // Clear view cache
    Route::get('/clear-view', function () {
        Artisan::call('view:clear');
        return "View cache cleared!";
    })->name('clear-view');

    // Optimize the application
    Route::get('/optimize', function () {
        Artisan::call('optimize');
        return "Application optimized!";
    })->name('optimize');

    // Fresh the database
    Route::get('/fresh-database', function () {
        Artisan::call('migrate:fresh', ["--force" => true]);
        return "Database has been refreshed!";
    })->name('fresh-database');

    // Rollback migrations
    Route::get('/rollback-migrations', function () {
        Artisan::call('migrate:rollback', ["--force" => true]);
        return "Migrations have been rolled back!";
    })->name('rollback-migrations');

    // Seed the database
    Route::get('/run-seeder', function () {
        Artisan::call('db:seed', ["--force" => true]);
        return "Database seeding completed!";
    })->name('run-seeder');

    // Run queue worker
    Route::get('/queue-work', function () {
        Artisan::call('queue:work', ["--daemon" => true]);
        return "Queue worker is now running!";
    })->name('queue-work');

    // Link storage
    Route::get('/storage-link', function () {
        Artisan::call('storage:link');
        return "Storage linked successfully!";
    })->name('storage-link');

    // Clear all caches (shortcut)
    Route::get('/clear-all', function () {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        return "All caches have been cleared!";
    })->name('clear-all');

    // Restart queue
    Route::get('/queue-restart', function () {
        Artisan::call('queue:restart');
        return "Queue restarted!";
    })->name('queue-restart');

    // Run the schedule
    Route::get('/schedule-run', function () {
        Artisan::call('schedule:run');
        return "Schedule executed!";
    })->name('schedule-run');


    Route::get('/download-log', function () {
        $logPath = storage_path('logs/laravel.log');

        if (File::exists($logPath)) {
            return Response::download($logPath, 'laravel.log', [
                'Content-Type' => 'text/plain',
            ]);
        }

        return response('Log file does not exist.', 404);
    })->name('download-log');


    Route::get('/clear-log-clean', function () {
        $logPath = storage_path('logs/laravel.log');

        if (File::exists($logPath)) {
            File::put($logPath, '');
            return 'Log file cleared!';
        }

        return 'Log file does not exist.';
    })->name('clear-log-clean');

    Route::get('/clear-log', function () {
        $logPath = storage_path('logs/laravel.log');

        if (File::exists($logPath)) {
            // Generate a new archive filename with timestamp
            $archiveName = 'laravel-' . date('Y-m-d_H-i-s') . '.log';
            $archivePath = storage_path('logs/' . $archiveName);

            // Rename (move) current log file
            File::move($logPath, $archivePath);

            // Create a new empty log file
            File::put($logPath, '');

            return "Log file archived as {$archiveName} and new log created!";
        }

        return 'Log file does not exist.';
    })->name('clear-log');


    Route::get('/download-and-clear-log', function () {
        // \Log::info("Testing log download and clear functionality");
        $logPath = storage_path('logs/laravel.log');

        if (File::exists($logPath)) {
            $logContent = File::get($logPath);

            // Clear log
            File::put($logPath, '');

            return response($logContent)
                ->header('Content-Type', 'text/plain')
                ->header('Content-Disposition', 'attachment; filename="laravel.log"');
        }

        return 'Log file does not exist.';
    })->name('download-and-clear-log');

    ROute::post('/new-env-key', [DevController::class, 'newEnvKey'])->name('new-env-key');
});
