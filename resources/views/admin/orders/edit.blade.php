@extends('admin.layout')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">注文編集</h3>
                <p class="mt-1 text-sm text-gray-600">注文 #{{ $order->id }} の情報を編集してください。</p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
            <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="shadow sm:overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="status" class="block text-sm font-medium text-gray-700">ステータス *</label>
                                <select name="status" id="status" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach([
                                        'pending' => '待機中',
                                        'processing' => '処理中',
                                        'shipped' => '発送済み',
                                        'delivered' => '配送完了',
                                        'cancelled' => 'キャンセル',
                                        'refunded' => '返金済み',
                                    ] as $value => $label)
                                        <option value="{{ $value }}" {{ old('status', $order->status) == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="tracking_number" class="block text-sm font-medium text-gray-700">追跡番号</label>
                                <input type="text" name="tracking_number" id="tracking_number"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       value="{{ old('tracking_number', $order->tracking_number) }}"
                                       placeholder="配送業者の追跡番号">
                                @error('tracking_number')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6">
                                <label for="shipping_address" class="block text-sm font-medium text-gray-700">配送先住所</label>
                                <textarea name="shipping_address" id="shipping_address" rows="4"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                          placeholder="配送先の住所を入力してください">{{ old('shipping_address', $order->shipping_address) }}</textarea>
                                @error('shipping_address')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6">
                                <label for="notes" class="block text-sm font-medium text-gray-700">メモ・備考</label>
                                <textarea name="notes" id="notes" rows="3"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                          placeholder="注文に関するメモや備考を入力してください">{{ old('notes', $order->notes) }}</textarea>
                                @error('notes')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <a href="{{ route('admin.orders.show', $order) }}" 
                           class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            キャンセル
                        </a>
                        <button type="submit" 
                                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            注文情報を更新
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ステータス変更フォーム -->
    <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">クイックステータス変更</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">ステータスを素早く変更できます。</p>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="flex flex-wrap gap-2">
                    @foreach([
                        'pending' => '待機中',
                        'processing' => '処理中',
                        'shipped' => '発送済み',
                        'delivered' => '配送完了',
                        'cancelled' => 'キャンセル',
                        'refunded' => '返金済み',
                    ] as $value => $label)
                        <button type="submit" name="status" value="{{ $value }}"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                                {{ $order->status === $value ? 'ring-2 ring-indigo-500 bg-indigo-50' : '' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </form>
        </div>
    </div>

    <!-- 注文統計情報 -->
    <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">注文統計</h3>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">注文日時</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $order->created_at->format('Y年m月d日 H:i') }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">最終更新</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $order->updated_at->format('Y年m月d日 H:i') }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">商品数</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $order->orderItems->count() }}点</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">合計金額</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 text-lg font-semibold">¥{{ number_format($order->total_cents / 100) }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Stripe決済情報 -->
    @if($order->stripe_payment_intent_id)
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <span class="text-blue-400">💳</span>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Stripe決済情報</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p><strong>Payment Intent ID:</strong> {{ $order->stripe_payment_intent_id }}</p>
                    <p class="mt-1">この注文はStripeで決済されています。返金処理が必要な場合は、Stripeダッシュボードから実行してください。</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
