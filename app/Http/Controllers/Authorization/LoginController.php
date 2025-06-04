<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class LoginController extends Controller
{
    public function show(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('authorization.login');
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:8',
        'remember' => 'nullable|boolean'
    ]);

    $credentials = $request->only('email', 'password');

    $remember = $request->boolean('remember');

    if (!Auth::attempt($credentials, $remember)) {
        return response()->json([
            'status' => false,
            'message' => 'Geçersiz e-posta veya şifre!',
        ]);
    }

    $user = Auth::user();

    if (!$user->hasVerifiedEmail()) {
        Auth::logout();

        return response()->json([
            'status' => false,
            'message' => 'E-posta adresiniz doğrulanmamış. Lütfen e-postanızı doğrulayın.',
            'resend_verification' => route('verification.resend'),
        ]);
    }

    return response()->json([
        'status' => true,
        'message' => 'Giriş başarılı!',
        'reload' => url('/'),
    ]);
}


}
