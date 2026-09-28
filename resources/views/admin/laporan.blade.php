{{-- ========================================================================================= --}}
{{-- [FITUR ADMIN] LAPORAN PENJUALAN & ANALISIS GRAFIK                                         --}}
{{-- Fungsi: Visualisasi omzet bulanan, persentase pertumbuhan, & grafik Chart.js 6 bulan       --}}
{{-- ========================================================================================= --}}
@extends('layouts.admin')

@section('content')
<div class="w-full">
    <!-- Header -->
    <div class="flex justify-between items-end mb-10">
        <div>
            <h2 class="font-heading text-4xl font-bold text-[#693e1b] mb-1">Laporan Penjualan</h2>
            <p class="text-sm text-[#8c7a6b] mt-2">Pantau hasil produksi dan tren pendapatan toko Anda.</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <!-- Card 1 -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#ece3d4]">
            <div class="flex justify-between items-center mb-6">
                <div class="text-[10px] font-bold text-[#8c7a6b] tracking-wider uppercase">Pemasukan Bulan Ini</div>
                @if($persentasePendapatan >= 0)
                <div class="flex items-center bg-[#fdf0dc] px-2.5 py-1 rounded-full text-[#b86b16] text-[10px] font-bold">
                    <i data-lucide="trending-up" class="w-3 h-3 mr-1"></i>
                    +{{ number_format($persentasePendapatan, 1) }}%
                </div>
                @else
                <div class="flex items-center bg-[#fadada] px-2.5 py-1 rounded-full text-[#c94040] text-[10px] font-bold">
                    <i data-lucide="trending-down" class="w-3 h-3 mr-1"></i>
                    {{ number_format($persentasePendapatan, 1) }}%
                </div>
                @endif
            </div>
            <div class="flex items-baseline">
                <span class="font-heading text-3xl font-bold text-[#693e1b]">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                <span class="text-xs font-medium text-[#8c7a6b] ml-2">dibanding bulan lalu</span>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#ece3d4]">
            <div class="flex justify-between items-center mb-6">
                <div class="text-[10px] font-bold text-[#8c7a6b] tracking-wider uppercase">Rata-Rata 1x Belanja</div>
                <div class="w-6 h-6 bg-[#f9f5f0] rounded flex items-center justify-center text-[#8c7a6b]">
                    <i data-lucide="receipt" class="w-3.5 h-3.5"></i>
                </div>
            </div>
            <div class="flex items-baseline">
                <span class="font-heading text-3xl font-bold text-[#693e1b]">Rp {{ number_format($rataRataPesanan, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#ece3d4] flex items-center">
            @if($produkTerlaris && $produkTerlaris->product)
                <img src="{{ $produkTerlaris->product->image ? asset('storage/' . $produkTerlaris->product->image) : 'https://placehold.co/200x200?text=No+Image' }}" class="w-20 h-20 rounded-2xl object-cover shadow-sm mr-5" alt="Best Seller">
                <div>
                    <div class="text-[10px] font-bold text-[#8c7a6b] tracking-wider uppercase mb-1">Roti Paling Laku Bulan Ini</div>
                    <h3 class="font-heading text-xl font-bold text-[#693e1b] leading-tight mb-1">{{ Str::limit($produkTerlaris->product->name, 20) }}</h3>
                    <div class="text-xs font-medium text-[#8c7a6b]">Terjual {{ $produkTerlaris->total_sold }} unit</div>
                </div>
            @else
                <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center shadow-sm mr-5">
                    <i data-lucide="box" class="w-8 h-8 text-gray-400"></i>
                </div>
                <div>
                    <div class="text-[10px] font-bold text-[#8c7a6b] tracking-wider uppercase mb-1">Roti Paling Laku Bulan Ini</div>
                    <h3 class="font-heading text-xl font-bold text-gray-400 leading-tight mb-1">Belum Ada Data</h3>
                </div>
            @endif
        </div>

    </div>

    <!-- Chart Section -->
    <div class="bg-white rounded-3xl shadow-sm border border-[#ece3d4] overflow-hidden">
        <div class="p-8 flex justify-between items-center border-b border-[#ece3d4]">
            <h3 class="font-heading text-2xl font-bold text-[#693e1b]">
                Grafik Pemasukan 6 Bulan Terakhir
            </h3>
        </div>
        
        <div class="px-8 pb-8 pt-6">
            <div class="relative w-full h-80">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('salesChart').getContext('2d');
        
        // Data dari Controller
        const labels = {!! json_encode($chartLabels) !!};
        const dataPoints = {!! json_encode($chartData) !!};

        // Buat gradasi warna untuk area bawah grafik
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(184, 107, 22, 0.2)');   // #b86b16
        gradient.addColorStop(1, 'rgba(184, 107, 22, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: dataPoints,
                    borderColor: '#693e1b',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#693e1b',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4 // Membuat garis sedikit melengkung (smooth)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Sembunyikan legenda agar lebih bersih
                    },
                    tooltip: {
                        backgroundColor: '#693e1b',
                        titleFont: { family: "'Plus Jakarta Sans', sans-serif", size: 13 },
                        bodyFont: { family: "'Plus Jakarta Sans', sans-serif", size: 14, weight: 'bold' },
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                let value = context.raw;
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#ece3d4',
                            drawBorder: false,
                            borderDash: [5, 5] // Garis putus-putus
                        },
                        ticks: {
                            font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 },
                            color: '#8c7a6b',
                            callback: function(value) {
                                if (value >= 1000000) return 'Rp ' + (value / 1000000) + ' Jt';
                                if (value >= 1000) return 'Rp ' + (value / 1000) + ' Rb';
                                return 'Rp ' + value;
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: { family: "'Plus Jakarta Sans', sans-serif", size: 12 },
                            color: '#8c7a6b'
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
