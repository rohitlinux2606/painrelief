@extends('layouts.app')

@section('title', 'Order Success - Vatahari')

@push('styles')
    <style>
        .success-container {
            margin-top: 60px;
            margin-bottom: 80px;
            max-width: 600px;
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
@section('content')

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
                <h5 class="fw-bold mb-2">Join Our Health Community & get Expert Advice! 🌿</h5>
                <p class="small text-muted mb-4">Connect with 500+ members, get daily health tips, and exclusive offers.
                </p>

                <a href="https://chat.whatsapp.com/IleJbXZJJLzI8nKSa7iXOD" target="_blank" class="btn-whatsapp"
                    onclick="trackJoinCommunity()">
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
@endsection

@push('scripts')
    <script>
        fbq('track', 'Purchase', {
            value: {{ $order->total }},
            currency: 'INR',
            num_items: {{ $order->items->sum('quantity') }},
            content_type: 'product',
            content_name: 'Order Purchase'
        });
    </script>

    <script>
        function trackJoinCommunity() {
            fbq('trackCustom', 'JoinCommunity', {
                platform: 'WhatsApp',
                page: 'Order Confirmation'
            });
        }
    </script>
    <script src="{{ asset('meta/pixel.js') }}"></script>
@endpush
