<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

\Illuminate\Support\Facades\Artisan::call('view:clear');
\Illuminate\Support\Facades\Artisan::call('config:clear');

require_once __DIR__.'/../app/Mail/OrderReceipt.php';
if (class_exists('App\Mail\OrderReceipt')) {
    echo "Class exists!<br>";
} else {
    echo "Class DOES NOT exist!<br>";
}

try {
    $order = \App\Models\Order::orderBy('id', 'desc')->first();
    if (!$order) die("No order");
    
    $order->email = 'sakarepna48@gmail.com';
    \Illuminate\Support\Facades\Mail::to($order->email)->send(new \App\Mail\OrderReceipt($order));
    echo "SUCCESS!";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
}
