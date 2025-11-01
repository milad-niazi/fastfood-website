<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\ProductImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $guarded = [];
    protected $appends = ['is_sale'];

    public function getIsSaleAttribute()
    {
        return $this->quantity > 0 && $this->sale_price !== 0 && $this->sale_price !== null && $this->date_on_sale_from < Carbon::now() && $this->date_on_sale_to > Carbon::now();
    }
    public function images()
    {
        return $this->hasMany(ProductImages::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE', '%' . trim($search) . '%')->orWhere('description', 'LIKE', '%' . trim($search) . '%');
    }
    public function scopeFilter($query)
    {
        if (request()->has('category')) {
            return $query->where('category_id', request()->category);
        }
        if (request()->has('sortBy')) {
            switch (request()->sortBy) {
                case 'max':
                    $query->orderBy('price', 'desc');
                    break;
                case 'min':
                    $query->orderBy('price');
                    break;
                case 'bestseller':
                    $orders = Order::where('payment_status', 1)->with('products')->get();
                    $productIds = [];
                    foreach ($orders as $order) {
                        foreach ($order->products as $product) {
                            array_push($productIds, $product->id);
                        }
                    }
                    $query->wherein('id', array_keys(array_count_values($productIds)));
                    break;
                case 'sale':
                    $query->where('sale_price', '!=', 0)->where('date_on_sale_from', '<', Carbon::now())->where('date_on_sale_to', '>', Carbon::now());
                    break;
                default:
                    $query;
                    break;
            }
        }
        return $query;
    }
}
