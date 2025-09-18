<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Hero Section - Today's Fortune -->
        <div class="mb-8">
            <livewire:dashboard.daily-fortune />
        </div>

        <!-- Fortune Calendar Section -->
        <div class="mb-8">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">運勢カレンダー</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-300">日々の運気と吉日を確認</p>
                    </div>
                    @if(auth()->user()->hasActiveSubscription())
                        <a href="{{ route('premium.calendar') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            カレンダーを見る
                        </a>
                    @else
                        <a href="{{ route('pricing') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            有料機能
                        </a>
                    @endif
                </div>
                <div class="text-center py-8">
                    <div class="text-4xl mb-2">📅</div>
                    <p class="text-gray-500 dark:text-gray-400">
                        @if(auth()->user()->hasActiveSubscription())
                            詳細な運勢カレンダーをご利用いただけます
                        @else
                            有料プランにご加入いただくと、詳細な運勢カレンダーをご利用いただけます
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Divination Methods Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Four Pillars of Destiny -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6 hover:shadow-md transition-shadow">
                <div class="text-center">
                    <div class="text-4xl mb-4">🔮</div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">四柱推命</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">生年月日時から導き出す本質</p>
                    <button class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        鑑定する
                    </button>
                </div>
            </div>

            <!-- Purple Star Astrology -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6 hover:shadow-md transition-shadow">
                <div class="text-center">
                    <div class="text-4xl mb-4">🌟</div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">紫微斗数</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">紫微星を中心とした運命分析</p>
                    <button class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        鑑定する
                    </button>
                </div>
            </div>

            <!-- Western Astrology -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6 hover:shadow-md transition-shadow">
                <div class="text-center">
                    <div class="text-4xl mb-4">⭐</div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">西洋占星術</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">惑星の配置から見る運勢</p>
                    <button class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        鑑定する
                    </button>
                </div>
            </div>

            <!-- Numerology -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6 hover:shadow-md transition-shadow">
                <div class="text-center">
                    <div class="text-4xl mb-4">🔢</div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">数秘術</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">数字の神秘的な力で導く</p>
                    <button class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        鑑定する
                    </button>
                </div>
            </div>
        </div>

        <!-- Mini Content Section -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Compatibility -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                <div class="text-center">
                    <div class="text-3xl mb-3">💕</div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">相性占い</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">二人の相性をチェック</p>
                    @if(auth()->user()->hasActiveSubscription())
                        <a href="{{ route('premium.compatibility') }}" class="w-full border border-purple-600 text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-purple-900/20 px-4 py-2 rounded-lg text-sm font-medium transition-colors block">
                            相性を占う
                        </a>
                    @else
                        <a href="{{ route('pricing') }}" class="w-full border border-gray-400 text-gray-400 px-4 py-2 rounded-lg text-sm font-medium transition-colors block">
                            有料機能
                        </a>
                    @endif
                </div>
            </div>

            <!-- Two Choice -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                <div class="text-center">
                    <div class="text-3xl mb-3">🤔</div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">二者択一占い</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">迷った時の選択をサポート</p>
                    <button class="w-full border border-purple-600 text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-purple-900/20 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        選択を占う
                    </button>
                </div>
            </div>

            <!-- Tarot -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                <div class="text-center">
                    <div class="text-3xl mb-3">🃏</div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">タロット一枚引き</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">今日のメッセージを受け取る</p>
                    <button class="w-full border border-purple-600 text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-purple-900/20 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        カードを引く
                    </button>
                </div>
            </div>
        </div>

        <!-- Subscription Status -->
        @if(auth()->user()->hasActiveSubscription())
            <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-2xl shadow-lg p-6 text-white">
                <div class="text-center">
                    <h3 class="text-xl font-bold mb-2">有料会員プランにご加入中</h3>
                    <p class="text-green-100 mb-4">
                        {{ auth()->user()->getSubscriptionDisplayName() }}で、詳細な鑑定をお楽しみいただけます
                    </p>
                    <a href="{{ route('pricing') }}" class="bg-white text-green-600 hover:bg-green-50 px-6 py-2 rounded-lg font-medium transition-colors inline-block">
                        プラン詳細を見る
                    </a>
                </div>
            </div>
        @else
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-2xl shadow-lg p-6 text-white">
                <div class="text-center">
                    <h3 class="text-xl font-bold mb-2">より深い鑑定をお楽しみください</h3>
                    <p class="text-purple-100 mb-4">
                        月額980円で詳細な鑑定、相性分析、運勢カレンダー、AI生成レポートが利用できます
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('pricing') }}" class="bg-white text-purple-600 hover:bg-purple-50 px-6 py-2 rounded-lg font-medium transition-colors">
                            月額プラン（¥980/月）
                        </a>
                        <a href="{{ route('pricing') }}" class="border border-white text-white hover:bg-white/10 px-6 py-2 rounded-lg font-medium transition-colors">
                            年額プラン（¥9,800/年）
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>