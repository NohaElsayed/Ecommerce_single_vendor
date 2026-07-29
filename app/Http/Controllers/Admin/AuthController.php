<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            if (!auth()->user()->hasAnyRole(['admin', 'manager', 'editor'])) {
                Auth::logout();
                return back()->with('error', 'ليس لديك صلاحية الدخول للوحة التحكم');
            }
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->with('error', 'بيانات الدخول غير صحيحة');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
