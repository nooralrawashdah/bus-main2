<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // معالجة تسجيل الدخول
    public function login(Request $request)
    {
        // 1. تحقق من البيانات
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // 2. حاول تسجيل الدخول
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. توجيه حسب نوع المستخدم
            $user = Auth::user();

            if ($user->hasRole('driver')) {
                return redirect()->route('driver.dashboard');
            } elseif ($user->hasRole('admin')) {
                return redirect()->route('manager.mdashboard');
            } else {
                return redirect()->route('student.dashboard');
            }
            /* else {
    // fallback إذا ما عنده أي دور
    Auth::logout();
    return redirect()->route('login')->withErrors(['email' => 'لا يوجد دور صالح لهذا الحساب.']);
}*/
        }

        // 4. إذا فشل تسجيل الدخول
        return back()->withErrors([

            'email' => ' not validet Email or password',
        ])->onlyInput('email');
    }

    // تسجيل الخروج
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
