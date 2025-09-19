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

            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                @if($isLoading)
                    <!-- Loading state -->
                    <div class="flex items-center justify-center py-12">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600"></div>
                        <span class="ml-3 text-gray-600 dark:text-gray-300">四柱推命を計算中...</span>
                    </div>
                @else
                    <!-- Person Switcher -->
                    <x-person-switcher :selectedPersonId="$selectedPersonId" />

                    <!-- Header -->
                    <div class="text-center mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">四柱推命</h1>
                        <p class="text-gray-600 dark:text-gray-300">生年月日時から導き出す本質</p>
                    </div>

                    <!-- 四柱推命表（無料） -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">四柱推命表</h2>
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
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-lg font-bold text-purple-600 dark:text-purple-400">{{ $chartData['year']['stem'] }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-lg font-bold text-purple-600 dark:text-purple-400">{{ $chartData['year']['branch'] }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">海中金</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-zinc-800">月柱</th>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-lg font-bold text-purple-600 dark:text-purple-400">{{ $chartData['month']['stem'] }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-lg font-bold text-purple-600 dark:text-purple-400">{{ $chartData['month']['branch'] }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">炉中火</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-zinc-800">日柱</th>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-lg font-bold text-purple-600 dark:text-purple-400">{{ $chartData['day']['stem'] }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-lg font-bold text-purple-600 dark:text-purple-400">{{ $chartData['day']['branch'] }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">路傍土</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-zinc-800">時柱</th>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-lg font-bold text-purple-600 dark:text-purple-400">{{ $chartData['hour']['stem'] }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-lg font-bold text-purple-600 dark:text-purple-400">{{ $chartData['hour']['branch'] }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">屋上土</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 鑑定サマリー（無料） -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">鑑定サマリー</h2>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-center">
                            あなたの干支「甲子・丙寅・庚午・丁亥」から読み取れる今月の運勢は、新しい挑戦に向けた準備期間として最適です。特に金運と仕事運に注目すべき時期で、慎重な判断と積極的な行動のバランスが重要になります。
                        </p>
                    </div>

                    <!-- 点線区切り -->
                    <div class="border-t-2 border-dashed border-gray-300 dark:border-gray-600 my-8"></div>

                    <!-- note風ペイウォール -->
                    <div class="text-center py-8">
                        <div class="mb-6">
                            <p class="text-lg font-bold text-gray-900 dark:text-white mb-2">ここから先は</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">378字 / 1画像</p>
                            <div class="text-3xl font-bold text-gray-900 dark:text-white mb-6">¥980</div>
                        </div>
                        
                        <!-- ぼかし表示 -->
                        <div class="relative mb-6">
                            <div class="opacity-30 blur-sm select-none pointer-events-none">
                                <div class="space-y-6 mb-8">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                            本質的な性格
                                        </h3>
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                            甲子の年柱を持つあなたは、リーダーシップと革新性を兼ね備えた性格です。丙寅の月柱は創造性と行動力を示し、庚午の日柱は正義感と情熱的な一面を表しています。丁亥の時柱は直感力と協調性に長けており、これらの要素が組み合わさって、バランスの取れた人格を形成しています。
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                            今月の流れ
                                        </h3>
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                            今月は特に金運が上昇する時期です。新しい投資や副業の検討に適したタイミングですが、庚午の特性を活かして慎重な判断を心がけてください。また、人間関係においても丁亥の協調性が発揮され、チームワークが重要になる場面で力を発揮できるでしょう。
                                        </p>
                                    </div>
                                </div>

                                <div class="mb-8">
                                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">運勢スコア</h2>
                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                        <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Communication</div>
                                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">85</div>
                                            <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" style="width: 85%"></div>
                                            </div>
                                        </div>
                                        <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Money</div>
                                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">78</div>
                                            <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" style="width: 78%"></div>
                                            </div>
                                        </div>
                                        <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Action</div>
                                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">92</div>
                                            <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" style="width: 92%"></div>
                                            </div>
                                        </div>
                                        <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Health</div>
                                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">73</div>
                                            <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" style="width: 73%"></div>
                                            </div>
                                        </div>
                                        <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Love</div>
                                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">69</div>
                                            <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" style="width: 69%"></div>
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
                                                新しいプロジェクトや学習に取り組むことで、潜在能力を開花させるチャンスです。特に創造性を活かせる分野での活動が吉。
                                            </p>
                                        </div>
                                        <div class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                            <h3 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">
                                                注意点
                                            </h3>
                                            <p class="text-purple-800 dark:text-purple-200">
                                                完璧主義に陥りすぎず、時には周囲の意見に耳を傾けることも大切です。バランスの取れた判断を心がけてください。
                                            </p>
                                        </div>
                                        <div class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                            <h3 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">
                                                開運のポイント
                                            </h3>
                                            <p class="text-purple-800 dark:text-purple-200">
                                                朝の時間を有効活用し、東向きで瞑想や読書を行うことで運気が上昇します。また、緑色のアイテムを持つと吉。
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
                            class="border border-purple-600 text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-purple-900/20 px-6 py-3 rounded-lg font-medium transition-colors"
                        >
                            再計算
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>