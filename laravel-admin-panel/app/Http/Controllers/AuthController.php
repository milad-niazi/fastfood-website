<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('auth.login.form')->withErrors(['email' => 'کاربری با این ایمیل یافت نشد']);
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->route('auth.login.form')->withErrors(['password' => 'پسورد وارد شده اشتباه هست']);
        }

        auth()->login($user, $remember = true);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login.form');
    }
}
