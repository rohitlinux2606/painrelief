<?php

return [
    'api_url' => env('CASHFREE_API_URL', 'https://api.cashfree.com/pg'),
    'api_key' => env('CASHFREE_API_KEY', '379630d729e6339acf5cf070c7036973'),
    'api_secret' => env('CASHFREE_API_SECRET', 'b4290c3571dae9b342d895036143d0d3c3865192'),
    'app_Id' => env('CASHFREE_APP_ID'),
    'app_pw' => env('CASHFREE_APP_PASSWORD'),

    // Development Mode
    'sandbox_api_url' => env('CASHFREE_SANDBOX_API_URL', 'https://sandbox.cashfree.com/pg'),
    'sandbox_api_key' => env('CASHFREE_SANDBOX_API_KEY', '31867834038e7c70cfaa3bf94f876813'),
    'sandbox_api_secret' => env('CASHFREE_SANDBOX_API_SECRET', 'b4290c3571dae9b342d895036143d0d3c3865192'),
];
