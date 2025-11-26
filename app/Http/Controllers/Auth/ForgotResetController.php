<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class ForgotResetController extends Controller
{
    public function showForm($token = null)
    {
        return view('auth.forgot-password', ['token' => $token]);
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    
        $userExists = \App\Models\User::where('email', $request->email)->exists();
    
        if (!$userExists) {
            return back()->withErrors(['email' => 'Email tidak ditemukan']);
        }
    
        $status = Password::sendResetLink(
            $request->only('email'),
            function ($user, $token) use ($request) {
                $url = route('password.reset', [
                    'token' => $token,
                    'email' => $request->email
                ]);
    
                $user->sendPasswordResetNotification($token);
            }
        );
    
        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Link reset password telah dikirim ke email Anda')
            : back()->withErrors(['email' => 'Gagal mengirim link reset password. Silakan coba lagi.']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
