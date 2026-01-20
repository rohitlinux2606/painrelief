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
            <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Users /</span> Customers</h4>
            <a href="{{ route('admin.customer-control.customer.create') }}" class="btn btn-primary">
                <i class='bx bx-plus-circle me-1'></i> Add Customer
            </a>
        </div>

        {{-- FILTERS --}}
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.customer-control.customer.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Search Customer</label>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Name, Email, Phone...">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class='bx bx-filter-alt'></i> Filter
                            </button>
                            <a href="{{ route('admin.customer-control.customer.index') }}"
                                class="btn btn-outline-secondary w-100">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Orders</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $customer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3">
                                            {{ strtoupper(substr($customer->first_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <span class="fw-bold">{{ $customer->full_name }}</span><br>
                                            <small class="text-muted">ID: {{ $customer->id }}</small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <small>Email: {{ $customer->email ?? 'N/A' }}</small><br>
                                    <small>Phone: {{ $customer->phone ?? 'N/A' }}</small>
                                </td>

                                <td>
                                    @if ($customer->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>

                                <td>
                                    <span class="badge bg-label-primary">
                                        {{ $customer->orders->count() }} Orders
                                    </span>
                                </td>

                                <td>
                                    @if ($customer->trashed())
                                        <a href="{{ route('admin.customer-control.customer.restore', $customer->id) }}"
                                            class="btn btn-sm btn-outline-success">
                                            <i class="bx bx-revision"></i>
                                        </a>

                                        <form
                                            action="{{ route('admin.customer-control.customer.forceDelete', $customer->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('admin.customer-control.customer.show', $customer->id) }}"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bx bx-show"></i>
                                        </a>

                                        <a href="{{ route('admin.customer-control.customer.edit', $customer->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-edit"></i>
                                        </a>

                                        <form
                                            action="{{ route('admin.customer-control.customer.destroy', $customer->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Delete this customer?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">No customers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-transparent border-top">
                {{ $customers->links() }}
            </div>
        </div>
    </div>
@endsection
