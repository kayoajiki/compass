<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Exceptions\IncompletePayment;

class SubscriptionController extends Controller
{
    /**
     * 料金プランページを表示
     */
    public function plans()
    {
        $plans = config('fortune.plans');
        $freeFeatures = config('fortune.free_features');
        $subscriptionFeatures = config('fortune.subscription_features');

        return view('subscription.plans', compact('plans', 'freeFeatures', 'subscriptionFeatures'));
    }

    /**
     * Stripe Checkout セッションを作成
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:monthly,yearly'
        ]);

        $user = Auth::user();
        $plan = config("fortune.plans.{$request->plan}");

        if (!$plan || !$plan['stripe_price_id']) {
            return redirect()->back()->withErrors(['plan' => '選択されたプランが見つかりません。']);
        }

        try {
            // Stripe Checkout セッションを作成
            $checkout = $user->newSubscription('default', $plan['stripe_price_id'])
                ->checkout([
                    'success_url' => route('dashboard') . '?subscription=success',
                    'cancel_url' => route('pricing'),
                    'metadata' => [
                        'plan_type' => $request->plan,
                        'user_id' => $user->id,
                    ],
                ]);

            return redirect($checkout->url);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['checkout' => '決済の開始に失敗しました。もう一度お試しください。']);
        }
    }

    /**
     * サブスクリプションをキャンセル
     */
    public function cancel(Request $request)
    {
        $user = Auth::user();

        if (!$user->hasActiveSubscription()) {
            return redirect()->back()->withErrors(['subscription' => 'アクティブなサブスクリプションが見つかりません。']);
        }

        try {
            $user->subscription('default')->cancel();
            
            return redirect()->back()->with('success', 'サブスクリプションをキャンセルしました。現在の期間が終了するまでサービスをご利用いただけます。');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['cancel' => 'キャンセルの処理に失敗しました。サポートまでお問い合わせください。']);
        }
    }

    /**
     * サブスクリプションを再開
     */
    public function resume(Request $request)
    {
        $user = Auth::user();

        if (!$user->subscription('default')->onGracePeriod()) {
            return redirect()->back()->withErrors(['subscription' => '再開可能なサブスクリプションが見つかりません。']);
        }

        try {
            $user->subscription('default')->resume();
            
            return redirect()->back()->with('success', 'サブスクリプションを再開しました。');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['resume' => '再開の処理に失敗しました。サポートまでお問い合わせください。']);
        }
    }

    /**
     * Stripe Customer Portal にリダイレクト
     */
    public function portal(Request $request)
    {
        $user = Auth::user();

        if (!$user->hasStripeId()) {
            return redirect()->back()->withErrors(['portal' => 'カスタマーポータルにアクセスできません。']);
        }

        try {
            $portal = $user->createSetupIntent();
            $portal = $user->billingPortalSession(route('dashboard'));
            
            return redirect($portal->url);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['portal' => 'カスタマーポータルへのアクセスに失敗しました。']);
        }
    }

    /**
     * サブスクリプションの状態を取得（API用）
     */
    public function status(Request $request)
    {
        $user = Auth::user();

        return response()->json([
            'has_subscription' => $user->hasActiveSubscription(),
            'subscription_type' => $user->getSubscriptionType(),
            'subscription_display_name' => $user->getSubscriptionDisplayName(),
            'on_grace_period' => $user->subscription('default')?->onGracePeriod() ?? false,
            'ends_at' => $user->subscription('default')?->ends_at,
        ]);
    }
}
