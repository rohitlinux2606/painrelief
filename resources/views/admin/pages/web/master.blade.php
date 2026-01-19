@extends('admin.layouts.app')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
    <style>
        .img-preview {
            width: 120px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #ddd;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold mb-4">Website Master Settings</h4>

        @include('admin.layouts.messages')

        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Manage Website Content</h5>
            </div>

            <form action="{{ route('admin.web.webmaster.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body">

                    {{-- HERO SECTION --}}
                    <h5 class="fw-bold mb-3">Hero Section</h5>
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Hero Title</label>
                            <input type="text" name="hero_title" class="form-control"
                                value="{{ old('hero_title', $webmaster->hero_title ?? '') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Hero Sub Title</label>
                            <input type="text" name="hero_subtitle" class="form-control"
                                value="{{ old('hero_subtitle', $webmaster->hero_subtitle ?? '') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Hero Button Text</label>
                            <input type="text" name="hero_btn" class="form-control"
                                value="{{ old('hero_btn', $webmaster->hero_btn ?? '') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Hero Button Link</label>
                            <input type="text" name="hero_link" class="form-control"
                                value="{{ old('hero_link', $webmaster->hero_link ?? '') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Hero Image</label>
                            <input type="file" name="hero_image" class="form-control">
                            @if (!empty($webmaster->hero_image))
                                <img src="{{ asset($webmaster->hero_image) }}" class="img-preview mt-2">
                            @endif
                        </div>

                    </div>

                    <hr>

                    {{-- ABOUT SECTION --}}
                    <h5 class="fw-bold mb-3">About Section</h5>
                    <div class="row">

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">About Description</label>
                            <textarea name="about_description" rows="3" class="form-control">{{ old('about_description', $webmaster->about_description ?? '') }}</textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">About Image</label>
                            <input type="file" name="about_image" class="form-control">
                            @if (!empty($webmaster->about_image))
                                <img src="{{ asset($webmaster->about_image) }}" class="img-preview mt-2">
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Logo</label>
                            <input type="file" name="logo" class="form-control">
                            @if (!empty($webmaster->logo))
                                <img src="{{ asset($webmaster->logo) }}" class="img-preview mt-2">
                            @endif
                        </div>

                    </div>

                    <hr>

                    {{-- OFFER SECTION --}}
                    <h5 class="fw-bold mb-3">Offer Section</h5>
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Related Offer Trip</label>
                            <select name="trip_id" class="form-select select2">
                                <option value="">Select Trip</option>
                                @foreach ($trips as $trip)
                                    <option value="{{ $trip->id }}"
                                        {{ old('trip_id', $webmaster->trip_id ?? '') == $trip->id ? 'selected' : '' }}>
                                        {{ $trip->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Offer Title</label>
                            <input type="text" name="offer_title" class="form-control"
                                value="{{ old('offer_title', $webmaster->offer_title ?? '') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Offer Sub Title</label>
                            <input type="text" name="offer_subtitle" class="form-control"
                                value="{{ old('offer_subtitle', $webmaster->offer_subtitle ?? '') }}">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Offer Description</label>
                            <textarea name="offer_description" rows="3" class="form-control">{{ old('offer_description', $webmaster->offer_description ?? '') }}</textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Offer Image</label>
                            <input type="file" name="offer_image" class="form-control">
                            @if (!empty($webmaster->offer_image))
                                <img src="{{ asset($webmaster->offer_image) }}" class="img-preview mt-2">
                            @endif
                        </div>

                    </div>

                    <hr>

                    {{-- CONTACT + SOCIAL --}}
                    <h5 class="fw-bold mb-3">Contact & Social</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Name</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $webmaster->name ?? '') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Owner Name</label>
                            <input type="text" name="owner_name" class="form-control"
                                value="{{ old('owner_name', $webmaster->owner_name ?? '') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $webmaster->phone ?? '') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Phone 2</label>
                            <input type="text" name="phone_2" class="form-control"
                                value="{{ old('phone_2', $webmaster->phone_2 ?? '') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $webmaster->email ?? '') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">GST No</label>
                            <input type="text" name="gst_no" class="form-control"
                                value="{{ old('gst_no', $webmaster->gst_no ?? '') }}">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Address</label>
                            <textarea name="address" rows="2" class="form-control">{{ old('address', $webmaster->address ?? '') }}</textarea>
                        </div>

                        {{-- Social --}}
                        @php
                            $socials = ['facebook', 'twitter', 'instagram', 'linkedin', 'youtube'];
                        @endphp

                        @foreach ($socials as $social)
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">{{ ucfirst($social) }} Link</label>
                                <input type="text" name="{{ $social }}" class="form-control"
                                    value="{{ old($social, $webmaster->$social ?? '') }}">
                            </div>
                        @endforeach

                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bx bx-save"></i> Save Changes
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap-5",
                width: "100%",
                allowClear: true,
            });
        });
    </script>
@endpush
