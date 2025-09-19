<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
    <title>FortuneCompass - 人生の羅針盤占い</title>
    <meta name="description" content="四柱推命、紫微斗数、西洋占星術、数秘術など複数の占術を横断し、あなたの人生の羅針盤を提供するサービスです。">
    <style>
        body {
            font-family: 'Hiragino Sans', 'Yu Gothic', 'Meiryo', 'Noto Sans JP', ui-sans-serif, system-ui, sans-serif;
            line-height: 1.6;
        }
        .font-sans {
            font-family: 'Hiragino Sans', 'Yu Gothic', 'Meiryo', 'Noto Sans JP', ui-sans-serif, system-ui, sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Hiragino Sans', 'Yu Gothic', 'Meiryo', 'Noto Sans JP', ui-sans-serif, system-ui, sans-serif;
            font-weight: 600;
        }
        .text-center {
            text-align: center;
        }
        .max-w-7xl {
            max-width: 80rem;
        }
        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }
        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .py-20 {
            padding-top: 5rem;
            padding-bottom: 5rem;
        }
        .mb-6 {
            margin-bottom: 1.5rem;
        }
        .mb-8 {
            margin-bottom: 2rem;
        }
        .text-4xl {
            font-size: 2.25rem;
            line-height: 2.5rem;
        }
        .text-6xl {
            font-size: 3.75rem;
            line-height: 1;
        }
        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem;
        }
        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }
        .text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }
        .font-bold {
            font-weight: 700;
        }
        .font-semibold {
            font-weight: 600;
        }
        .text-gray-900 {
            color: #111827;
        }
        .text-white {
            color: #ffffff;
        }
        .text-gray-600 {
            color: #4b5563;
        }
        .text-gray-300 {
            color: #d1d5db;
        }
        .text-purple-600 {
            color: #9333ea;
        }
        .text-purple-400 {
            color: #c084fc;
        }
        .bg-purple-600 {
            background-color: #9333ea;
        }
        .hover\\:bg-purple-700:hover {
            background-color: #7c3aed;
        }
        .text-white {
            color: #ffffff;
        }
        .px-8 {
            padding-left: 2rem;
            padding-right: 2rem;
        }
        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }
        .rounded-lg {
            border-radius: 0.5rem;
        }
        .transition-colors {
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
        .flex {
            display: flex;
        }
        .flex-col {
            flex-direction: column;
        }
        .sm\\:flex-row {
            flex-direction: row;
        }
        .gap-4 {
            gap: 1rem;
        }
        .justify-center {
            justify-content: center;
        }
        .items-center {
            align-items: center;
        }
        .justify-between {
            justify-content: space-between;
        }
        .h-16 {
            height: 4rem;
        }
        .bg-white\\/80 {
            background-color: rgba(255, 255, 255, 0.8);
        }
        .backdrop-blur-sm {
            backdrop-filter: blur(4px);
        }
        .border-b {
            border-bottom-width: 1px;
        }
        .border-purple-100 {
            border-color: #f3e8ff;
        }
        .dark\\:bg-zinc-900\\/80 {
            background-color: rgba(24, 24, 27, 0.8);
        }
        .dark\\:border-zinc-700 {
            border-color: #3f3f46;
        }
        .min-h-screen {
            min-height: 100vh;
        }
        .bg-gradient-to-br {
            background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
        }
        .from-purple-50 {
            --tw-gradient-from: #faf5ff;
            --tw-gradient-to: rgba(250, 245, 255, 0);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
        }
        .to-amber-50 {
            --tw-gradient-to: #fffbeb;
        }
        .dark\\:from-zinc-900 {
            --tw-gradient-from: #18181b;
            --tw-gradient-to: rgba(24, 24, 27, 0);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
        }
        .dark\\:to-zinc-800 {
            --tw-gradient-to: #27272a;
        }
        .overflow-hidden {
            overflow: hidden;
        }
        .relative {
            position: relative;
        }
        .max-w-3xl {
            max-width: 48rem;
        }
        .grid {
            display: grid;
        }
        .md\\:grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .lg\\:grid-cols-4 {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
        .gap-8 {
            gap: 2rem;
        }
        .p-6 {
            padding: 1.5rem;
        }
        .bg-white\\/80 {
            background-color: rgba(255, 255, 255, 0.8);
        }
        .dark\\:bg-zinc-900\\/80 {
            background-color: rgba(24, 24, 27, 0.8);
        }
        .rounded-2xl {
            border-radius: 1rem;
        }
        .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        .text-4xl {
            font-size: 2.25rem;
            line-height: 2.5rem;
        }
        .mb-4 {
            margin-bottom: 1rem;
        }
        .mb-2 {
            margin-bottom: 0.5rem;
        }
        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem;
        }
        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }
        .font-medium {
            font-weight: 500;
        }
        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        .rounded-md {
            border-radius: 0.375rem;
        }
        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .border {
            border-width: 1px;
        }
        .border-purple-600 {
            border-color: #9333ea;
        }
        .hover\\:bg-purple-50:hover {
            background-color: #faf5ff;
        }
        .dark\\:text-purple-400 {
            color: #c084fc;
        }
        .dark\\:hover\\:bg-purple-900\\/20:hover {
            background-color: rgba(147, 51, 234, 0.2);
        }
        .py-20 {
            padding-top: 5rem;
            padding-bottom: 5rem;
        }
        .bg-white\\/50 {
            background-color: rgba(255, 255, 255, 0.5);
        }
        .dark\\:bg-zinc-800\\/50 {
            background-color: rgba(39, 39, 42, 0.5);
        }
        .mb-16 {
            margin-bottom: 4rem;
        }
        .mb-4 {
            margin-bottom: 1rem;
        }
        .text-center {
            text-align: center;
        }
        .max-w-4xl {
            max-width: 56rem;
        }
        .py-8 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        .bg-gray-50 {
            background-color: #f9fafb;
        }
        .dark\\:bg-zinc-900 {
            background-color: #18181b;
        }
        .border-t {
            border-top-width: 1px;
        }
        .border-gray-200 {
            border-color: #e5e7eb;
        }
        .dark\\:border-zinc-700 {
            border-color: #3f3f46;
        }
        .text-gray-600 {
            color: #4b5563;
        }
        .dark\\:text-gray-400 {
            color: #9ca3af;
        }
        @media (min-width: 640px) {
            .sm\\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }
        @media (min-width: 1024px) {
            .lg\\:px-8 {
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }
        @media (min-width: 768px) {
            .md\\:text-6xl {
                font-size: 3.75rem;
                line-height: 1;
            }
        }
        @media (min-width: 640px) {
            .sm\\:flex-row {
                flex-direction: row;
            }
        }
        @media (min-width: 768px) {
            .md\\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        @media (min-width: 1024px) {
            .lg\\:grid-cols-4 {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }
    </style>
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
