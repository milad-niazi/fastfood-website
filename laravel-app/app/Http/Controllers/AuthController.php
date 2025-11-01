<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'cellphone' => ['required', 'regex:/^09[0|1|2|3][0-9]{8}$/']
        ]);
        try {
            $user = User::where('cellphone', $request->cellphone)->first();
            $otpCode = mt_rand(10000, 99999);
            $loginToken = Hash::make('lkasjdlksajdlkajldkjwoijk@lksad*');
            if ($user) {
                $user->update([
                    'otp' => $otpCode,
                    'login_token' => $loginToken
                ]);
            } else {
                $user = User::create([
                    'cellphone' => $request->cellphone,
                    'otp' => $otpCode,
                    'login_token' => $loginToken
                ]);
            }

            sendOtpSms($request->cellphone, $otpCode);

            return response()->json(['login_token' => $loginToken], 200);
        } catch (\Exception $th) {
            return response()->json(['errors' => $th->getMessage()], 500);
        }
    }

    public function checkOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:5',
            'login_token' => 'required'
        ]);

        try {
            $user = User::where('login_token', $request->login_token)->firstOrFail();

            if ($user->otp == $request->otp) {
                Auth::guard('web')->login($user, $remember = true);
                return response()->json(['message' => 'ورود با موفقیت انجام شد!'], 200);
            } else {
                return response()->json(['message' => 'کد ورود اشتباه است!'], 422);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Success!'], 200);
        }
    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            'login_token' => 'required'
        ]);
        try {
            $user = User::where('login_token', $request->login_token)->first();
            $otpCode = mt_rand(10000, 99999);
            $loginToken = Hash::make('lkasjdlksajdlkajldkjwoijk@lksad*');

            $user->update([
                'otp' => $otpCode,
                'login_token' => $loginToken
            ]);
            sendOtpSms($user->cellphone, $otpCode);
            return response()->json(['login_token' => $loginToken], 200);
        } catch (\Exception $th) {
            return response()->json(['errors' => $th->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home.index');
    }
}
