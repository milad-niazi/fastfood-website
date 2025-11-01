<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function menu(Request $request)
    {
        $categories = Category::all()->whereNull('deleted_at');
        $products = Product::whereNull('deleted_at')->where('quantity', '>', 0)->where('status', 1)->search($request->search)->search($request->search)->filter()->paginate(3);
        return view('products.menu', compact('products', 'categories'));
    }
}
