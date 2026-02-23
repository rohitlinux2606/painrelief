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
        $client = $this->amazonService->getClient();

        // Example of dynamic credentials if needed:
        // $this->amazonService->setCredentials(['refreshToken' => '...'])->getClient();
    }
}
