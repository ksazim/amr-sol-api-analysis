<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'prd_img',
        'sku',
        'cat',
        'stock',
        'old_price',
        'new_price',
        'status'
    ];

    public function prices()
    {
        return $this->hasMany(\App\Models\ProductPrice::class);
    }
}
