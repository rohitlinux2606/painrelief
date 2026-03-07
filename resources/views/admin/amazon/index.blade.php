@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Amazon SP-API Dashboard</h3>
                    </div>
                    <div class="card-body">
                        <p>Welcome to the Amazon Selling Partner API integration dashboard. You can use the following
                            endpoints to interact with Amazon:</p>
                        <ul>
                            <li><strong>Fetch Products:</strong>
                                <code>{{ route('amazon.fetch-products') }}?sku=YOUR_SKU</code>
                            </li>
                            <li><strong>Pricing:</strong> <code>{{ route('amazon.get-pricing') }}?asins=ASIN1,ASIN2</code>
                            </li>
                            <li><strong>List Orders:</strong> <code>{{ route('amazon.list-orders') }}</code></li>
                            <li><strong>Track Order:</strong>
                                <code>{{ route('amazon.track-order', ['orderId' => 'ORDER_ID']) }}</code>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
