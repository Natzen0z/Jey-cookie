<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan - Jeycookie</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #ec4899;
            margin-bottom: 25px;
        }
        .brand {
            font-size: 28px;
            font-weight: bold;
            color: #ec4899;
        }
        .brand-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }
        .success-badge {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            display: inline-block;
            margin: 15px 0;
        }
        .order-info {
            background: #fdf2f8;
            padding: 15px 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .order-number {
            font-size: 18px;
            font-weight: bold;
            color: #db2777;
        }
        .section-title {
            color: #db2777;
            font-size: 16px;
            font-weight: 600;
            margin-top: 25px;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #fce7f3;
        }
        .item-table {
            width: 100%;
            border-collapse: collapse;
        }
        .item-table th, .item-table td {
            padding: 12px 10px;
            text-align: left;
            border-bottom: 1px solid #f3f4f6;
        }
        .item-table th {
            background: #fdf2f8;
            color: #6b7280;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 600;
        }
        .item-name {
            font-weight: 500;
        }
        .item-qty {
            text-align: center;
        }
        .item-price {
            text-align: right;
        }
        .totals-table {
            width: 100%;
            margin-top: 15px;
        }
        .totals-table td {
            padding: 8px 0;
        }
        .totals-table .label {
            color: #6b7280;
        }
        .totals-table .value {
            text-align: right;
            font-weight: 500;
        }
        .total-row td {
            font-size: 18px;
            font-weight: bold;
            color: #db2777;
            padding-top: 15px;
            border-top: 2px solid #fce7f3;
        }
        .shipping-info {
            background: #f9fafb;
            padding: 15px 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .shipping-info p {
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .contact-info {
            margin-top: 15px;
        }
        .contact-info a {
            color: #ec4899;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="brand-icon">🍪</div>
            <div class="brand">Jeycookie</div>
            <p style="color: #6b7280; margin: 0;">Fresh Homemade Bakery</p>
        </div>

        <div style="text-align: center;">
            <div class="success-badge">✓ Pembayaran Berhasil</div>
            <h2 style="margin: 15px 0 5px;">Terima Kasih Atas Pesanan Anda!</h2>
            <p style="color: #6b7280;">Pesanan Anda sedang diproses dan akan segera dikirim.</p>
        </div>

        <div class="order-info">
            <div class="order-number">Pesanan #{{ $order->order_number }}</div>
            <p style="margin: 5px 0; color: #6b7280;">
                Tanggal: {{ $order->created_at->format('d M Y, H:i') }} WIB
            </p>
        </div>

        <div class="section-title">📦 Detail Pesanan</div>
        <table class="item-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td class="item-name">
                        {{ $item->product_name }}<br>
                        <small style="color: #9ca3af;">Rp {{ number_format($item->product_price, 0, ',', '.') }} / item</small>
                    </td>
                    <td class="item-qty">{{ $item->quantity }}</td>
                    <td class="item-price">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table class="totals-table">
            <tr>
                <td class="label">Subtotal</td>
                <td class="value">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Ongkir</td>
                <td class="value">
                    @if($order->delivery_fee == 0)
                        <span style="color: #10b981;">GRATIS</span>
                    @else
                        Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}
                    @endif
                </td>
            </tr>
            @if($order->discount > 0)
            <tr>
                <td class="label">Diskon</td>
                <td class="value" style="color: #10b981;">- Rp {{ number_format($order->discount, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td>Total</td>
                <td style="text-align: right;">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="section-title">🚚 Alamat Pengiriman</div>
        <div class="shipping-info">
            <p style="font-weight: 600; margin-bottom: 8px;">{{ $order->customer_name }}</p>
            <p>📱 {{ $order->customer_phone }}</p>
            <p>📍 {{ $order->customer_address }}</p>
        </div>

        @if($order->notes)
        <div class="section-title">📝 Catatan</div>
        <p style="color: #6b7280;">{{ $order->notes }}</p>
        @endif

        <div class="footer">
            <p>Jika ada pertanyaan tentang pesanan Anda, silakan hubungi kami.</p>
            <div class="contact-info">
                <p>📧 <a href="mailto:hello@jeycookie.com">hello@jeycookie.com</a></p>
                <p>📱 +62 812-3456-7890</p>
            </div>
            <p style="margin-top: 20px; font-size: 12px;">
                &copy; {{ date('Y') }} Jeycookie. Freshly baked with ❤️
            </p>
        </div>
    </div>
</body>
</html>
