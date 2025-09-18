<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
    <title>FortuneCompass - 人生の羅針盤占い</title>
    <meta name="description" content="四柱推命、紫微斗数、西洋占星術、数秘術など複数の占術を横断し、あなたの人生の羅針盤を提供するサービスです。">
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-50 to-amber-50 dark:from-zinc-900 dark:to-zinc-800">
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-sm border-b border-purple-100 dark:bg-zinc-900/80 dark:border-zinc-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-purple-600 dark:text-purple-400">FortuneCompass</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-purple-600 dark:text-gray-300 dark:hover:text-purple-400 px-3 py-2 rounded-md text-sm font-medium">
                            ダッシュボード
                        </a>
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
    <div class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                    人生の<span class="text-purple-600 dark:text-purple-400">羅針盤</span>占い
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto">
                    四柱推命・紫微斗数・西洋占星術・数秘術など複数の占術を横断し、<br>
                    あなたの人生の方向性を多角的に照らし出します
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg text-lg font-medium transition-colors">
                            ダッシュボードへ
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg text-lg font-medium transition-colors">
                            無料で始める
                        </a>
                        <a href="{{ route('login') }}" class="border border-purple-600 text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-purple-900/20 px-8 py-3 rounded-lg text-lg font-medium transition-colors">
                            ログイン
                        </a>
                    @endauth
                </div>
            </div>
        </div>
        
        <!-- Decorative elements -->
        <div class="absolute top-20 right-10 w-20 h-20 bg-purple-200/30 rounded-full blur-xl"></div>
        <div class="absolute bottom-20 left-10 w-32 h-32 bg-amber-200/30 rounded-full blur-xl"></div>
    </div>

    <!-- Features Section -->
    <div class="py-20 bg-white/50 dark:bg-zinc-800/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    複数の占術で多角的に分析
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    今日の運勢から長期的な人生の流れまで、様々な角度からあなたをサポートします
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center p-6 bg-white/80 dark:bg-zinc-900/80 rounded-2xl shadow-sm">
                    <div class="text-4xl mb-4">🔮</div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">四柱推命</h3>
                    <p class="text-gray-600 dark:text-gray-300">生年月日時から導き出す、あなたの本質と運命</p>
                </div>
                
                <div class="text-center p-6 bg-white/80 dark:bg-zinc-900/80 rounded-2xl shadow-sm">
                    <div class="text-4xl mb-4">⭐</div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">西洋占星術</h3>
                    <p class="text-gray-600 dark:text-gray-300">太陽・月・惑星の配置から見る性格と運勢</p>
                </div>
                
                <div class="text-center p-6 bg-white/80 dark:bg-zinc-900/80 rounded-2xl shadow-sm">
                    <div class="text-4xl mb-4">🔢</div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">数秘術</h3>
                    <p class="text-gray-600 dark:text-gray-300">数字の神秘的な力で導く人生の方向性</p>
                </div>
                
                <div class="text-center p-6 bg-white/80 dark:bg-zinc-900/80 rounded-2xl shadow-sm">
                    <div class="text-4xl mb-4">📅</div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">運勢カレンダー</h3>
                    <p class="text-gray-600 dark:text-gray-300">日々の運気と吉日をカレンダーで確認</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-20">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
                今すぐあなたの運勢をチェック
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
                無料で今日の運勢を確認し、より深い鑑定は月額980円でお楽しみいただけます
            </p>
            @auth
                <a href="{{ route('dashboard') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg text-lg font-medium transition-colors">
                    ダッシュボードへ
                </a>
            @else
                <a href="{{ route('register') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg text-lg font-medium transition-colors">
                    無料で始める
                </a>
            @endauth
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-50 dark:bg-zinc-900 border-t border-gray-200 dark:border-zinc-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-gray-600 dark:text-gray-400">
                <p>&copy; 2024 FortuneCompass. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
