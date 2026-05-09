<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'salla_order_id', 'reference_id', 'status',
        'customer_name', 'customer_phone', 'total',
        'payment_method', 'raw_payload', 'whatsapp_sent',
    ];

    protected $casts = [
        'raw_payload'    => 'array',
        'whatsapp_sent'  => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
