<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Reading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\WebhookController;

class StripeWebhookController extends Controller
{
    /**
     * Handle Stripe webhook
     */
    public function handle(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        $event = $payload['type'] ?? null;

        // 冪等性のため、処理済みのイベントはスキップ
        $eventId = $payload['id'] ?? null;
        if ($eventId && $this->isEventProcessed($eventId)) {
            return response('Event already processed', 200);
        }

        try {
            switch ($event) {
                case 'checkout.session.completed':
                    $this->handleCheckoutSessionCompleted($payload['data']['object']);
                    break;
                case 'payment_intent.succeeded':
                    $this->handlePaymentIntentSucceeded($payload['data']['object']);
                    break;
            }

            // イベント処理完了を記録
            if ($eventId) {
                $this->markEventAsProcessed($eventId);
            }

            // Cashierのデフォルト処理も実行
            $cashierController = new WebhookController();
            $cashierController->handleWebhook($request);

        } catch (\Exception $e) {
            Log::error('Stripe webhook error: ' . $e->getMessage(), [
                'event' => $event,
                'payload' => $payload
            ]);
            
            return response('Webhook error', 500);
        }

        return response('OK', 200);
    }

    private function handleCheckoutSessionCompleted($session)
    {
        $sessionId = $session['id'];
        $order = Order::where('stripe_session_id', $sessionId)->first();

        if (!$order || $order->status === 'paid') {
            return; // 既に処理済み
        }

        DB::beginTransaction();
        try {
            // 注文をpaidに更新
            $order->update([
                'status' => 'paid',
                'stripe_payment_intent' => $session['payment_intent'],
            ]);

            // 鑑定注文の場合
            if ($order->type === 'reading') {
                $orderItem = $order->orderItems()->first();
                $meta = $orderItem->meta_json;
                
                // 鑑定レコードが存在しない場合は作成
                $existingReading = Reading::where('user_id', $order->user_id)
                    ->where('product_id', $orderItem->product_id)
                    ->where('status', 'pending_generation')
                    ->first();

                if (!$existingReading) {
                    Reading::create([
                        'user_id' => $order->user_id,
                        'person_id' => $meta['person_id'] ?? null,
                        'product_id' => $orderItem->product_id,
                        'status' => 'pending_generation',
                        'title' => $orderItem->product->name,
                        'notes' => $meta['notes'] ?? null,
                    ]);
                }
            }

            // 物販注文の場合
            if ($order->type === 'merch') {
                // 在庫を減算
                foreach ($order->orderItems as $item) {
                    $product = $item->product;
                    if ($product->stock !== null) {
                        $product->decrement('stock', $item->quantity);
                    }
                }
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function handlePaymentIntentSucceeded($paymentIntent)
    {
        // 必要に応じて追加の処理
        Log::info('Payment intent succeeded', ['payment_intent' => $paymentIntent['id']]);
    }

    private function isEventProcessed($eventId): bool
    {
        return cache()->has("stripe_event_processed_{$eventId}");
    }

    private function markEventAsProcessed($eventId): void
    {
        cache()->put("stripe_event_processed_{$eventId}", true, now()->addHours(24));
    }
}
