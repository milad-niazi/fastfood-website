<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Hekmatinasser\Verta\Facades\Verta;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();
        return view('coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('coupons.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'percentage' => 'required|integer',
            'expired_at' => 'required|date_format:Y/m/d H:i:s'
        ]);

        Coupon::create([
            'code' => $request->code,
            'percentage' => $request->percentage,
            'expired_at' => Verta::parse($request->expired_at)->formatGregorian('Y-n-j H:i')
        ]);

        return redirect()->route('coupon.index')->with('success', 'کد تخفیف با موفقیت ایجاد شد');
    }

    public function edit(Coupon $coupon)
    {
        return view('coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $coupon->id,
            'percentage' => 'required|integer',
            'expired_at' => 'required|date_format:Y/m/d H:i:s'
        ]);

        $coupon->update([
            'code' => $request->code,
            'percentage' => $request->percentage,
            'expired_at' => Verta::parse($request->expired_at)->formatGregorian('Y-n-j H:i')
        ]);

        return redirect()->route('coupon.index')->with('success', 'کد تخفیف با موفقیت ویرایش شد');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('coupon.index')->with('warning', 'کد تخفیف با موفقیت حذف شد');
    }
}
