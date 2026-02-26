<?php

namespace App\Services;

use SellingPartnerApi\Enums\Endpoint;
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
