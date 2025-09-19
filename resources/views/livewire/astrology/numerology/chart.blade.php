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
                        <span class="ml-3 text-gray-600 dark:text-gray-300">数秘術を計算中...</span>
                    </div>
                @else
                    <!-- Person Switcher -->
                    <x-person-switcher :selectedPersonId="$selectedPersonId" />

                    <!-- Header -->
                    <div class="text-center mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">数秘術</h1>
                        <p class="text-gray-600 dark:text-gray-300">数字の神秘的な力で導く</p>
                    </div>

                    <!-- Numerology Numbers -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 text-center">数秘術ナンバー</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Life Path Number -->
                            <div class="text-center p-6 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                <h3 class="text-lg font-semibold text-purple-900 dark:text-purple-100 mb-2">ライフパスナンバー</h3>
                                <div class="text-4xl font-bold text-purple-600 dark:text-purple-400 mb-2">
                                    {{ $chartData['life_path_number'] ?? '7' }}
                                </div>
                                <p class="text-sm text-purple-700 dark:text-purple-300">人生の目的と方向性</p>
                            </div>

                            <!-- Expression Number -->
                            <div class="text-center p-6 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                <h3 class="text-lg font-semibold text-purple-900 dark:text-purple-100 mb-2">表現ナンバー</h3>
                                <div class="text-4xl font-bold text-purple-600 dark:text-purple-400 mb-2">
                                    {{ $chartData['expression_number'] ?? '3' }}
                                </div>
                                <p class="text-sm text-purple-700 dark:text-purple-300">才能と表現力</p>
                            </div>

                            <!-- Soul Urge Number -->
                            <div class="text-center p-6 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                <h3 class="text-lg font-semibold text-purple-900 dark:text-purple-100 mb-2">ソウルアージナンバー</h3>
                                <div class="text-4xl font-bold text-purple-600 dark:text-purple-400 mb-2">
                                    {{ $chartData['soul_urge_number'] ?? '9' }}
                                </div>
                                <p class="text-sm text-purple-700 dark:text-purple-300">内なる欲求と動機</p>
                            </div>
                        </div>
                    </div>

                    <!-- パーソナルイヤー（無料） -->
                    @if(isset($chartData['personal_year']) && !empty($chartData['personal_year']))
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">パーソナルイヤー</h2>
                            <div class="text-center p-6 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-2">
                                    {{ $chartData['personal_year']['personal_year_number'] ?? '5' }}
                                </div>
                                <div class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                    {{ $chartData['personal_year']['description'] ?? '変化と自由の年' }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-300">
                                    {{ $chartData['personal_year']['current_year'] ?? '2024' }}年
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- 鑑定サマリー（無料） -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">鑑定サマリー</h2>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-center">
                            ライフパスナンバー7を持つあなたは、深い洞察力と精神的な探求心に富んでいます。今月は特に直感力と知的好奇心が高まる時期で、新しい学びや内省を通じて、自分自身の真の価値を発見できるでしょう。
                        </p>
                    </div>

                    <!-- 点線区切り -->
                    <div class="border-t-2 border-dashed border-gray-300 dark:border-gray-600 my-8"></div>

                    <!-- note風ペイウォール -->
                    <div class="text-center py-8">
                        <div class="mb-6">
                            <p class="text-lg font-bold text-gray-900 dark:text-white mb-2">ここから先は</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">412字 / 1画像</p>
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
                                            ライフパスナンバー7の影響により、あなたは自然な知性と精神的な深さを持っています。表現ナンバー3は創造性とコミュニケーション能力を示し、ソウルアージナンバー9は理想主義と奉仕精神を表しています。これらの数字の組み合わせが、知的で直感的な人格を形成しています。
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                            今月の運勢
                                        </h3>
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                            今月は特にパーソナルイヤー5の影響により、変化と自由を求める気持ちが高まります。新しい挑戦や冒険を通じて、自分自身の可能性を広げる時期です。また、数字のエネルギーが活性化され、直感力と創造性が特に優れた状態になるでしょう。
                                        </p>
                                    </div>
                                </div>

                                <div class="mb-8">
                                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">運勢スコア</h2>
                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                        <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Intuition</div>
                                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">94</div>
                                            <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" style="width: 94%"></div>
                                            </div>
                                        </div>
                                        <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Wisdom</div>
                                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">89</div>
                                            <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" style="width: 89%"></div>
                                            </div>
                                        </div>
                                        <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Creativity</div>
                                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">82</div>
                                            <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" style="width: 82%"></div>
                                            </div>
                                        </div>
                                        <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Spirituality</div>
                                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">96</div>
                                            <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" style="width: 96%"></div>
                                            </div>
                                        </div>
                                        <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                            <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Service</div>
                                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">87</div>
                                            <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" style="width: 87%"></div>
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
                                                瞑想や読書などの精神的な活動に時間を費やすことで、内在する知性と直感力を高めることができます。特に哲学や心理学などの深い学びが運気上昇に繋がるでしょう。
                                            </p>
                                        </div>
                                        <div class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                            <h3 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">
                                                注意点
                                            </h3>
                                            <p class="text-purple-800 dark:text-purple-200">
                                                完璧主義に陥りすぎると、行動が鈍くなってしまう可能性があります。時には直感を信じて、完璧でなくても行動を起こす勇気を持ちましょう。
                                            </p>
                                        </div>
                                        <div class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                            <h3 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">
                                                開運のポイント
                                            </h3>
                                            <p class="text-purple-800 dark:text-purple-200">
                                                静寂な環境で過ごす時間を増やすことで、数秘術のエネルギーが活性化されます。また、紫色や深い青色のアイテムを持つと、精神的な成長が促進されるでしょう。
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