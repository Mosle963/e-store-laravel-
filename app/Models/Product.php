<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'supplier_id',
        'unit_price',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
