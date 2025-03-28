<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;

class RegisterController extends Controller
{
    public function show(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('authorization.register');
    }

    public function register(Request $request)
    {
        // Validasyon kuralları
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Eğer validasyon başarısız olursa
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        try {
            // Kullanıcı oluşturma
            $user = User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            // Oturumu başlat
            Auth::login($user);

            // Email doğrulama bildirimi gönder
            event(new Registered($user));

            return response()->json([
                'status' => true,
                'message' => 'Kayıt başarılı! Lütfen e-postanızı doğrulayın.',
                'reload' => route('verification.resend'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kayıt sırasında bir hata oluştu. Lütfen tekrar deneyin.',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function verify_mail(Request $request, $id, $hash)
    {
        $user = User::find($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return view('authorization.complate-verify', [
                'status' => false,
                'message' => 'Geçersiz doğrulama linki. Lütfen tekrar deneyin.',
                'show_resend' => true, // Kullanıcıya yeniden e-posta gönderme butonunu göstermek için
            ]);
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        Auth::login($user);

        return view('authorization.complate-verify', [
            'status' => true,
            'message' => 'E-posta başarıyla doğrulandı! Hesabınız artık aktif.',
            'show_resend' => false, // Başarılı olursa yeniden gönderme butonu gösterilmez
        ]);
    }


    public function wait_verify(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('authorization.verify-email');
    }

    public function resend_verification(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Oturum açılmadı. Lütfen giriş yapın.',
            ], 401);
        }

        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'status' => false,
                'message' => 'E-posta zaten doğrulandı.',
            ]);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'status' => true,
            'message' => 'Doğrulama e-postası tekrar gönderildi!',
        ]);
    }
}
