<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderReceipt;

Route::get('/test-email', function () {
    try {
        $order = \App\Models\Order::orderBy('id', 'desc')->first();
        if (!$order) {
            return "No order found";
        }
        
        $order->email = 'sakarepna48@gmail.com';
        Mail::to($order->email)->send(new OrderReceipt($order));
        
        return "Email terkirim ke {$order->email}!";
    } catch (\Throwable $e) {
        return "Error: " . $e->getMessage() . " di " . $e->getFile() . " baris " . $e->getLine();
    }
});
