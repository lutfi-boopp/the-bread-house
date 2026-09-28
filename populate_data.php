<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

// Hapus kategori lama
Category::whereIn('name', ['Pastry', 'Artisan Bread'])->delete();

// Jika ingin menghapus semua kategori dan produk (opsional, tapi biar bersih kita bersihkan saja yang dummy lama)
// Product::truncate(); // Jangan truncate jika ada data yang mau disimpan, kita hapus saja semua untuk percobaan
Product::query()->delete();
Category::query()->delete();

$categories = [
    'Roti Manis' => [
        ['name' => 'Roti Coklat Lumer', 'price' => 8000, 'stock' => 20, 'desc' => 'Roti lembut dengan isian coklat lumer di dalam.'],
        ['name' => 'Roti Keju Susu', 'price' => 9000, 'stock' => 15, 'desc' => 'Roti manis dengan taburan keju parut dan susu kental manis.']
    ],
    'Roti Tawar' => [
        ['name' => 'Roti Tawar Gandum', 'price' => 15000, 'stock' => 10, 'desc' => 'Roti tawar gandum sehat dan kaya serat.'],
        ['name' => 'Roti Tawar Putih Lembut', 'price' => 12000, 'stock' => 12, 'desc' => 'Roti tawar putih klasik yang super lembut.']
    ],
    'Kue & Dessert' => [
        ['name' => 'Brownies Panggang', 'price' => 35000, 'stock' => 5, 'desc' => 'Brownies coklat panggang dengan topping almond.'],
        ['name' => 'Bolu Karamel (Sarang Semut)', 'price' => 25000, 'stock' => 8, 'desc' => 'Kue bolu karamel tradisional yang manis dan legit.']
    ],
    'Minuman Dingin' => [
        ['name' => 'Es Kopi Susu Aren', 'price' => 15000, 'stock' => 30, 'desc' => 'Perpaduan espresso, susu segar, dan gula aren pilihan.'],
        ['name' => 'Matcha Latte Ice', 'price' => 18000, 'stock' => 20, 'desc' => 'Minuman matcha asli Jepang dipadu dengan susu dingin.']
    ],
    'Minuman Panas' => [
        ['name' => 'Hot Cappuccino', 'price' => 16000, 'stock' => 25, 'desc' => 'Kopi hangat dengan buih susu tebal.'],
        ['name' => 'Teh Tarik Panas', 'price' => 10000, 'stock' => 30, 'desc' => 'Teh susu dengan metode tarik tradisional yang khas.']
    ]
];

foreach ($categories as $catName => $products) {
    $cat = Category::create([
        'name' => $catName,
        'slug' => Str::slug($catName)
    ]);

    foreach ($products as $prod) {
        Product::create([
            'category_id' => $cat->id,
            'name' => $prod['name'],
            'slug' => Str::slug($prod['name']),
            'description' => $prod['desc'],
            'price' => $prod['price'],
            'stock' => $prod['stock']
        ]);
    }
}

echo "Data berhasil di-generate!\n";
