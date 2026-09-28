<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 
        'price', 'image', 'rating', 'is_active', 'stock'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Hitung ulang dan update rating produk berdasarkan jumlah barang yang terjual.
     * Hanya Best Seller yang mendapat 5.0. Rating berkisar antara 3.5 hingga 5.0.
     */
    public function recalculateRating()
    {
        $totalSold = $this->orderItems()->sum('quantity');

        // Cari total penjualan tertinggi di seluruh produk (Best Seller)
        $maxSold = \App\Models\OrderItem::selectRaw('SUM(quantity) as total')
                    ->groupBy('product_id')
                    ->orderByDesc('total')
                    ->value('total');

        if (!$maxSold || $maxSold == 0) {
            $this->rating = 3.5; // Jika belum ada pesanan di toko
        } else {
            // Kalkulasi proporsional: 3.5 (minimum) sampai 5.0 (maksimum)
            $this->rating = round(3.5 + (1.5 * ($totalSold / $maxSold)), 1);
        }
        
        $this->save();
    }
}
