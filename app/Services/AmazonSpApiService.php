<?php

namespace App\Services;

use SellingPartnerApi\SellingPartnerApi;
use SellingPartnerApi\Enums\Endpoint;

class AmazonSpApiService
{
    protected $config;
    protected $client;

    /**
     * AmazonSpApiService constructor.
     *
     * @param array|null $customCredentials If provided, these will override default config.
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
     * @param string $endpoint
     * @return Endpoint
     */
    protected function getEndpoint(string $endpoint)
    {
        return match (strtoupper($endpoint)) {
            'EU' => Endpoint::EU,
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
     * Dynamically update credentials and re-initialize client.
     *
     * @param array $credentials
     * @return $this
     */
    public function setCredentials(array $credentials)
    {
        $this->config = array_merge($this->config, $credentials);
        $this->initializeClient();
        return $this;
    }
}
