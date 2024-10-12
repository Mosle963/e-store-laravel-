<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
class Order_item extends Model
{
    use HasFactory;
    protected $fillable=[
        'order_id',
        'product_id',
        'unit_price',
        'quantity'
    ];

    protected static function booted()
    {
        static::saved(function ($order_item) {
            $order_item->order->updateTotalAmount();
        });

        static::deleted(function ($order_item) {
            $order_item->order->updateTotalAmount();
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
