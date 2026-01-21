<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart - Vatahari</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments)
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

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -1px;
        }

        .cart-container {
            margin-top: 40px;
            margin-bottom: 60px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .cart-item-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .qty-input {
            width: 45px;
            text-align: center;
            border: none;
            background: transparent;
            font-weight: 600;
        }

        .qty-btn {
            background: #f1f1f1;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .summary-box {
            background-color: #fff;
            padding: 25px;
            border-radius: 12px;
            position: sticky;
            top: 20px;
        }

        .btn-checkout {
            background-color: #000;
            color: #fff !important;
            /* Link color override karne ke liye */
            border-radius: 6px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            border: none;
            display: block;
            /* Full width lene ke liye */
            text-align: center;
            /* Text ko beech mein karne ke liye */
            text-decoration: none;
            /* Underline hatane ke liye */
            transition: background-color 0.3s ease;
        }

        .btn-checkout:hover {
            background-color: #333;
            color: #fff !important;
        }

        .remove-link {
            font-size: 0.85rem;
            color: #dc3545;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand text-black" href="#">VATAHARI</a>
        </div>
    </nav>

    <div class="container cart-container">
        <h2 class="fw-bold mb-4">Your Cart</h2>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card p-4" id="cart-items-container">
                    @if ($cart && $cart->items->count() > 0)
                        @foreach ($cart->items as $item)
                            <div class="row align-items-center g-3 mb-4 cart-item" data-item-id="{{ $item->id }}">
                                <div class="col-auto">
                                    <img src="{{ asset($item->product->thumbnail) }}" class="cart-item-img"
                                        alt="Product">
                                </div>
                                <div class="col">
                                    <h6 class="fw-bold mb-1">{{ $item->product->title }}</h6>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="d-flex align-items-center border rounded px-1">
                                            <button class="qty-btn"
                                                onclick="updateCartDB('{{ $item->id }}', 'decrease', this.nextElementSibling, this.closest('.cart-item-row'))">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <input type="text" class="qty-input" value="{{ $item->quantity }}"
                                                readonly>
                                            <button class="qty-btn"
                                                onclick="updateCartDB('{{ $item->id }}', 'increase', this.previousElementSibling, this.closest('.cart-item-row'))">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                        <a href="#" class="remove-link remove-item"><i
                                                class="bi bi-trash me-1"></i>Remove</a>
                                    </div>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <span class="fw-bold item-total" data-unit-price="{{ $item->price }}">
                                        Rs. {{ number_format($item->price * $item->quantity, 2) }}
                                    </span>
                                </div>
                            </div>
                            <hr class="text-muted opacity-25">
                        @endforeach
                    @else
                        <div class="text-center p-5">
                            <i class="bi bi-cart-x style font-size: 3rem; opacity: 0.2;"></i>
                            <p class="mt-3">Your cart is empty!</p>
                            <a href="/" class="btn btn-dark btn-sm">Start Shopping</a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <div class="summary-box shadow-sm">
                    <h5 class="fw-bold mb-4">Order Summary</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal (<span id="total-qty-count">0</span> items)</span>
                        <span id="subtotal-display">Rs. 0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Estimated Shipping</span>
                        <span class="text-success fw-bold">FREE</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <h5 class="fw-bold">Estimated Total</h5>
                        <h5 class="fw-bold" id="grand-total-display">Rs. 0.00</h5>
                    </div>
                    <a href="{{ route('checkout') }}" class="btn-checkout">
                        Checkout Now
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // 1. updateCartDB ko bahar rakhein taaki onclick ise dhund sake
        function updateCartDB(itemId, action, inputElement, rowElement) {
            fetch("{{ route('update-cart') }}", { // Make sure 'update-cart' route exists
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        item_id: itemId,
                        action: action
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Input box update karein
                        inputElement.value = data.new_qty;

                        // UI totals refresh karein (Jo niche define hai)
                        // Hum direct function call kar sakte hain calculation ke liye
                        window.refreshAllTotals();
                    }
                })
                .catch(err => console.error("Error updating cart:", err));
        }

        document.addEventListener('DOMContentLoaded', function() {

            // Is function ko window object mein daal dete hain taaki bahar se call ho sake
            window.refreshAllTotals = function updateCartTotals() {
                let subtotal = 0;
                let totalItems = 0;

                const cartItems = document.querySelectorAll('.cart-item');

                cartItems.forEach(item => {
                    const qtyInput = item.querySelector('.qty-input');
                    if (!qtyInput) return;

                    const qty = parseInt(qtyInput.value);
                    const unitPrice = parseFloat(item.querySelector('.item-total').getAttribute(
                        'data-unit-price'));

                    const itemTotalPrice = qty * unitPrice;

                    // Row price update karein
                    item.querySelector('.item-total').innerText =
                        `Rs. ${itemTotalPrice.toLocaleString('en-IN', {minimumFractionDigits: 2})}`;

                    subtotal += itemTotalPrice;
                    totalItems += qty;
                });

                // Summary Box update karein
                document.getElementById('total-qty-count').innerText = totalItems;
                document.getElementById('subtotal-display').innerText =
                    `Rs. ${subtotal.toLocaleString('en-IN', {minimumFractionDigits: 2})}`;
                document.getElementById('grand-total-display').innerText =
                    `Rs. ${subtotal.toLocaleString('en-IN', {minimumFractionDigits: 2})}`;

                if (cartItems.length === 0) {
                    document.getElementById('cart-items-container').innerHTML =
                        `<div class="text-center p-5"><p>Your cart is empty!</p><a href="/" class="btn btn-dark btn-sm">Start Shopping</a></div>`;
                }
            }

            // Handle Item Removal (AJAX ke bina local UI remove)
            document.querySelectorAll('.remove-item').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('Are you sure you want to remove this item?')) {
                        const row = this.closest('.cart-item');
                        const hr = row.nextElementSibling;
                        row.remove();
                        if (hr && hr.tagName === 'HR') hr.remove();
                        window.refreshAllTotals();
                    }
                });
            });

            // Initial Calculation
            window.refreshAllTotals();
        });
    </script>
</body>

</html>
