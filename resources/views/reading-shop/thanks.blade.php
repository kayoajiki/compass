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
                    鑑定の準備を開始いたしました
                </p>
            </div>

            <!-- 鑑定情報 -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">注文詳細</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">鑑定内容</span>
                        <span class="font-semibold text-gray-900">{{ $reading->title }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">ステータス</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($reading->status === 'pending_generation') bg-yellow-100 text-yellow-800
                            @elseif($reading->status === 'generating') bg-blue-100 text-blue-800
                            @elseif($reading->status === 'ready') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            @switch($reading->status)
                                @case('pending_generation')
                                    準備中
                                    @break
                                @case('generating')
                                    生成中
                                    @break
                                @case('ready')
                                    完了
                                    @break
                                @default
                                    エラー
                                    @break
                            @endswitch
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">注文日時</span>
                        <span class="text-gray-900">{{ $reading->created_at->format('Y年n月j日 H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- 次のステップ -->
            <div class="bg-blue-50 rounded-2xl p-6 mb-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">次のステップ</h3>
                <div class="space-y-2 text-blue-800">
                    <p>1. 鑑定生成が完了するまでお待ちください（通常1-2時間程度）</p>
                    <p>2. 完了後、ダッシュボードで鑑定結果をご確認いただけます</p>
                    <p>3. 結果が準備できましたらメールでお知らせいたします</p>
                </div>
            </div>

            <!-- アクションボタン -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('dashboard') }}" class="flex-1 bg-purple-600 text-white py-3 px-6 rounded-lg font-semibold text-center hover:bg-purple-700 transition-colors">
                    ダッシュボードに戻る
                </a>
                <a href="{{ route('reading-shop') }}" class="flex-1 border border-gray-300 text-gray-700 py-3 px-6 rounded-lg font-semibold text-center hover:bg-gray-50 transition-colors">
                    他の鑑定を申し込む
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
