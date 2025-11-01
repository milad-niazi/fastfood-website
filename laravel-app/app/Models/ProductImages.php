<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImages extends Model
{
    use HasFactory;

    protected $table = 'product_images';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
