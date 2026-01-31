@extends('admin.layouts.app')

{{-- Styles same as create page --}}
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
                <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Catalog /</span> Edit Product</h4>
            </div>
            <div class="col-sm-6 text-sm-end">
                <a href="{{ route('admin.product-control.product.index') }}"
                    class="btn btn-outline-secondary btn-sm shadow-sm">
                    <i class="bx bx-arrow-back me-1"></i>Back
                </a>
            </div>
        </div>

        {{-- Route changes to Update and Method is PUT --}}
        <form action="{{ route('admin.product-control.product.update', $product->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.layouts.messages')

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Product Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Product Title *</label>
                                <input type="text" name="title" class="form-control"
                                    value="{{ old('title', $product->title) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">External Link</label>
                                <input type="text" name="external_link" class="form-control"
                                    placeholder="Amazon,flipkart..."
                                    value="{{ old('external_link', $product->external_link) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea name="description" class="form-control" rows="8">{{ old('description', $product->description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Pricing</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Price *</label>
                                    <input type="number" step="0.01" name="price" class="form-control"
                                        value="{{ old('price', $product->price) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Compare at price</label>
                                    <input type="number" step="0.01" name="compare_at_price" class="form-control"
                                        value="{{ old('compare_at_price', $product->compare_at_price) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Inventory</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">SKU</label>
                                    <input type="text" name="sku" class="form-control"
                                        value="{{ old('sku', $product->sku) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Barcode</label>
                                    <input type="text" name="barcode" class="form-control"
                                        value="{{ old('barcode', $product->barcode) }}">
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="track_quantity" value="1"
                                            id="trackQuantity" {{ $product->track_quantity ? 'checked' : '' }}>
                                        <label class="form-check-label" for="trackQuantity">Track quantity</label>
                                    </div>
                                    <div class="mt-3 w-50">
                                        <input type="number" name="stock_quantity" class="form-control"
                                            value="{{ old('stock_quantity', $product->stock_quantity) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">

                    <!-- Marketing Links Section -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">
                            <h5 class="form-section-title fw-bold mb-0">Marketing / Ad Links</h5>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#generateLinkModal">
                                <i class="bx bx-plus"></i> Create Link
                            </button>
                        </div>
                        <div class="card-body">
                            @if($product->marketingLinks->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($product->marketingLinks as $link)
                                        <div class="list-group-item px-0">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <small class="fw-bold text-uppercase">{{ $link->platform }}</small>
                                                <small class="text-muted">{{ $link->campaign_name }}</small>
                                            </div>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control" value="{{ $link->generated_url }}" readonly id="link-{{ $link->id }}">
                                                <button class="btn btn-outline-primary copy-btn" type="button" data-clipboard-target="#link-{{ $link->id }}">
                                                    <i class="bx bx-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted small text-center my-3">No marketing links yet.</p>
                            @endif
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Status</h5>
                        </div>
                        <div class="card-body">
                            <select name="status" class="form-select">
                                <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="draft" {{ $product->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="archived" {{ $product->status == 'archived' ? 'selected' : '' }}>Archived
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Media</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="image-preview-wrapper mb-3" id="preview_box">
                                @if ($product->thumbnail)
                                    <img src="{{ asset($product->thumbnail) }}" alt="Current Image">
                                @else
                                    <i class="bx bx-image-add bx-lg text-muted"></i>
                                @endif
                            </div>
                            <input type="file" name="thumbnail" id="thumbnail_input" class="form-control"
                                accept="image/*">
                            <small class="text-muted mt-2 d-block">Leave blank to keep current image</small>
                        </div>
                    </div>

                    {{-- Existing Media Section --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Product Gallery</h5>
                        </div>
                        <div class="card-body">
                            {{-- 1. पुरानी इमेजेस का ग्रिड --}}
                            <div class="row g-2 mb-4" id="gallery-wrapper">
                                @foreach ($product->images as $image)
                                    <div
                                        class="col-md-3 col-6 text-center position-relative gallery-item-{{ $image->id }}">
                                        <div class="border rounded p-1">
                                            <img src="{{ asset($image->image_path) }}" class="img-fluid rounded"
                                                style="height: 100px; width: 100%; object-fit: cover;">
                                            {{-- डिलीट बटन --}}
                                            <button type="button"
                                                class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle remove-img"
                                                data-id="{{ $image->id }}" style="padding: 2px 6px;">&times;</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- 2. नई इमेजेस अपलोड करने का इनपुट --}}
                            <label class="form-label fw-semibold">Add More Images</label>
                            <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mb-5">
                <button type="submit" class="btn btn-primary btn-lg px-5 shadow">Update Product</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.10/clipboard.min.js"></script>
    <script>
        // Copy to clipboard init
        new ClipboardJS('.copy-btn');

        $(document).on('click', '.remove-img', function() {
            let id = $(this).data('id');
            let parentDiv = $('.gallery-item-' + id);

            if (confirm('Are you sure?')) {
                $.ajax({
                    url: "{{ route('admin.product-control.image.delete') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.success) {
                            parentDiv.fadeOut('slow', function() {
                                $(this).remove();
                            });
                        }
                    }
                });
            }
        });

        // Generate Link AJAX
        $('#generateLinkForm').on('submit', function(e){
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('admin.product-control.product.generate-link') }}",
                type: "POST",
                data: formData,
                success: function(res) {
                    if(res.success) {
                        alert(res.message);
                        location.reload();
                    } else {
                        alert('Error: ' + res.message);
                    }
                },
                error: function(err) {
                   alert('Something went wrong');
                   console.log(err);
                }
            });
        });
    </script>
@endpush

<!-- Generate Link Modal -->
<div class="modal fade" id="generateLinkModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <form class="modal-content" id="generateLinkForm">
            <div class="modal-header">
                <h5 class="modal-title">Generate UTM Link</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="mb-3">
                    <label class="form-label">Platform *</label>
                    <select name="platform" class="form-select" required>
                        <option value="facebook">Facebook (Meta)</option>
                        <option value="instagram">Instagram</option>
                        <option value="google">Google Ads</option>
                        <option value="whatsapp">WhatsApp</option>
                        <option value="email">Email</option>
                        <option value="sms">SMS</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Campaign Name</label>
                    <input type="text" name="campaign_name" class="form-control" placeholder="e.g. Diwali Sale 2026">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Generate & Save</button>
            </div>
        </form>
    </div>
</div>
