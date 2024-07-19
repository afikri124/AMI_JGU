<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login_account' => 'required|string',
            'password' => 'required|string',
        ]);

        $login_account = $request->input('login_account');
        $password = $request->input('password');

        // Cek apakah username/email ada
        $user = \App\Models\User::where('email', $login_account)
                                ->orWhere('username', $login_account)
                                ->first();

        if ($user) {
            // Username/email benar, tetapi password salah
            if (!Auth::attempt(['email' => $login_account, 'password' => $password]) && !Auth::attempt(['username' => $login_account, 'password' => $password])) {
                return back()->withErrors(['password' => 'Password salah. Silakan coba lagi.']);
            }
        } else {
            return back()->withErrors(['login_account' => 'These credentials do not match our records.']);
        }

        // Lakukan login
        if (Auth::attempt(['email' => $login_account, 'password' => $password]) || Auth::attempt(['username' => $login_account, 'password' => $password])) {
            return redirect()->intended('dashboard');
        } else {
            return back()->withErrors(['login_account' => 'These credentials do not match our records.']);
        }
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
