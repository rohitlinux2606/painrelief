@extends('admin.layouts.app')

@section('title', $title)

@push('styles')
    <style>
        .shiprocket-card {
            border-left: 5px solid #696cff;
        }

        .shiprocket-card.shipped {
            border-left-color: #71dd37;
        }

        .tracking-timeline {
            position: relative;
            padding-left: 20px;
            border-left: 2px solid #e7e7e8;
        }

        .tracking-step {
            position: relative;
            margin-bottom: 15px;
        }

        .tracking-step::before {
            content: '';
            position: absolute;
            left: -26px;
            top: 2px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #696cff;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl container-p-y">

        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">
                <span class="text-muted fw-light">Orders /</span> #{{ $order->order_number }}
            </h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.order-control.order.index') }}" class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Back to Orders
                </a>
            </div>
        </div>

        @include('admin.layouts.messages')

        <div class="row">
            {{-- Order Status & Summary --}}
            <div class="col-lg-8">
                {{-- Items Table Card --}}
                <div class="card mb-4 shadow-sm">
                    <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                        <span>Order Items</span>
                        <span class="badge bg-primary">Total Items: {{ $order->items->count() }}</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td><strong>{{ $item->title }}</strong></td>
                                        <td>₹{{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end">₹{{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end">Subtotal:</td>
                                    <td class="text-end">₹{{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">Tax:</td>
                                    <td class="text-end">₹{{ number_format($order->tax, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">Shipping:</td>
                                    <td class="text-end">₹{{ number_format($order->shipping, 2) }}</td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="3" class="text-end">Grand Total:</td>
                                    <td class="text-end text-primary fs-5">₹{{ number_format($order->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {{-- SHIPROCKET INTEGRATION & FULFILLMENT CARD --}}
                <div class="card mb-4 shadow-sm shiprocket-card {{ $order->hasShiprocketOrder() ? 'shipped' : '' }}">
                    <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bx bx-package fs-4 text-primary"></i>
                            <h5 class="fw-bold mb-0">Shiprocket Fulfillment</h5>
                        </div>
                        @if ($order->hasShiprocketOrder())
                            <span class="badge bg-label-success px-3 py-2">
                                <i class="bx bx-check-circle me-1"></i> Shipped via Shiprocket
                            </span>
                        @else
                            <span class="badge bg-label-secondary px-3 py-2">Not Shipped yet</span>
                        @endif
                    </div>
                    <div class="card-body">
                        @if ($order->hasShiprocketOrder())
                            {{-- SHIPROCKET ORDER DETAILS --}}
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6 col-md-3">
                                    <label class="text-muted small fw-semibold">Shiprocket Order ID</label>
                                    <div class="fw-bold"><code>{{ $order->shiprocket_order_id }}</code></div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <label class="text-muted small fw-semibold">Shipment ID</label>
                                    <div class="fw-bold"><code>{{ $order->shiprocket_shipment_id ?: 'N/A' }}</code></div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <label class="text-muted small fw-semibold">AWB Tracking Code</label>
                                    <div class="fw-bold text-primary">{{ $order->shiprocket_awb_code ?: 'Pending AWB' }}</div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <label class="text-muted small fw-semibold">Courier Partner</label>
                                    <div class="fw-bold">{{ $order->shiprocket_courier_name ?: 'Shiprocket Courier' }}</div>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-sm-6">
                                    <label class="text-muted small fw-semibold">Shiprocket Status</label>
                                    <div>
                                        <span class="badge bg-info text-capitalize fs-6 px-3 py-1">
                                            {{ $order->shiprocket_status ?: 'SHIPPED' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="text-muted small fw-semibold">Shipped Timestamp</label>
                                    <div>{{ $order->shipped_at ? $order->shipped_at->format('M d, Y h:i A') : 'N/A' }}</div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 pt-2 border-top">
                                <a href="{{ route('admin.order-control.order.track-shiprocket', $order->id) }}" class="btn btn-primary btn-sm shadow-sm">
                                    <i class="bx bx-radar me-1"></i> Refresh / Track Status
                                </a>

                                <button type="button" id="btn_view_sr_details" class="btn btn-outline-primary btn-sm">
                                    <i class="bx bx-show me-1"></i> View Shiprocket API Details
                                </button>

                                @if ($order->shiprocket_tracking_url)
                                    <a href="{{ $order->shiprocket_tracking_url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                        <i class="bx bx-link-external me-1"></i> Public Tracking Link
                                    </a>
                                @endif

                                <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#returnOrderModal">
                                    <i class="bx bx-undo me-1"></i> Create Return Order
                                </button>

                                <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#exchangeOrderModal">
                                    <i class="bx bx-sync me-1"></i> Create Exchange Order
                                </button>

                                <form action="{{ route('admin.order-control.order.cancel-shiprocket', $order->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to cancel this order on Shiprocket?');">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bx bx-x-circle me-1"></i> Cancel Shiprocket Shipment
                                    </button>
                                </form>
                            </div>
                        @else
                            {{-- SHIP ORDER FORM --}}
                            <p class="text-muted mb-3">
                                Push this order details directly to your Shiprocket account to create a shipment and obtain AWB tracking number.
                            </p>

                            @if (!$shiprocket || !$shiprocket->status || !$shiprocket->isTokenValid())
                                <div class="alert alert-warning d-flex align-items-center mb-0" role="alert">
                                    <i class="bx bx-error me-2 fs-4"></i>
                                    <div>
                                        Shiprocket is not active or token is invalid. Please configure your account credentials in
                                        <a href="{{ route('admin.shiprocket.index') }}" class="alert-link">Shiprocket Settings</a> first.
                                    </div>
                                </div>
                            @else
                                <button type="button" class="btn btn-success px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#shipModal">
                                    <i class="bx bx-paper-plane me-1"></i> Ship via Shiprocket
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right Sidebar: Customer, Order Status & Shipping Details --}}
            <div class="col-lg-4">
                {{-- Quick Status Update Card --}}
                <div class="card mb-4 shadow-sm">
                    <div class="card-header fw-bold">Update Order Status</div>
                    <div class="card-body">
                        <form action="{{ route('admin.order-control.order.update-status', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" class="form-select text-capitalize" required>
                                    @foreach (['pending', 'paid', 'shipped', 'delivered', 'cancelled'] as $st)
                                        <option value="{{ $st }}" {{ $order->status === $st ? 'selected' : '' }}>
                                            {{ ucfirst($st) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @if (!$order->hasShiprocketOrder())
                                <div class="mb-3 form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="push_to_shiprocket" id="push_to_sr_switch" value="1">
                                    <label class="form-check-label small" for="push_to_sr_switch">
                                        Auto-push to Shiprocket if setting status to <strong>Shipped</strong>
                                    </label>
                                </div>
                            @endif

                            <button type="submit" class="btn btn-primary w-100 shadow-sm">
                                <i class="bx bx-check-double me-1"></i> Update Status
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Customer Details Card --}}
                <div class="card mb-4 shadow-sm">
                    <div class="card-header fw-bold">Customer Info</div>
                    <div class="card-body">
                        <p class="mb-1"><strong>Name:</strong> {{ $order->customer->full_name ?? 'Guest' }}</p>
                        <p class="mb-1"><strong>Email:</strong> {{ $order->customer->email ?? 'N/A' }}</p>
                        <p class="mb-0"><strong>Phone:</strong> {{ $order->customer->phone ?? 'N/A' }}</p>
                    </div>
                </div>

                {{-- Shipping Address Card --}}
                <div class="card shadow-sm">
                    <div class="card-header fw-bold">Shipping Address</div>
                    <div class="card-body">
                        @if ($order->address)
                            <p class="mb-1"><strong>{{ $order->address->name }}</strong></p>
                            <p class="mb-1">{{ $order->address->address_line1 }}</p>
                            @if ($order->address->address_line2)
                                <p class="mb-1">{{ $order->address->address_line2 }}</p>
                            @endif
                            <p class="mb-0">
                                {{ $order->address->city }}, {{ $order->address->state }}<br>
                                {{ $order->address->country }} - {{ $order->address->postal_code }}
                            </p>
                            <p class="mt-2 mb-0 small"><i class="bx bx-phone"></i> {{ $order->address->phone }}</p>
                        @else
                            <p class="text-danger mb-0">Address not available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- SHIP VIA SHIPROCKET MODAL --}}
    @if (!$order->hasShiprocketOrder() && $shiprocket)
        <div class="modal fade" id="shipModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('admin.order-control.order.ship-shiprocket', $order->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Ship Order via Shiprocket</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-primary py-2 small mb-3">
                                Target Order: <strong>#{{ $order->order_number }}</strong> | Customer: <strong>{{ $order->customer->full_name ?? 'Guest' }}</strong>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Pickup Location</label>
                                <input type="text" name="pickup_location" class="form-control"
                                    value="{{ $shiprocket->pickup_location ?: 'Primary' }}" placeholder="Primary">
                            </div>

                            <div class="row g-2 mb-3">
                                <label class="form-label fw-semibold mb-1">Package Dimensions (cm)</label>
                                <div class="col-4">
                                    <input type="number" step="0.1" name="length" class="form-control" placeholder="Length" value="10" required>
                                    <small class="text-muted">Length</small>
                                </div>
                                <div class="col-4">
                                    <input type="number" step="0.1" name="breadth" class="form-control" placeholder="Breadth" value="10" required>
                                    <small class="text-muted">Breadth</small>
                                </div>
                                <div class="col-4">
                                    <input type="number" step="0.1" name="height" class="form-control" placeholder="Height" value="10" required>
                                    <small class="text-muted">Height</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Package Weight (Kg)</label>
                                <input type="number" step="0.01" name="weight" class="form-control" value="0.5" min="0.01" required>
                                <small class="text-muted">Gross dead weight of the shipment in Kilograms.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success px-4 shadow">
                                <i class="bx bx-paper-plane me-1"></i> Confirm & Push to Shiprocket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- CREATE RETURN ORDER MODAL --}}
    @if ($shiprocket && $shiprocket->isTokenValid())
        <div class="modal fade" id="returnOrderModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <form action="{{ route('admin.order-control.order.create-return-order', $order->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold"><i class="bx bx-undo me-1 text-warning"></i> Create Shiprocket Return Order</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-warning py-2 small mb-3">
                                Target Store Order: <strong>#{{ $order->order_number }}</strong> | Customer: <strong>{{ $order->customer->full_name ?? ($order->address->name ?? 'Customer') }}</strong>
                                <br>Initiating a Return Order will arrange pickup from the customer's address to your store warehouse.
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Pickup Address (Customer)</label>
                                    <input type="text" class="form-control" value="{{ $order->address->address_line1 ?? '' }}, {{ $order->address->city ?? '' }} - {{ $order->address->postal_code ?? '' }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Shipping Address (Warehouse Destination)</label>
                                    <input type="text" class="form-control" value="{{ $shiprocket->pickup_location ?: 'Main Warehouse' }} (Pincode: {{ $shiprocket->pincode ?: '110001' }})" readonly>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="form-check form-switch pt-2">
                                        <input class="form-check-input" type="checkbox" name="qc_enable" id="modal_qc_enable" value="1" checked>
                                        <label class="form-check-label fw-bold" for="modal_qc_enable">Enable Quality Check (QC)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">QC Brand</label>
                                    <input type="text" name="qc_brand" class="form-control" value="{{ $shiprocket->company_name ?: 'Store Item' }}">
                                </div>
                            </div>

                            <div class="row g-2 mb-3">
                                <label class="form-label fw-semibold mb-1">Return Package Dimensions (cm) & Weight (Kg)</label>
                                <div class="col-3">
                                    <input type="number" step="0.1" name="length" class="form-control" placeholder="Length" value="10" required>
                                    <small class="text-muted">Length (cm)</small>
                                </div>
                                <div class="col-3">
                                    <input type="number" step="0.1" name="breadth" class="form-control" placeholder="Breadth" value="10" required>
                                    <small class="text-muted">Breadth (cm)</small>
                                </div>
                                <div class="col-3">
                                    <input type="number" step="0.1" name="height" class="form-control" placeholder="Height" value="10" required>
                                    <small class="text-muted">Height (cm)</small>
                                </div>
                                <div class="col-3">
                                    <input type="number" step="0.01" name="weight" class="form-control" placeholder="Weight" value="0.5" min="0.01" required>
                                    <small class="text-muted">Weight (Kg)</small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning px-4 shadow">
                                <i class="bx bx-undo me-1"></i> Submit Return Order to Shiprocket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- CREATE EXCHANGE ORDER MODAL --}}
    @if ($shiprocket && $shiprocket->isTokenValid())
        <div class="modal fade" id="exchangeOrderModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <form action="{{ route('admin.order-control.order.create-exchange-order', $order->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold"><i class="bx bx-sync me-1 text-info"></i> Create Shiprocket Exchange Order</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-info py-2 small mb-3">
                                Target Store Order: <strong>#{{ $order->order_number }}</strong> | Customer: <strong>{{ $order->customer->full_name ?? ($order->address->name ?? 'Customer') }}</strong>
                                <br>Initiating an Exchange Order will process return pickup for the old item and forward delivery for the new item simultaneously.
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Customer Address (Pickup & Delivery)</label>
                                    <input type="text" class="form-control" value="{{ $order->address->address_line1 ?? '' }}, {{ $order->address->city ?? '' }} - {{ $order->address->postal_code ?? '' }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Seller Location ID</label>
                                    <input type="text" class="form-control" value="{{ $shiprocket->pickup_location ?: 'Primary' }}" readonly>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="form-check form-switch pt-2">
                                        <input class="form-check-input" type="checkbox" name="qc_enable" id="ex_modal_qc_enable" value="1" checked>
                                        <label class="form-check-label fw-bold" for="ex_modal_qc_enable">Enable Quality Check (QC)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">QC Brand</label>
                                    <input type="text" name="qc_brand" class="form-control" value="{{ $shiprocket->company_name ?: 'Store Item' }}">
                                </div>
                            </div>

                            <div class="row g-2 mb-3">
                                <label class="form-label fw-semibold mb-1">Exchange Package Dimensions (cm) & Weight (Kg)</label>
                                <div class="col-3">
                                    <input type="number" step="0.1" name="exchange_length" class="form-control" placeholder="Length" value="11" required>
                                    <small class="text-muted">Length (cm)</small>
                                </div>
                                <div class="col-3">
                                    <input type="number" step="0.1" name="exchange_breadth" class="form-control" placeholder="Breadth" value="11" required>
                                    <small class="text-muted">Breadth (cm)</small>
                                </div>
                                <div class="col-3">
                                    <input type="number" step="0.1" name="exchange_height" class="form-control" placeholder="Height" value="11" required>
                                    <small class="text-muted">Height (cm)</small>
                                </div>
                                <div class="col-3">
                                    <input type="number" step="0.01" name="exchange_weight" class="form-control" placeholder="Weight" value="0.5" min="0.01" required>
                                    <small class="text-muted">Weight (Kg)</small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-info px-4 shadow text-white">
                                <i class="bx bx-sync me-1"></i> Submit Exchange Order to Shiprocket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- SHIPROCKET DETAILS JSON MODAL --}}
    <div class="modal fade" id="srDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Shiprocket Specific Order API Details (`/v1/external/orders/show/`)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <pre id="sr_details_json" class="bg-dark text-light p-3 rounded" style="max-height: 420px; overflow-y: auto; font-size: 0.85rem;"></pre>
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
            $('#btn_view_sr_details').click(function() {
                const btn = $(this);
                const originalText = btn.html();
                btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin me-1"></i> Fetching...');

                $.ajax({
                    url: "{{ route('admin.order-control.order.shiprocket-details', $order->id) }}",
                    type: "GET",
                    success: function(response) {
                        btn.prop('disabled', false).html(originalText);
                        if (response.success) {
                            $('#sr_details_json').text(JSON.stringify(response.raw_data || response.order, null, 4));
                            $('#srDetailsModal').modal('show');
                        } else {
                            alert('Error: ' + (response.message || 'Failed to fetch order details.'));
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html(originalText);
                        let msg = 'Failed to load Shiprocket order details.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        alert('Error: ' + msg);
                    }
                });
            });
        });
    </script>
@endpush
