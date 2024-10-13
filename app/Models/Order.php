<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_date',
        'customer_id',
    ];

    //generate an order number on creation of new order
    protected static function booted()
    {
        static::creating(function ($order) {
            $order->order_number = 'Ord-'.Carbon::now()->format('YmdHis').'-'.Str::random(4);
        });
    }

    public function order_items()
    {
        return $this->hasMany(Order_item::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    //function to update the total amount to be triggeres when
    //related order_item is created,edited or deleted
    public function updateTotalAmount()
    {
        $this->total_amount = $this->order_items->sum(function ($item) {
            return $item->unit_price * $item->quantity;
        });
        $this->save();
    }
}
