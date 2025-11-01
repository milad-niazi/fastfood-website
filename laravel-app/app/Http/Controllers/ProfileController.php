<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Province;
use App\Models\UserAddress;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        /** @var \Illuminate\Contracts\Auth\Guard $auth */
        $auth = auth();
        $user = $auth->user();
        return view('profile.index', compact('user'));
    }
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return redirect()->route('profile.index')->with('success', 'ویرایش کاربر با موفقیت انجام شد.');
    }
    public function addresses()
    {
        /** @var \Illuminate\Contracts\Auth\Guard $auth */
        $auth = auth();
        $addresses = $auth->user()->addresses;
        return view('profile.addresses.index', compact('addresses'));
    }
    public function addressCreate()
    {
        $provinces = Province::all();
        $cities = City::all();
        return view('profile.addresses.create', compact('provinces', 'cities'));
    }
    public function addressStore(Request $request, User $user)
    {
        /** @var \Illuminate\Contracts\Auth\Guard $auth */
        $auth = auth();
        $user = $auth->user();
        $request->validate([
            'title' => 'required|string',
            'cellphone' => ['required', 'regex:/^09[0|1|2|3][0-9]{8}$/'],
            'postal_code' => ['required', 'regex:/^\d{5}[ -]?\d{5}$/'],
            'province_id' => 'required|integer',
            'city_id' => 'required|integer',
            'address' => 'required|string'
        ]);
        UserAddress::create([
            'title' => $request->title,
            'address' => $request->address,
            'cellphone' => $request->cellphone,
            'postal_code' => $request->postal_code,
            'user_id' => $user->id,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id
        ]);
        return redirect()->route('profile.address')->with('success', 'ایجاد آدرس با موفقیت انجام شد.');
    }
    public function addressEdit(UserAddress $address)
    {
        $provinces = Province::all();
        $cities = City::all();
        return view('profile.addresses.edit', compact('address', 'cities', 'provinces'));
    }
    public function addressUpdate(Request $request, UserAddress $address)
    {
        $request->validate([
            'title' => 'required|string',
            'cellphone' => ['required', 'regex:/^09[0|1|2|3][0-9]{8}$/'],
            'postal_code' => ['required', 'regex:/^\d{5}[ -]?\d{5}$/'],
            'province_id' => 'required|integer',
            'city_id' => 'required|integer',
            'address' => 'required|string'
        ]);

        $address->update([
            'title' => $request->title,
            'cellphone' => $request->cellphone,
            'postal_code' => $request->postal_code,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
        ]);
        return redirect()->route('profile.address')->with('success', 'آدرس شما با موفقیت ویرایش شد');
    }

    public function addToWishlist(Request $request)
    {
        /** @var \Illuminate\Contracts\Auth\Guard $auth */
        $auth = auth();
        $user = $auth->user();

        $request->validate(['product_id' => 'required|integer|exists:products,id']);

        if (!$auth->check()) {
            return redirect()->back()->with('warning', 'ابتدا وارد حساب کاربری شوید.');
        }

        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id
        ]);

        return redirect()->back()->with('success', 'محصول با موفقیت به لیست علاقمندی اضافه شد.');
    }

    public function orders()
    {
        $orders = auth()->user()->orders()->orderByDesc('created_at')->with(['address', 'orderItems'])->paginate(3);
        return view('profile.orders', compact('orders'));
    }

    public function wishlist()
    {
        // /** @var \Illuminate\Contracts\Auth\Guard $auth */
        $wishlist = Auth::user()->wishlist;
        // $wishlist = auth()->user()->wishlist;
        // $auth = auth();
        // $user = $auth->user();
        // $wishlist = Wishlist::where($user);
        return view('profile.wishlist', compact('wishlist'));
    }
    public function removeFromWishlist(Request $request)
    {
        $request->validate(['wishlist' => 'required|integer|exists:wishlist,id']);
        $wishlist = Wishlist::findOrFail($request->wishlist);
        $wishlist->delete();

        return redirect()->route('profile.wishlist')->with('warning', ' علاقمندی های شما با موفقیت اصلاح شد.');
    }

    public function transactions()
    {
        $transactions = auth()->user()->transactions()->orderByDesc('created_at')->paginate(3);
        return view('profile.transactions', compact('transactions'));
    }
}
