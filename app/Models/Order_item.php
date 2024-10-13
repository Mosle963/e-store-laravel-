<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'unit_price',
        'quantity',
    ];

    //use the booted function to trigger an action when order item created,edited or deleted
    //modify the order owns the order item to update the total amount
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
