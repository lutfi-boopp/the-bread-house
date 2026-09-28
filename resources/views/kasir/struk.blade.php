{{-- ========================================================================================= --}}
{{-- [FITUR KASIR] TEMPLATE CETAK STRUK BELANJA --}}
{{-- Fungsi: Layout struk belanja ukuran thermal 58mm/80mm & cetak otomatis (window.print()) --}}
{{-- ========================================================================================= --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $order->order_number }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #000;
            background-color: #fff;
        }

        .receipt {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }

        .mb-1 {
            margin-bottom: 5px;
        }

        .mb-2 {
            margin-bottom: 10px;
        }

        .mt-2 {
            margin-top: 10px;
        }

        .border-top {
            border-top: 1px dashed #000;
        }

        .border-bottom {
            border-bottom: 1px dashed #000;
        }

        .py-1 {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .py-2 {
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .flex {
            display: flex;
            justify-content: space-between;
        }

        .header h1 {
            font-size: 18px;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }

        .header p {
            margin: 0 0 3px 0;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 3px 0;
            vertical-align: top;
        }

        .item-name {
            width: 50%;
        }

        .item-qty {
            width: 15%;
            text-align: center;
        }

        .item-price {
            width: 35%;
            text-align: right;
        }

        @media print {
            html, body {
                margin: 0;
                padding: 0;
                height: auto;
            }

            .receipt {
                width: 100%;
                padding: 5px;
                margin: 0;
            }

            @page {
                margin: 0;
                size: 80mm auto; /* Memastikan printer thermal otomatis memotong di akhir konten */
            }
        }
    </style>
</head>

<body>
    <div class="receipt">
        <div class="header text-center mb-2">
            <h1>The Bread House</h1>
            <p>Jl. Jend. Sudirman No. 271, Ciamis</p>
            <p>Telp: 0812-3456-7890</p>
        </div>

        <div class="border-top border-bottom py-1 mb-2">
            <div class="flex">
                <span>Tanggal</span>
                <span>{{ $order->updated_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="flex">
                <span>No. Pesanan</span>
                <span>{{ $order->order_number }}</span>
            </div>
            <div class="flex">
                <span>Pelanggan</span>
                <span>{{ $order->recipient_name ?? $order->user->name ?? 'Walk-in' }}</span>
            </div>
            <div class="flex">
                <span>Pembayaran</span>
                <span style="text-transform: uppercase;">{{ $order->payment_method }}</span>
            </div>
        </div>

        <table class="mb-2 border-bottom pb-2">
            @foreach($order->orderItems as $item)
                <tr>
                    <td class="item-name">{{ $item->product->name ?? 'Item' }}</td>
                    <td class="item-qty">{{ $item->quantity }}x</td>
                    <td class="item-price">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>

        <div class="mb-2 border-bottom pb-2">
            <div class="flex mb-1">
                <span>Subtotal</span>
                <span>{{ number_format($order->subtotal ?? ($order->total_amount - $order->shipping_cost), 0, ',', '.') }}</span>
            </div>
            @php
                $realSubtotal = $order->subtotal ?? ($order->total_amount - $order->shipping_cost);
                $pajak = round($realSubtotal * 0.08);
                $layanan = $order->shipping_cost - $pajak;
            @endphp
            @if($order->shipping_cost > 0)
                <div class="flex mb-1">
                    <span>Pajak (8%)</span>
                    <span>{{ number_format($pajak, 0, ',', '.') }}</span>
                </div>
                <div class="flex mb-1">
                    <span>Layanan (5%)</span>
                    <span>{{ number_format($layanan, 0, ',', '.') }}</span>
                </div>
            @endif
            <div class="flex font-bold mt-2" style="font-size: 14px;">
                <span>TOTAL</span>
                <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="text-center mt-2">
            <p class="mb-1 font-bold">TERIMA KASIH</p>
            <p style="font-size: 10px;">Barang yang sudah dibeli<br>tidak dapat dikembalikan</p>
        </div>
    </div>

    <script>
        // Otomatis trigger print saat halaman terbuka
        window.onload = function () {
            window.print();

            // Opsional: Tutup tab setelah dialog print ditutup (beberapa browser mendukung ini)
            // window.onafterprint = function() {
            //     window.close();
            // }
        }
    </script>
</body>

</html>