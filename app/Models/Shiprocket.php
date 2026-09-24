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

    /**
     * Create an Order in Shiprocket.
     *
     * Endpoints:
     * - Custom / Adhoc: /v1/external/orders/create/adhoc
     * - Channel Specific: /v1/external/orders/create
     *
     * @param \App\Models\Order $order
     * @param array $packageData ['length', 'breadth', 'height', 'weight', 'pickup_location']
     * @return array ['success' => bool, 'message' => string, 'order_id' => string, 'shipment_id' => string, 'awb_code' => string, 'raw_data' => mixed]
     */
    public function createOrder(\App\Models\Order $order, array $packageData = []): array
    {
        $token = $this->getValidToken();

        if (!$token) {
            return [
                'success' => false,
                'message' => 'Unable to obtain a valid Shiprocket authentication token.',
            ];
        }

        $address = $order->address;
        $customer = $order->customer;

        // Extract customer name
        $fullName = trim($customer->full_name ?? ($address->name ?? 'Customer'));
        $nameParts = explode(' ', $fullName, 2);
        $firstName = $nameParts[0] ?? 'Customer';
        $lastName = $nameParts[1] ?? 'User';

        $billingAddress = $address->address_line1 ?? ($address->address ?? 'Main Street');
        $billingAddress2 = $address->address_line2 ?? '';
        $billingCity = $address->city ?? 'City';
        $billingState = $address->state ?? 'State';
        $billingPincode = (int) preg_replace('/[^0-9]/', '', $address->postal_code ?? '110001');
        $billingCountry = $address->country ?? 'India';
        $billingEmail = $customer->email ?? ($order->email ?? 'customer@example.com');
        $billingPhone = preg_replace('/[^0-9]/', '', $customer->phone ?? ($address->phone ?? '9876543210'));
        if (strlen($billingPhone) > 10) {
            $billingPhone = substr($billingPhone, -10);
        }

        // Determine Payment Method
        $paymentMethod = strtolower($order->payment_method) === 'cod' ? 'COD' : 'Prepaid';

        // Format order items
        $orderItems = [];
        foreach ($order->items as $item) {
            $orderItems[] = [
                'name' => $item->title ?? 'Product Item',
                'sku' => 'PROD-' . ($item->product_id ?? $item->id),
                'units' => (int) $item->quantity,
                'selling_price' => (float) $item->price,
                'discount' => 0,
                'tax' => 0,
                'hsn' => 441122,
            ];
        }

        if (empty($orderItems)) {
            $orderItems[] = [
                'name' => 'Store Product',
                'sku' => 'SKU-' . $order->id,
                'units' => 1,
                'selling_price' => (float) $order->total,
                'discount' => 0,
                'tax' => 0,
                'hsn' => 441122,
            ];
        }

        $pickupLoc = !empty($packageData['pickup_location']) ? $packageData['pickup_location'] : ($this->pickup_location ?: 'Primary');

        $payload = [
            'order_id' => (string) $order->order_number,
            'order_date' => $order->created_at ? $order->created_at->format('Y-m-d H:i') : date('Y-m-d H:i'),
            'pickup_location' => $pickupLoc,
            'comment' => 'Order shipped via Painrelief Admin Panel',
            'billing_customer_name' => $firstName,
            'billing_last_name' => $lastName,
            'billing_address' => $billingAddress,
            'billing_address_2' => $billingAddress2,
            'billing_city' => $billingCity,
            'billing_pincode' => $billingPincode,
            'billing_state' => $billingState,
            'billing_country' => $billingCountry,
            'billing_email' => $billingEmail,
            'billing_phone' => $billingPhone,
            'shipping_is_billing' => true,
            'order_items' => $orderItems,
            'payment_method' => $paymentMethod,
            'shipping_charges' => (float) $order->shipping,
            'giftwrap_charges' => 0,
            'transaction_charges' => 0,
            'total_discount' => 0,
            'sub_total' => (float) $order->subtotal,
            'length' => (float) ($packageData['length'] ?? 10),
            'breadth' => (float) ($packageData['breadth'] ?? 10),
            'height' => (float) ($packageData['height'] ?? 10),
            'weight' => (float) ($packageData['weight'] ?? 0.5),
        ];

        // If channel_id is specified in Shiprocket profile, add it to payload
        if (!empty($this->channel_id)) {
            $payload['channel_id'] = (string) $this->channel_id;
        }

        $baseUrl = rtrim($this->api_base_url ?: 'https://apiv2.shiprocket.in/v1/external', '/');
        // Choose endpoint: channel specific or adhoc custom order creation
        $endpoint = !empty($this->channel_id) ? $baseUrl . '/orders/create' : $baseUrl . '/orders/create/adhoc';

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->post($endpoint, $payload);

            if ($response->successful()) {
                $data = $response->json();
                $srOrderId = (string) ($data['order_id'] ?? ($data['data']['order_id'] ?? $order->order_number));
                $srShipmentId = (string) ($data['shipment_id'] ?? ($data['data']['shipment_id'] ?? ''));
                $awbCode = (string) ($data['awb_code'] ?? ($data['data']['awb_code'] ?? ''));
                $courierName = (string) ($data['courier_name'] ?? ($data['data']['courier_name'] ?? 'Shiprocket Courier'));
                $status = (string) ($data['status'] ?? 'SHIPPED');
                $trackingUrl = (string) ($data['tracking_url'] ?? '');

                // Update Local Order Model
                $order->update([
                    'shiprocket_order_id' => $srOrderId,
                    'shiprocket_shipment_id' => $srShipmentId,
                    'shiprocket_awb_code' => $awbCode,
                    'shiprocket_courier_name' => $courierName,
                    'shiprocket_status' => $status,
                    'shiprocket_tracking_url' => $trackingUrl,
                    'status' => 'shipped',
                    'shipped_at' => Carbon::now(),
                ]);

                return [
                    'success' => true,
                    'message' => 'Order successfully shipped and created in Shiprocket.',
                    'order_id' => $srOrderId,
                    'shipment_id' => $srShipmentId,
                    'awb_code' => $awbCode,
                    'courier_name' => $courierName,
                    'raw_data' => $data,
                ];
            }

            $errorMessage = $response->json('message') ?? $response->json('error') ?? $response->body() ?? 'Failed to create order on Shiprocket.';

            return [
                'success' => false,
                'message' => 'Shiprocket API Error: ' . (is_string($errorMessage) ? $errorMessage : json_encode($errorMessage)),
                'raw_data' => $response->json(),
            ];
        } catch (\Exception $e) {
            Log::error('Shiprocket Order Creation Error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Connection Exception: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Track Order / Shipment status from Shiprocket API.
     *
     * @param string|int $orderIdOrShipmentId
     * @return array ['success' => bool, 'message' => string, 'shipment_track' => array, 'raw_data' => mixed]
     */
    public function trackShipment($orderIdOrShipmentId): array
    {
        $token = $this->getValidToken();

        if (!$token) {
            return [
                'success' => false,
                'message' => 'Unable to obtain a valid Shiprocket authentication token.',
            ];
        }

        $baseUrl = rtrim($this->api_base_url ?: 'https://apiv2.shiprocket.in/v1/external', '/');
        // Shiprocket tracking endpoint: /courier/track/shipment/{shipment_id} or /orders/show/{order_id}
        $endpoint = $baseUrl . '/courier/track/shipment/' . $orderIdOrShipmentId;

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->get($endpoint);

            if ($response->successful()) {
                $data = $response->json();
                $trackingData = $data['tracking_data'] ?? ($data['data'] ?? $data);

                return [
                    'success' => true,
                    'message' => 'Tracking information fetched successfully.',
                    'tracking_data' => $trackingData,
                    'raw_data' => $data,
                ];
            }

            // Fallback to order show endpoint
            $showEndpoint = $baseUrl . '/orders/show/' . $orderIdOrShipmentId;
            $showResponse = Http::withToken($token)->acceptJson()->get($showEndpoint);

            if ($showResponse->successful()) {
                $showData = $showResponse->json();

                return [
                    'success' => true,
                    'message' => 'Order details retrieved.',
                    'tracking_data' => $showData['data'] ?? $showData,
                    'raw_data' => $showData,
                ];
            }

            return [
                'success' => false,
                'message' => 'Tracking data unavailable for ID: ' . $orderIdOrShipmentId,
            ];
        } catch (\Exception $e) {
            Log::error('Shiprocket Track Error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Connection Exception: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Cancel Order(s) in Shiprocket API.
     *
     * Endpoint: /v1/external/orders/cancel
     *
     * @param array|int|string $shiprocketOrderIds
     * @return array ['success' => bool, 'message' => string, 'raw_data' => mixed]
     */
    public function cancelOrder($shiprocketOrderIds): array
    {
        $token = $this->getValidToken();

        if (!$token) {
            return [
                'success' => false,
                'message' => 'Unable to obtain a valid Shiprocket authentication token.',
            ];
        }

        $ids = is_array($shiprocketOrderIds) ? $shiprocketOrderIds : [$shiprocketOrderIds];
        $baseUrl = rtrim($this->api_base_url ?: 'https://apiv2.shiprocket.in/v1/external', '/');
        $endpoint = $baseUrl . '/orders/cancel';

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->post($endpoint, [
                    'ids' => $ids,
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Order(s) cancelled successfully on Shiprocket.',
                    'raw_data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'message' => $response->json('message') ?? 'Failed to cancel order on Shiprocket.',
                'raw_data' => $response->json(),
            ];
        } catch (\Exception $e) {
            Log::error('Shiprocket Cancel Order Error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Update Pickup Location of created orders on Shiprocket API.
     *
     * Endpoint: PATCH /v1/external/orders/address/pickup
     */
    public function updateOrderPickupLocation($shiprocketOrderId, string $pickupLocation): array
    {
        $token = $this->getValidToken();

        if (!$token) {
            return [
                'success' => false,
                'message' => 'Unable to obtain a valid Shiprocket authentication token.',
            ];
        }

        $ids = is_array($shiprocketOrderId) ? $shiprocketOrderId : [$shiprocketOrderId];
        $baseUrl = rtrim($this->api_base_url ?: 'https://apiv2.shiprocket.in/v1/external', '/');
        $endpoint = $baseUrl . '/orders/address/pickup';

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->patch($endpoint, [
                    'order_id' => $ids,
                    'pickup_location' => $pickupLocation,
                ]);

            return [
                'success' => $response->successful(),
                'message' => $response->json('message') ?? ($response->successful() ? 'Pickup location updated.' : 'Failed to update pickup location.'),
                'raw_data' => $response->json(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Update Customer Delivery Address on Shiprocket API.
     *
     * Endpoint: POST /v1/external/orders/address/update
     */
    public function updateCustomerAddress($shiprocketOrderId, array $addressData): array
    {
        $token = $this->getValidToken();

        if (!$token) {
            return [
                'success' => false,
                'message' => 'Unable to obtain a valid Shiprocket authentication token.',
            ];
        }

        $baseUrl = rtrim($this->api_base_url ?: 'https://apiv2.shiprocket.in/v1/external', '/');
        $endpoint = $baseUrl . '/orders/address/update';

        $payload = array_merge([
            'order_id' => $shiprocketOrderId,
        ], $addressData);

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->post($endpoint, $payload);

            return [
                'success' => $response->successful(),
                'message' => $response->json('message') ?? ($response->successful() ? 'Delivery address updated on Shiprocket.' : 'Failed to update address.'),
                'raw_data' => $response->json(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
