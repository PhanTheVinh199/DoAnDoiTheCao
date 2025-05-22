<?php

// app/Models/Order.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_code', 'user_id', 'total_amount', 'status',
    ];

    // Định nghĩa quan hệ với model ThanhVien
    public function user()
    {
        return $this->belongsTo(ThanhVien::class, 'user_id');
    }
}
