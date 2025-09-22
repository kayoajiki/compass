<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // adminガードを使用して認証
        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();
            
            // 管理者権限をチェック
            if ($user && $user->isAdmin()) {
                $request->session()->regenerate();
                return redirect()->intended('/admin');
            } else {
                Auth::guard('admin')->logout();
                return back()->withErrors([
                    'email' => '管理者権限が必要です。',
                ]);
            }
        }

        return back()->withErrors([
            'email' => '認証情報が正しくありません。',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}
