<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * プロフィール編集ページを表示
     */
    public function edit()
    {
        $user = Auth::user();
        
        // プロフィールが完成済みの場合はダッシュボードにリダイレクト
        if ($user->hasCompletedProfile()) {
            return redirect()->route('dashboard');
        }
        
        return view('profile.edit');
    }
}
