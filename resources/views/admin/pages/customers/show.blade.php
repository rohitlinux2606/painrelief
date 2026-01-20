@extends('admin.layouts.app')

@section('content')
    <div class="container-xxl container-p-y">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">
                <span class="text-muted fw-light">Customers /</span> View Customer
            </h4>
            <a href="{{ route('admin.customer-control.customer.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back"></i> Back
            </a>
        </div>

        <div class="row">
            {{-- Customer Info --}}
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header fw-bold">Customer Info</div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $customer->full_name }}</p>
                        <p><strong>Email:</strong> {{ $customer->email ?? 'N/A' }}</p>
                        <p><strong>Phone:</strong> {{ $customer->phone ?? 'N/A' }}</p>
                        <p><strong>DOB:</strong> {{ $customer->dob?->format('d M Y') ?? 'N/A' }}</p>
                        <p><strong>Gender:</strong> {{ ucfirst($customer->gender) ?? 'N/A' }}</p>
                        <p>
                            <strong>Status:</strong>
                            @if ($customer->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Orders --}}
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header fw-bold">Orders</div>
                    <div class="card-body">
                        <p>Total Orders: <strong>{{ $customer->orders->count() }}</strong></p>
                    </div>
                </div>
            </div>

            {{-- Addresses --}}
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header fw-bold">Addresses</div>
                    <div class="card-body">
                        @forelse($customer->addresses as $address)
                            <div class="border p-3 rounded mb-2">
                                <strong>{{ ucfirst($address->type) }}</strong><br>
                                {{ $address->address_line1 }},
                                {{ $address->city }},
                                {{ $address->state }},
                                {{ $address->country }} - {{ $address->postal_code }}
                            </div>
                        @empty
                            <p class="text-muted">No addresses found.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
