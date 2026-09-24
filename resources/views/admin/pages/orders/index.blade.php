@extends('admin.layouts.app')

@push('styles')
    <style>
        .avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #f1f1f1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #555;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Sales /</span> Orders</h4>
            <a href="{{ route('admin.order-control.order.create') }}" class="btn btn-primary">
                <i class='bx bx-plus-circle me-1'></i> Create Order
            </a>
        </div>

        @include('admin.layouts.messages')

        {{-- FILTERS --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.order-control.order.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Search Order</label>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Order No, Customer, Email, Phone...">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Order Status</label>
                            <select name="status" class="form-select">
                                <option value="">All</option>
                                @foreach (['pending', 'paid', 'shipped', 'delivered', 'cancelled'] as $st)
                                    <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>
                                        {{ ucfirst($st) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Payment Status</label>
                            <select name="payment_status" class="form-select">
                                <option value="">All</option>
                                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>
                                    Pending</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid
                                </option>
                                <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed
                                </option>
                            </select>
                        </div>

                        <div class="col-md-2 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class='bx bx-filter-alt'></i> Filter
                            </button>
                            <a href="{{ route('admin.order-control.order.index') }}"
                                class="btn btn-outline-secondary w-100">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Order Status</th>
                            <th>Shiprocket</th>
                            <th>Payment</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            @php
                                $badgeClass = match($order->status) {
                                    'paid' => 'bg-label-success',
                                    'shipped' => 'bg-label-info',
                                    'delivered' => 'bg-success',
                                    'cancelled' => 'bg-label-danger',
                                    default => 'bg-label-warning',
                                };
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <strong>#{{ $order->order_number }}</strong><br>
                                    <small class="text-muted">{{ $order->created_at->format('d M Y') }}</small>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3">
                                            {{ strtoupper(substr($order->customer->first_name ?? 'G', 0, 1)) }}
                                        </div>
                                        <div>
                                            <span class="fw-bold">{{ $order->customer->full_name ?? 'Guest' }}</span><br>
                                            <small class="text-muted">{{ $order->customer->email ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <strong>₹{{ number_format($order->total, 2) }}</strong><br>
                                    <small class="text-muted">{{ $order->items->count() }} items</small>
                                </td>

                                <td>
                                    <span class="badge {{ $badgeClass }} text-capitalize">
                                        {{ $order->status }}
                                    </span>
                                </td>

                                <td>
                                    @if ($order->hasShiprocketOrder())
                                        <span class="badge bg-label-success me-1" title="Shiprocket Order ID: {{ $order->shiprocket_order_id }}">
                                            <i class="bx bx-package me-1"></i> Pushed
                                        </span>
                                        @if ($order->shiprocket_awb_code)
                                            <small class="d-block text-muted">AWB: {{ $order->shiprocket_awb_code }}</small>
                                        @endif
                                    @else
                                        <span class="badge bg-label-secondary">Not Pushed</span>
                                    @endif
                                </td>

                                <td>
                                    <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.order-control.order.show', $order->id) }}"
                                            class="btn btn-sm btn-outline-info" title="View Order">
                                            <i class="bx bx-show"></i>
                                        </a>

                                        @if ($order->hasShiprocketOrder())
                                            <a href="{{ route('admin.order-control.track-shiprocket', $order->id) }}"
                                                class="btn btn-sm btn-outline-success" title="Track Shiprocket">
                                                <i class="bx bx-radar"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-transparent border-top">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
