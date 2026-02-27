<?php

namespace App\Services;

use SellingPartnerApi\Enums\Endpoint;
use SellingPartnerApi\Seller\FBAOutboundV20200701\Dto\CreateFulfillmentOrderRequest;
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
}
