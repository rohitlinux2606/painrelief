<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
use SellingPartnerApi\Enums\Endpoint;
use SellingPartnerApi\Seller\FBAOutboundV20200701\Dto\Address as AmazonAddress;
use SellingPartnerApi\Seller\FBAOutboundV20200701\Dto\CodSettings;
use SellingPartnerApi\Seller\FBAOutboundV20200701\Dto\CreateFulfillmentOrderItem;
use SellingPartnerApi\Seller\FBAOutboundV20200701\Dto\CreateFulfillmentOrderRequest;
use SellingPartnerApi\Seller\FBAOutboundV20200701\Dto\Money;
use SellingPartnerApi\Seller\FBAOutboundV20200701\Dto\PaymentInformation;
use SellingPartnerApi\Seller\ReportsV20210630\Dto\CreateReportSpecification;
use SellingPartnerApi\SellingPartnerApi;

class AmazonSpApiService
{
    protected $config;

    protected $client;

    /**
     * AmazonSpApiService constructor.
     *
     * @param  array|null  $customCredentials  If provided, these will override default config.
     */
    public function __construct(?array $customCredentials = null)
    {
        $this->config = config('amazon');

        if ($customCredentials) {
            $this->config = array_merge($this->config, $customCredentials);
        }

        $this->initializeClient();
    }

    /**
     * Initialize the SellingPartnerApi client.
     */
    protected function initializeClient()
    {
        $this->client = SellingPartnerApi::seller(
            clientId: $this->config['client_id'],
            clientSecret: $this->config['client_secret'],
            refreshToken: $this->config['refresh_token'],
            endpoint: $this->getEndpoint($this->config['endpoint']),
        );
    }

    /**
     * Get the correct Endpoint enum based on string.
     *
     * @return Endpoint
     */
    protected function getEndpoint(string $endpoint)
    {
        return match (strtoupper($endpoint)) {
            'EU', 'EU-WEST-1' => Endpoint::EU,
            'FE' => Endpoint::FE,
            default => Endpoint::NA,
        };
    }

    /**
     * Get the SP-API client instance.
     *
     * @return SellingPartnerApi
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Get orders.
     */
    public function getOrders(array $params = [])
    {
        $mergedParams = array_merge([
            'marketplaceIds' => [$this->config['marketplace_id']],
            'createdAfter' => now()->subDays(7)->toRfc3339String(),
        ], $params);

        return $this->client->ordersV0()->getOrders(...$mergedParams);
    }

    /**
     * Get order details by ID.
     */
    public function getOrder(string $orderId)
    {
        return $this->client->ordersV0()->getOrder($orderId);
    }

    /**
     * Get pricing for ASINs.
     */
    public function getPricing(array $asins)
    {
        return $this->client->productPricingV0()->getPricing(
            marketplaceId: $this->config['marketplace_id'],
            itemType: 'Asin',
            asins: $asins
        );
    }

    /**
     * Get listing item details.
     */
    public function getListingItem(string $sku)
    {
        return $this->client->listingsItemsV20210801()->getListingsItem(
            sellerId: $this->config['seller_id'],
            sku: $sku,
            marketplaceIds: [$this->config['marketplace_id']]
        );
    }

    /**
     * Get FBA inventory summaries.
     */
    public function getInventorySummaries(array $sellerSkus = [])
    {
        return $this->client->fbaInventoryV1()->getInventorySummaries(
            granularityType: 'Marketplace',
            granularityId: $this->config['marketplace_id'],
            marketplaceIds: [$this->config['marketplace_id']],
            sellerSkus: $sellerSkus
        );
    }

    /**
     * Create a report.
     * Report types: GET_MERCHANT_LISTINGS_DATA, GET_FBA_MYI_UNSUPPRESSED_INVENTORY_DATA, etc.
     */
    public function createReport(string $reportType, ?string $startTime = null, ?string $endTime = null)
    {
        $spec = new CreateReportSpecification(
            reportType: $reportType,
            marketplaceIds: [$this->config['marketplace_id']],
            dataStartTime: $startTime ? new \DateTime($startTime) : null,
            dataEndTime: $endTime ? new \DateTime($endTime) : null,
        );

        return $this->client->reportsV20210630()->createReport($spec);
    }

    /**
     * Get report details and status.
     */
    public function getReport(string $reportId)
    {
        return $this->client->reportsV20210630()->getReport($reportId);
    }

    /**
     * Get report document details (including download URL).
     */
    public function getReportDocument(string $documentId, string $reportType = 'GET_MERCHANT_LISTINGS_DATA')
    {
        return $this->client->reportsV20210630()->getReportDocument($documentId, $reportType);
    }

    /**
     * Create FBA Outbound Fulfillment Order (MCF) from local Order model.
     */
    public function createMcfOrder(Order $order)
    {
        $address = $order->address;
        $customer = $order->customer;

        // 1. Prepare Destination Address (split into max 60 chars per line)
        // Ensure we don't duplicate state/city in address lines if they are already in dedicated fields
        $fullAddress = trim($address->address_line1);
        $addressLines = explode("\n", wordwrap($fullAddress, 60, "\n", true));

        // Sanitize Phone Number: Remove non-numeric, strip leading zero for India
        $phone = preg_replace('/\D/', '', $address->phone ?? $customer->phone ?? '');
        if (str_starts_with($phone, '0')) {
            $phone = ltrim($phone, '0');
        }

        $destinationAddress = new AmazonAddress(
            name: substr(trim($address->name ?? ($customer->first_name.' '.$customer->last_name)), 0, 50),
            addressLine1: $addressLines[0] ?? substr($fullAddress, 0, 60),
            postalCode: $address->postal_code,
            countryCode: $address->country ?? 'IN',
            addressLine2: $addressLines[1] ?? null,
            addressLine3: $addressLines[2] ?? null,
            city: $address->city,
            stateOrRegion: $address->state,
            phone: substr($phone, -10), // Ensure exactly 10 digits for India
        );

        // 2. Prepare Items & Check FBA Inventory
        $skusInOrder = $order->items->pluck('product.amazon_sku')->filter()->unique()->toArray();
        Log::info('Checking FBA inventory for SKUs in Order #'.$order->order_number.': '.implode(', ', $skusInOrder));
        $fbaInventory = [];

        try {
            $inventoryResponse = $this->getInventorySummaries($skusInOrder);
            $summaries = $inventoryResponse->json()['payload']['inventorySummaries'] ?? [];
            foreach ($summaries as $summary) {
                $fbaInventory[$summary['sellerSku']] = $summary['totalQuantity'] ?? 0;
            }
        } catch (\Exception $e) {
            Log::warning('Could not fetch FBA inventory for SKUs: '.implode(', ', $skusInOrder).'. Proceeding with caution. Error: '.$e->getMessage());
        }

        $items = [];
        $skippedItems = [];
        $isCodOrder = ($order->payment_method === 'COD');

        // 2b. COD Collection Logic (Distribution of order->total across items)
        $totalItemsToCollect = 0;
        if ($isCodOrder) {
            $totalItemPriceSum = $order->items->sum(fn ($i) => $i->price * $i->quantity);
            $orderTotal = (float) $order->total;
            $runningTotal = 0;

            foreach ($order->items as $index => $item) {
                $product = $item->product;
                if ($product && $product->amazon_sku && isset($fbaInventory[$product->amazon_sku])) {
                    // For the last item, adjust to handle rounding and ensure sum == orderTotal
                    if ($index === $order->items->count() - 1) {
                        $itemTotalCollection = $orderTotal - $runningTotal;
                    } else {
                        // Weight based distribution
                        $itemTotalCollection = ($totalItemPriceSum > 0)
                            ? ($item->price * $item->quantity / $totalItemPriceSum) * $orderTotal
                            : ($orderTotal / $order->items->count());
                        $itemTotalCollection = round($itemTotalCollection, 2);
                        $runningTotal += $itemTotalCollection;
                    }

                    $perUnitValue = round($itemTotalCollection / $item->quantity, 2);

                    $items[] = new CreateFulfillmentOrderItem(
                        sellerSku: $product->amazon_sku,
                        sellerFulfillmentOrderItemId: (string) $item->id,
                        quantity: (int) $item->quantity,
                        perUnitDeclaredValue: new Money(
                            currencyCode: 'INR',
                            value: number_format($perUnitValue, 2, '.', '')
                        ),
                    );
                } elseif ($product && $product->amazon_sku) {
                    $skippedItems[] = $product->amazon_sku;
                }
            }
        } else {
            // Prepaid Orders - Simple items
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product && $product->amazon_sku && isset($fbaInventory[$product->amazon_sku])) {
                    $items[] = new CreateFulfillmentOrderItem(
                        sellerSku: $product->amazon_sku,
                        sellerFulfillmentOrderItemId: (string) $item->id,
                        quantity: (int) $item->quantity,
                    );
                } elseif ($product && $product->amazon_sku) {
                    $skippedItems[] = $product->amazon_sku;
                }
            }
        }

        if (! empty($skippedItems)) {
            Log::warning("Skipping MCF for Order #{$order->order_number}: The following SKUs are not FBA-active or have no inventory: ".implode(', ', $skippedItems));
        }

        if (empty($items)) {
            Log::warning("MCF Fulfillment skipped for Order #{$order->order_number}: No FBA-active items found.");

            return null;
        }

        // 2c. Get Fulfillment Preview to determine available speed and SLA
        $shippingSpeed = 'Standard'; // Priority, Standard, Expedited
        try {
            $previewRequest = new \SellingPartnerApi\Seller\FBAOutboundV20200701\Dto\GetFulfillmentPreviewRequest(
                address: $destinationAddress,
                items: array_map(fn ($i) => new \SellingPartnerApi\Seller\FBAOutboundV20200701\Dto\GetFulfillmentPreviewItem(
                    sellerSku: $i->sellerSku,
                    sellerFulfillmentOrderItemId: $i->sellerFulfillmentOrderItemId,
                    quantity: $i->quantity
                ), $items),
                marketplaceId: $this->config['marketplace_id'],
                includeCodFulfillmentPreview: $isCodOrder
            );

            $previewResponse = $this->client->fbaOutboundV20200701()->getFulfillmentPreview($previewRequest);
            if ($previewResponse->successful()) {
                $previews = $previewResponse->dto()->fulfillmentPreviews ?? [];
                if (! empty($previews)) {
                    // Pick the first available speed that has valid fulfillment options
                    $shippingSpeed = $previews[0]->shippingSpeedCategory;
                    Log::info("Amazon MCF Preview Success. Selected Speed: {$shippingSpeed}");
                } else {
                    Log::warning("Amazon MCF Preview returned no fulfillment options for Order #{$order->order_number}. SLA might not be available.");
                }
            } else {
                Log::warning("Amazon MCF Preview API call failed for Order #{$order->order_number}: ".$previewResponse->body());
            }
        } catch (\Exception $e) {
            Log::warning('Amazon MCF Preview Error: '.$e->getMessage());
        }

        // 3. Prepare Payment Information and COD Settings
        $paymentInformation = null;
        if ($isCodOrder) {
            $paymentInformation = [
                new PaymentInformation(
                    paymentTransactionId: $order->order_number,
                    paymentMode: 'COD',
                    paymentDate: $order->created_at->startOfSecond(),
                ),
            ];
        }

        $codSettings = null;
        if ($isCodOrder) {
            $codSettings = new CodSettings(
                isCodRequired: true,
            );
        }

        // 4. Create Request
        $request = new CreateFulfillmentOrderRequest(
            sellerFulfillmentOrderId: $order->order_number,
            displayableOrderId: $order->order_number,
            displayableOrderDate: $order->created_at->startOfSecond(),
            displayableOrderComment: 'Order from Website: '.$order->order_number,
            shippingSpeedCategory: $shippingSpeed,
            destinationAddress: $destinationAddress,
            fulfillmentAction: 'Ship',
            fulfillmentPolicy: 'FillOrKill',
            items: $items,
            marketplaceId: $this->config['marketplace_id'],
            codSettings: $codSettings,
            paymentInformation: $paymentInformation,
        );

        Log::info('Creating Amazon MCF Order:', [
            'order_number' => $order->order_number,
            'marketplace_id' => $this->config['marketplace_id'],
            'address' => $destinationAddress,
            'items_count' => count($items),
            'is_cod' => $isCodOrder,
        ]);

        try {
            $response = $this->client->fbaOutboundV20200701()->createFulfillmentOrder($request);
            Log::info("Amazon MCF Order Created Successfully for Order #{$order->order_number}");

            return $response;
        } catch (\Exception $e) {
            Log::error("Amazon MCF Order Creation Failed for Order #{$order->order_number}: ".$e->getMessage(), [
                'request' => $request,
                'response' => method_exists($e, 'getResponse') ? $e->getResponse()?->body() : 'N/A',
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    /**
     * Create FBA Outbound Fulfillment Order (MCF).
     */
    public function createFulfillmentOrder(array $data)
    {
        // In a real implementation, you would map $data to CreateFulfillmentOrderRequest
        // For now, we'll assume the caller provides compatible structure
        $request = CreateFulfillmentOrderRequest::deserialize($data);

        return $this->client->fbaOutboundV20200701()->createFulfillmentOrder($request);
    }

    /**
     * Dynamically update credentials and re-initialize client.
     *
     * @return $this
     */
    public function setCredentials(array $credentials)
    {
        $this->config = array_merge($this->config, $credentials);
        $this->initializeClient();

        return $this;
    }

    /**
     * List fulfillment orders.
     */
    public function listFulfillmentOrders(?\DateTimeInterface $queryStartDate = null, ?string $nextToken = null)
    {
        return $this->client->fbaOutboundV20200701()->listAllFulfillmentOrders($queryStartDate, $nextToken);
    }

    /**
     * Cancel Fulfillment Order as a buyer is IsBuyerRequestedCancel flag is true
     */
    public function cancelFulfillmentOrder(string $sellerFulfillmentOrderId)
    {
        try {
            $response = $this->client->fbaOutboundV20200701()->cancelFulfillmentOrder($sellerFulfillmentOrderId);
            Log::info("Amazon MCF Order Cancelled Successfully for Order #{$sellerFulfillmentOrderId}");

            return $response;
        } catch (\Exception $e) {
            Log::error("Amazon MCF Order Cancellation Failed for Order #{$sellerFulfillmentOrderId}: ".$e->getMessage(), [
                'request' => $sellerFulfillmentOrderId,
                'response' => method_exists($e, 'getResponse') ? $e->getResponse()?->body() : 'N/A',
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }
}
