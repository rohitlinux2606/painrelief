<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AmazonSpApiService;
use Illuminate\Support\Facades\Log;

class AmazonController extends Controller
{
    protected $amazonService;

    public function __construct(AmazonSpApiService $amazonService)
    {
        $this->amazonService = $amazonService;
    }

    public function index()
    {
        $client = $this->amazonService->getClient();

        // Example of dynamic credentials if needed:
        // $this->amazonService->setCredentials(['refreshToken' => '...'])->getClient();
    }

    /**
     * सैंडबॉक्स में प्रोडक्ट लिस्ट (Listings Items) फेच करने का उदाहरण
     */
    public function fetchProducts()
    {
        Log::info('Fetch Products');
        $client = $this->amazonService->getClient();

        // भारत/EU के लिए Marketplace ID (अमेज़न इंडिया के लिए: A21TJRUUN4KGV)
        $marketplaceIds = ['A21TJRUUN4KGV'];

        // यह आपके सेलर अकाउंट की ID है
        $sellerId = 'SiddhiHerbals';

        try {
            // Listings Items API का उपयोग करके डेटा फेच करना
            // नोट: सैंडबॉक्स में यह सिर्फ मॉक डेटा देगा
            $listingsApi = $client->listingsItems();

            // यहाँ हम एक टेस्ट SKU का उपयोग कर रहे हैं
            $testSku = 'goodhealth_pack01';

            $response = $listingsApi->getListingsItem(
                $sellerId,
                $testSku,
                $marketplaceIds
            );

            return $response->json();
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ];
        }
    }
}
