<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
    <title>料金プラン - FortuneCompass</title>
    <meta name="description" content="FortuneCompassの料金プランをご紹介。月額980円または年額9,800円で、詳細な占い鑑定をお楽しみいただけます。">
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-50 to-amber-50 dark:from-zinc-900 dark:to-zinc-800">
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-sm border-b border-purple-100 dark:bg-zinc-900/80 dark:border-zinc-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-purple-600 dark:text-purple-400">FortuneCompass</h1>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-purple-600 dark:text-gray-300 dark:hover:text-purple-400 px-3 py-2 rounded-md text-sm font-medium">
                            ダッシュボード
                        </a>
                        @if($hasActiveSubscription)
                            <span class="bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400 px-3 py-1 rounded-full text-sm font-medium">
                                有料会員
                            </span>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-purple-600 dark:text-gray-300 dark:hover:text-purple-400 px-3 py-2 rounded-md text-sm font-medium">
                            ログイン
                        </a>
                        <a href="{{ route('register') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            無料で始める
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                料金プラン
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto">
                より深い鑑定と詳細な分析で、あなたの人生の羅針盤を提供します
            </p>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="max-w-2xl mx-auto mb-8 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                <div class="flex">
                    <svg class="w-5 h-5 text-blue-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm text-blue-800 dark:text-blue-200">{{ session('message') }}</p>
                </div>
            </div>
        @endif

        <!-- Pricing Cards -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Free Plan -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-gray-200 dark:border-zinc-700 p-8">
                <div class="text-center">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">無料プラン</h3>
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-gray-900 dark:text-white">¥0</span>
                        <span class="text-gray-600 dark:text-gray-400">/月</span>
                    </div>
                    <ul class="space-y-3 text-left mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">今日の運勢（簡易版）</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">各占術：盤面表示＋総合点</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">タロット1日1回</span>
                        </li>
                    </ul>
                    @auth
                        <a href="{{ route('dashboard') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg text-sm font-medium transition-colors block text-center">
                            ダッシュボードへ
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg text-sm font-medium transition-colors block text-center">
                            無料で始める
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Monthly Plan -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-lg border-2 border-purple-500 dark:border-purple-400 p-8 relative">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-purple-500 text-white px-4 py-1 rounded-full text-sm font-medium">おすすめ</span>
                </div>
                <div class="text-center">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">月額プラン</h3>
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-purple-600 dark:text-purple-400">¥980</span>
                        <span class="text-gray-600 dark:text-gray-400">/月</span>
                    </div>
                    <ul class="space-y-3 text-left mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">無料プランの全機能</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">各占術詳細（観点別・提案付き）</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">相性・二者択一・吉日詳細</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">他者鑑定追加（上限5人）</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">運勢カレンダー＋月次レポート</span>
                        </li>
                    </ul>
                    @if($hasActiveSubscription)
                        <span class="w-full bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400 px-6 py-3 rounded-lg text-sm font-medium block text-center">
                            現在のプラン
                        </span>
                    @else
                        <button class="w-full bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg text-sm font-medium transition-colors">
                            月額プランを選択
                        </button>
                    @endif
                </div>
            </div>

            <!-- Yearly Plan -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-gray-200 dark:border-zinc-700 p-8">
                <div class="text-center">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">年額プラン</h3>
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-gray-900 dark:text-white">¥9,800</span>
                        <span class="text-gray-600 dark:text-gray-400">/年</span>
                        <div class="text-sm text-green-600 dark:text-green-400 font-medium mt-1">
                            月額プランより17%お得！
                        </div>
                    </div>
                    <ul class="space-y-3 text-left mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">月額プランの全機能</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">年間レポート（AI生成）</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">優先サポート</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">新機能の早期アクセス</span>
                        </li>
                    </ul>
                    @if($hasActiveSubscription)
                        <span class="w-full bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400 px-6 py-3 rounded-lg text-sm font-medium block text-center">
                            現在のプラン
                        </span>
                    @else
                        <button class="w-full bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg text-sm font-medium transition-colors">
                            年額プランを選択
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-16 max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white text-center mb-8">
                よくある質問
            </h2>
            <div class="space-y-6">
                <div class="bg-white dark:bg-zinc-900 rounded-lg p-6 border border-gray-200 dark:border-zinc-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        解約はいつでもできますか？
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        はい、いつでも解約可能です。解約後も現在の請求期間終了までご利用いただけます。
                    </p>
                </div>
                <div class="bg-white dark:bg-zinc-900 rounded-lg p-6 border border-gray-200 dark:border-zinc-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        支払い方法は何がありますか？
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        クレジットカード（Visa、Mastercard、American Express）でのお支払いに対応しています。
                    </p>
                </div>
                <div class="bg-white dark:bg-zinc-900 rounded-lg p-6 border border-gray-200 dark:border-zinc-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        無料プランから有料プランに変更できますか？
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        はい、いつでもアップグレード可能です。変更は即座に反映されます。
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-50 dark:bg-zinc-900 border-t border-gray-200 dark:border-zinc-700 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-gray-600 dark:text-gray-400">
                <p>&copy; 2024 FortuneCompass. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
