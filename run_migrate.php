<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    \Illuminate\Support\Facades\Artisan::call('migrate');
    echo "<h1>Migrasi Database Berhasil!</h1>";
    echo "<p>Tabel-tabel yang hilang (termasuk order_items) sudah dibuat ulang.</p>";
    echo "<pre>" . \Illuminate\Support\Facades\Artisan::output() . "</pre>";
} catch (\Exception $e) {
    echo "<h1>Gagal melakukan migrasi:</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
}
