<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Make user_id and shipping info nullable
            $table->foreignId('user_id')->nullable()->change();
            $table->string('recipient_name')->nullable()->change();
            $table->string('recipient_phone')->nullable()->change();
            $table->text('shipping_address')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('postal_code')->nullable()->change();
            
            // Add order_type column
            $table->enum('order_type', ['dine_in', 'takeaway', 'delivery'])->default('takeaway')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_type');
            
            $table->foreignId('user_id')->nullable(false)->change();
            $table->string('recipient_name')->nullable(false)->change();
            $table->string('recipient_phone')->nullable(false)->change();
            $table->text('shipping_address')->nullable(false)->change();
            $table->string('city')->nullable(false)->change();
            $table->string('postal_code')->nullable(false)->change();
        });
    }
};
