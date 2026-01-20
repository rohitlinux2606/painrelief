@extends('admin.layouts.app')

{{-- Styles same as create.blade.php --}}
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
            background: #000;
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Catalog /</span> {{ $title }}</h4>
            <a href="{{ route('admin.product-control.product-videos.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bx bx-arrow-back me-1"></i>Back
            </a>
        </div>

        <form action="{{ route('admin.product-control.product-videos.update', $video->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.layouts.messages')

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Select Product *</label>
                                <select name="product_id" class="form-select select2" required>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ $video->product_id == $product->id ? 'selected' : '' }}>
                                            {{ $product->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Video URL *</label>
                                <input type="url" name="video_url" id="video_url" class="form-control"
                                    value="{{ old('video_url', $video->video_url) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status</label>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <input class="form-check-input" type="radio" name="status" id="statusActive"
                                            value="1" {{ $video->status == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusActive">Active</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-check-input" type="radio" name="status" id="statusInactive"
                                            value="0" {{ $video->status == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusInactive">Inactive</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Video Preview</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="video-preview-container" id="videoPreview">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 shadow">Update Video</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5'
            });

            function loadPreview(url) {
                let regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=|shorts\/)([^#&?]*).*/;
                let match = url.match(regExp);
                if (match && match[2].length == 11) {
                    $('#videoPreview').html(
                        `<iframe src="https://www.youtube.com/embed/${match[2]}" allowfullscreen></iframe>`);
                } else {
                    $('#videoPreview').html(`<p class="text-muted">Invalid URL</p>`);
                }
            }

            // Page load par preview dikhao
            loadPreview($('#video_url').val());

            // Input change par preview update karo
            $('#video_url').on('input', function() {
                loadPreview($(this).val());
            });
        });
    </script>
@endpush
