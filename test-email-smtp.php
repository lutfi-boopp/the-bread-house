<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Order;
use App\Mail\OrderReceipt;
use Illuminate\Support\Facades\Mail;

try {
    // Cari order yang sudah selesai untuk di-test
    $order = Order::first();
    if(!$order) {
        die("Tidak ada data order untuk di-test\n");
    }
    
    echo "Mencoba mengirim email ke sakarepna48@gmail.com...\n";
    Mail::to('sakarepna48@gmail.com')->send(new OrderReceipt($order));
    echo "Email berhasil dikirim!\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
