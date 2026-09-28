<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Pembayaran - UPI Bakery</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f5; padding: 40px 20px; margin: 0; }
        .receipt-container { max-width: 500px; margin: 0 auto; background: #ffffff; padding: 40px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .receipt-header { text-align: center; border-bottom: 2px dashed #e4e4e7; padding-bottom: 25px; margin-bottom: 25px; }
        .receipt-header h1 { margin: 0; color: #b37a54; font-size: 32px; font-weight: 800; letter-spacing: -0.5px; }
        .receipt-header p { margin: 8px 0 0; color: #71717a; font-size: 14px; line-height: 1.5; }
        .status-badge { display: inline-block; background: #dcfce7; color: #166534; padding: 6px 12px; border-radius: 20px; font-weight: bold; font-size: 12px; letter-spacing: 0.5px; margin-top: 15px; }
        .order-details { margin-bottom: 25px; background: #fafafa; padding: 20px; border-radius: 12px; }
        .detail-row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; }
        .detail-row:last-child { margin-bottom: 0; }
        .detail-label { color: #71717a; }
        .detail-value { font-weight: 600; color: #27272a; text-align: right; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        table th { text-align: left; padding-bottom: 12px; color: #a1a1aa; font-weight: 600; font-size: 12px; text-transform: uppercase; border-bottom: 1px solid #e4e4e7; }
        table td { padding: 15px 0; border-bottom: 1px solid #f4f4f5; color: #3f3f46; font-size: 14px; }
        table th.right, table td.right { text-align: right; }
        .item-name { font-weight: 600; color: #27272a; display: block; margin-bottom: 4px; }
        .item-qty { color: #a1a1aa; font-size: 12px; }
        .summary { border-top: 2px dashed #e4e4e7; padding-top: 20px; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; color: #52525b; }
        .summary-row.grand-total { margin-top: 15px; padding-top: 15px; border-top: 1px solid #e4e4e7; font-size: 20px; font-weight: 800; color: #b37a54; }
        .receipt-footer { text-align: center; margin-top: 40px; }
        .receipt-footer p { margin: 5px 0; color: #a1a1aa; font-size: 13px; }
        .btn-track { display: inline-block; background: #b37a54; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; font-size: 14px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <h1>UPI Bakery</h1>
            <p>Jl. Jend. Sudirman No. 271, Ciamis<br>Telp: 0812-3456-7890</p>
            <div class="status-badge">PEMBAYARAN LUNAS</div>
        </div>

        <div class="order-details">
            <div class="detail-row">
                <span class="detail-label">No. Pesanan</span>
                <span class="detail-value">{{ $order->order_number }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tanggal</span>
                <span class="detail-value">{{ $order->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Nama Pemesan</span>
                <span class="detail-value">{{ $order->recipient_name ?? $order->customer_name ?? 'Pelanggan' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Metode Pembayaran</span>
                <span class="detail-value" style="text-transform: uppercase;">{{ $order->payment_method }}</span>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Deskripsi Roti</th>
                    <th class="right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems ?? $order->items as $item)
                <tr>
                    <td>
                        <span class="item-name">{{ $item->product_name ?? ($item->product ? $item->product->name : 'Produk') }}</span>
                        <span class="item-qty">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                    </td>
                    <td class="right" style="font-weight: 600;">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            @php
                $realSubtotal = $order->subtotal ?? ($order->total_amount - $order->shipping_cost);
                $pajak = $realSubtotal * 0.08;
                $layanan = $realSubtotal * 0.05;
                $grandTotal = $realSubtotal + $pajak + $layanan;
            @endphp
            <div class="summary-row">
                <span>Subtotal</span>
                <span style="font-weight: 600;">Rp {{ number_format($realSubtotal, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Pajak (8%)</span>
                <span>Rp {{ number_format($pajak, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Biaya Layanan (5%)</span>
                <span>Rp {{ number_format($layanan, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row grand-total">
                <span>Total Pembayaran</span>
                <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="receipt-footer">
            <p>Terima kasih telah berbelanja di UPI Bakery!</p>
            <p>Struk elektronik ini adalah bukti pembayaran yang sah.</p>
        </div>
    </div>
</body>
</html>
