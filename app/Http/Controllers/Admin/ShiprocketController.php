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
}
