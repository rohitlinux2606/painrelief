<?php

return [
    'client_id' => env('AMAZON_SPAPI_CLIENT_ID'),
    'client_secret' => env('AMAZON_SPAPI_CLIENT_SECRET'),
    'refresh_token' => env('AMAZON_SPAPI_REFRESH_TOKEN'),
    'endpoint' => env('AMAZON_SPAPI_REGION', 'EU'), // Using REGION as endpoint for now, or could map it
    'marketplace_id' => env('AMAZON_MARKETPLACE_ID'),
    'seller_id' => env('AMAZON_SELLER_ID'),
    'aws_access_key' => env('AMAZON_SPAPI_AWS_ACCESS_KEY'),
    'aws_secret_key' => env('AMAZON_SPAPI_AWS_SECRET_KEY'),
    'role_arn' => env('AMAZON_SPAPI_ROLE_ARN'),
];
