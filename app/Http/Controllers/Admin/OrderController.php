<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'orderItems.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled,refunded',
            'shipping_address' => 'nullable|string',
            'tracking_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $data = $request->only(['status', 'shipping_address', 'tracking_number', 'notes']);
        
        // ステータスが変更された場合の処理
        if ($order->status !== $data['status']) {
            $this->handleStatusChange($order, $data['status']);
        }

        $order->update($data);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', '注文情報が正常に更新されました。');
    }

    public function destroy(Order $order)
    {
        // キャンセル済みまたは返金済みの注文のみ削除可能
        if (!in_array($order->status, ['cancelled', 'refunded'])) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'この注文は削除できません。まずキャンセルまたは返金処理を行ってください。');
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', '注文が正常に削除されました。');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled,refunded',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        $this->handleStatusChange($order, $newStatus);
        
        $order->update(['status' => $newStatus]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', "注文ステータスを「{$this->getStatusLabel($oldStatus)}」から「{$this->getStatusLabel($newStatus)}」に変更しました。");
    }

    private function handleStatusChange(Order $order, string $newStatus)
    {
        // ステータス変更時の特別な処理
        switch ($newStatus) {
            case 'processing':
                // 処理開始時の処理（在庫確保など）
                $this->reserveInventory($order);
                break;
            case 'shipped':
                // 発送時の処理（配送業者への通知など）
                $this->notifyShipping($order);
                break;
            case 'delivered':
                // 配送完了時の処理
                $this->handleDelivery($order);
                break;
            case 'cancelled':
                // キャンセル時の処理（在庫戻しなど）
                $this->handleCancellation($order);
                break;
            case 'refunded':
                // 返金時の処理
                $this->handleRefund($order);
                break;
        }
    }

    private function reserveInventory(Order $order)
    {
        // 在庫確保処理
        foreach ($order->orderItems as $item) {
            if ($item->product->type === 'physical' && $item->product->stock !== null) {
                $item->product->decrement('stock', $item->quantity);
            }
        }
    }

    private function notifyShipping(Order $order)
    {
        // 配送業者への通知処理（実装例）
        // 実際の実装では、配送業者のAPIを呼び出したり、メール通知を送信したりします
    }

    private function handleDelivery(Order $order)
    {
        // 配送完了時の処理
        // 顧客への配送完了通知など
    }

    private function handleCancellation(Order $order)
    {
        // キャンセル時の在庫戻し処理
        foreach ($order->orderItems as $item) {
            if ($item->product->type === 'physical' && $item->product->stock !== null) {
                $item->product->increment('stock', $item->quantity);
            }
        }
    }

    private function handleRefund(Order $order)
    {
        // Stripe返金処理
        if ($order->stripe_payment_intent_id) {
            // 実際の実装では、Stripe APIを使用して返金処理を行います
            // Stripe::refunds()->create([
            //     'payment_intent' => $order->stripe_payment_intent_id,
            //     'amount' => $order->total_cents,
            // ]);
        }
    }

    private function getStatusLabel(string $status): string
    {
        $labels = [
            'pending' => '待機中',
            'processing' => '処理中',
            'shipped' => '発送済み',
            'delivered' => '配送完了',
            'cancelled' => 'キャンセル',
            'refunded' => '返金済み',
        ];

        return $labels[$status] ?? $status;
    }

    public function getStatusOptions(): array
    {
        return [
            'pending' => '待機中',
            'processing' => '処理中',
            'shipped' => '発送済み',
            'delivered' => '配送完了',
            'cancelled' => 'キャンセル',
            'refunded' => '返金済み',
        ];
    }
}
