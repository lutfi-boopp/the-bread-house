<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'session_id', 'order_number', 'order_type', 'payment_method',
        'subtotal', 'shipping_cost', 'total_amount', 'estimated_time',
        'recipient_name', 'recipient_phone', 'shipping_address', 'city',
        'postal_code', 'shipping_notes', 'table_number', 'email'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
