<div class="reading-slider-container">
    <!-- ヘッダー -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                <span class="text-white text-xl">🔮</span>
            </div>
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900">個別鑑定</h2>
                <p class="text-sm text-gray-600">あなただけの特別な鑑定をご提供</p>
            </div>
        </div>
        <a href="{{ route('reading-shop') }}" 
           class="bg-purple-500 text-white px-6 py-3 rounded-xl font-semibold text-base hover:bg-purple-600 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 border border-purple-400/30 hover:border-purple-300/50">
            🔮 すべて見る →
        </a>
    </div>


    @if(count($products) > 0)
        <!-- スライドショー -->
        <div class="relative bg-white rounded-2xl shadow-lg overflow-hidden" 
             x-data="{ 
                currentIndex: 0,
                autoPlay: true,
                interval: 6000,
                init() {
                    if (this.autoPlay && {{ count($products) }} > 1) {
                        this.startAutoPlay();
                    }
                },
                startAutoPlay() {
                    setInterval(() => {
                        if (this.autoPlay && {{ count($products) }} > 1) {
                            this.next();
                        }
                    }, this.interval);
                },
                next() {
                    if ({{ count($products) }} > 1) {
                        this.currentIndex = (this.currentIndex + 1) % {{ count($products) }};
                        $wire.goToSlide(this.currentIndex);
                    }
                },
                previous() {
                    if ({{ count($products) }} > 1) {
                        this.currentIndex = this.currentIndex === 0 ? {{ count($products) - 1 }} : this.currentIndex - 1;
                        $wire.goToSlide(this.currentIndex);
                    }
                }
             }"
             x-init="init()">
            <!-- メインスライド -->
            <div class="relative h-72 sm:h-96 lg:h-[28rem]">
                @foreach($products as $index => $product)
                    @if(isset($product['name']))
                    <div x-show="currentIndex === {{ $index }}" 
                         class="absolute inset-0 flex flex-col sm:flex-row items-center p-4 sm:p-6 lg:p-8">
                        
                        <!-- 鑑定画像エリア -->
                        <div class="w-full sm:w-1/2 lg:w-2/5 mb-6 sm:mb-0">
                            @if(isset($product['image_url']) && $product['image_url'])
                                <div class="w-full h-48 sm:h-64 lg:h-80 bg-gray-100 rounded-2xl shadow-xl overflow-hidden">
                                    <img src="{{ $product['image_url'] }}" 
                                         alt="{{ $product['name'] }}"
                                         class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-full h-48 sm:h-64 lg:h-80 bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 rounded-2xl shadow-xl flex items-center justify-center">
                                    <div class="text-8xl opacity-40">
                                        @if(str_contains($product['name'], '四柱'))
                                            🔮
                                        @elseif(str_contains($product['name'], '紫微'))
                                            ⭐
                                        @elseif(str_contains($product['name'], '西洋'))
                                            🌟
                                        @elseif(str_contains($product['name'], '数秘'))
                                            🔢
                                        @else
                                            ✨
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <!-- 鑑定情報 -->
                        <div class="w-full sm:w-1/2 lg:w-3/5 sm:pl-6 lg:pl-8">
                            <div class="h-full flex flex-col justify-between">
                                <div>
                                    <!-- 鑑定名 -->
                                    <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 mb-3">
                                        {{ $product['name'] }}
                                    </h3>
                                    
                                    <!-- 説明 -->
                                    <p class="text-gray-700 text-sm sm:text-base mb-4">
                                        {{ $product['metadata']['description'] ?? '' }}
                                    </p>
                                    
                                    <!-- 所要時間 -->
                                    @if(isset($product['metadata']['duration']))
                                        <div class="mb-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                ⏱️ {{ $product['metadata']['duration'] }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    <!-- 価格 -->
                                    <div class="text-2xl font-bold text-blue-600 mb-4">
                                        ¥{{ number_format($product['price_cents'] / 100) }}
                                    </div>
                                </div>
                                
                                <!-- CTA -->
                                <div class="pt-4">
                                    <a href="{{ route('reading-shop') }}" 
                                       class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-3 rounded-xl font-bold hover:from-blue-600 hover:to-purple-700 transition-all duration-300 text-sm shadow-lg">
                                        🔮 申し込む
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>

            <!-- ナビゲーションボタン -->
            @if(count($products) > 1)
                <!-- 前へボタン -->
                <button @click="previous()" 
                        class="absolute left-2 sm:left-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 shadow-lg transition-all">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                <!-- 次へボタン -->
                <button @click="next()" 
                        class="absolute right-2 sm:right-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 shadow-lg transition-all">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- インジケーター -->
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                    @foreach($products as $index => $product)
                        <button @click="currentIndex = {{ $index }}"
                                :class="currentIndex === {{ $index }} ? 'bg-purple-600' : 'bg-white/60'"
                                class="w-2 h-2 rounded-full transition-all">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    @else
        <!-- 商品がない場合 -->
        <div class="bg-gray-50 rounded-2xl p-8 text-center">
            <div class="text-gray-400 text-4xl mb-4">🔮</div>
            <p class="text-gray-600">現在、鑑定サービスの準備中です</p>
        </div>
    @endif
</div>