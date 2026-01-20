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

        .video-preview-container {
            width: 100%;
            aspect-ratio: 9/16;
            /* Shorts format */
            background: #f5f5f9;
            border: 2px dashed #d9dee3;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .video-preview-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row align-items-center mb-4 g-3">
            <div class="col-sm-6">
                <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Catalog /</span> {{ $title }}</h4>
            </div>
            <div class="col-sm-6 text-sm-end">
                <a href="{{ route('admin.product-control.product-videos.index') }}"
                    class="btn btn-outline-secondary btn-sm shadow-sm">
                    <i class="bx bx-arrow-back me-1"></i>Back to List
                </a>
            </div>
        </div>

        <form action="{{ route('admin.product-control.product-videos.store') }}" method="POST">
            @csrf
            @include('admin.layouts.messages')

            <div class="row">
                {{-- Left Side: Form Fields --}}
                <div class="col-lg-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Video Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Select Product *</label>
                                <select name="product_id" class="form-select select2" required>
                                    <option value="">-- Search and Select Product --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->title }} (SKU: {{ $product->sku ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Video URL (YouTube/Shorts) *</label>
                                <input type="url" name="video_url" id="video_url" class="form-control"
                                    placeholder="https://www.youtube.com/shorts/xxxxxx" value="{{ old('video_url') }}"
                                    required>
                                <small class="text-muted">Paste the full YouTube Shorts or Video link.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Display Status</label>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check custom-option custom-option-basic">
                                            <label class="form-check-label custom-option-content" for="statusActive">
                                                <input class="form-check-input" type="radio" name="status"
                                                    id="statusActive" value="1"
                                                    {{ old('status', '1') == '1' ? 'checked' : '' }}>
                                                <span class="custom-option-header">
                                                    <span class="h6 mb-0">Active</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check custom-option custom-option-basic">
                                            <label class="form-check-label custom-option-content" for="statusInactive">
                                                <input class="form-check-input" type="radio" name="status"
                                                    id="statusInactive" value="0"
                                                    {{ old('status') == '0' ? 'checked' : '' }}>
                                                <span class="custom-option-header">
                                                    <span class="h6 mb-0">Inactive</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Side: Preview --}}
                <div class="col-lg-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Video Preview</h5>
                        </div>
                        <div class="card-body">
                            <div class="video-preview-container" id="videoPreview">
                                <div class="text-center p-3 text-muted">
                                    <i class="bx bx-video bx-lg mb-2"></i>
                                    <p class="mb-0 small">Enter URL to see preview</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-3 shadow">
                                <i class="bx bx-save me-1"></i> Save Video
                            </button>
                            <a href="{{ route('admin.product-control.product-videos.index') }}"
                                class="btn btn-label-secondary w-100">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Select2 initialization
            $('.select2').select2({
                theme: 'bootstrap-5',
                placeholder: 'Choose a product'
            });

            // YouTube Preview Logic
            $('#video_url').on('input', function() {
                let url = $(this).val();
                let videoId = extractVideoID(url);

                if (videoId) {
                    $('#videoPreview').html(`
                        <iframe src="https://www.youtube.com/embed/${videoId}"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                    `);
                } else {
                    $('#videoPreview').html(`
                        <div class="text-center p-3 text-muted">
                            <i class="bx bx-video-off bx-lg mb-2"></i>
                            <p class="mb-0 small">Invalid YouTube URL</p>
                        </div>
                    `);
                }
            });

            function extractVideoID(url) {
                let regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=|shorts\/)([^#&?]*).*/;
                let match = url.match(regExp);
                return (match && match[2].length == 11) ? match[2] : false;
            }
        });
    </script>
@endpush
