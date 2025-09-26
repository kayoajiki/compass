<div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-4 sm:py-6 lg:py-8">
        <!-- Hero Section - Today's Fortune -->
        <div class="mb-8">
            <livewire:dashboard.daily-fortune />
        </div>

        <!-- Weekly Calendar Section -->
        <div class="mb-8">
            <livewire:dashboard.weekly-calendar />
        </div>

        <!-- チャットボット -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">チャットで話そう</h2>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <livewire:chatbots.mood-coach />
                <livewire:chatbots.tarot-quick-advisor />
                <livewire:chatbots.strength-booster />
            </div>
        </div>

        <!-- Divination Methods Grid -->
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">占術で占おう</h2>
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-6 sm:mb-8">
            <!-- Four Pillars of Destiny -->
            <div class="bg-[#fdf7ff] dark:bg-zinc-900 rounded-xl sm:rounded-2xl shadow-sm border border-[#9a89b4]/30 dark:border-zinc-700 p-3 sm:p-4 lg:p-6 hover:shadow-md transition-shadow">
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl lg:text-4xl mb-2 sm:mb-3 lg:mb-4">🔮</div>
                    <h3 class="text-sm sm:text-base lg:text-lg font-semibold text-gray-900 dark:text-white mb-1 sm:mb-2">四柱推命</h3>
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mb-2 sm:mb-3 lg:mb-4">生年月日時から導き出す本質</p>
                    <a href="{{ route('four-pillars.chart') }}" class="w-full bg-[#4e3291] hover:bg-[#9a89b4] text-white px-2 sm:px-3 lg:px-4 py-1.5 sm:py-2 rounded-md sm:rounded-lg text-xs sm:text-sm font-medium transition-colors block">
                        鑑定する
                    </a>
                </div>
            </div>

            <!-- Purple Star Astrology -->
            <div class="bg-[#fdf7ff] dark:bg-zinc-900 rounded-xl sm:rounded-2xl shadow-sm border border-[#9a89b4]/30 dark:border-zinc-700 p-3 sm:p-4 lg:p-6 hover:shadow-md transition-shadow">
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl lg:text-4xl mb-2 sm:mb-3 lg:mb-4">🌟</div>
                    <h3 class="text-sm sm:text-base lg:text-lg font-semibold text-gray-900 dark:text-white mb-1 sm:mb-2">紫微斗数</h3>
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mb-2 sm:mb-3 lg:mb-4">紫微星を中心とした運命分析</p>
                    <a href="{{ route('ziwei.chart') }}" class="w-full bg-[#4e3291] hover:bg-[#9a89b4] text-white px-2 sm:px-3 lg:px-4 py-1.5 sm:py-2 rounded-md sm:rounded-lg text-xs sm:text-sm font-medium transition-colors block">
                        鑑定する
                    </a>
                </div>
            </div>

            <!-- Western Astrology -->
            <div class="bg-[#fdf7ff] dark:bg-zinc-900 rounded-xl sm:rounded-2xl shadow-sm border border-[#9a89b4]/30 dark:border-zinc-700 p-3 sm:p-4 lg:p-6 hover:shadow-md transition-shadow">
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl lg:text-4xl mb-2 sm:mb-3 lg:mb-4">⭐</div>
                    <h3 class="text-sm sm:text-base lg:text-lg font-semibold text-gray-900 dark:text-white mb-1 sm:mb-2">西洋占星術</h3>
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mb-2 sm:mb-3 lg:mb-4">惑星の配置から見る<br>運勢</p>
                    <a href="{{ route('western.chart') }}" class="w-full bg-[#4e3291] hover:bg-[#9a89b4] text-white px-2 sm:px-3 lg:px-4 py-1.5 sm:py-2 rounded-md sm:rounded-lg text-xs sm:text-sm font-medium transition-colors block">
                        鑑定する
                    </a>
                </div>
            </div>

            <!-- Numerology -->
            <div class="bg-[#fdf7ff] dark:bg-zinc-900 rounded-xl sm:rounded-2xl shadow-sm border border-[#9a89b4]/30 dark:border-zinc-700 p-3 sm:p-4 lg:p-6 hover:shadow-md transition-shadow">
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl lg:text-4xl mb-2 sm:mb-3 lg:mb-4">🔢</div>
                    <h3 class="text-sm sm:text-base lg:text-lg font-semibold text-gray-900 dark:text-white mb-1 sm:mb-2">数秘術</h3>
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mb-2 sm:mb-3 lg:mb-4">数字の神秘的な力で<br>導く</p>
                    <a href="{{ route('numerology.chart') }}" class="w-full bg-[#4e3291] hover:bg-[#9a89b4] text-white px-2 sm:px-3 lg:px-4 py-1.5 sm:py-2 rounded-md sm:rounded-lg text-xs sm:text-sm font-medium transition-colors block">
                        鑑定する
                    </a>
                </div>
            </div>
        </div>

        <!-- Mini Content Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <!-- Compatibility -->
            <div class="bg-white dark:bg-zinc-900 rounded-xl sm:rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-4 sm:p-6">
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl mb-2 sm:mb-3">💕</div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-1 sm:mb-2">相性占い</h3>
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mb-3 sm:mb-4">二人の相性をチェック</p>
                    <a href="{{ route('compatibility.chart') }}" class="w-full border border-purple-600 text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-purple-900/20 px-3 sm:px-4 py-1.5 sm:py-2 rounded-md sm:rounded-lg text-xs sm:text-sm font-medium transition-colors block">
                        相性を占う
                    </a>
                </div>
            </div>

            <!-- Two Choice -->
            <div class="bg-white dark:bg-zinc-900 rounded-xl sm:rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-4 sm:p-6">
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl mb-2 sm:mb-3">🤔</div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-1 sm:mb-2">二者択一占い</h3>
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mb-3 sm:mb-4">迷った時の選択をサポート</p>
                    <button class="w-full border border-purple-600 text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-purple-900/20 px-3 sm:px-4 py-1.5 sm:py-2 rounded-md sm:rounded-lg text-xs sm:text-sm font-medium transition-colors">
                        選択を占う
                    </button>
                </div>
            </div>

            <!-- Tarot -->
            <div class="bg-white dark:bg-zinc-900 rounded-xl sm:rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-4 sm:p-6">
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl mb-2 sm:mb-3">🃏</div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-1 sm:mb-2">タロット一枚引き</h3>
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mb-3 sm:mb-4">今日のメッセージを受け取る</p>
                    <button class="w-full border border-purple-600 text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-purple-900/20 px-3 sm:px-4 py-1.5 sm:py-2 rounded-md sm:rounded-lg text-xs sm:text-sm font-medium transition-colors">
                        カードを引く
                    </button>
                </div>
            </div>
        </div>

        <!-- 開運アイテムスライドショー -->
        <section class="mb-6 sm:mb-8">
            <livewire:components.merch-slider />
        </section>

        <!-- 個別鑑定スライドショー -->
        <section class="mb-6 sm:mb-8">
            <livewire:components.reading-slider />
        </section>

        <!-- Subscription Status -->
        @if(auth()->user()->hasActiveSubscription())
            <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 text-white">
                <div class="text-center">
                    <h3 class="text-lg sm:text-xl font-bold mb-2">有料会員プランにご加入中</h3>
                    <p class="text-green-100 text-sm sm:text-base mb-3 sm:mb-4">
                        {{ auth()->user()->getSubscriptionDisplayName() }}で、詳細な鑑定をお楽しみいただけます
                    </p>
                    <a href="{{ route('pricing') }}" class="bg-white text-green-600 hover:bg-green-50 px-4 sm:px-6 py-2 rounded-md sm:rounded-lg text-sm sm:text-base font-medium transition-colors inline-block">
                        プラン詳細を見る
                    </a>
                </div>
            </div>
        @else
            <div class="bg-[#4e3291] rounded-xl sm:rounded-2xl shadow-xl p-6 sm:p-8 text-white border border-[#9a89b4]/20">
                <div class="text-center">
                    <h3 class="text-xl sm:text-2xl font-bold mb-3 text-white">より深い鑑定をお楽しみください</h3>
                    <p class="text-white/80 text-sm sm:text-base mb-6 sm:mb-8 leading-relaxed">
                        月額980円で詳細な鑑定、相性分析、運勢カレンダー、AI生成レポートが利用できます
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                        <a href="{{ route('pricing') }}" 
                           class="bg-white text-[#4e3291] hover:bg-[#fffade] hover:text-[#4e3291] px-6 sm:px-8 py-3 rounded-lg sm:rounded-xl text-sm sm:text-base font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            💎 月額プラン（¥980/月）
                        </a>
                        <a href="{{ route('pricing') }}" 
                           class="border-2 border-white text-white hover:bg-white hover:text-[#4e3291] px-6 sm:px-8 py-3 rounded-lg sm:rounded-xl text-sm sm:text-base font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            ⭐ 年額プラン（¥9,800/年）
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>