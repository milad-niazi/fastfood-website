<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->with(['address', 'orderItems'])->paginate(3);
        return view('orders.index', compact('orders'));
    }
}
