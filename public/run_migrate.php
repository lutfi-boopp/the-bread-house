<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

try {
    if (!Schema::hasTable('order_items')) {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('price');
            $table->integer('quantity');
            $table->timestamps();
        });
        echo "<h1>Sukses!</h1><p>Tabel 'order_items' telah berhasil dibuat paksa.</p>";
    } else {
        echo "<h1>Tabel sudah ada!</h1><p>Tabel 'order_items' ternyata sudah ada di database.</p>";
    }
} catch (\Exception $e) {
    echo "<h1>Error:</h1><p>" . $e->getMessage() . "</p>";
}
