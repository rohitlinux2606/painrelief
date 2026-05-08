<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            color: #333333;
        }

        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .header {
            background-color: #1a1a1a;
            color: #ffffff;
            text-align: center;
            padding: 30px 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .order-info {
            background-color: #f9f9f9;
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 30px;
            border-left: 4px solid #1a1a1a;
        }

        .order-info p {
            margin: 5px 0;
            font-size: 14px;
        }

        .table-container {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        .table-container th {
            text-align: left;
            padding: 12px 10px;
            background-color: #f4f4f4;
            font-size: 12px;
            text-transform: uppercase;
            color: #666;
            border-bottom: 2px solid #ddd;
        }

        .table-container td {
            padding: 15px 10px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .item-title {
            font-weight: 600;
            color: #1a1a1a;
        }

        .totals-container {
            width: 100%;
            max-width: 300px;
            float: right;
            margin-bottom: 40px;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 8px 10px;
            font-size: 14px;
        }

        .totals-table tr.total-row td {
            font-size: 16px;
            font-weight: bold;
            border-top: 2px solid #1a1a1a;
            padding-top: 15px;
        }

        .clear {
            clear: both;
        }

        .address-section {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 30px;
        }

        .address-section h3 {
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 16px;
            color: #1a1a1a;
            text-transform: uppercase;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .address-section p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
            line-height: 1.5;
        }

        .footer {
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #eaeaea;
        }

        .footer p {
            margin: 5px 0;
        }

        .footer a {
            color: #1a1a1a;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>Order Confirmed</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Hello {{ $data['name'] }},
            </div>

            <p style="font-size: 15px; line-height: 1.6; color: #555;">
                Thank you for shopping with <strong>Vatahari</strong>! We've received your order and are getting it
                ready for shipment. Here are your complete order details.
            </p>

            <!-- Order Info -->
            <div class="order-info">
                <p><strong>Order Number:</strong> {{ $data['order_number'] }}</p>
                <p><strong>Order Date:</strong>
                    {{ $data['order']->created_at ? $data['order']->created_at->format('M d, Y') : now()->format('M d, Y') }}
                </p>
                <p><strong>Payment Method:</strong> {{ $data['order']->payment_method ?? 'Not specified' }}</p>
            </div>

            <!-- Items Table -->
            <table class="table-container">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($data['order']) && $data['order']->items)
                        @foreach ($data['order']->items as $item)
                            <tr>
                                <td>
                                    <span class="item-title">{{ $item->title }}</span>
                                </td>
                                <td style="text-align: center;">{{ $item->quantity }}</td>
                                <td style="text-align: right;">Rs. {{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            <!-- Totals -->
            <div class="totals-container">
                <table class="totals-table">
                    <tr>
                        <td style="color: #666;">Subtotal</td>
                        <td style="text-align: right;">Rs. {{ number_format($data['order']->subtotal ?? 0, 2) }}</td>
                    </tr>
                    @if (isset($data['order']->discount) && $data['order']->discount > 0)
                        <tr>
                            <td style="color: #666;">Discount</td>
                            <td style="text-align: right; color: #28a745;">- Rs.
                                {{ number_format($data['order']->discount, 2) }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td style="color: #666;">Shipping</td>
                        <td style="text-align: right;">
                            @if (isset($data['order']->shipping) && $data['order']->shipping > 0)
                                Rs. {{ number_format($data['order']->shipping, 2) }}
                            @else
                                <span style="color: #28a745; font-weight: bold;">FREE</span>
                            @endif
                        </td>
                    </tr>
                    <tr class="total-row">
                        <td>Total</td>
                        <td style="text-align: right;">Rs. {{ number_format($data['total'], 2) }}</td>
                    </tr>
                </table>
            </div>
            <div class="clear"></div>

            <!-- Shipping Address -->
            @if (isset($data['address']))
                <div class="address-section">
                    <h3>Shipping Details</h3>
                    <p><strong>{{ $data['address']->name ?? $data['name'] }}</strong></p>
                    <p>{{ $data['address']->address_line1 }}</p>
                    @if ($data['address']->address_line2)
                        <p>{{ $data['address']->address_line2 }}</p>
                    @endif
                    <p>{{ $data['address']->city }}, {{ $data['address']->state }} -
                        {{ $data['address']->postal_code }}</p>
                    <p>Phone: {{ $data['address']->phone }}</p>
                </div>
            @endif

            <p style="font-size: 14px; color: #555; text-align: center; margin-top: 30px;">
                Your order is expected to be delivered by
                <strong>{{ \Carbon\Carbon::today()->addDays(5)->format('M d, Y') }}</strong>.
            </p>

        </div>

        <!-- Footer -->
        <div class="footer">
            <p>If you have any questions, please contact our support team.</p>
            <p>&copy; {{ date('Y') }} Shrivenu Naturals. All rights reserved.</p>
        </div>
    </div>

</body>

</html>
