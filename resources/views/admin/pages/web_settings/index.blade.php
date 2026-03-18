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

        .image-preview-wrapper {
            width: 100%;
            height: 150px;
            border: 2px dashed #d9dee3;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #f5f5f9;
            margin-bottom: 15px;
        }

        .image-preview-wrapper img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row align-items-center mb-4 g-3">
            <div class="col-sm-6">
                <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Settings /</span> Web Configuration</h4>
            </div>
        </div>

        <form action="{{ route('admin.web-setting.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.layouts.messages')

            <div class="row">
                <div class="col-lg-8">
                    {{-- GENERAL DETAILS --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">General Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Site Name</label>
                                <input type="text" name="site_name" class="form-control"
                                    value="{{ old('site_name', $setting->site_name ?? '') }}">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Contact Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', $setting->email ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Phone Number</label>
                                    <input type="text" name="phone_number" class="form-control"
                                        value="{{ old('phone_number', $setting->phone_number ?? '') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Address</label>
                                <textarea name="address" class="form-control" rows="3">{{ old('address', $setting->address ?? '') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Google Map Link</label>
                                <textarea name="map_link" class="form-control" rows="2">{{ old('map_link', $setting->map_link ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- PRICING AND E-COMMERCE --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Store Policies & Offers</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Shipping Charge</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" step="0.01" name="shipping_charge" class="form-control"
                                            value="{{ old('shipping_charge', $setting->shipping_charge ?? 0) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Free Shipping Min. Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" step="0.01" name="free_shipping_amount"
                                            class="form-control"
                                            value="{{ old('free_shipping_amount', $setting->free_shipping_amount ?? 0) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Online Payment Discount (%)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="discount_percentage" class="form-control"
                                            value="{{ old('discount_percentage', $setting->discount_percentage ?? '') }}">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Coupon Code</label>
                                    <input type="text" name="coupon_code" class="form-control"
                                        value="{{ old('coupon_code', $setting->coupon_code ?? '') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    {{-- LOGO --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Site Logo</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="image-preview-wrapper" id="preview_box">
                                @if (isset($setting->logo))
                                    <img src="{{ asset($setting->logo) }}" alt="Logo">
                                @else
                                    <i class="bx bx-image-add bx-lg text-muted"></i>
                                @endif
                            </div>
                            <input type="file" name="logo" id="logo_input" class="form-control" accept="image/*">
                        </div>
                    </div>

                    {{-- SOCIAL MEDIA --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Social Links</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">WhatsApp Number</label>
                                <input type="text" name="whatsapp" class="form-control"
                                    value="{{ old('whatsapp', $setting->whatsapp ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Facebook URL</label>
                                <input type="url" name="facebook" class="form-control"
                                    value="{{ old('facebook', $setting->facebook ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Instagram URL</label>
                                <input type="url" name="instagram" class="form-control"
                                    value="{{ old('instagram', $setting->instagram ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">YouTube URL</label>
                                <input type="url" name="youtube" class="form-control"
                                    value="{{ old('youtube', $setting->youtube ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Twitter URL</label>
                                <input type="url" name="twitter" class="form-control"
                                    value="{{ old('twitter', $setting->twitter ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mb-5">
                <hr>
                <button type="submit" class="btn btn-primary btn-lg px-5 shadow">Save Configuration</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#logo_input').change(function() {
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        $('#preview_box').html(`<img src="${event.target.result}" alt="Preview">`);
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush
