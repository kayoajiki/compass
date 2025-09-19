<x-layouts.app :title="'詳細相性分析 - FortuneCompass'">
    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    詳細相性分析
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    多角的な占術による深い相性分析とアドバイス
                </p>
            </div>

            @if(!auth()->user()->hasActiveSubscription())
                <!-- Non-subscriber view -->
                <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                    <div class="text-center py-12">
                        <div class="mb-6">
                            <div class="w-20 h-20 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">サブスクリプションが必要です</h2>
                            <p class="text-gray-600 dark:text-gray-300 mb-6">
                                詳細相性分析をご覧いただくには、<br>
                                月額プランまたは年額プランへのご加入が必要です
                            </p>
                        </div>
                        
                        <div class="space-y-4">
                            <a href="{{ route('pricing') }}" class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg font-medium transition-colors">
                                料金プランを見る
                            </a>
                            <div>
                                <a href="{{ route('compatibility.chart') }}" class="text-purple-600 hover:text-purple-500 dark:text-purple-400 dark:hover:text-purple-300 text-sm underline">
                                    基本相性分析に戻る
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Subscriber view -->
                <div class="space-y-8">
                    <!-- Multi-Divination Analysis -->
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">多角占術による相性分析</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Four Pillars Analysis -->
                            <div class="p-6 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-4">四柱推命による分析</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-blue-800 dark:text-blue-200">五行の相性</span>
                                        <span class="font-bold text-blue-600 dark:text-blue-400">85%</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-blue-800 dark:text-blue-200">干支の相性</span>
                                        <span class="font-bold text-blue-600 dark:text-blue-400">78%</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-blue-800 dark:text-blue-200">十神の相性</span>
                                        <span class="font-bold text-blue-600 dark:text-blue-400">82%</span>
                                    </div>
                                </div>
                                <p class="text-sm text-blue-700 dark:text-blue-300 mt-3">
                                    五行のバランスが良く、お互いを補完し合う関係性です。
                                </p>
                            </div>

                            <!-- Western Astrology Analysis -->
                            <div class="p-6 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                <h3 class="text-lg font-semibold text-purple-900 dark:text-purple-100 mb-4">西洋占星術による分析</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-purple-800 dark:text-purple-200">太陽星座の相性</span>
                                        <span class="font-bold text-purple-600 dark:text-purple-400">90%</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-purple-800 dark:text-purple-200">月星座の相性</span>
                                        <span class="font-bold text-purple-600 dark:text-purple-400">75%</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-purple-800 dark:text-purple-200">金星の相性</span>
                                        <span class="font-bold text-purple-600 dark:text-purple-400">88%</span>
                                    </div>
                                </div>
                                <p class="text-sm text-purple-700 dark:text-purple-300 mt-3">
                                    太陽星座の相性が非常に良く、自然な親和性があります。
                                </p>
                            </div>

                            <!-- Numerology Analysis -->
                            <div class="p-6 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                <h3 class="text-lg font-semibold text-green-900 dark:text-green-100 mb-4">数秘術による分析</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-green-800 dark:text-green-200">ライフパス数の相性</span>
                                        <span class="font-bold text-green-600 dark:text-green-400">80%</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-green-800 dark:text-green-200">ソウルナンバーの相性</span>
                                        <span class="font-bold text-green-600 dark:text-green-400">85%</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-green-800 dark:text-green-200">ディスティニーナンバーの相性</span>
                                        <span class="font-bold text-green-600 dark:text-green-400">77%</span>
                                    </div>
                                </div>
                                <p class="text-sm text-green-700 dark:text-green-300 mt-3">
                                    数秘術的にも相性が良く、お互いの人生の目標が一致しています。
                                </p>
                            </div>

                            <!-- Zi Wei Analysis -->
                            <div class="p-6 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                                <h3 class="text-lg font-semibold text-orange-900 dark:text-orange-100 mb-4">紫微斗数による分析</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-orange-800 dark:text-orange-200">命宮の相性</span>
                                        <span class="font-bold text-orange-600 dark:text-orange-400">83%</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-orange-800 dark:text-orange-200">夫妻宮の相性</span>
                                        <span class="font-bold text-orange-600 dark:text-orange-400">86%</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-orange-800 dark:text-orange-200">交友宮の相性</span>
                                        <span class="font-bold text-orange-600 dark:text-orange-400">79%</span>
                                    </div>
                                </div>
                                <p class="text-sm text-orange-700 dark:text-orange-300 mt-3">
                                    紫微斗数的にも非常に良い相性で、長期的な関係が期待できます。
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Relationship Analysis -->
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">詳細関係性分析</h2>
                        
                        <div class="space-y-6">
                            <!-- Strengths -->
                            <div class="p-6 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                <h3 class="text-lg font-semibold text-green-900 dark:text-green-100 mb-4">関係性の強み</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-3">
                                        <div class="flex items-start space-x-3">
                                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-green-900 dark:text-green-100">価値観の一致</h4>
                                                <p class="text-sm text-green-800 dark:text-green-200">人生の目標や価値観が非常によく合っており、お互いを理解し合えます。</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-start space-x-3">
                                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-green-900 dark:text-green-100">コミュニケーション</h4>
                                                <p class="text-sm text-green-800 dark:text-green-200">言葉での意思疎通がスムーズで、お互いの気持ちを理解し合えます。</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-3">
                                        <div class="flex items-start space-x-3">
                                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-green-900 dark:text-green-100">相互補完</h4>
                                                <p class="text-sm text-green-800 dark:text-green-200">お互いの弱点を補い合い、一緒に成長できる関係性です。</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-start space-x-3">
                                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-green-900 dark:text-green-100">長期的安定</h4>
                                                <p class="text-sm text-green-800 dark:text-green-200">占術的にも長期的な関係性の安定性が高いとされています。</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Challenges -->
                            <div class="p-6 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                                <h3 class="text-lg font-semibold text-yellow-900 dark:text-yellow-100 mb-4">注意すべきポイント</h3>
                                <div class="space-y-4">
                                    <div class="flex items-start space-x-3">
                                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-yellow-900 dark:text-yellow-100">意見の対立</h4>
                                            <p class="text-sm text-yellow-800 dark:text-yellow-200">時々意見の違いで対立することがありますが、これは健全な関係性の証拠でもあります。</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start space-x-3">
                                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-yellow-900 dark:text-yellow-100">ペースの違い</h4>
                                            <p class="text-sm text-yellow-800 dark:text-yellow-200">行動のペースが異なることがあるので、お互いのリズムを尊重することが重要です。</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personalized Advice -->
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">あなたたちへの特別なアドバイス</h2>
                        
                        <div class="space-y-6">
                            <div class="p-6 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                <h3 class="font-semibold text-purple-900 dark:text-purple-100 mb-3">関係性を深める方法</h3>
                                <ul class="text-purple-800 dark:text-purple-200 space-y-2">
                                    <li>• 定期的な深い対話の時間を作る</li>
                                    <li>• お互いの興味や趣味を共有する</li>
                                    <li>• 一緒に新しいことに挑戦する</li>
                                    <li>• 感謝の気持ちを言葉で伝える</li>
                                </ul>
                            </div>
                            
                            <div class="p-6 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                <h3 class="font-semibold text-blue-900 dark:text-blue-100 mb-3">最適なコミュニケーション方法</h3>
                                <p class="text-blue-800 dark:text-blue-200">
                                    あなたたちは言葉でのコミュニケーションが得意です。感情的な話をする際は、相手の気持ちをよく聞き、共感を示すことが大切です。
                                    また、時には文字でのコミュニケーション（手紙やメッセージ）も効果的です。
                                </p>
                            </div>
                            
                            <div class="p-6 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                <h3 class="font-semibold text-green-900 dark:text-green-100 mb-3">将来の展望</h3>
                                <p class="text-green-800 dark:text-green-200">
                                    占術的には非常に安定した関係性が期待できます。お互いを尊重し合い、成長し合える関係を築いていけば、
                                    長期的に幸せな関係を維持できるでしょう。特に、共通の目標を持つことで、より強い絆を築くことができます。
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="text-center">
                        <a href="{{ route('compatibility.chart') }}" class="inline-block border border-purple-600 text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-purple-900/20 px-6 py-2 rounded-lg font-medium transition-colors">
                            基本相性分析に戻る
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
