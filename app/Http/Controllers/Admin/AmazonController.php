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
            // $sku = '1C3V-KT2M-8EX9';
            if (! $sku) {
                return response()->json(['error' => 'SKU is required'], 400);
            }

            $response = $this->amazonService->getListingItem($sku);

            return response()->json($response->json());
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

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function listOrders()
    {
        try {
            $params = request()->all();
            $response = $this->amazonService->getOrders($params);

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function trackOrder($orderId)
    {
        try {
            $response = $this->amazonService->getOrder($orderId);

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Step 1: Request a report (e.g., GET_MERCHANT_LISTINGS_DATA)
     */
    public function requestReport()
    {
        try {
            $reportType = request('report_type', 'GET_MERCHANT_LISTINGS_DATA');
            $response = $this->amazonService->createReport($reportType);

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Step 2: Check the status of the requested report
     */
    public function checkReportStatus($reportId)
    {
        try {
            $response = $this->amazonService->getReport($reportId);

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Step 3: Get report document details and download
     */
    public function downloadReport($documentId)
    {
        try {
            $reportType = request('report_type', 'GET_MERCHANT_LISTINGS_DATA');
            $response = $this->amazonService->getReportDocument($documentId);

            // For the document details, we can return JSON
            $documentJson = $response->json();

            $document = $response->dto();

            // The 'download' method in the DTO handles decryption and parsing
            $contents = $document->download($reportType);

            return response()->json([
                'document' => $documentJson,
                'contents' => $contents,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Step 4: Import products from the downloaded report into the database
     */
    public function importProducts($documentId)
    {
        try {
            $reportType = request('report_type', 'GET_MERCHANT_LISTINGS_DATA');
            $response = $this->amazonService->getReportDocument($documentId, $reportType);
            $document = $response->dto();
            $contents = $document->download($reportType);

            if (empty($contents)) {
                return response()->json(['error' => 'Report is empty or could not be downloaded'], 400);
            }

            $importedCount = 0;
            $updatedCount = 0;

            foreach ($contents as $item) {
                // Map Amazon fields to Product model fields
                // Using amazon_sku as the unique identifier
                $sku = $item['seller-sku'] ?? null;
                if (! $sku) {
                    continue;
                }

                $title = $item['item-name'] ?? 'Amazon Product';
                $productData = [
                    'title' => $title,
                    'slug' => \Illuminate\Support\Str::slug($title.'-'.$sku),
                    'price' => $item['price'] ?? 0,
                    'stock_quantity' => $item['quantity'] ?? 0,
                    'amazon_product_id' => $item['product-id'] ?? null,
                    'amazon_asin' => $item['asin1'] ?? null,
                    'amazon_sku' => $sku,
                    'amazon_price' => $item['price'] ?? 0,
                    'amazon_quantity' => $item['quantity'] ?? 0,
                    'amazon_image' => $item['image-url'] ?? null,
                    'status' => 'active',
                ];

                $product = \App\Models\Product::updateOrCreate(
                    ['amazon_sku' => $sku],
                    $productData
                );

                if ($product->wasRecentlyCreated) {
                    $importedCount++;
                } else {
                    $updatedCount++;
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully processed products.',
                'imported' => $importedCount,
                'updated' => $updatedCount,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Create an outbound fulfillment order
     */
    public function createOutboundOrder()
    {
        try {
            $data = request()->all();
            if (empty($data)) {
                return response()->json(['error' => 'Order data is required'], 400);
            }

            $response = $this->amazonService->createFulfillmentOrder($data);

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
