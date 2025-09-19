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
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $readingData['title'] ?? '四柱推命 詳細鑑定' }}</h1>
                            <p class="text-gray-600 dark:text-gray-300">あなたの本質を深く分析します</p>
                        </div>
                    </div>

                    <!-- 命盤表示 -->
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                        <h2 class="text-xl font-bold mb-4 text-center">命盤</h2>
                        @if(!empty($chartData))
                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse border border-gray-300 dark:border-zinc-600" role="table" aria-label="四柱推命表">
                                    <thead>
                                        <tr class="bg-purple-50 dark:bg-purple-900/20">
                                            <th scope="col" class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">柱</th>
                                            <th scope="col" class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">天干</th>
                                            <th scope="col" class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">地支</th>
                                            <th scope="col" class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">納音</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-zinc-800">年柱</th>
                                            <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-lg font-bold text-purple-600 dark:text-purple-400">{{ $chartData['year']['stem'] ?? '甲' }}</td>
                                            <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-lg font-bold text-purple-600 dark:text-purple-400">{{ $chartData['year']['branch'] ?? '子' }}</td>
                                            <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">海中金</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-zinc-800">月柱</th>
                                            <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-lg font-bold text-purple-600 dark:text-purple-400">{{ $chartData['month']['stem'] ?? '丙' }}</td>
                                            <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-lg font-bold text-purple-600 dark:text-purple-400">{{ $chartData['month']['branch'] ?? '寅' }}</td>
                                            <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">炉中火</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-zinc-800">日柱</th>
                                            <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-lg font-bold text-purple-600 dark:text-purple-400">{{ $chartData['day']['stem'] ?? '庚' }}</td>
                                            <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-lg font-bold text-purple-600 dark:text-purple-400">{{ $chartData['day']['branch'] ?? '午' }}</td>
                                            <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">路傍土</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-zinc-800">時柱</th>
                                            <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-lg font-bold text-purple-600 dark:text-purple-400">{{ $chartData['hour']['stem'] ?? '丁' }}</td>
                                            <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-lg font-bold text-purple-600 dark:text-purple-400">{{ $chartData['hour']['branch'] ?? '亥' }}</td>
                                            <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">屋上土</td>
                                        </tr>
                                    </tbody>
                                </table>
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
                        <!-- デバッグ情報 -->
                        <div class="mb-4 p-4 bg-yellow-100 border border-yellow-300 rounded">
                            <p class="text-sm">デバッグ: isSubscriber = {{ $isSubscriber ? 'true' : 'false' }}</p>
                        </div>
                        
                        @php
                            // デバッグ用：強制的にfalseに設定
                            $isSubscriber = false;
                        @endphp
                        
                        @if(false)
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
                        <a href="{{ route('four-pillars.chart') }}" class="border border-purple-600 text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-purple-900/20 px-6 py-3 rounded-lg font-medium transition-colors">
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