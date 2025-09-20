<x-layouts.app>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <!-- ヘッダー -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">個別鑑定</h1>
                <p class="text-lg text-gray-600">
                    あなただけの特別な鑑定をご提供いたします
                </p>
            </div>

            <!-- 鑑定商品一覧 -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($readingProducts as $product)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <!-- 商品画像エリア（プレースホルダー） -->
                        <div class="h-48 bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
                            <div class="text-6xl opacity-30">
                                @if(str_contains($product->name, '四柱'))
                                    🔮
                                @elseif(str_contains($product->name, '紫微'))
                                    ⭐
                                @elseif(str_contains($product->name, '西洋'))
                                    🌟
                                @elseif(str_contains($product->name, '数秘'))
                                    🔢
                                @else
                                    ✨
                                @endif
                            </div>
                        </div>

                        <!-- 商品情報 -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ $product->metadata['description'] ?? '' }}</p>
                            
                            <!-- 特徴 -->
                            @if(isset($product->metadata['features']))
                                <div class="mb-4">
                                    <h4 class="font-semibold text-gray-700 mb-2">含まれる内容</h4>
                                    <ul class="space-y-1">
                                        @foreach($product->metadata['features'] as $feature)
                                            <li class="text-sm text-gray-600 flex items-center">
                                                <span class="w-2 h-2 bg-purple-400 rounded-full mr-2"></span>
                                                {{ $feature }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- 所要時間 -->
                            @if(isset($product->metadata['duration']))
                                <div class="mb-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        ⏱️ {{ $product->metadata['duration'] }}
                                    </span>
                                </div>
                            @endif

                            <!-- 価格 -->
                            <div class="mb-6">
                                <span class="text-3xl font-bold text-purple-600">{{ $product->formatted_price }}</span>
                            </div>

                            <!-- 申し込みフォーム -->
                            <form method="POST" action="{{ route('reading.checkout') }}" class="space-y-4">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <!-- 鑑定対象選択 -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        鑑定対象
                                    </label>
                                    <select name="person_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        <option value="">あなた（本人）</option>
                                        <!-- 将来的に他者プロフィール選択機能を追加 -->
                                    </select>
                                    @error('person_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- 質問・要望 -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        ご質問・ご要望（任意）
                                    </label>
                                    <textarea 
                                        name="notes" 
                                        rows="3" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
                                        placeholder="気になることや知りたいことをお聞かせください"
                                        maxlength="1000"
                                    >{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- 申し込みボタン -->
                                <button type="submit" class="w-full bg-purple-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                                    この内容で申し込む
                                </button>
                            </form>

                            <!-- 注意事項 -->
                            <div class="mt-4 p-3 bg-yellow-50 rounded-lg">
                                <p class="text-sm text-yellow-800">
                                    <span class="font-semibold">ご注意：</span>
                                    お支払い後、自動で鑑定生成を開始いたします。
                                    鑑定結果はマイページでご確認いただけます。
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
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
