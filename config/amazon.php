<?php

return [
    'client_id' => env('SELLING_PARTNER_CLIENT_ID'),
    'client_secret' => env('SELLING_PARTNER_CLIENT_SECRET'),
    'refresh_token' => env('SELLING_PARTNER_REFRESH_TOKEN'),
    'access_token' => env('SELLING_PARTNER_ACCESS_TOKEN'),
    'endpoint' => env('SELLING_PARTNER_ENDPOINT', 'NA'), // Default to NA
];
