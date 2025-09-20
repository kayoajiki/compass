<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Reading;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Cashier;

class ReadingController extends Controller
{
    public function index()
    {
        $readingProducts = Product::active()
            ->byType('service')
            ->get();

        return view('reading-shop.index', compact('readingProducts'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'person_id' => 'nullable|exists:profiles,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // 本人のプロフィールを取得（person_idがnullの場合）
        $personId = $request->person_id ?? auth()->user()->profile?->id;
        
        if (!$personId) {
            return back()->withErrors(['person_id' => '鑑定対象のプロフィールが設定されていません。']);
        }

        try {
            DB::beginTransaction();

            // 注文を作成
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_cents' => $product->price_cents,
                'currency' => $product->currency,
                'status' => 'pending',
                'type' => 'reading',
            ]);

            // 注文アイテムを作成
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'unit_price_cents' => $product->price_cents,
                'subtotal_cents' => $product->price_cents,
                'meta_json' => [
                    'person_id' => $personId,
                    'notes' => $request->notes,
                ],
            ]);

            // Stripe Checkout Sessionを作成
            $checkoutSession = auth()->user()->checkoutCharge(
                $product->price_cents,
                $product->name,
                1,
                [
                    'success_url' => route('reading.thanks') . '?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('reading.canceled'),
                    'metadata' => [
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'person_id' => $personId,
                    ],
                ]
            );

            // 注文にStripe Session IDを保存
            $order->update(['stripe_session_id' => $checkoutSession->id]);

            DB::commit();

            return redirect($checkoutSession->url);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Reading checkout error: ' . $e->getMessage());
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

                    // 鑑定レコードを作成
                    $orderItem = $order->orderItems()->first();
                    $meta = $orderItem->meta_json;
                    
                    $reading = Reading::create([
                        'user_id' => $order->user_id,
                        'person_id' => $meta['person_id'] ?? null,
                        'product_id' => $orderItem->product_id,
                        'status' => 'pending_generation',
                        'title' => $orderItem->product->name,
                        'notes' => $meta['notes'] ?? null,
                    ]);

                    // モックジョブをディスパッチ（実際のDify連携は後で実装）
                    $this->generateMockReading($reading->id);

                    DB::commit();

                    return view('reading-shop.thanks', compact('reading'));
                }
            }

            return redirect()->route('dashboard')->withErrors(['error' => '支払いが完了していません。']);

        } catch (\Exception $e) {
            Log::error('Reading thanks error: ' . $e->getMessage());
            return redirect()->route('dashboard')->withErrors(['error' => '処理中にエラーが発生しました。']);
        }
    }

    public function canceled()
    {
        return view('reading-shop.canceled');
    }

    private function generateMockReading($readingId)
    {
        // モック鑑定生成（実際のDify連携は後で実装）
        $reading = Reading::find($readingId);
        
        if ($reading) {
            $reading->update([
                'status' => 'generating',
            ]);

            // 模擬的な鑑定結果を生成
            $mockResult = [
                'summary' => 'あなたの運命は非常に興味深い流れを持っています。',
                'sections' => [
                    [
                        'heading' => '性格分析',
                        'content' => 'あなたは直感力に優れた人です。'
                    ],
                    [
                        'heading' => '運勢予測',
                        'content' => '来月は大きな変化の時期となります。'
                    ],
                    [
                        'heading' => '開運アドバイス',
                        'content' => '東の方角を意識して行動すると良いでしょう。'
                    ]
                ]
            ];

            $reading->update([
                'status' => 'ready',
                'summary' => $mockResult['summary'],
                'json_result' => json_encode($mockResult),
            ]);
        }
    }
}
