@extends('admin.layouts.app')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet">
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
                <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Catalog /</span> Add New Product</h4>
            </div>
            <div class="col-sm-6 text-sm-end">
                <a href="{{ route('admin.product-control.product.index') }}"
                    class="btn btn-outline-secondary btn-sm shadow-sm">
                    <i class="bx bx-arrow-back me-1"></i>Back to Products
                </a>
            </div>
        </div>

        <form action="{{ route('admin.product-control.product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.layouts.messages')

            <div class="row">
                <div class="col-lg-8">
                    {{-- SECTION 1: BASIC INFO --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Product Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Product Title *</label>
                                <input type="text" name="title" class="form-control"
                                    placeholder="e.g. Nike Air Max 270" value="{{ old('title') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">External Link</label>
                                <input type="text" name="external_link" class="form-control"
                                    placeholder="Amazon,flipkart..." value="{{ old('external_link') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea name="description" class="form-control" rows="8">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 2: PRICING --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Pricing</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Price *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" step="0.01" name="price" class="form-control"
                                            placeholder="0.00" value="{{ old('price') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Compare at price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" step="0.01" name="compare_at_price" class="form-control"
                                            placeholder="0.00" value="{{ old('compare_at_price') }}">
                                    </div>
                                    <small class="text-muted">To show a reduced price, move the original price here.</small>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                    <label class="form-label fw-semibold">Cost per item</label>
                                    <div class="input-group w-50">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" step="0.01" name="cost_per_item" class="form-control"
                                            value="{{ old('cost_per_item') }}">
                                    </div>
                                    <small class="text-muted">Customers won’t see this.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 3: INVENTORY --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Inventory</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">SKU (Stock Keeping Unit)</label>
                                    <input type="text" name="sku" class="form-control" value="{{ old('sku') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Barcode (ISBN, UPC, GTIN, etc.)</label>
                                    <input type="text" name="barcode" class="form-control" value="{{ old('barcode') }}">
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="track_quantity" value="1"
                                            id="trackQuantity" checked>
                                        <label class="form-check-label" for="trackQuantity">Track quantity</label>
                                    </div>
                                    <div class="mt-3 w-50">
                                        <label class="form-label fw-semibold">Quantity Available</label>
                                        <input type="number" name="stock_quantity" class="form-control"
                                            value="{{ old('stock_quantity', 0) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN: STATUS & MEDIA --}}
                <div class="col-lg-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Status</h5>
                        </div>
                        <div class="card-body">
                            <select name="status" class="form-select mb-3">
                                <option value="active">Active</option>
                                <option value="draft" selected>Draft</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Media</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="image-preview-wrapper mb-3" id="preview_box">
                                <i class="bx bx-image-add bx-lg text-muted"></i>
                            </div>
                            {{-- <input type="file" name="thumbnail" id="thumbnail_input" class="form-control"
                                accept="image/*"> --}}
                            <input type="file" name="thumbnail" id="thumbnail_input" class="form-control">
                        </div>
                    </div>
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Product Gallery</h5>
                        </div>
                        <div class="card-body">
                            <label class="form-label fw-semibold">Upload Multiple Images</label>
                            {{-- 'images[]' और 'multiple' एट्रिब्यूट ज़रूरी है --}}
                            <input type="file" name="images[]" class="form-control" multiple>
                            <small class="text-muted">You can select multiple photos at once.</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mb-5">
                <hr>
                <button type="submit" class="btn btn-primary btn-lg px-5 shadow">Save Product</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });

            // Image Preview logic
            $('#thumbnail_input').change(function() {
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
