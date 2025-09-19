<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Google認証のリダイレクト
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Google認証のコールバック
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // 既存ユーザーを検索
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if ($user) {
                // 既存ユーザーの場合、ログイン
                Auth::login($user);
            } else {
                // 新規ユーザーの場合、作成してログイン
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'email_verified_at' => now(), // Google認証済みなので即座に検証済み
                ]);
                
                Auth::login($user);
            }
            
            // プロフィール完成状況に応じてリダイレクト
            if ($user->hasCompletedProfile()) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('profile.edit')
                    ->with('message', '出生情報を入力して、占いを始めましょう！');
            }
            
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google認証に失敗しました。');
        }
    }
}
