<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'address_id' => 'required|integer|exists:user_addresses,id',
            'coupon_code' => 'nullable|string'
        ]);

        if (!$request->session()->has('cart')) {
            return redirect()->route('cart.index')->with('error', 'سبد خرید خالی میباشد.');
        }

        $cart = $request->session()->get('cart');

        $totalAmount = 0;

        foreach ($cart as $key => $orderItem) {
            $product = Product::findOrFail($key);
            if ($product->quantity < $orderItem['qty']) {
                return redirect()->route('cart.index')->with('error', 'تعداد محصول وارد شده اشتباه است.');
            }
            $totalAmount += $product->is_sale ? $product->sale_price * $orderItem['qty'] : $product->price * $orderItem['qty'];
        }
        $couponAmount = 0;
        $coupon = null;
        if ($request->coupon_code) {
            $coupon = Coupon::where('code', $request->coupon_code)->where('expired_at', '>', Carbon::now()->first());

            if ($coupon == null) {
                return redirect()->route('cart.index')->with('error', 'کد تخفیف استفاده شده وجود ندارد.');
            }

            if (Order::where('user_id', Auth::id())->where('coupon_id', $coupon->id)->where('payment_status', 1)) {
                return redirect()->route('cart.index')->with('error', 'شما قبلا از این کد تخفیف استفاده کرده اید.');
            }
            $couponAmount = ($totalAmount * $coupon->percentage) / 100;
        }
        $payingAmount = $totalAmount - $couponAmount;

        $amounts = [
            'totalAmount' => $totalAmount,
            'couponAmount' => $couponAmount,
            'payingAmount' => $payingAmount,
        ];
        $api = env('PAY_IR_API_KEY');
        $amount = $payingAmount . '0';
        $redirect = env('PAY_IR_CALLBACK_URL');

        $result = $this->sendRequest($api, $amount, $redirect);
        $result = json_decode($result);

        if ($result->status) {
            OrderController::create($cart, $request->address_id, $coupon, $amounts, $result->token);

            return redirect()->to("https://pay.ir/pg/$result->token");
        } else {
            return redirect()->route('cart.index')->with('error', 'تراکنش با خطا مواجه شد');
        }
    }

    public function verify(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'status' => 'required|integer'
        ]);

        $api = env('PAY_IR_API_KEY');
        $token = $request->token;
        $result = json_decode($this->verifyRequest($api, $token));
        // dd($result);

        if (isset($result->status)) {
            if ($result->status == 1) {
                OrderController::update($token, $result->transId);

                return redirect()->route('payment.status', ['status' => 1, 'transId' => $result->transId])->with('success', 'تراکنش با موفقیت انجام شد.');
            } else {
                return redirect()->route('payment.status', ['status' => 0])->with('error', 'تراکنش با خطا مواجه شد.');
            }
        } else {
            return redirect()->route('payment.status', ['status' => 0])->with('error', 'تراکنش با خطا مواجه شد.');
        }
    }

    public function sendRequest($api, $amount, $redirect, $mobile = null, $factorNumber = null, $description = null)
    {
        return $this->curl_post('https://pay.ir/pg/send', [
            'api'          => $api,
            'amount'       => $amount,
            'redirect'     => $redirect,
            'mobile'       => $mobile,
            'factorNumber' => $factorNumber,
            'description'  => $description,
        ]);
    }

    public function verifyRequest($api, $token)
    {
        return $this->curl_post('https://pay.ir/pg/verify', [
            'api'     => $api,
            'token' => $token,
        ]);
    }

    public function curl_post($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }
    public function status(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'transId' => 'nullable'
        ]);
        $status =  $request->status;
        $transId =  $request->has('transId') ? $request->transId : null;
        return view('payment.verify', compact('status', 'transId'));
    }
}
