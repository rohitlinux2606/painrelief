@extends('admin.layouts.app')

@push('styles')
    <style>
        .video-preview-img {
            width: 60px;
            height: 80px;
            /* 9:16 aspect ratio for shorts */
            object-fit: cover;
            border-radius: 4px;
            background: #000;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Catalog /</span> Product Shorts</h4>
            <div>
                <a href="{{ route('admin.product-control.product-videos.create') }}" class="btn btn-primary shadow-sm">
                    <i class='bx bx-plus-circle me-1'></i> Add New Short
                </a>
            </div>
        </div>

        {{-- FILTERS --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                @include('admin.layouts.messages')
                <form action="{{ route('admin.product-control.product-videos.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label small fw-bold">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Search by Product Title or Video URL...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary w-100"><i class='bx bx-filter-alt'></i>
                                Filter</button>
                            <a href="{{ route('admin.product-control.product-videos.index') }}"
                                class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card shadow-sm border-0">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="80">Preview</th>
                            <th>Product Info</th>
                            <th>Video Link</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($videos as $video)
                            <tr>
                                <td>
                                    @php
                                        // Extract YouTube ID to show thumbnail
                                        preg_match(
                                            '/(?<=v=|v\/|vi\/|be\/|shorts\/|embed\/)[^#\&\?]+/',
                                            $video->video_url,
                                            $matches,
                                        );
                                        $videoId = $matches[0] ?? null;
                                    @endphp
                                    @if ($videoId)
                                        <img src="https://img.youtube.com/vi/{{ $videoId }}/mqdefault.jpg"
                                            class="video-preview-img">
                                    @else
                                        <div
                                            class="video-preview-img d-flex align-items-center justify-content-center bg-dark text-white small">
                                            No ID</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark">{{ $video->product->title ?? 'N/A' }}</span>
                                        <small class="text-muted">ID: #{{ $video->product_id }}</small>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ $video->video_url }}" target="_blank" class="text-primary small">
                                        <i class='bx bx-link-external'></i> View Video
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-label-{{ $video->status ? 'success' : 'secondary' }}">
                                        <span class="status-dot bg-{{ $video->status ? 'active' : 'draft' }}"></span>
                                        {{ $video->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.product-control.product-videos.edit', $video->id) }}"
                                            class="btn btn-sm btn-icon btn-outline-primary m-1">
                                            <i class='bx bx-edit-alt'></i>
                                        </a>
                                        <form
                                            action="{{ route('admin.product-control.product-videos.destroy', $video->id) }}"
                                            method="POST" class="d-inline" onsubmit="return confirm('Delete this video?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-icon btn-outline-danger m-1">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">No product videos found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-transparent border-top">
                {{ $videos->links() }}
            </div>
        </div>
    </div>
@endsection
