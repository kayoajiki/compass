<x-layouts.app>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- 成功メッセージ -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">ご購入ありがとうございました！</h1>
                <p class="text-lg text-gray-600">
                    注文を受け付けました
                </p>
            </div>

            <!-- 注文詳細 -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">注文詳細</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">注文番号</span>
                        <span class="font-semibold text-gray-900">#{{ $order->id }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">ステータス</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($order->status === 'paid') bg-green-100 text-green-800
                            @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800
                            @endif">
                            @switch($order->status)
                                @case('paid')
                                    支払い完了
                                    @break
                                @case('pending')
                                    処理中
                                    @break
                                @default
                                    エラー
                                    @break
                            @endswitch
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">注文日時</span>
                        <span class="text-gray-900">{{ $order->created_at->format('Y年n月j日 H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- 注文商品 -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">注文商品</h3>
                
                @foreach($order->orderItems as $item)
                    <div class="flex items-center space-x-4 py-3 border-b border-gray-100 last:border-b-0">
                        <!-- 商品アイコン -->
                        <div class="w-12 h-12 bg-gradient-to-br from-pink-100 to-purple-100 rounded-lg flex items-center justify-center">
                            <span class="text-xl opacity-60">
                                @if(str_contains($item->product->name, 'クリスタル'))
                                    💎
                                @elseif(str_contains($item->product->name, 'ローズ'))
                                    🌹
                                @elseif(str_contains($item->product->name, 'アメジスト'))
                                    🔮
                                @elseif(str_contains($item->product->name, 'お守り'))
                                    🛡️
                                @else
                                    ✨
                                @endif
                            </span>
                        </div>
                        
                        <!-- 商品情報 -->
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">{{ $item->product->name }}</h4>
                            <p class="text-sm text-gray-600">数量: {{ $item->quantity }}個</p>
                        </div>
                        
                        <!-- 価格 -->
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">{{ $item->formatted_subtotal }}</p>
                        </div>
                    </div>
                @endforeach
                
                <!-- 合計金額 -->
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-900">合計金額</span>
                        <span class="text-xl font-bold text-purple-600">{{ $order->formatted_total }}</span>
                    </div>
                </div>
            </div>

            <!-- 配送情報 -->
            <div class="bg-blue-50 rounded-2xl p-6 mb-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">配送について</h3>
                <div class="space-y-2 text-blue-800">
                    <p>• 商品は2-3営業日以内に発送いたします</p>
                    <p>• 配送状況はメールでお知らせいたします</p>
                    <p>• 全国送料無料でお届けいたします</p>
                </div>
            </div>

            <!-- アクションボタン -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('dashboard') }}" class="flex-1 bg-purple-600 text-white py-3 px-6 rounded-lg font-semibold text-center hover:bg-purple-700 transition-colors">
                    ダッシュボードに戻る
                </a>
                <a href="{{ route('shop') }}" class="flex-1 border border-gray-300 text-gray-700 py-3 px-6 rounded-lg font-semibold text-center hover:bg-gray-50 transition-colors">
                    他の商品を見る
                </a>
            </div>

            <!-- サポート情報 -->
            <div class="text-center mt-8">
                <p class="text-sm text-gray-500">
                    ご質問がございましたら、
                    <a href="mailto:support@example.com" class="text-purple-600 hover:text-purple-700">
                        サポートまでお問い合わせください
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-layouts.app>
