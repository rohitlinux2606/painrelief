<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shiprocket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShiprocketController extends Controller
{
    /**
     * Display the Shiprocket configuration profile page.
     */
    public function index()
    {
        $shiprocket = Shiprocket::first() ?? new Shiprocket();
        $pickupLocations = [];
        $courierList = [];

        if ($shiprocket->exists && $shiprocket->isTokenValid()) {
            $locationsResult = $shiprocket->getPickupLocations();
            if ($locationsResult['success']) {
                $pickupLocations = $locationsResult['locations'];
            }

            $couriersResult = $shiprocket->getCourierList();
            if ($couriersResult['success']) {
                $courierList = $couriersResult['couriers'];
            }
        }

        return view('admin.pages.shiprocket.index', compact('shiprocket', 'pickupLocations', 'courierList'));
    }

    /**
     * Store or update the Shiprocket profile configuration.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'nullable|string',
            'channel_id' => 'nullable|string|max:100',
            'pickup_location' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'status' => 'nullable|boolean',
            'is_sandbox' => 'nullable|boolean',
            'api_base_url' => 'nullable|url|max:255',
        ]);

        try {
            $shiprocket = Shiprocket::first() ?? new Shiprocket();

            $data = $request->only([
                'email',
                'channel_id',
                'pickup_location',
                'pincode',
                'company_name',
                'phone',
                'api_base_url',
            ]);

            $data['status'] = $request->has('status') ? (bool) $request->input('status') : false;
            $data['is_sandbox'] = $request->has('is_sandbox') ? (bool) $request->input('is_sandbox') : false;
            $data['api_base_url'] = $request->input('api_base_url') ?: 'https://apiv2.shiprocket.in/v1/external';

            // Only update password if a new one was entered
            if ($request->filled('password')) {
                $data['password'] = $request->input('password');
            }

            $shiprocket->fill($data);
            $shiprocket->save();

            // Attempt authentication if password is set and user requested test or auto-auth
            $authStatusMessage = '';
            if (!empty($shiprocket->email) && !empty($shiprocket->password) && ($request->filled('password') || $request->has('authenticate_now'))) {
                $authResult = $shiprocket->authenticateApi();
                if ($authResult['success']) {
                    $authStatusMessage = ' API connection tested and token generated successfully!';
                } else {
                    $authStatusMessage = ' (Warning: API login attempt failed: ' . $authResult['message'] . ')';
                }
            }

            return redirect()->route('admin.shiprocket.index')
                ->with('success', 'Shiprocket profile settings updated successfully.' . $authStatusMessage);
        } catch (\Exception $e) {
            Log::error('Shiprocket Settings Store Error: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong while saving Shiprocket profile: ' . $e->getMessage());
        }
    }

    /**
     * Test connection to Shiprocket API using stored or provided credentials.
     */
    public function testConnection(Request $request)
    {
        $shiprocket = Shiprocket::first() ?? new Shiprocket();

        if ($request->filled('email')) {
            $shiprocket->email = $request->input('email');
        }
        if ($request->filled('password')) {
            $shiprocket->password = $request->input('password');
        }

        if (empty($shiprocket->email) || empty($shiprocket->password)) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please provide both Shiprocket email and password.',
                ], 422);
            }

            return redirect()->back()->with('error', 'Please provide both Shiprocket email and password before testing connection.');
        }

        $result = $shiprocket->authenticateApi();

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return redirect()->route('admin.shiprocket.index')
                ->with('success', 'Shiprocket Connection Successful! Token generated and saved.');
        }

        return redirect()->route('admin.shiprocket.index')
            ->with('error', 'Shiprocket Authentication Failed: ' . $result['message']);
    }

    /**
     * Fetch registered pickup locations from Shiprocket.
     */
    public function fetchLocations()
    {
        $shiprocket = Shiprocket::first();

        if (!$shiprocket) {
            return response()->json([
                'success' => false,
                'message' => 'Shiprocket configuration not found.',
                'locations' => [],
            ], 404);
        }

        $result = $shiprocket->getPickupLocations();

        return response()->json($result);
    }

    /**
     * Fetch list of couriers with counts from Shiprocket API.
     */
    public function fetchCouriers(Request $request)
    {
        $shiprocket = Shiprocket::first();

        if (!$shiprocket) {
            return response()->json([
                'success' => false,
                'message' => 'Shiprocket configuration not found.',
                'couriers' => [],
            ], 404);
        }

        $result = $shiprocket->getCourierList();

        return response()->json($result);
    }

    /**
     * Check Courier Serviceability via Shiprocket API.
     */
    public function checkServiceability(Request $request)
    {
        $request->validate([
            'pickup_postcode' => 'required|string|max:10',
            'delivery_postcode' => 'required|string|max:10',
            'weight' => 'required|numeric|min:0.01',
            'cod' => 'required|in:0,1',
            'declared_items_value' => 'nullable|numeric|min:0',
            'is_return' => 'nullable|in:0,1',
        ]);

        $shiprocket = Shiprocket::first();

        if (!$shiprocket) {
            return response()->json([
                'success' => false,
                'message' => 'Shiprocket configuration not found. Please save credentials first.',
                'available_couriers' => [],
            ], 404);
        }

        $result = $shiprocket->checkServiceability($request->only([
            'pickup_postcode',
            'delivery_postcode',
            'weight',
            'cod',
            'declared_items_value',
            'is_return',
        ]));

        return response()->json($result);
    }

    /**
     * Get Specific Order Details from Shiprocket API by Order ID / Shipment ID.
     *
     * Endpoint: /v1/external/orders/show/{order_id}
     */
    public function getSpecificOrderDetails(Request $request, $order_id = null)
    {
        $searchId = $order_id ?: $request->input('order_id');

        if (!$searchId) {
            return response()->json([
                'success' => false,
                'message' => 'Please provide a valid Shiprocket Order ID or Shipment ID.',
            ], 422);
        }

        $shiprocket = Shiprocket::first();

        if (!$shiprocket) {
            return response()->json([
                'success' => false,
                'message' => 'Shiprocket configuration not found.',
            ], 404);
        }

        $result = $shiprocket->getOrderDetails($searchId);

        return response()->json($result);
    }

    /**
     * Create a Return Order on Shiprocket API.
     *
     * Endpoint: /v1/external/orders/create/return
     */
    public function createReturnOrder(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string|max:100',
            'order_date' => 'required|string',
            'pickup_customer_name' => 'required|string|max:100',
            'pickup_address' => 'required|string|max:255',
            'pickup_city' => 'required|string|max:100',
            'pickup_state' => 'required|string|max:100',
            'pickup_pincode' => 'required',
            'pickup_email' => 'required|email',
            'pickup_phone' => 'required|string|max:20',
            'shipping_customer_name' => 'required|string|max:100',
            'shipping_address' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_pincode' => 'required',
            'shipping_phone' => 'required|string|max:20',
            'sub_total' => 'required|numeric',
            'weight' => 'required|numeric|min:0.01',
        ]);

        $shiprocket = Shiprocket::first();

        if (!$shiprocket) {
            return response()->json([
                'success' => false,
                'message' => 'Shiprocket configuration not found.',
            ], 404);
        }

        $result = $shiprocket->createReturnOrder($request->all());

        return response()->json($result);
    }

    /**
     * Create an Exchange Order on Shiprocket API.
     *
     * Endpoint: /v1/external/orders/create/exchange
     */
    public function createExchangeOrder(Request $request)
    {
        $request->validate([
            'exchange_order_id' => 'required|string|max:100',
            'return_order_id' => 'required|string|max:100',
            'buyer_pickup_first_name' => 'required|string|max:100',
            'buyer_pickup_address' => 'required|string|max:255',
            'buyer_pickup_city' => 'required|string|max:100',
            'buyer_pickup_state' => 'required|string|max:100',
            'buyer_pickup_pincode' => 'required',
            'buyer_pickup_phone' => 'required|string|max:20',
            'buyer_shipping_first_name' => 'required|string|max:100',
            'buyer_shipping_address' => 'required|string|max:255',
            'buyer_shipping_city' => 'required|string|max:100',
            'buyer_shipping_state' => 'required|string|max:100',
            'buyer_shipping_pincode' => 'required',
            'buyer_shipping_phone' => 'required|string|max:20',
            'sub_total' => 'required',
        ]);

        $shiprocket = Shiprocket::first();

        if (!$shiprocket) {
            return response()->json([
                'success' => false,
                'message' => 'Shiprocket configuration not found.',
            ], 404);
        }

        $result = $shiprocket->createExchangeOrder($request->all());

        return response()->json($result);
    }

    /**
     * Get Tracking details by AWB code via Shiprocket API.
     *
     * Endpoint: /v1/external/courier/track/awb/{awb_code}
     */
    public function getTrackingByAwb(Request $request, $awb_code = null)
    {
        $awbCode = $awb_code ?: $request->input('awb_code');

        if (!$awbCode) {
            return response()->json([
                'success' => false,
                'message' => 'Please provide a valid AWB tracking code.',
            ], 422);
        }

        $shiprocket = Shiprocket::first();

        if (!$shiprocket) {
            return response()->json([
                'success' => false,
                'message' => 'Shiprocket configuration not found.',
            ], 404);
        }

        $result = $shiprocket->trackByAwb($awbCode);

        return response()->json($result);
    }

    /**
     * Get Wallet Balance via Shiprocket API.
     *
     * Endpoint: /v1/external/account/details/wallet-balance
     */
    public function getWalletBalance(Request $request)
    {
        $shiprocket = Shiprocket::first();

        if (!$shiprocket) {
            return response()->json([
                'success' => false,
                'message' => 'Shiprocket configuration not found.',
            ], 404);
        }

        $result = $shiprocket->getWalletBalance();

        return response()->json($result);
    }
}
