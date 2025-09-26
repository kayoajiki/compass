<div class="min-h-screen bg-gray-50 dark:bg-zinc-900">
    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back to Dashboard Button -->
            <div class="mb-6">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    ダッシュボードに戻る
                </a>
            </div>

            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                @if($isLoading)
                    <!-- Loading state -->
                    <div class="flex items-center justify-center py-12">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600"></div>
                        <span class="ml-3 text-gray-600 dark:text-gray-300">西洋占星術を計算中...</span>
                    </div>
                @else
                    <!-- Person Switcher -->
                    <x-person-switcher :selectedPersonId="$selectedPersonId" />

                    <!-- Header -->
                    <div class="text-center mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">西洋占星術</h1>
                        <p class="text-gray-600 dark:text-gray-300">惑星の配置から見る運勢</p>
                    </div>

                    <!-- Planets -->
                    @if(isset($chartData['planets']) && !empty($chartData['planets']))
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">主要天体</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($chartData['planets'] as $planet)
                                    <div class="p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-zinc-700">
                                        <div class="text-center">
                                            <div class="text-lg font-semibold text-purple-600 dark:text-purple-400 mb-1">{{ $planet['name'] }}</div>
                                            <div class="text-sm text-gray-600 dark:text-gray-300">{{ $planet['sign'] }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $planet['degree'] }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- ハウス（無料） -->
                    @if(isset($chartData['houses']) && !empty($chartData['houses']))
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">ハウス</h2>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                @foreach($chartData['houses'] as $house)
                                    <div class="p-3 bg-gray-50 dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-zinc-700 text-center">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $house['house'] }}</div>
                                        <div class="text-xs text-purple-600 dark:text-purple-400">{{ $house['sign'] }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $house['degree'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- 鑑定サマリー（無料） -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">鑑定サマリー</h2>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-center">
                            太陽星座の影響により、あなたは創造性と表現力に富んだ性格です。今月は特に感情面と創造的な活動に注目すべき時期で、直感を信じて新しい挑戦に取り組むことで、大きな成長を遂げることができるでしょう。
                        </p>
                    </div>

                    <!-- 点線区切り -->
                    <div class="border-t-2 border-dashed border-gray-300 dark:border-gray-600 my-8"></div>

                    <!-- note風ペイウォール -->
                    <div class="text-center py-8">
                        <div class="mb-6">
                            <p class="text-lg font-bold text-gray-900 dark:text-white mb-2">ここから先は</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">523字 / 1画像</p>
                            <div class="text-3xl font-bold text-gray-900 dark:text-white mb-6">¥980</div>
                        </div>
                        
                        <!-- ぼかし表示 -->
                        <div class="relative mb-6">
                            <div class="opacity-30 blur-sm select-none pointer-events-none">
                                <div class="space-y-6 mb-8">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                            性格分析
                                        </h3>
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                            太陽星座の影響により、あなたは自然な創造性と表現力を持っています。月星座は感情的な安定性と直感力を示し、水星はコミュニケーション能力の高さを表しています。これらの惑星の配置が組み合わさって、芸術的で感受性豊かな人格を形成しています。
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                            今月の運勢
                                        </h3>
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                            今月は特に金星の影響が強く、美的感覚と人間関係に注目すべき時期です。新しい出会いや創造的な活動を通じて、自分自身の可能性を広げるチャンスが訪れるでしょう。また、火星の位置により、行動力と決断力が高まる時期でもあります。
                                        </p>
                                    </div>
                                </div>

                                <div class="mb-8">
                                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">運勢スコア</h2>
                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                        <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Creativity</div>
                                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">91</div>
                                            <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" style="width: 91%"></div>
                                            </div>
                                        </div>
                                        <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Emotions</div>
                                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">87</div>
                                            <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" style="width: 87%"></div>
                                            </div>
                                        </div>
                                        <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Communication</div>
                                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">83</div>
                                            <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" style="width: 83%"></div>
                                            </div>
                                        </div>
                                        <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Intuition</div>
                                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">79</div>
                                            <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" style="width: 79%"></div>
                                            </div>
                                        </div>
                                        <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Relationships</div>
                                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">85</div>
                                            <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" style="width: 85%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-8">
                                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">開運アドバイス</h2>
                                    <div class="space-y-4">
                                        <div class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                            <h3 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">
                                                今月の一歩目
                                            </h3>
                                            <p class="text-purple-800 dark:text-purple-200">
                                                創造的な活動や芸術的な表現に取り組むことで、内在する才能を開花させることができます。特に音楽、絵画、文章などの表現活動が運気上昇に繋がるでしょう。
                                            </p>
                                        </div>
                                        <div class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                            <h3 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">
                                                注意点
                                            </h3>
                                            <p class="text-purple-800 dark:text-purple-200">
                                                感情的な起伏が激しくなる時期なので、冷静な判断を心がけることが重要です。また、他人の意見に流されすぎず、自分の直感を信じる勇気を持ちましょう。
                                            </p>
                                        </div>
                                        <div class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                            <h3 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">
                                                開運のポイント
                                            </h3>
                                            <p class="text-purple-800 dark:text-purple-200">
                                                朝日を浴びながら瞑想やヨガを行うことで、内なるエネルギーが活性化されます。また、美しい自然の中で過ごす時間を増やすと、創造性が高まるでしょう。
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('pricing') }}" 
                           class="inline-block w-full max-w-xs mx-auto bg-gray-900 hover:bg-gray-800 text-white px-8 py-3 rounded-lg font-medium transition-colors"
                           aria-label="サブスク登録ページに移動">
                            購入手続きへ
                        </a>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <button 
                            wire:click="loadChartData"
                            class="border border-[#4e3291] text-[#4e3291] hover:bg-[#fffade] dark:text-[#9a89b4] dark:hover:bg-[#4e3291]/20 px-6 py-3 rounded-lg font-medium transition-colors"
                        >
                            再計算
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>