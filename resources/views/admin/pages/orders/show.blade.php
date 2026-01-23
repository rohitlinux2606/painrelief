@extends('admin.layouts.app')

@section('title', $title)

@section('content')
    <div class="container-xxl container-p-y">

        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">
                <span class="text-muted fw-light">Orders /</span> #{{ $order->order_number }}
            </h4>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back"></i> Back
            </a>
        </div>

        <div class="row">
            {{-- Order Status & Summary --}}
            <div class="col-lg-8">
                {{-- Items Table Card --}}
                <div class="card mb-4">
                    <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                        <span>Order Items</span>
                        <span class="badge bg-primary">Total Items: {{ $order->items->count() }}</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td><strong>{{ $item->title }}</strong></td>
                                        <td>₹{{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end">₹{{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end">Subtotal:</td>
                                    <td class="text-end">₹{{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">Tax:</td>
                                    <td class="text-end">₹{{ number_format($order->tax, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">Shipping:</td>
                                    <td class="text-end">₹{{ number_format($order->shipping, 2) }}</td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="3" class="text-end">Grand Total:</td>
                                    <td class="text-end text-primary">₹{{ number_format($order->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Right Sidebar: Customer & Shipping Details --}}
            <div class="col-lg-4">
                {{-- Customer Details --}}
                <div class="card mb-4">
                    <div class="card-header fw-bold">Customer Info</div>
                    <div class="card-body">
                        <p class="mb-1"><strong>Name:</strong> {{ $order->customer->full_name }}</p>
                        <p class="mb-1"><strong>Email:</strong> {{ $order->customer->email }}</p>
                        <p class="mb-0"><strong>Phone:</strong> {{ $order->customer->phone }}</p>
                    </div>
                </div>

                {{-- Order Status Card --}}
                <div class="card mb-4">
                    <div class="card-header fw-bold">Order Status</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="badge bg-label-info mb-2">Order Status:
                                {{ strtoupper($order->status) }}</span><br>
                            <span class="badge bg-label-success">Payment: {{ strtoupper($order->payment_status) }}</span>
                        </div>
                        <p class="small text-muted mb-0">Payment Method: {{ $order->payment_method }}</p>
                    </div>
                </div>

                {{-- Shipping Address --}}
                <div class="card">
                    <div class="card-header fw-bold">Shipping Address</div>
                    <div class="card-body">
                        @if ($order->address)
                            <p class="mb-1"><strong>{{ $order->address->name }}</strong></p>
                            <p class="mb-1">{{ $order->address->address_line1 }}</p>
                            @if ($order->address->address_line2)
                                <p class="mb-1">{{ $order->address->address_line2 }}</p>
                            @endif
                            <p class="mb-0">
                                {{ $order->address->city }}, {{ $order->address->state }}<br>
                                {{ $order->address->country }} - {{ $order->address->postal_code }}
                            </p>
                            <p class="mt-2 mb-0 small"><i class="bx bx-phone"></i> {{ $order->address->phone }}</p>
                        @else
                            <p class="text-danger">Address not available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
