<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order_item;
class Order extends Model
{
    use HasFactory;
    protected $fillable=[
        'order_date',
        'customer_id',
    ];

    protected static function booted()
    {
        static::creating(function ($order) {
            $order->order_number ='Ord-'.Carbon::now()->format('YmdHis').'-'.Str::random(4);
        });
    }

    public function order_items()
    {
        return $this->hasMany(Order_item::class);
    }

    public function updateTotalAmount()
    {
        $this->total_amount = $this->orderItems->sum(function ($item) {
            return $item->unit_price * $item->quantity;
        });
        $this->save();
    }



}
