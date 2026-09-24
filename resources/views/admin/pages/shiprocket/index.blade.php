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

        .status-card {
            border-left: 5px solid #696cff;
        }

        .status-card.connected {
            border-left-color: #71dd37;
        }

        .status-card.disconnected {
            border-left-color: #ff3e1d;
        }

        .status-card.expired {
            border-left-color: #ffab00;
        }

        .token-display {
            font-family: monospace;
            background-color: #f5f5f9;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            word-break: break-all;
        }

        .courier-table-container {
            max-height: 450px;
            overflow-y: auto;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row align-items-center mb-4 g-3">
            <div class="col-sm-6">
                <h4 class="fw-bold mb-0">
                    <span class="text-muted fw-light">Settings /</span> Shiprocket Integration
                </h4>
            </div>
            <div class="col-sm-6 text-sm-end">
                <button type="button" id="btn_test_connection" class="btn btn-outline-primary shadow-sm me-2">
                    <i class="bx bx-wifi me-1"></i> Test API Connection
                </button>
            </div>
        </div>

        @include('admin.layouts.messages')

        {{-- Status Summary Card --}}
        <div class="card status-card {{ $shiprocket->isTokenValid() ? 'connected' : ($shiprocket->token ? 'expired' : 'disconnected') }} mb-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar avatar-md flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-package fs-3"></i>
                            </span>
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold">Shiprocket Profile Status</h5>
                            <p class="mb-0 text-muted small">
                                @if ($shiprocket->isTokenValid())
                                    <span class="badge bg-label-success me-1"><i class="bx bx-check-circle me-1"></i>Connected</span>
                                    Token active until <strong>{{ $shiprocket->token_expires_at?->format('M d, Y h:i A') }}</strong>
                                @elseif($shiprocket->token)
                                    <span class="badge bg-label-warning me-1"><i class="bx bx-error me-1"></i>Token Expired</span>
                                    Token expired on {{ $shiprocket->token_expires_at?->format('M d, Y h:i A') }}. Please re-authenticate.
                                @else
                                    <span class="badge bg-label-secondary me-1"><i class="bx bx-x-circle me-1"></i>Not Connected</span>
                                    Enter your Shiprocket account credentials and test connection to authenticate.
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="badge {{ $shiprocket->status ? 'bg-success' : 'bg-secondary' }} px-3 py-2">
                            {{ $shiprocket->status ? 'Integration Active' : 'Integration Inactive' }}
                        </span>
                        @if ($shiprocket->last_connected_at)
                            <div class="text-muted small mt-1">
                                Last verified: {{ $shiprocket->last_connected_at->diffForHumans() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.shiprocket.store') }}" method="POST" id="shiprocket_form">
            @csrf
            <div class="row">
                {{-- Left Column: Credentials & API Settings --}}
                <div class="col-lg-7">
                    {{-- AUTHENTICATION CREDENTIALS --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">
                            <h5 class="form-section-title fw-bold mb-0">API Credentials & Authentication</h5>
                            <span class="text-muted small">Endpoint: <code>/v1/external/auth/login</code></span>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="sr_email">Shiprocket Account Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input type="email" id="sr_email" name="email" class="form-control"
                                        placeholder="admin@example.com"
                                        value="{{ old('email', $shiprocket->email ?? '') }}" required>
                                </div>
                                <div class="form-text">Registered email for logging in to your Shiprocket panel.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="sr_password">
                                    Shiprocket Password
                                    @if ($shiprocket->password)
                                        <span class="text-muted fw-normal">(Leave blank to keep existing password)</span>
                                    @else
                                        <span class="text-danger">*</span>
                                    @endif
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                                    <input type="password" id="sr_password" name="password" class="form-control"
                                        placeholder="••••••••••••"
                                        {{ $shiprocket->password ? '' : 'required' }}>
                                    <button class="btn btn-outline-secondary" type="button" id="toggle_password_btn">
                                        <i class="bx bx-show" id="toggle_password_icon"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="authenticate_now" id="authenticate_now" value="1" checked>
                                    <label class="form-check-label fw-semibold" for="authenticate_now">
                                        Authenticate & Refresh Token on Save
                                    </label>
                                </div>
                            </div>

                            @if ($shiprocket->token)
                                <div class="mt-4 pt-3 border-top">
                                    <label class="form-label fw-semibold text-muted small text-uppercase mb-1">Stored Bearer Token</label>
                                    <div class="token-display text-truncate" title="{{ $shiprocket->token }}">
                                        {{ Str::limit($shiprocket->token, 60, '...') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- SYSTEM & ENDPOINT CONFIGURATION --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">API Environment Configuration</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">API Base URL</label>
                                <input type="url" name="api_base_url" class="form-control"
                                    value="{{ old('api_base_url', $shiprocket->api_base_url ?? 'https://apiv2.shiprocket.in/v1/external') }}"
                                    placeholder="https://apiv2.shiprocket.in/v1/external">
                                <div class="form-text">Default official Shiprocket API v2 base URL.</div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card bg-label-secondary border-0 p-3 h-100">
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input" type="checkbox" name="status" id="status_switch" value="1"
                                                {{ old('status', $shiprocket->status ?? true) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold text-dark" for="status_switch">
                                                Enable Shiprocket Integration
                                            </label>
                                        </div>
                                        <small class="text-muted mt-1 d-block">Master toggle for dispatching orders via Shiprocket.</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card bg-label-secondary border-0 p-3 h-100">
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input" type="checkbox" name="is_sandbox" id="sandbox_switch" value="1"
                                                {{ old('is_sandbox', $shiprocket->is_sandbox ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold text-dark" for="sandbox_switch">
                                                Sandbox / Testing Mode
                                            </label>
                                        </div>
                                        <small class="text-muted mt-1 d-block">Enable if using a test/staging Shiprocket environment.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Shipping & Profile Details --}}
                <div class="col-lg-5">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">
                            <h5 class="form-section-title fw-bold mb-0">Pickup & Channel Profile</h5>
                            @if ($shiprocket->isTokenValid())
                                <button type="button" id="btn_fetch_locations" class="btn btn-sm btn-outline-secondary">
                                    <i class="bx bx-refresh me-1"></i> Refresh Locations
                                </button>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="pickup_location">Primary Pickup Location Name</label>
                                @if(!empty($pickupLocations) && count($pickupLocations) > 0)
                                    <select name="pickup_location" id="pickup_location" class="form-select">
                                        <option value="">-- Select Pickup Location --</option>
                                        @foreach($pickupLocations as $loc)
                                            @php $locName = $loc['pickup_location'] ?? ($loc['name'] ?? ''); @endphp
                                            <option value="{{ $locName }}" {{ old('pickup_location', $shiprocket->pickup_location) == $locName ? 'selected' : '' }}>
                                                {{ $locName }} ({{ $loc['pin_code'] ?? $loc['pincode'] ?? '' }})
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text" name="pickup_location" id="pickup_location" class="form-control"
                                        placeholder="e.g. Primary, Warehouse, Home"
                                        value="{{ old('pickup_location', $shiprocket->pickup_location ?? '') }}">
                                @endif
                                <div class="form-text">Must match the pickup location name configured in your Shiprocket account dashboard.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Pickup Location Pincode</label>
                                <input type="text" name="pincode" id="sr_profile_pincode" class="form-control" placeholder="110001"
                                    value="{{ old('pincode', $shiprocket->pincode ?? '') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Default Channel ID</label>
                                <input type="text" name="channel_id" class="form-control" placeholder="e.g. 123456"
                                    value="{{ old('channel_id', $shiprocket->channel_id ?? '') }}">
                                <div class="form-text">Optional Channel ID assigned by Shiprocket for custom store orders.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Company / Store Name</label>
                                <input type="text" name="company_name" class="form-control" placeholder="My Online Store"
                                    value="{{ old('company_name', $shiprocket->company_name ?? '') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Contact Phone Number</label>
                                <input type="text" name="phone" class="form-control" placeholder="+91 9876543210"
                                    value="{{ old('phone', $shiprocket->phone ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mb-4">
                <button type="submit" class="btn btn-primary btn-lg px-5 shadow">
                    <i class="bx bx-save me-1"></i> Save Shiprocket Profile
                </button>
            </div>
        </form>

        {{-- SHIPROCKET GET SPECIFIC ORDER DETAILS WIDGET --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-transparent py-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <h5 class="form-section-title fw-bold mb-0">Get Specific Order Details</h5>
                    <span class="text-muted small">Endpoint: <code>GET /v1/external/orders/show/{order_id}</code></span>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3 align-items-end mb-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Shiprocket Order ID / Shipment ID</label>
                        <input type="text" id="lookup_order_id" class="form-control" placeholder="e.g. 16167171 or ORD-12345">
                    </div>
                    <div class="col-md-4">
                        <button type="button" id="btn_fetch_order_details" class="btn btn-primary w-100 shadow-sm">
                            <i class="bx bx-search-alt me-1"></i> Fetch Order Details
                        </button>
                    </div>
                </div>

                <div id="order_details_result" style="display: none;" class="mt-4 pt-3 border-top">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="fw-bold text-primary mb-0"><i class="bx bx-info-circle me-1"></i> Order Information</h6>
                        <button type="button" id="btn_view_order_json" class="btn btn-sm btn-outline-secondary">
                            <i class="bx bx-code-alt me-1"></i> View Raw API Response
                        </button>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <small class="text-muted d-block">Shiprocket Order ID</small>
                            <span id="dt_order_id" class="fw-bold text-dark"></span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Channel Order ID</small>
                            <span id="dt_channel_order_id" class="fw-bold"></span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Status</small>
                            <span id="dt_status" class="badge bg-label-info"></span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Payment Method</small>
                            <span id="dt_payment_method" class="fw-semibold"></span>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <small class="text-muted d-block">Customer Name</small>
                            <span id="dt_customer_name" class="fw-semibold"></span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Customer Email</small>
                            <span id="dt_customer_email"></span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Customer Phone</small>
                            <span id="dt_customer_phone"></span>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Delivery Address</small>
                            <div id="dt_address" class="small bg-light p-2 rounded"></div>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Pickup Location</small>
                            <div id="dt_pickup_location" class="small bg-light p-2 rounded"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- COURIER SERVICEABILITY CHECK WIDGET --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-transparent py-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <h5 class="form-section-title fw-bold mb-0">Check Courier Serviceability & Rates</h5>
                    <span class="text-muted small">Endpoint: <code>GET /v1/external/courier/serviceability/</code></span>
                </div>
            </div>
            <div class="card-body">
                <form id="serviceability_form">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Pickup Pincode <span class="text-danger">*</span></label>
                            <input type="text" id="svc_pickup_pincode" class="form-control" placeholder="110001"
                                value="{{ $shiprocket->pincode ?? '' }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Delivery Pincode <span class="text-danger">*</span></label>
                            <input type="text" id="svc_delivery_pincode" class="form-control" placeholder="400001" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Weight (Kg) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" id="svc_weight" class="form-control" value="0.5" min="0.01" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Payment Mode</label>
                            <select id="svc_cod" class="form-select">
                                <option value="0">Prepaid</option>
                                <option value="1">COD (Cash on Delivery)</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" id="btn_check_serviceability" class="btn btn-primary w-100 shadow-sm">
                                <i class="bx bx-search-alt me-1"></i> Check Rates
                            </button>
                        </div>
                    </div>
                </form>

                {{-- Serviceability Results Section --}}
                <div id="serviceability_results" class="mt-4" style="display: none;">
                    <div id="svc_summary_alert" class="alert alert-info d-flex align-items-center mb-3" role="alert">
                        <i class="bx bx-info-circle fs-4 me-2"></i>
                        <div id="svc_summary_text"></div>
                    </div>

                    <div class="courier-table-container border rounded">
                        <table class="table table-hover align-middle mb-0" id="svc_table">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th>Courier Partner</th>
                                    <th>Mode</th>
                                    <th>Rate (₹)</th>
                                    <th>Est. Delivery (ETD)</th>
                                    <th>COD Status</th>
                                    <th class="text-end">Raw JSON</th>
                                </tr>
                            </thead>
                            <tbody id="svc_table_body"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- SHIPROCKET COURIERS LIST SECTION --}}
        <div class="card shadow-sm mb-5">
            <div class="card-header bg-transparent py-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <h5 class="form-section-title fw-bold mb-0">Courier Partners & Counts</h5>
                    <span class="text-muted small">Endpoint: <code>GET /v1/external/courier/courierListWithCounts</code></span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <input type="text" id="courier_search_input" class="form-control form-control-sm" placeholder="Search courier..." style="width: 200px;">
                    <button type="button" id="btn_fetch_couriers" class="btn btn-sm btn-primary shadow-sm">
                        <i class="bx bx-refresh me-1"></i> Fetch / Refresh Couriers
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="courier-table-container">
                    <table class="table table-hover align-middle mb-0" id="couriers_table">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Courier ID</th>
                                <th>Courier Name</th>
                                <th>Mode / Category</th>
                                <th>Status / Active</th>
                                <th>Shipment / Order Count</th>
                                <th class="text-end">Raw Data</th>
                            </tr>
                        </thead>
                        <tbody id="couriers_table_body">
                            @if(!empty($courierList) && count($courierList) > 0)
                                @foreach($courierList as $courier)
                                    @php
                                        $id = $courier['id'] ?? ($courier['courier_id'] ?? '-');
                                        $name = $courier['name'] ?? ($courier['courier_name'] ?? 'Courier Partner');
                                        $mode = $courier['mode'] ?? ($courier['category'] ?? ($courier['type'] ?? 'Surface/Air'));
                                        $status = isset($courier['status']) ? ($courier['status'] ? 'Active' : 'Inactive') : (isset($courier['active']) ? ($courier['active'] ? 'Active' : 'Inactive') : 'Active');
                                        $count = $courier['count'] ?? ($courier['shipment_count'] ?? ($courier['order_count'] ?? 0));
                                    @endphp
                                    <tr>
                                        <td><code>{{ $id }}</code></td>
                                        <td class="fw-semibold text-dark">{{ $name }}</td>
                                        <td>
                                            <span class="badge bg-label-info">{{ ucfirst($mode) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $status === 'Active' ? 'bg-label-success' : 'bg-label-secondary' }}">
                                                {{ $status }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $count }}</span>
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary view-courier-json"
                                                data-json="{{ json_encode($courier) }}" title="View Courier JSON Details">
                                                <i class="bx bx-code-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="bx bx-run bx-sm mb-1 d-block"></i>
                                        No courier partners loaded yet. Click <strong>"Fetch / Refresh Couriers"</strong> to call the Shiprocket Courier List API.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- COURIER / ORDER JSON DETAILS MODAL --}}
    <div class="modal fade" id="courierJsonModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modal_title_text">Shiprocket API Raw Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <pre id="courier_json_content" class="bg-dark text-light p-3 rounded" style="max-height: 400px; overflow-y: auto; font-size: 0.85rem;"></pre>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let currentOrderJson = null;

            // Password Visibility Toggle
            $('#toggle_password_btn').click(function() {
                const input = $('#sr_password');
                const icon = $('#toggle_password_icon');
                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('bx-show').addClass('bx-hide');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('bx-hide').addClass('bx-show');
                }
            });

            // AJAX Test Connection Button
            $('#btn_test_connection').click(function(e) {
                e.preventDefault();
                const btn = $(this);
                const originalText = btn.html();

                const email = $('#sr_email').val();
                const password = $('#sr_password').val();

                if (!email) {
                    alert('Please enter your Shiprocket account email.');
                    $('#sr_email').focus();
                    return;
                }

                btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin me-1"></i> Authenticating...');

                $.ajax({
                    url: "{{ route('admin.shiprocket.test-connection') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: email,
                        password: password
                    },
                    success: function(response) {
                        btn.prop('disabled', false).html(originalText);
                        if (response.success) {
                            alert('Success: ' + response.message);
                            window.location.reload();
                        } else {
                            alert('Authentication Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html(originalText);
                        let msg = 'Failed to connect to Shiprocket API server.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        alert('Error: ' + msg);
                    }
                });
            });

            // Fetch Pickup Locations via AJAX
            $('#btn_fetch_locations').click(function() {
                const btn = $(this);
                const originalText = btn.html();
                btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin me-1"></i> Fetching...');

                $.ajax({
                    url: "{{ route('admin.shiprocket.fetch-locations') }}",
                    type: "GET",
                    success: function(response) {
                        btn.prop('disabled', false).html(originalText);
                        if (response.success && response.locations && response.locations.length > 0) {
                            let options = '<option value="">-- Select Pickup Location --</option>';
                            response.locations.forEach(function(loc) {
                                const name = loc.pickup_location || loc.name || '';
                                const pin = loc.pin_code || loc.pincode || '';
                                options += `<option value="${name}">${name} (${pin})</option>`;
                            });

                            let selectHtml = `<select name="pickup_location" id="pickup_location" class="form-select">${options}</select>`;
                            $('#pickup_location').replaceWith(selectHtml);
                            alert('Fetched ' + response.locations.length + ' pickup location(s) successfully!');
                        } else {
                            alert('Notice: ' + (response.message || 'No pickup locations found on your Shiprocket account.'));
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false).html(originalText);
                        alert('Could not retrieve pickup locations. Ensure API token is active.');
                    }
                });
            });

            // Fetch Specific Order Details via AJAX
            $('#btn_fetch_order_details').click(function() {
                const orderId = $('#lookup_order_id').val();
                if (!orderId) {
                    alert('Please enter a Shiprocket Order ID or Shipment ID.');
                    $('#lookup_order_id').focus();
                    return;
                }

                const btn = $(this);
                const originalText = btn.html();
                btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin me-1"></i> Fetching...');

                $.ajax({
                    url: "{{ url('admin/shiprocket/order-details') }}/" + encodeURIComponent(orderId),
                    type: "GET",
                    success: function(response) {
                        btn.prop('disabled', false).html(originalText);
                        if (response.success && response.order) {
                            currentOrderJson = response.raw_data || response.order;
                            const ord = response.order;

                            $('#dt_order_id').text(ord.id || ord.order_id || orderId);
                            $('#dt_channel_order_id').text(ord.channel_order_id || ord.order_number || 'N/A');
                            $('#dt_status').text(ord.status || 'NEW');
                            $('#dt_payment_method').text(ord.payment_method || 'N/A');
                            $('#dt_customer_name').text(ord.customer_name || (ord.billing_customer_name ? ord.billing_customer_name + ' ' + (ord.billing_last_name || '') : 'N/A'));
                            $('#dt_customer_email').text(ord.customer_email || ord.billing_email || 'N/A');
                            $('#dt_customer_phone').text(ord.customer_phone || ord.billing_phone || 'N/A');

                            const addr = [ord.customer_address || ord.billing_address, ord.customer_city || ord.billing_city, ord.customer_state || ord.billing_state, ord.customer_pincode || ord.billing_pincode].filter(Boolean).join(', ');
                            $('#dt_address').text(addr || 'N/A');
                            $('#dt_pickup_location').text(ord.pickup_location || 'Primary');

                            $('#order_details_result').slideDown();
                        } else {
                            alert('Order Details Error: ' + (response.message || 'Order not found on Shiprocket.'));
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html(originalText);
                        let msg = 'Failed to fetch order details.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        alert('Error: ' + msg);
                    }
                });
            });

            $('#btn_view_order_json').click(function() {
                if (currentOrderJson) {
                    $('#modal_title_text').text('Shiprocket Order Details API JSON');
                    $('#courier_json_content').text(JSON.stringify(currentOrderJson, null, 4));
                    $('#courierJsonModal').modal('show');
                }
            });

            // Fetch Couriers List via AJAX
            $('#btn_fetch_couriers').click(function() {
                const btn = $(this);
                const originalText = btn.html();
                btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin me-1"></i> Loading...');

                $.ajax({
                    url: "{{ route('admin.shiprocket.fetch-couriers') }}",
                    type: "GET",
                    success: function(response) {
                        btn.prop('disabled', false).html(originalText);
                        if (response.success && response.couriers) {
                            renderCouriersTable(response.couriers);
                        } else {
                            alert('Error: ' + (response.message || 'Failed to retrieve courier list.'));
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html(originalText);
                        let msg = 'Failed to fetch courier list.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        alert('Error: ' + msg);
                    }
                });
            });

            // Check Courier Serviceability via AJAX
            $('#btn_check_serviceability').click(function() {
                const pickup = $('#svc_pickup_pincode').val();
                const delivery = $('#svc_delivery_pincode').val();
                const weight = $('#svc_weight').val();
                const cod = $('#svc_cod').val();

                if (!pickup || !delivery) {
                    alert('Please enter both pickup and delivery pincodes.');
                    return;
                }

                const btn = $(this);
                const originalText = btn.html();
                btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin me-1"></i> Checking...');

                $.ajax({
                    url: "{{ route('admin.shiprocket.check-serviceability') }}",
                    type: "GET",
                    data: {
                        pickup_postcode: pickup,
                        delivery_postcode: delivery,
                        weight: weight,
                        cod: cod
                    },
                    success: function(response) {
                        btn.prop('disabled', false).html(originalText);
                        if (response.success) {
                            renderServiceabilityResults(response, delivery);
                        } else {
                            alert('Serviceability Error: ' + (response.message || 'Failed to fetch serviceability.'));
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html(originalText);
                        let msg = 'Failed to check serviceability.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        alert('Error: ' + msg);
                    }
                });
            });

            // Render Serviceability Results Table
            function renderServiceabilityResults(data, deliveryPincode) {
                const resultsContainer = $('#serviceability_results');
                const tbody = $('#svc_table_body');
                tbody.empty();

                const couriers = data.available_couriers || [];
                const recommendedId = data.recommended_courier_id;

                $('#svc_summary_text').html(`Found <strong>${couriers.length}</strong> available courier partner(s) for delivery to pincode <strong>${deliveryPincode}</strong>.`);
                resultsContainer.show();

                if (couriers.length === 0) {
                    tbody.append(`
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No courier serviceability found for destination pincode ${deliveryPincode}.
                            </td>
                        </tr>
                    `);
                    return;
                }

                couriers.forEach(function(c) {
                    const cId = c.courier_company_id || c.id || '';
                    const cName = c.courier_name || c.name || 'Courier Partner';
                    const isRecommended = (recommendedId && cId == recommendedId);
                    const rate = c.rate !== undefined ? c.rate : (c.freight_charge !== undefined ? c.freight_charge : '-');
                    const etd = c.etd || c.estimated_delivery_days || 'Standard';
                    const codAvailable = c.cod !== undefined ? (c.cod ? 'Available' : 'Not Available') : 'N/A';
                    const mode = c.mode || c.category || 'Surface';
                    const jsonStr = JSON.stringify(c).replace(/'/g, "&apos;");

                    tbody.append(`
                        <tr>
                            <td>
                                <div class="fw-semibold text-dark">${cName}</div>
                                <small class="text-muted">ID: ${cId}</small>
                                ${isRecommended ? '<span class="badge bg-success ms-2"><i class="bx bx-star me-1"></i>Recommended</span>' : ''}
                            </td>
                            <td><span class="badge bg-label-info">${mode}</span></td>
                            <td class="fw-bold text-success">₹${rate}</td>
                            <td>${etd}</td>
                            <td>
                                <span class="badge ${codAvailable === 'Available' ? 'bg-label-success' : 'bg-label-warning'}">
                                    ${codAvailable}
                                </span>
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-icon btn-outline-secondary view-courier-json"
                                    data-json='${jsonStr}' title="View Raw JSON">
                                    <i class="bx bx-code-alt"></i>
                                </button>
                            </td>
                        </tr>
                    `);
                });
            }

            // Render Couriers Table Function
            function renderCouriersTable(couriers) {
                const tbody = $('#couriers_table_body');
                tbody.empty();

                let courierArray = [];
                if (Array.isArray(couriers)) {
                    courierArray = couriers;
                } else if (typeof couriers === 'object') {
                    courierArray = Object.values(couriers);
                }

                if (courierArray.length === 0) {
                    tbody.append(`
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No courier partners found in API response.
                            </td>
                        </tr>
                    `);
                    return;
                }

                courierArray.forEach(function(c) {
                    const id = c.id || c.courier_id || '-';
                    const name = c.name || c.courier_name || 'Courier Partner';
                    const mode = c.mode || c.category || c.type || 'Surface/Air';
                    const status = (c.status !== undefined ? (c.status ? 'Active' : 'Inactive') : (c.active !== undefined ? (c.active ? 'Active' : 'Inactive') : 'Active'));
                    const count = c.count !== undefined ? c.count : (c.shipment_count !== undefined ? c.shipment_count : (c.order_count !== undefined ? c.order_count : 0));
                    const jsonStr = JSON.stringify(c).replace(/'/g, "&apos;");

                    tbody.append(`
                        <tr>
                            <td><code>${id}</code></td>
                            <td class="fw-semibold text-dark">${name}</td>
                            <td><span class="badge bg-label-info">${mode}</span></td>
                            <td><span class="badge ${status === 'Active' ? 'bg-label-success' : 'bg-label-secondary'}">${status}</span></td>
                            <td><span class="fw-bold">${count}</span></td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-icon btn-outline-secondary view-courier-json"
                                    data-json='${jsonStr}' title="View Courier Details">
                                    <i class="bx bx-code-alt"></i>
                                </button>
                            </td>
                        </tr>
                    `);
                });
            }

            // View Courier JSON Modal Handler
            $(document).on('click', '.view-courier-json', function() {
                const json = $(this).data('json');
                $('#modal_title_text').text('Shiprocket API Raw Data');
                $('#courier_json_content').text(JSON.stringify(json, null, 4));
                $('#courierJsonModal').modal('show');
            });

            // Live Search Filter for Couriers Table
            $('#courier_search_input').on('keyup', function() {
                const value = $(this).val().toLowerCase();
                $('#couriers_table_body tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
@endpush
