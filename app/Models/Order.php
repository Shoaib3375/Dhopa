<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_type',
        'status',
        'schedule',
        'total_price',
        'pickup_address',
        'delivery_address',
        'special_instructions',
        'payment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
