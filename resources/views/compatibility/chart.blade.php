<x-layouts.app :title="'相性占い - FortuneCompass'">
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

            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    相性占い
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    あなたと大切な人の相性を多角的に分析します
                </p>
            </div>

            <!-- Person Selection -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">相性を見たい相手を選択</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Your Profile -->
                    <div class="p-6 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                        <h3 class="text-lg font-semibold text-purple-900 dark:text-purple-100 mb-4">あなた</h3>
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-lg">{{ auth()->user()->initials() }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-300">{{ auth()->user()->profile?->birth_date ? auth()->user()->profile->birth_date->format('Y年n月j日') : '生年月日未設定' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Partner Selection -->
                    <div class="p-6 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">相手</h3>
                        <div class="space-y-3">
                            <button class="w-full p-3 text-left border border-gray-300 dark:border-zinc-600 rounded-lg hover:bg-gray-100 dark:hover:bg-zinc-700 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">友</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">友達Aさん</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-300">1990年5月15日</p>
                                    </div>
                                </div>
                            </button>
                            <button class="w-full p-3 text-left border border-gray-300 dark:border-zinc-600 rounded-lg hover:bg-gray-100 dark:hover:bg-zinc-700 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">恋</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">恋人Bさん</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-300">1988年12月3日</p>
                                    </div>
                                </div>
                            </button>
                            <button class="w-full p-3 text-left border border-purple-300 dark:border-purple-600 rounded-lg bg-purple-100 dark:bg-purple-900/30">
                                <div class="flex items-center justify-between">
                                    <span class="text-purple-700 dark:text-purple-300 font-medium">新しい相手を追加</span>
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Basic Compatibility Results -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">基本相性</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Overall Compatibility -->
                    <div class="text-center p-6 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg">
                        <div class="text-4xl font-bold text-purple-600 dark:text-purple-400 mb-2">85%</div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">総合相性</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">非常に良い相性です</p>
                    </div>

                    <!-- Love Compatibility -->
                    <div class="text-center p-6 bg-gradient-to-br from-pink-50 to-pink-100 dark:from-pink-900/20 dark:to-pink-800/20 rounded-lg">
                        <div class="text-4xl font-bold text-pink-600 dark:text-pink-400 mb-2">78%</div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">恋愛相性</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">良好な関係を築けます</p>
                    </div>

                    <!-- Friendship Compatibility -->
                    <div class="text-center p-6 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg">
                        <div class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">92%</div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">友情相性</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">最高の友達になれます</p>
                    </div>
                </div>
            </div>

            <!-- Compatibility Chart -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">相性チャート</h2>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                        <div class="text-2xl mb-2">💕</div>
                        <h3 class="font-medium text-gray-900 dark:text-white mb-1">愛情</h3>
                        <div class="w-full bg-gray-200 dark:bg-zinc-700 rounded-full h-2 mb-1">
                            <div class="bg-pink-500 h-2 rounded-full" style="width: 78%"></div>
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-300">78%</span>
                    </div>
                    
                    <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                        <div class="text-2xl mb-2">🗣️</div>
                        <h3 class="font-medium text-gray-900 dark:text-white mb-1">コミュニケーション</h3>
                        <div class="w-full bg-gray-200 dark:bg-zinc-700 rounded-full h-2 mb-1">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: 85%"></div>
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-300">85%</span>
                    </div>
                    
                    <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                        <div class="text-2xl mb-2">🎯</div>
                        <h3 class="font-medium text-gray-900 dark:text-white mb-1">価値観</h3>
                        <div class="w-full bg-gray-200 dark:bg-zinc-700 rounded-full h-2 mb-1">
                            <div class="bg-green-500 h-2 rounded-full" style="width: 72%"></div>
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-300">72%</span>
                    </div>
                    
                    <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                        <div class="text-2xl mb-2">⚡</div>
                        <h3 class="font-medium text-gray-900 dark:text-white mb-1">エネルギー</h3>
                        <div class="w-full bg-gray-200 dark:bg-zinc-700 rounded-full h-2 mb-1">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 88%"></div>
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-300">88%</span>
                    </div>
                </div>
            </div>

            <!-- 基本分析（無料） -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">基本分析</h2>
                
                <div class="space-y-4">
                    <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <h3 class="font-semibold text-green-900 dark:text-green-100 mb-2">良い相性ポイント</h3>
                        <ul class="text-green-800 dark:text-green-200 space-y-1">
                            <li>• お互いの価値観が似ており、理解し合える</li>
                            <li>• コミュニケーションがスムーズに取れる</li>
                            <li>• エネルギーレベルが合っている</li>
                        </ul>
                    </div>
                    
                    <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                        <h3 class="font-semibold text-yellow-900 dark:text-yellow-100 mb-2">注意点</h3>
                        <ul class="text-yellow-800 dark:text-yellow-200 space-y-1">
                            <li>• 時々意見の違いで対立する可能性</li>
                            <li>• お互いのペースを尊重することが重要</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- 鑑定サマリー（無料） -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">鑑定サマリー</h2>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-center">
                    総合相性85%のあなたたちは、非常に良好な関係を築ける相性です。特に友情面での相性が抜群で、お互いを理解し合える深い絆を育むことができるでしょう。恋愛関係でも安定した関係を築くことが期待できます。
                </p>
            </div>

            <!-- 点線区切り -->
            <div class="border-t-2 border-dashed border-gray-300 dark:border-gray-600 my-8"></div>

            <!-- note風ペイウォール -->
            <div class="text-center py-8">
                <div class="mb-6">
                    <p class="text-lg font-bold text-gray-900 dark:text-white mb-2">ここから先は</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">587字 / 1画像</p>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white mb-6">¥980</div>
                </div>
                
                <!-- ぼかし表示 -->
                <div class="relative mb-6">
                    <div class="opacity-30 blur-sm select-none pointer-events-none">
                        <div class="space-y-6 mb-8">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    詳細相性分析
                                </h3>
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                    あなたたちの相性を多角的に分析すると、四柱推命、西洋占星術、数秘術の観点から非常に調和の取れた組み合わせであることが分かります。特に感情面での理解度が高く、お互いの気持ちを深く理解し合える関係性を築くことができます。また、価値観の一致度も高く、将来のビジョンを共有しやすい相性です。
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    長期的な関係性
                                </h3>
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                    長期的な視点で見ると、あなたたちは互いの成長を促進し合える関係性を築くことができます。特に困難な時期には、お互いを支え合う力強い絆を育むことができるでしょう。また、共通の目標に向かって協力し合える相性のため、パートナーシップや結婚においても非常に安定した関係を期待できます。
                                </p>
                            </div>
                        </div>

                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">関係性スコア</h2>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                    <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Trust</div>
                                    <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">91</div>
                                    <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: 91%"></div>
                                    </div>
                                </div>
                                <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                    <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Intimacy</div>
                                    <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">87</div>
                                    <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: 87%"></div>
                                    </div>
                                </div>
                                <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                    <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Support</div>
                                    <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">94</div>
                                    <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: 94%"></div>
                                    </div>
                                </div>
                                <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                    <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Growth</div>
                                    <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">82</div>
                                    <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: 82%"></div>
                                    </div>
                                </div>
                                <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                    <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Future</div>
                                    <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">89</div>
                                    <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: 89%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">関係性アドバイス</h2>
                            <div class="space-y-4">
                                <div class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                    <h3 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">
                                        関係性を深めるために
                                    </h3>
                                    <p class="text-purple-800 dark:text-purple-200">
                                        共通の趣味や活動を見つけることで、より深い絆を築くことができます。特に創造的な活動や学習を通じて、お互いの成長を共有することで関係性がさらに強化されるでしょう。
                                    </p>
                                </div>
                                <div class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                    <h3 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">
                                        注意点
                                    </h3>
                                    <p class="text-purple-800 dark:text-purple-200">
                                        時々意見の違いで対立することがありますが、これは健全な関係性の証拠でもあります。お互いの意見を尊重し、建設的な対話を心がけることで、より強い関係を築くことができるでしょう。
                                    </p>
                                </div>
                                <div class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                    <h3 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">
                                        開運のポイント
                                    </h3>
                                    <p class="text-purple-800 dark:text-purple-200">
                                        一緒に旅行や新しい体験をすることで、関係性に新鮮さと刺激を与えることができます。また、お互いの誕生日や記念日を大切にすることで、絆を深める効果が期待できるでしょう。
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
        </div>
    </div>
</x-layouts.app>
