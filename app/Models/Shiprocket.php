<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Shiprocket extends Model
{
    protected $table = 'shiprockets';

    protected $fillable = [
        'email',
        'password',
        'token',
        'token_expires_at',
        'channel_id',
        'pickup_location',
        'pincode',
        'company_name',
        'phone',
        'status',
        'is_sandbox',
        'api_base_url',
        'last_connected_at',
    ];

    protected $casts = [
        'token_expires_at' => 'datetime',
        'last_connected_at' => 'datetime',
        'status' => 'boolean',
        'is_sandbox' => 'boolean',
    ];

    protected $hidden = [
        'password',
        'token',
    ];

    /**
     * Authenticate with Shiprocket API and retrieve auth token.
     *
     * @return array ['success' => bool, 'message' => string, 'data' => mixed]
     */
    public function authenticateApi(): array
    {
        if (empty($this->email) || empty($this->password)) {
            return [
                'success' => false,
                'message' => 'Shiprocket account email and password are required for authentication.',
            ];
        }

        $baseUrl = rtrim($this->api_base_url ?: 'https://apiv2.shiprocket.in/v1/external', '/');
        $endpoint = $baseUrl . '/auth/login';

        try {
            $response = Http::acceptJson()
                ->post($endpoint, [
                    'email' => $this->email,
                    'password' => $this->password,
                ]);

            if ($response->successful()) {
                $responseData = $response->json();
                $token = $responseData['token'] ?? null;

                if ($token) {
                    $this->token = $token;
                    // Token is typically valid for 10 days
                    $this->token_expires_at = Carbon::now()->addDays(10);
                    $this->last_connected_at = Carbon::now();

                    if (isset($responseData['company_name']) && empty($this->company_name)) {
                        $this->company_name = $responseData['company_name'];
                    }

                    $this->save();

                    return [
                        'success' => true,
                        'message' => 'Successfully authenticated with Shiprocket API.',
                        'data' => $responseData,
                    ];
                }

                return [
                    'success' => false,
                    'message' => 'Authentication token was not returned by Shiprocket API.',
                    'data' => $responseData,
                ];
            }

            $errorMessage = $response->json('message') ?? $response->json('error') ?? $response->body() ?? 'Failed to authenticate with Shiprocket API.';

            return [
                'success' => false,
                'message' => 'Shiprocket API Error: ' . (is_string($errorMessage) ? $errorMessage : json_encode($errorMessage)),
            ];
        } catch (\Exception $e) {
            Log::error('Shiprocket Auth Error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Connection Exception: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Check if current stored token is valid.
     */
    public function isTokenValid(): bool
    {
        return !empty($this->token) && ($this->token_expires_at === null || $this->token_expires_at->isFuture());
    }

    /**
     * Get valid API token, automatically re-authenticating if expired or missing.
     */
    public function getValidToken(): ?string
    {
        if ($this->isTokenValid()) {
            return $this->token;
        }

        $result = $this->authenticateApi();

        if ($result['success']) {
            return $this->token;
        }

        return null;
    }

    /**
     * Fetch registered pickup locations from Shiprocket API.
     *
     * @return array
     */
    public function getPickupLocations(): array
    {
        $token = $this->getValidToken();

        if (!$token) {
            return [
                'success' => false,
                'message' => 'Unable to obtain a valid Shiprocket authentication token.',
                'locations' => [],
            ];
        }

        $baseUrl = rtrim($this->api_base_url ?: 'https://apiv2.shiprocket.in/v1/external', '/');
        $endpoint = $baseUrl . '/settings/company/pickup';

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->get($endpoint);

            if ($response->successful()) {
                $data = $response->json();
                $shippingAddresses = $data['data']['shipping_address'] ?? [];

                return [
                    'success' => true,
                    'locations' => $shippingAddresses,
                ];
            }

            return [
                'success' => false,
                'message' => $response->json('message') ?? 'Failed to fetch pickup locations from Shiprocket.',
                'locations' => [],
            ];
        } catch (\Exception $e) {
            Log::error('Shiprocket Fetch Pickup Locations Error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => $e->getMessage(),
                'locations' => [],
            ];
        }
    }

    /**
     * Fetch list of couriers with counts from Shiprocket API.
     *
     * Endpoint: /v1/external/courier/courierListWithCounts
     *
     * @return array ['success' => bool, 'message' => string, 'couriers' => array, 'raw_data' => mixed]
     */
    public function getCourierList(): array
    {
        $token = $this->getValidToken();

        if (!$token) {
            return [
                'success' => false,
                'message' => 'Unable to obtain a valid Shiprocket authentication token.',
                'couriers' => [],
            ];
        }

        $baseUrl = rtrim($this->api_base_url ?: 'https://apiv2.shiprocket.in/v1/external', '/');
        $endpoint = $baseUrl . '/courier/courierListWithCounts';

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->get($endpoint);

            if ($response->successful()) {
                $data = $response->json();

                // Extract courier data from response payload structure
                $couriers = $data['courier_data'] ?? ($data['data'] ?? ($data['couriers'] ?? $data));

                return [
                    'success' => true,
                    'message' => 'Courier list retrieved successfully.',
                    'couriers' => is_array($couriers) ? $couriers : [],
                    'raw_data' => $data,
                ];
            }

            $errorMessage = $response->json('message') ?? $response->json('error') ?? 'Failed to fetch courier list from Shiprocket.';

            return [
                'success' => false,
                'message' => 'Shiprocket API Error: ' . (is_string($errorMessage) ? $errorMessage : json_encode($errorMessage)),
                'couriers' => [],
            ];
        } catch (\Exception $e) {
            Log::error('Shiprocket Fetch Courier List Error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Connection Exception: ' . $e->getMessage(),
                'couriers' => [],
            ];
        }
    }

    /**
     * Check Courier Serviceability from Shiprocket API.
     *
     * Endpoint: /v1/external/courier/serviceability/
     *
     * @param array $params ['pickup_postcode', 'delivery_postcode', 'weight', 'cod', 'declared_items_value', 'is_return']
     * @return array ['success' => bool, 'message' => string, 'available_couriers' => array, 'recommended_courier_id' => mixed, 'raw_data' => mixed]
     */
    public function checkServiceability(array $params): array
    {
        $token = $this->getValidToken();

        if (!$token) {
            return [
                'success' => false,
                'message' => 'Unable to obtain a valid Shiprocket authentication token.',
                'available_couriers' => [],
            ];
        }

        $baseUrl = rtrim($this->api_base_url ?: 'https://apiv2.shiprocket.in/v1/external', '/');
        $endpoint = $baseUrl . '/courier/serviceability/';

        $queryParams = [
            'pickup_postcode' => $params['pickup_postcode'] ?? ($this->pincode ?? ''),
            'delivery_postcode' => $params['delivery_postcode'] ?? '',
            'weight' => $params['weight'] ?? 0.5,
            'cod' => isset($params['cod']) ? (int) $params['cod'] : 0,
        ];

        if (isset($params['declared_items_value']) && $params['declared_items_value'] !== '') {
            $queryParams['declared_items_value'] = $params['declared_items_value'];
        }

        if (isset($params['is_return'])) {
            $queryParams['is_return'] = (int) $params['is_return'];
        }

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->get($endpoint, $queryParams);

            if ($response->successful()) {
                $data = $response->json();
                $couriers = $data['data']['available_courier_companies'] ?? ($data['available_courier_companies'] ?? []);
                $recommendation = $data['data']['recommended_courier_company_id'] ?? ($data['recommended_courier_company_id'] ?? null);

                return [
                    'success' => true,
                    'message' => 'Courier serviceability retrieved successfully.',
                    'available_couriers' => is_array($couriers) ? $couriers : [],
                    'recommended_courier_id' => $recommendation,
                    'raw_data' => $data,
                ];
            }

            $errorMessage = $response->json('message') ?? $response->json('error') ?? $response->body() ?? 'Failed to check courier serviceability.';

            return [
                'success' => false,
                'message' => 'Shiprocket API Error: ' . (is_string($errorMessage) ? $errorMessage : json_encode($errorMessage)),
                'available_couriers' => [],
            ];
        } catch (\Exception $e) {
            Log::error('Shiprocket Courier Serviceability Error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Connection Exception: ' . $e->getMessage(),
                'available_couriers' => [],
            ];
        }
    }
}
