<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Cashier;

class ShopController extends Controller
{
    public function index()
    {
        $merchProducts = Product::active()
            ->byType('physical')
            ->where('stock', '>', 0)
            ->get();

        return view('shop.index', compact('merchProducts'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // 在庫チェック
        if (!$product->isInStock() || $product->stock < $request->quantity) {
            return back()->withErrors(['stock' => '在庫が不足しています。']);
        }

        try {
            DB::beginTransaction();

            $quantity = $request->quantity;
            $subtotal = $product->price_cents * $quantity;

            // 注文を作成
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_cents' => $subtotal,
                'currency' => $product->currency,
                'status' => 'pending',
                'type' => 'merch',
            ]);

            // 注文アイテムを作成
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price_cents' => $product->price_cents,
                'subtotal_cents' => $subtotal,
            ]);

            // Stripe Checkout Sessionを作成
            $checkoutSession = auth()->user()->checkoutCharge(
                $subtotal,
                $product->name . " x{$quantity}",
                $quantity,
                [
                    'success_url' => route('shop.thanks') . '?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('shop.canceled'),
                    'metadata' => [
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                    ],
                ]
            );

            // 注文にStripe Session IDを保存
            $order->update(['stripe_session_id' => $checkoutSession->id]);

            DB::commit();

            return redirect($checkoutSession->url);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Shop checkout error: ' . $e->getMessage());
            return back()->withErrors(['error' => '注文処理中にエラーが発生しました。']);
        }
    }

    public function thanks(Request $request)
    {
        $sessionId = $request->get('session_id');
        
        if (!$sessionId) {
            return redirect()->route('dashboard')->withErrors(['error' => 'セッションIDが見つかりません。']);
        }

        try {
            // Stripe Sessionを取得
            $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId);
            
            if ($session->payment_status === 'paid') {
                $order = Order::where('stripe_session_id', $sessionId)->first();
                
                if ($order && $order->status === 'pending') {
                    DB::beginTransaction();

                    // 注文をpaidに更新
                    $order->update([
                        'status' => 'paid',
                        'stripe_payment_intent' => $session->payment_intent,
                    ]);

                    // 在庫を減算
                    foreach ($order->orderItems as $item) {
                        $product = $item->product;
                        if ($product->stock !== null) {
                            $product->decrement('stock', $item->quantity);
                        }
                    }

                    DB::commit();

                    return view('shop.thanks', compact('order'));
                }
            }

            return redirect()->route('dashboard')->withErrors(['error' => '支払いが完了していません。']);

        } catch (\Exception $e) {
            Log::error('Shop thanks error: ' . $e->getMessage());
            return redirect()->route('dashboard')->withErrors(['error' => '処理中にエラーが発生しました。']);
        }
    }

    public function canceled()
    {
        return view('shop.canceled');
    }
}
