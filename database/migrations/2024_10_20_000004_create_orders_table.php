<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_number')->unique();
            $table->enum('status', ['menunggu_pembayaran', 'diproses', 'selesai', 'dibatalkan'])->default('menunggu_pembayaran');
            $table->enum('payment_method', ['kasir', 'qris']);
            $table->enum('payment_status', ['belum_dibayar', 'sudah_dibayar', 'gagal'])->default('belum_dibayar');
            $table->integer('subtotal');
            $table->integer('shipping_cost')->default(0);
            $table->integer('total_amount');
            $table->string('estimated_time')->nullable();
            
            // Shipping Info
            $table->string('recipient_name');
            $table->string('recipient_phone');
            $table->text('shipping_address');
            $table->string('city');
            $table->string('postal_code');
            $table->text('shipping_notes')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
