<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public static function create($cart, $addressId, $coupon, $amounts, $token)
    {
        DB::beginTransaction();

        $order = Order::create([
            'user_id' => auth()->id(),
            'address_id' => $addressId,
            'total_amount' => $amounts['totalAmount'],
            'coupon_amount' => $amounts['couponAmount'],
            'paying_amount' => $amounts['payingAmount'],
            'coupon_id' => $coupon == null ? null : $coupon->id
        ]);

        foreach ($cart as $key => $orderItem) {
            $product = Product::findOrFail($key);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'price' => $product->is_sale ? $product->sale_price : $product->price,
                'quantity' => $orderItem['qty'],
                'subtotal' => $product->is_sale ? ($product->sale_price * $orderItem['qty']) : ($product->price * $orderItem['qty'])
            ]);
        }

        Transaction::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'amount' => $amounts['payingAmount'],
            'token' => $token
        ]);

        DB::commit();
    }
    public static function update($token, $refNumber)
    {
        DB::beginTransaction();

        $transaction = Transaction::where('token', $token)->firstOrFail();

        $transaction->update([
            'status' => 1,
            'ref_number' => $refNumber
        ]);

        $order = Order::findOrFail($transaction->order_id);

        $order->update([
            'status' => 1,
            'payment_status' => 1
        ]);

        foreach (OrderItem::where('order_id', $order->id)->get() as $item) {
            $product = Product::find($item->product_id);
            $product->update([
                'quantity' => ($product->quantity -  $item->quantity)
            ]);
        }

        DB::commit();
    }
}
