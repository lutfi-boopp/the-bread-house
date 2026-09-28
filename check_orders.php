<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$orders = \App\Models\Order::orderBy('id', 'desc')->take(3)->get();
foreach ($orders as $order) {
    echo "Order: {$order->order_number}, Status: {$order->status}, Email: {$order->email}\n";
}
