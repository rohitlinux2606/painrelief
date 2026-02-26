<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AmazonSpApiService;

class AmazonController extends Controller
{
    protected $amazonService;

    public function __construct(AmazonSpApiService $amazonService)
    {
        $this->amazonService = $amazonService;
    }

    public function index()
    {
        return view('admin.amazon.index');
    }

    public function fetchProducts()
    {
        try {
            // Simplified example: Fetching by a specific SKU for testing
            // In a real app, you might loop through your DB products
            $sku = request('sku');
            if (! $sku) {
                return response()->json(['error' => 'SKU is required'], 400);
            }

            $response = $this->amazonService->getListingItem($sku);

            return response()->json($response->data());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPricing()
    {
        try {
            $asins = explode(',', request('asins', ''));
            if (empty($asins)) {
                return response()->json(['error' => 'ASINs are required'], 400);
            }

            $response = $this->amazonService->getPricing($asins);

            return response()->json($response->data());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function listOrders()
    {
        try {
            $params = request()->all();
            $response = $this->amazonService->getOrders($params);

            return response()->json($response->data());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function trackOrder($orderId)
    {
        try {
            $response = $this->amazonService->getOrder($orderId);

            return response()->json($response->data());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
