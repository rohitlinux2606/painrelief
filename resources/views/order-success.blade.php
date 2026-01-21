<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed - Vatahari</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

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
    <style>
        body {
            background-color: #f9fafb;
            font-family: -apple-system, sans-serif;
        }

        .success-card {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .success-header {
            background: #000;
            color: #fff;
            padding: 40px 20px;
            text-align: center;
        }

        .check-icon {
            font-size: 3rem;
            color: #4bb543;
            background: #fff;
            border-radius: 50%;
            padding: 5px 15px;
            margin-bottom: 15px;
            display: inline-block;
        }

        .order-details {
            padding: 30px;
            border-bottom: 1px solid #eee;
        }

        .whatsapp-section {
            padding: 30px;
            background: #f0fff4;
            text-align: center;
            border: 2px dashed #25D366;
            margin: 20px;
            border-radius: 12px;
        }

        .btn-whatsapp {
            background-color: #25D366;
            color: #fff;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
        }

        .btn-whatsapp:hover {
            background-color: #128C7E;
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-home {
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
            margin-top: 20px;
            display: inline-block;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="success-card">
            <div class="success-header">
                <div class="check-icon"><i class="bi bi-check-lg"></i></div>
                <h2 class="fw-bold">Order Confirmed!</h2>
                <p class="mb-0 opacity-75">Thank you, {{ $order->customer->first_name }}! Your order is being processed.
                </p>
            </div>

            <div class="order-details">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Order Number:</span>
                    <span class="fw-bold text-uppercase">{{ $order->order_number }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Total Amount:</span>
                    <span class="fw-bold">Rs. {{ number_format($order->total, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Payment Method:</span>
                    <span class="badge bg-light text-dark border">{{ $order->payment_method }}</span>
                </div>
                <hr>
                <p class="small text-muted mb-0"><i class="bi bi-truck me-2"></i> We'll send shipping updates to
                    <strong>{{ $order->customer->email }}</strong>
                </p>
            </div>

            <div class="whatsapp-section">
                <h5 class="fw-bold mb-2">Join Our Health Community! 🌿</h5>
                <p class="small text-muted mb-4">Connect with 500+ members, get daily health tips, and exclusive offers.
                </p>

                <a href="https://chat.whatsapp.com/IleJbXZJJLzI8nKSa7iXOD" target="_blank" class="btn-whatsapp">
                    <i class="bi bi-whatsapp"></i> Join Vatahari Community
                </a>

                <div class="mt-3">
                    <small class="text-muted italic" style="font-size: 0.75rem;">*Private group, no spam
                        guaranteed.</small>
                </div>
            </div>

            <div class="text-center pb-4">
                <a href="/" class="btn-home"><i class="bi bi-arrow-left me-1"></i> Continue Shopping</a>
            </div>
        </div>
    </div>

</body>

</html>
