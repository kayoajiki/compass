<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 認証されていない場合はログインページへ
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // アクティブなサブスクリプションを持っていない場合は価格ページへ
        if (!$user->hasActiveSubscription()) {
            return redirect()->route('pricing')
                ->with('message', 'この機能をご利用いただくには、サブスクリプションが必要です。');
        }

        return $next($request);
    }
}
