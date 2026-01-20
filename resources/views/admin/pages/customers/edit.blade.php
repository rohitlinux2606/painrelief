@extends('admin.layouts.app')

@push('styles')
    <style>
        .form-section-title {
            position: relative;
            padding-left: 15px;
            color: #495057;
            border-left: 4px solid #696cff;
        }

        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row align-items-center mb-4 g-3">
            <div class="col-sm-6">
                <h4 class="fw-bold mb-0">
                    <span class="text-muted fw-light">Customers /</span> Edit Customer
                </h4>
            </div>
            <div class="col-sm-6 text-sm-end">
                <a href="{{ route('admin.customer-control.customer.index') }}"
                    class="btn btn-outline-secondary btn-sm shadow-sm">
                    <i class="bx bx-arrow-back me-1"></i> Back
                </a>
            </div>
        </div>

        <form action="{{ route('admin.customer-control.customer.update', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.layouts.messages')

            <div class="row">
                <div class="col-lg-8">

                    {{-- BASIC INFO --}}
                    <div class="card mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Basic Information</h5>
                        </div>
                        <div class="card-body">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">First Name *</label>
                                    <input type="text" name="first_name" class="form-control"
                                        value="{{ old('first_name', $customer->first_name) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Last Name</label>
                                    <input type="text" name="last_name" class="form-control"
                                        value="{{ old('last_name', $customer->last_name) }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', $customer->email) }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Phone</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ old('phone', $customer->phone) }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">New Password</label>
                                    <input type="password" name="password" class="form-control">
                                    <small class="text-muted">Leave blank to keep current password</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Date of Birth</label>
                                    <input type="date" name="dob" class="form-control"
                                        value="{{ old('dob', optional($customer->dob)->format('Y-m-d')) }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Gender</label>
                                    <select name="gender" class="form-select">
                                        <option value="">Select</option>
                                        <option value="male" {{ $customer->gender == 'male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="female" {{ $customer->gender == 'female' ? 'selected' : '' }}>Female
                                        </option>
                                        <option value="other" {{ $customer->gender == 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN --}}
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Status</h5>
                        </div>
                        <div class="card-body">
                            <select name="is_active" class="form-select">
                                <option value="1" {{ $customer->is_active ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$customer->is_active ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mb-5">
                <hr>
                <button type="submit" class="btn btn-primary btn-lg px-5 shadow">
                    Update Customer
                </button>
            </div>

        </form>
    </div>
@endsection
