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
                        <span class="ml-3 text-gray-600 dark:text-gray-300">紫微斗数を計算中...</span>
                    </div>
                @else
                    <!-- Person Switcher -->
                    <x-person-switcher :selectedPersonId="$selectedPersonId" />

                    <!-- Header -->
                    <div class="text-center mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">紫微斗数</h1>
                        <p class="text-gray-600 dark:text-gray-300">紫微星を中心とした運命分析</p>
                    </div>

                    <!-- Main Star Info -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">主星情報</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="text-center p-6 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">命宮</h3>
                                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $chartData['ming_gong'] }}</div>
                            </div>
                            <div class="text-center p-6 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">主星</h3>
                                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $chartData['main_star'] }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- 十二宮盤（無料） -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">十二宮盤</h2>
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

                    <!-- 鑑定サマリー（無料） -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">鑑定サマリー</h2>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-center">
                            紫微星を命宮に持つあなたは、自然なリーダーシップと王者の風格を備えています。今月は特に財運と人間関係に注目すべき時期で、慎重な判断と大胆な行動のバランスが成功の鍵となります。
                        </p>
                    </div>

                    <!-- 点線区切り -->
                    <div class="border-t-2 border-dashed border-gray-300 dark:border-gray-600 my-8"></div>

                    <!-- note風ペイウォール -->
                    <div class="text-center py-8">
                        <div class="mb-6">
                            <p class="text-lg font-bold text-gray-900 dark:text-white mb-2">ここから先は</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">456字 / 1画像</p>
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
                                            紫微星の影響により、あなたは自然な権威と魅力を持っています。自信に満ちた行動力と優雅な振る舞いで、周囲の人々を惹きつける力があります。また、美しいものや高品質なものを好む傾向があり、自分自身の価値を高めることに投資する意識が強いでしょう。
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                            今月の運勢
                                        </h3>
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                            今月は特に財運が上昇する時期です。新しい投資や事業の拡大に適したタイミングですが、紫微星の慎重さを活かしてリスクを十分に検討してから行動することが重要です。また、人間関係においても指導的な立場を任される機会が増えるでしょう。
                                        </p>
                                    </div>
                                </div>

                                <div class="mb-8">
                                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">運勢スコア</h2>
                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                        <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Leadership</div>
                                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">95</div>
                                            <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" style="width: 95%"></div>
                                            </div>
                                        </div>
                                        <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Wealth</div>
                                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">88</div>
                                            <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" style="width: 88%"></div>
                                            </div>
                                        </div>
                                        <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Career</div>
                                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">92</div>
                                            <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" style="width: 92%"></div>
                                            </div>
                                        </div>
                                        <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Health</div>
                                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">76</div>
                                            <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" style="width: 76%"></div>
                                            </div>
                                        </div>
                                        <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Relationships</div>
                                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">84</div>
                                            <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" style="width: 84%"></div>
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
                                                リーダーシップを発揮できる場面で積極的に行動することで、周囲からの信頼と評価が高まります。特に新しいプロジェクトの提案やチーム運営において力を発揮できるでしょう。
                                            </p>
                                        </div>
                                        <div class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                            <h3 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">
                                                注意点
                                            </h3>
                                            <p class="text-purple-800 dark:text-purple-200">
                                                権威的な態度を取りすぎると、周囲との距離を生んでしまう可能性があります。謙虚さと寛容さを忘れずに、バランスの取れた指導を心がけてください。
                                            </p>
                                        </div>
                                        <div class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                            <h3 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">
                                                開運のポイント
                                            </h3>
                                            <p class="text-purple-800 dark:text-purple-200">
                                                紫色のアイテムを持つと運気が上昇します。また、高級感のある環境で過ごす時間を増やすことで、紫微星のエネルギーが活性化されるでしょう。
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
