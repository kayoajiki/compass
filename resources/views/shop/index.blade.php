<x-layouts.app>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <!-- ヘッダー -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">開運アイテムショップ</h1>
                <p class="text-lg text-gray-600">
                    あなたの運勢をサポートする特別なアイテムをご用意しました
                </p>
            </div>

            <!-- 商品一覧 -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($merchProducts as $product)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <!-- 商品画像エリア -->
                        @if($product->image_url)
                            <div class="h-48 bg-gray-100">
                                <img src="{{ $product->image_url }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="h-48 bg-gradient-to-br from-pink-100 to-purple-100 flex items-center justify-center">
                                <div class="text-6xl opacity-30">
                                    @if(str_contains($product->name, 'クリスタル'))
                                        💎
                                    @elseif(str_contains($product->name, 'ローズ'))
                                        🌹
                                    @elseif(str_contains($product->name, 'アメジスト'))
                                        🔮
                                    @elseif(str_contains($product->name, 'お守り'))
                                        🛡️
                                    @else
                                        ✨
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- 商品情報 -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ $product->metadata['description'] ?? '' }}</p>
                            
                            <!-- 商品詳細 -->
                            @if(isset($product->metadata['size']) || isset($product->metadata['material']))
                                <div class="mb-4">
                                    <div class="space-y-1 text-sm text-gray-600">
                                        @if(isset($product->metadata['size']))
                                            <p><span class="font-medium">サイズ：</span>{{ $product->metadata['size'] }}</p>
                                        @endif
                                        @if(isset($product->metadata['material']))
                                            <p><span class="font-medium">素材：</span>{{ $product->metadata['material'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- 効果・効能 -->
                            @if(isset($product->metadata['benefits']))
                                <div class="mb-4">
                                    <h4 class="font-semibold text-gray-700 mb-2">効果・効能</h4>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($product->metadata['benefits'] as $benefit)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $benefit }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- 在庫情報 -->
                            <div class="mb-4">
                                @if($product->stock > 10)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        ✅ 在庫あり
                                    </span>
                                @elseif($product->stock > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        ⚠️ 残り{{ $product->stock }}個
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        ❌ 在庫切れ
                                    </span>
                                @endif
                            </div>

                            <!-- 価格 -->
                            <div class="mb-6">
                                <span class="text-3xl font-bold text-purple-600">{{ $product->formatted_price }}</span>
                            </div>

                            <!-- 購入フォーム -->
                            @if($product->stock > 0)
                                <form method="POST" action="{{ route('shop.checkout') }}" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    <!-- 数量選択 -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            数量
                                        </label>
                                        <select name="quantity" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                            @for($i = 1; $i <= min(5, $product->stock); $i++)
                                                <option value="{{ $i }}">{{ $i }}個</option>
                                            @endfor
                                        </select>
                                        @error('quantity')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- 購入ボタン -->
                                    <button type="submit" class="w-full bg-purple-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                                        購入へ進む
                                    </button>
                                </form>
                            @else
                                <div class="w-full bg-gray-100 text-gray-500 py-3 px-4 rounded-lg font-semibold text-center">
                                    在庫切れ
                                </div>
                            @endif

                            <!-- 配送情報 -->
                            <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                                <p class="text-sm text-blue-800">
                                    <span class="font-semibold">配送：</span>
                                    全国送料無料（通常2-3営業日でお届け）
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- 配送・返品ポリシー -->
            <div class="mt-12 bg-gray-50 rounded-2xl p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">配送・返品について</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">配送について</h3>
                        <ul class="space-y-1 text-sm text-gray-600">
                            <li>• 全国送料無料</li>
                            <li>• 通常2-3営業日で配送</li>
                            <li>• 配送状況はメールでお知らせ</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">返品について</h3>
                        <ul class="space-y-1 text-sm text-gray-600">
                            <li>• 商品到着から7日以内</li>
                            <li>• 未使用・未開封の場合のみ</li>
                            <li>• 返品理由をお聞かせください</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- 戻るボタン -->
            <div class="text-center mt-8">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    ← ダッシュボードに戻る
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
