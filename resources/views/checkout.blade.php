<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Vatahari</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '774268225654141');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=774268225654141&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fbq('track', 'InitiateCheckout', {
                currency: "INR",
                value: 00
            });
        });
    </script>

    <style>
        :root {
            --border-color: #e6e6e6;
            --text-light: #707070;
            --bg-summary: #fafafa;
        }

        body {
            background-color: #fff;
            font-family: -apple-system, sans-serif;
            color: #333;
        }

        .navbar {
            border-bottom: 1px solid var(--border-color);
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 1.5px;
        }

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
</head>

<body>

    <nav class="navbar">
        <div class="container main-wrapper px-3 px-lg-0">
            <a class="navbar-brand text-dark text-decoration-none" href="/">VATAHARI</a>
        </div>
    </nav>

    <div class="main-wrapper">
        <div class="row g-0">
            <div class="col-lg-7 form-section">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb small mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('show-cart') }}"
                                class="text-dark text-decoration-none">Cart</a></li>
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
                        <input type="email" name="email" class="form-control shopify-input" placeholder="Email"
                            required>
                    </div>
                    <div class="mb-4">
                        <input type="tel" name="phone" class="form-control shopify-input"
                            placeholder="Phone number (for delivery updates)" required>
                    </div>

                    <span class="form-label-custom">Shipping Address</span>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input type="text" name="first_name" class="form-control shopify-input"
                                placeholder="First name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="last_name" class="form-control shopify-input"
                                placeholder="Last name" required>
                        </div>
                        <div class="col-12">
                            <input type="text" name="address" class="form-control shopify-input"
                                placeholder="Complete Address (House No, Street, Area)" required>
                        </div>

                        <div class="col-md-4">
                            <select name="state" id="state-select" class="form-select select2" required>
                                <option value="" selected disabled>Loading States...</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <select name="city" id="city-select" class="form-select select2" required disabled>
                                <option value="" selected disabled>Select State First</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <input type="text" name="pincode" class="form-control shopify-input"
                                placeholder="PIN code" required>
                        </div>
                    </div>

                    <div class="mt-5 d-flex justify-content-between align-items-center">
                        <a href="{{ route('show-cart') }}" class="text-dark text-decoration-none small">
                            <i class="bi bi-chevron-left"></i> Return to cart
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
                                <img src="{{ asset($item->product->thumbnail) }}" class="w-100 h-100 rounded"
                                    style="object-fit: cover;">
                                <span class="img-badge">{{ $item->quantity }}</span>
                            </div>

                            <div class="flex-grow-1 ms-3">
                                <h6 class="small mb-0 fw-bold">{{ $item->product->title }}</h6>
                                <small class="text-muted">Unit Price: Rs.
                                    {{ number_format($item->price, 2) }}</small><br>
                                <a class="btn btn-sm p-0 text-danger small remove-item-btn"
                                    href="{{ route('checkout.delete-item', $item->id) }}"
                                    style="font-size: 0.7rem; text-decoration: underline; border:none; background:none;">
                                    <i class="bi bi-trash3"></i> Remove
                                </a>
                            </div>

                            <div class="text-end small fw-bold">Rs. {{ number_format($itemTotal, 2) }}</div>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // 1. Initialize Select2
            $('.select2').select2({
                placeholder: "Select an option",
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
                    '<option value="">Loading Cities...</option>');

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

            // Form Submit Loading
            $('#checkoutForm').on('submit', function() {
                const btn = $(this).find('.btn-continue');
                btn.html('<span class="spinner-border spinner-border-sm"></span> Processing...').prop(
                    'disabled', true);
            });
        });
    </script>

    <script src="{{ asset('meta/pixel.js') }}"></script>
</body>

</html>
