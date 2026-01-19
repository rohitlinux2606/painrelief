<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Vatahari</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

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
                            <input type="text" name="city" class="form-control shopify-input" placeholder="City"
                                required>
                        </div>
                        <div class="col-md-4">
                            <select name="state" class="form-select shopify-input" required>
                                <option value="" selected disabled>State</option>
                                <option value="Delhi">Delhi</option>
                                <option value="Maharashtra">Maharashtra</option>
                                <option value="Uttar Pradesh">Uttar Pradesh</option>
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
                        <div class="d-flex align-items-center mb-4 cart-product-row" data-price="{{ $item->price }}"
                            data-qty="{{ $item->quantity }}">
                            <div class="product-img-wrapper">
                                <img src="{{ asset($item->product->thumbnail) }}" class="w-100 h-100 rounded"
                                    style="object-fit: cover;">
                                <span class="img-badge">{{ $item->quantity }}</span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="small mb-0 fw-bold">{{ $item->product->title }}</h6>
                                <small class="text-muted">Unit Price: Rs. {{ number_format($item->price, 2) }}</small>
                            </div>
                            <div class="text-end small fw-bold">Rs. {{ number_format($itemTotal, 2) }}</div>
                        </div>
                    @endforeach
                </div>

                {{-- <div class="d-flex gap-2 mb-4 border-top pt-4">
                    <input type="text" class="form-control shopify-input" placeholder="Discount code">
                    <button class="btn btn-light border px-3 small">Apply</button>
                </div> --}}

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Calculation Logic
            function calculateOrderSummary() {
                let subtotal = 0;
                const rows = document.querySelectorAll('.cart-product-row');

                rows.forEach(row => {
                    const price = parseFloat(row.getAttribute('data-price'));
                    const qty = parseInt(row.getAttribute('data-qty'));
                    subtotal += (price * qty);
                });

                // Formatting to Indian Currency
                const formatter = new Intl.NumberFormat('en-IN', {
                    style: 'currency',
                    currency: 'INR',
                    minimumFractionDigits: 2
                });

                const formattedSubtotal = formatter.format(subtotal).replace('₹', 'Rs. ');

                document.getElementById('subtotal-val').innerText = formattedSubtotal;
                document.getElementById('total-val').innerText = formattedSubtotal;
            }

            // Run on load
            calculateOrderSummary();

            // Simple Form Validation Feedback
            const form = document.getElementById('checkoutForm');
            form.addEventListener('submit', function(e) {
                const btn = form.querySelector('.btn-continue');
                btn.innerHTML =
                    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...`;
                btn.disabled = true;
            });
        });
    </script>
</body>

</html>
