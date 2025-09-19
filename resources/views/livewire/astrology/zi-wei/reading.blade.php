<div class="min-h-screen bg-gray-50 dark:bg-zinc-900">
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back to Dashboard Button -->
            <div class="mb-6">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    ダッシュボードに戻る
                </a>
            </div>

            <div class="space-y-6">
                @if($isLoading)
                    <!-- Loading state -->
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                        <div class="flex items-center justify-center py-12">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600"></div>
                            <span class="ml-3 text-gray-600 dark:text-gray-300">詳細鑑定を生成中...</span>
                        </div>
                    </div>
                @else
                    <!-- Person Switcher -->
                    <x-person-switcher :selectedPersonId="$selectedPersonId" />

                    <!-- Header -->
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                        <div class="text-center">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $readingData['title'] ?? '紫微斗数 詳細鑑定' }}</h1>
                            <p class="text-gray-600 dark:text-gray-300">紫微星を中心とした運命分析</p>
                        </div>
                    </div>

                    <!-- 命盤表示 -->
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                        <h2 class="text-xl font-bold mb-4 text-center">命盤</h2>
                        @if(!empty($chartData))
                            <!-- Main Star Info -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 text-center">主星情報</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="text-center p-6 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">命宮</h4>
                                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $chartData['ming_gong'] ?? '命宮' }}</div>
                                    </div>
                                    <div class="text-center p-6 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">主星</h4>
                                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $chartData['main_star'] ?? '破軍' }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- 12 Palaces Grid -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 text-center">十二宮盤</h3>
                                <div class="grid grid-cols-3 md:grid-cols-4 gap-3 max-w-4xl mx-auto">
                                    @foreach($chartData['palaces'] as $index => $palace)
                                        <div class="aspect-square p-3 bg-gray-50 dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-zinc-700 text-center" 
                                             role="gridcell" 
                                             aria-label="{{ $palace['name'] }}{{ $palace['star'] ? ' - ' . $palace['star'] : '' }}">
                                            <div class="text-xs font-medium text-gray-900 dark:text-white mb-1">{{ $palace['name'] }}</div>
                                            @if(isset($palace['star']))
                                                <div class="text-sm font-bold text-purple-600 dark:text-purple-400">{{ $palace['star'] }}</div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- サマリー -->
                    @if(isset($readingData['summary']))
                        <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                            <h2 class="text-xl font-bold mb-4 text-center">{{ $readingData['title'] ?? '鑑定サマリー' }}</h2>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-center">{{ $readingData['summary'] }}</p>
                        </div>
                    @endif

                    <!-- 詳細部分 -->
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                        @if($isSubscriber)
                            {{-- サブスク会員：通常表示 --}}
                            <!-- Reading Sections -->
                            @if(isset($readingData['sections']))
                                <div class="space-y-6 mb-8">
                                    @foreach($readingData['sections'] as $section)
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                                {{ $section['heading'] }}
                                            </h3>
                                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                                {{ $section['body'] }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Scores -->
                            @if(isset($readingData['scores']))
                                <div class="mb-8">
                                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">運勢スコア</h2>
                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                        @foreach($readingData['scores'] as $category => $score)
                                            <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                                <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">
                                                    {{ ucfirst($category) }}
                                                </div>
                                                <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">
                                                    {{ $score }}
                                                </div>
                                                <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                    <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $score }}%"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Advice -->
                            @if(isset($readingData['advice']))
                                <div class="mb-8">
                                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">開運アドバイス</h2>
                                    <div class="space-y-4">
                                        @foreach($readingData['advice'] as $advice)
                                            <div class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                                <h3 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">
                                                    {{ $advice['title'] }}
                                                </h3>
                                                <p class="text-purple-800 dark:text-purple-200">
                                                    {{ $advice['text'] }}
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @else
                            {{-- 非会員：note風blur表示 --}}
                            @if(isset($readingData['sections']))
                                <div class="space-y-6 mb-8">
                                    @foreach($readingData['sections'] as $section)
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                                {{ $section['heading'] }}
                                            </h3>
                                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                                {{ \Illuminate\Support\Str::limit($section['body'], 100) }}...
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- 点線区切り --}}
                            <div class="border-t-2 border-dashed border-gray-300 dark:border-gray-600 my-8"></div>

                            {{-- note風ペイウォール --}}
                            <div class="text-center py-8">
                                <div class="mb-6">
                                    <p class="text-lg font-bold text-gray-900 dark:text-white mb-2">ここから先は</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                        @php
                                            $totalChars = 0;
                                            $imageCount = 0;
                                            if(isset($readingData['sections'])) {
                                                foreach($readingData['sections'] as $section) {
                                                    $totalChars += mb_strlen($section['body']);
                                                }
                                            }
                                            if(isset($readingData['advice'])) {
                                                foreach($readingData['advice'] as $advice) {
                                                    $totalChars += mb_strlen($advice['text']);
                                                }
                                            }
                                        @endphp
                                        {{ $totalChars }}字 / {{ $imageCount }}画像
                                    </p>
                                    <div class="text-3xl font-bold text-gray-900 dark:text-white mb-6">¥980</div>
                                </div>
                                
                                {{-- ぼかし表示 --}}
                                <div class="relative mb-6">
                                    <div class="opacity-30 blur-sm select-none pointer-events-none">
                                        @if(isset($readingData['scores']))
                                            <div class="mb-8">
                                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">運勢スコア</h2>
                                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                                    @foreach($readingData['scores'] as $category => $score)
                                                        <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                                            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">
                                                                {{ ucfirst($category) }}
                                                            </div>
                                                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">
                                                                {{ $score }}
                                                            </div>
                                                            <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                                <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $score }}%"></div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        @if(isset($readingData['advice']))
                                            <div class="mb-8">
                                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">開運アドバイス</h2>
                                                <div class="space-y-4">
                                                    @foreach($readingData['advice'] as $advice)
                                                        <div class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                                            <h3 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">
                                                                {{ $advice['title'] }}
                                                            </h3>
                                                            <p class="text-purple-800 dark:text-purple-200">
                                                                {{ $advice['text'] }}
                                                            </p>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <a href="{{ route('pricing') }}" 
                                   class="inline-block w-full max-w-xs mx-auto bg-gray-900 hover:bg-gray-800 text-white px-8 py-3 rounded-lg font-medium transition-colors"
                                   aria-label="サブスク登録ページに移動">
                                    購入手続きへ
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('ziwei.chart') }}" class="border border-purple-600 text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-purple-900/20 px-6 py-3 rounded-lg font-medium transition-colors">
                            盤面に戻る
                        </a>
                        <button 
                            wire:click="loadData"
                            class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium transition-colors"
                        >
                            鑑定を更新
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>