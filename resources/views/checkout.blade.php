@extends('layouts.web')

@section('title', 'Checkout - Vatahari')

@section('content')
    <div class="main-wrapper">
        <div class="row g-0">
            <div class="col-lg-7 form-section">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb small mb-4">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('show-cart') }}"
                            class="text-dark text-decoration-none">Cart</a></li> --}}
                        <li class="breadcrumb-item">Cart</li>
                        <li class="breadcrumb-item active fw-bold">Information</li>
                        <li class="breadcrumb-item text-muted">Shipping</li>
                    </ol>
                </nav>

                <form action="{{ route('place-order') }}" method="POST" id="checkoutForm">
                    @csrf
                    <div class="d-flex justify-content-between align-items-end mb-2">
                        <span class="form-label-custom mb-0">Contact Information</span>
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control shopify-input" placeholder="Email">
                    </div>
                    <div class="mb-4">
                        <input type="tel" name="phone" class="form-control shopify-input"
                            placeholder="Phone number (for delivery updates)">
                    </div>

                    <span class="form-label-custom">Shipping Address</span>
                    <div class="row g-2">
                        <div class="col-md-12">
                            <input type="text" name="first_name" class="form-control shopify-input"
                                placeholder="Your name" required>
                        </div>
                        {{-- <div class="col-md-6">
                            <input type="text" name="last_name" class="form-control shopify-input"
                                placeholder="Last name">
                        </div> --}}
                        <div class="col-12">
                            <input type="text" name="address" class="form-control shopify-input"
                                placeholder="Complete Address (House No, Street, Area)" required>
                        </div>

                        <div class="col-md-4">
                            <select name="state" id="state-select" class="form-select select2" required>
                                <option value="" selected disabled>Select State</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <select name="city" id="city-select" class="form-select select2" required disabled>
                                <option value="" selected disabled>Select City</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <input type="text" name="pincode" class="form-control shopify-input" placeholder="PIN code"
                                required>
                        </div>
                    </div>

                    <div class="mt-5 d-flex justify-content-between align-items-center">
                        {{-- <a href="{{ route('show-cart') }}" class="text-dark text-decoration-none small">
                        <i class="bi bi-chevron-left"></i> Return to cart
                    </a> --}}
                        <a href="{{ route('page.home') }}" class="text-dark text-decoration-none small">
                            <i class="bi bi-chevron-left"></i> Return to home
                        </a>
                        <button type="submit" class="btn btn-continue">Complete Order</button>
                    </div>
                </form>
            </div>

            <div class="col-lg-5 summary-section">
                <div id="order-items-list">
                    @php $subtotal = 0; @endphp
                    @foreach ($cart->items as $item)
                        @php
                            $itemTotal = $item->price * $item->quantity;
                            $subtotal += $itemTotal;
                        @endphp
                        <div class="d-flex align-items-center mb-4 cart-product-row position-relative"
                            id="cart-row-{{ $item->id }}" data-price="{{ $item->price }}"
                            data-qty="{{ $item->quantity }}">

                            <div class="product-img-wrapper">
                                @if ($item->product)
                                    <img src="{{ asset($item->product->thumbnail) }}" class="w-100 h-100 rounded"
                                        style="object-fit: cover;">
                                @else
                                    <div
                                        class="w-100 h-100 rounded bg-light d-flex align-items-center justify-content-center">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                                <span class="img-badge qty-badge-{{ $item->id }}">{{ $item->quantity }}</span>
                            </div>

                            <div class="flex-grow-1 ms-3">
                                <h6 class="small mb-1 fw-bold">
                                    {{ $item->product ? $item->product->title : 'Product Unavailable' }}</h6>
                                <small class="text-muted d-block mb-2">Unit Price: Rs.
                                    {{ number_format($item->price, 2) }}</small>

                                <div class="d-flex align-items-center gap-2">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-secondary qty-btn"
                                            data-action="decrease" data-item-id="{{ $item->id }}">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <span
                                            class="btn btn-outline-secondary disabled qty-display-{{ $item->id }}">{{ $item->quantity }}</span>
                                        <button type="button" class="btn btn-outline-secondary qty-btn"
                                            data-action="increase" data-item-id="{{ $item->id }}">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                    <button class="btn btn-sm btn-outline-danger remove-item-btn"
                                        data-item-id="{{ $item->id }}" title="Remove Item">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="text-end small fw-bold item-total-{{ $item->id }}">Rs.
                                {{ number_format($itemTotal, 2) }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="border-top pt-3">
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold" id="subtotal-val">Rs. {{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 small">
                        <span class="text-muted">Shipping</span>
                        <span class="text-success fw-bold">FREE</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <h5 class="fw-bold mb-0">Total</h5>
                        <h4 class="fw-bold mb-0" id="total-val" style="color: #000;">Rs.
                            {{ number_format($subtotal, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModel" tabindex="-1" aria-labelledby="paymentModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="paymentModelLabel">Payment Methods</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 pb-4">
                    @php $master = \App\Models\WebSetting::first(); @endphp
                    <ul class="list-group mb-4 mt-2">
                        <!-- Online Payment Option -->
                        <li
                            class="list-group-item d-flex justify-content-between align-items-center py-3 border-dark rounded mb-2">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('cdn/images/upi.webp') }}" alt="UPI" width="40"
                                    height="40" class="me-3 rounded">
                                <div>
                                    <strong class="mb-1 d-block h6">Pay Online</strong>
                                    @if ($master && $master->discount_percentage > 0)
                                        <span class="text-success small fw-bold">
                                            <i class="bi bi-lightning-charge-fill"></i> Get
                                            {{ $master->discount_percentage }}% discount!
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <button id="fire_cashfree" class="btn btn-dark btn-sm px-3 rounded">Pay Now</button>
                        </li>

                        <!-- Cash on Delivery Option -->
                        <li
                            class="list-group-item d-flex justify-content-between align-items-center py-3 rounded bg-light">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('cdn/images/cod.webp') }}" alt="COD" width="40"
                                    height="40" class="me-3 rounded">
                                <div>
                                    <strong class="mb-1 d-block h6">Cash on Delivery</strong>
                                    <span class="text-muted small">Pay when you receive</span>
                                </div>
                            </div>
                            <button id="cod_btn" class="btn btn-outline-dark btn-sm px-3 rounded">COD</button>
                        </li>
                    </ul>

                    <form action="" hidden method="POST" id="pay_req">
                        @csrf
                        <input type="hidden" name="paymentMethod" id="paymentMethod" value="cod">
                        <input type="hidden" name="order_id" id="order_id" value="">
                        <input type="hidden" name="order_number" id="order_number" value="">
                        <input type="hidden" name="amount" id="amount" value="">
                        <input type="hidden" name="customer_id" id="customer_id" value="">
                        <input type="hidden" name="name" id="address_name" value="">
                        <input type="hidden" name="email" id="address_email" value="">
                        <input type="hidden" name="mobile" id="address_mobile" value="">
                        <input type="hidden" name="subtotal" id="subtotal" value="">
                    </form>

                    <div class="text-center mt-2">
                        <small class="text-muted" style="font-size: 0.75rem;">
                            <i>By continuing, you agree to our <br>
                                <a href="{{ route('page.terms') }}" target="_blank" class="text-dark fw-bold">Terms and
                                    Conditions</a> &
                                <a href="{{ route('page.privacy') }}" target="_blank" class="text-dark fw-bold">Privacy
                                    Policy</a>.
                            </i>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        :root {
            --border-color: #e6e6e6;
            --text-light: #707070;
            --bg-summary: #fafafa;
        }

        body {
            background-color: #fff;
        }

        /* .navbar {
                        border-bottom: 1px solid var(--border-color);
                        padding: 15px 0;
                    } */

        .main-wrapper {
            max-width: 1100px;
            margin: 0 auto;
        }

        .form-section {
            padding: 40px 20px 40px 0;
        }

        .summary-section {
            background-color: var(--bg-summary);
            border-left: 1px solid var(--border-color);
            padding: 40px 0 40px 40px;
            min-height: 100vh;
        }

        .form-label-custom {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 8px;
            display: block;
        }

        .shopify-input {
            border: 1px solid var(--border-color) !important;
            border-radius: 5px !important;
            padding: 11px !important;
            font-size: 0.9rem !important;
        }

        .shopify-input:focus {
            border-color: #000 !important;
            box-shadow: 0 0 0 1px #000 !important;
        }

        /* Select2 Style Adjustment to match Shopify Inputs */
        .select2-container--default .select2-selection--single {
            border: 1px solid var(--border-color) !important;
            height: 45px !important;
            padding: 8px !important;
        }

        .select2-container--default .select2-selection--arrow {
            height: 43px !important;
        }

        .btn-continue {
            background-color: #000;
            color: #fff;
            padding: 16px 30px;
            border-radius: 5px;
            font-weight: 600;
            width: auto;
            float: right;
            border: none;
        }

        .product-img-wrapper {
            width: 64px;
            height: 64px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background: #fff;
            position: relative;
        }

        .img-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #666;
            color: #fff;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .form-section {
                padding: 20px;
            }

            .summary-section {
                padding: 20px;
                border-left: none;
                min-height: auto;
                order: -1;
            }

            .btn-continue {
                width: 100%;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fbq('track', 'InitiateCheckout', {
                currency: "INR",
                value: {{ $subtotal }}
            });
        });

        $(document).ready(function() {
            // 1. Initialize Select2
            $('#state-select').select2({
                placeholder: "Select State",
                allowClear: true,
                width: '100%'
            });

            $('#city-select').select2({
                placeholder: "Select City",
                allowClear: true,
                width: '100%'
            });

            const stateSelect = $('#state-select');
            const citySelect = $('#city-select');

            // 2. Fetch All States of India on Load
            fetch("https://countriesnow.space/api/v0.1/countries/states", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        country: "India"
                    })
                })
                .then(res => res.json())
                .then(data => {
                    stateSelect.empty().append('<option value="" selected disabled>Select State</option>');
                    data.data.states.forEach(state => {
                        stateSelect.append(`<option value="${state.name}">${state.name}</option>`);
                    });
                })
                .catch(err => {
                    console.error("Error loading states", err);
                    stateSelect.empty().append('<option value="">Error Loading</option>');
                });

            // 3. Handle State Change to Load Cities
            stateSelect.on('change', function() {
                const stateName = $(this).val();
                if (!stateName) return;

                citySelect.prop('disabled', true).empty().append(
                    '<option value="" selected disabled>Select City</option>');

                fetch("https://countriesnow.space/api/v0.1/countries/state/cities", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            country: "India",
                            state: stateName
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        citySelect.empty().append(
                            '<option value="" selected disabled>Select City</option>');
                        data.data.forEach(city => {
                            citySelect.append(`<option value="${city}">${city}</option>`);
                        });
                        citySelect.prop('disabled', false);
                    })
                    .catch(err => console.error("Error loading cities", err));
            });

            // Original Calculation Logic
            function calculateOrderSummary() {
                let subtotal = 0;
                $('.cart-product-row').each(function() {
                    const price = parseFloat($(this).data('price'));
                    const qty = parseInt($(this).data('qty'));
                    subtotal += (price * qty);
                });

                const formatter = new Intl.NumberFormat('en-IN', {
                    style: 'currency',
                    currency: 'INR',
                    minimumFractionDigits: 2
                });
                const formattedSubtotal = formatter.format(subtotal).replace('₹', 'Rs. ');
                $('#subtotal-val').text(formattedSubtotal);
                $('#total-val').text(formattedSubtotal);
            }
            calculateOrderSummary();

            // AJAX Quantity Update
            $('.qty-btn').on('click', function() {
                const btn = $(this);
                const action = btn.data('action');
                const itemId = btn.data('item-id');
                const row = $(`#cart-row-${itemId}`);

                btn.prop('disabled', true);

                $.post('{{ route('update-cart') }}', {
                        _token: '{{ csrf_token() }}',
                        item_id: itemId,
                        action: action
                    })
                    .done(function(response) {
                        if (response.status === 'success') {
                            // Update quantity displays
                            $(`.qty-display-${itemId}`).text(response.new_qty);
                            $(`.qty-badge-${itemId}`).text(response.new_qty);
                            $(`.item-total-${itemId}`).text(`Rs. ${response.item_total}`);

                            // Update row data
                            row.data('qty', response.new_qty);

                            // Update totals
                            $('#subtotal-val').text(`Rs. ${response.cart_subtotal}`);
                            $('#total-val').text(`Rs. ${response.cart_subtotal}`);
                        }
                    })
                    .fail(function() {
                        alert('Error updating quantity. Please try again.');
                    })
                    .always(function() {
                        btn.prop('disabled', false);
                    });
            });

            // AJAX Remove Item
            $('.remove-item-btn').on('click', function() {
                const btn = $(this);
                const itemId = btn.data('item-id');
                const row = $(`#cart-row-${itemId}`);

                if (!confirm('Remove this item from cart?')) return;

                btn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i>');

                window.location.href = `{{ url('/cart/delete-item') }}/${itemId}`;
            });

            // Form Submit Loading & AJAX Payment Popup
            $('#checkoutForm').on('submit', function(e) {
                e.preventDefault();
                const btn = $(this).find('.btn-continue');
                const originalText = btn.text();
                btn.html('<span class="spinner-border spinner-border-sm"></span> Processing...').prop(
                    'disabled', true);

                let formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('place-order') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        btn.html(originalText).prop('disabled', false);

                        if (response.status === 'success') {
                            let customer = response.data.customer;
                            let address = response.data.address;
                            let order = response.data.order;

                            $('#order_id').val(order.id);
                            $('#order_number').val(order.order_number);
                            $('#customer_id').val(customer.id);
                            $('#address_name').val(address.name);
                            $('#address_email').val(customer.email);
                            $('#address_mobile').val(address.phone);
                            $('#subtotal').val(order.subtotal);
                            $('#amount').val(order.total);

                            // redirect to order success page
                            let url = "{{ route('order-success', ':orderNumber') }}";
                            window.location.href = url.replace(':orderNumber', order
                                .order_number);

                            // // Show standard Bootstrap Modal
                            // var paymentModal = new bootstrap.Modal(document.getElementById(
                            //     'paymentModel'));
                            // paymentModal.show();
                        } else if (response.status === 'error') {
                            alert(response.message || "Something went wrong.");
                        }
                    },
                    error: function(xhr) {
                        btn.html(originalText).prop('disabled', false);

                        // Parse validation errors if 422
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMsg = "Validation failed:\n";
                            for (var key in errors) {
                                errorMsg += errors[key][0] + "\n";
                            }
                            alert(errorMsg);
                        } else {
                            alert("Failed to submit order. Please try again.");
                        }
                    }
                });
            });

            // Payment method submission handlers
            $("#cod_btn").click(function() {
                $("#pay_req").attr('action', "{{ route('shop.payment.cod') }}");
                $("#paymentMethod").val('cod');
                $("#pay_req").submit();
            });

            $("#fire_cashfree").click(function() {
                $("#pay_req").attr('action', "{{ route('shop.payment.cashfree') }}");
                $("#paymentMethod").val('cashfree');
                $("#pay_req").submit();
            });
        });
    </script>
@endpush
