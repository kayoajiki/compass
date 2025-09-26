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
            color: #4e3291;
        }
        .text-purple-400 {
            color: #9a89b4;
        }
        .bg-purple-600 {
            background-color: #4e3291;
        }
        .hover\\:bg-purple-700:hover {
            background-color: #9a89b4;
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
            border-color: #9a89b4;
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
            --tw-gradient-from: #fffade;
            --tw-gradient-to: rgba(255, 250, 222, 0);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
        }
        .to-amber-50 {
            --tw-gradient-to: #fdf7ff;
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
            border-color: #4e3291;
        }
        .hover\\:bg-purple-50:hover {
            background-color: #fffade;
        }
        .dark\\:text-purple-400 {
            color: #9a89b4;
        }
        .dark\\:hover\\:bg-purple-900\\/20:hover {
            background-color: rgba(154, 137, 180, 0.2);
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
<body class="min-h-screen bg-gradient-to-br from-[#fffade] to-[#fdf7ff] dark:from-zinc-900 dark:to-zinc-800">
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-sm border-b border-[#9a89b4] dark:bg-zinc-900/80 dark:border-zinc-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-[#4e3291] dark:text-[#9a89b4]">FortuneCompass</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-[#4e3291] dark:text-gray-300 dark:hover:text-[#9a89b4] px-3 py-2 rounded-md text-sm font-medium">
                                ダッシュボード
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-[#4e3291] dark:text-gray-300 dark:hover:text-[#9a89b4] px-3 py-2 rounded-md text-sm font-medium">
                                ログイン
                            </a>
                            <a href="{{ route('register') }}" class="bg-[#4e3291] hover:bg-[#9a89b4] text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
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
                        人生の<span class="text-[#4e3291] dark:text-[#9a89b4]">羅針盤</span>占い
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto">
                    四柱推命・紫微斗数・西洋占星術・数秘術など複数の占術を横断し、<br>
                    あなたの人生の方向性を多角的に照らし出します
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-[#4e3291] hover:bg-[#9a89b4] text-white px-8 py-3 rounded-lg text-lg font-medium transition-colors">
                            ダッシュボードへ
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-[#4e3291] hover:bg-[#9a89b4] text-white px-8 py-3 rounded-lg text-lg font-medium transition-colors">
                            無料で始める
                        </a>
                        <a href="{{ route('login') }}" class="border border-[#4e3291] text-[#4e3291] hover:bg-[#fffade] dark:text-[#9a89b4] dark:hover:bg-zinc-800 px-8 py-3 rounded-lg text-lg font-medium transition-colors">
                            ログイン
                        </a>
                    @endauth
                </div>
            </div>
        </div>
        
        <!-- Decorative elements -->
        <div class="absolute top-20 right-10 w-20 h-20 bg-[#faeaff]/30 rounded-full blur-xl"></div>
        <div class="absolute bottom-20 left-10 w-32 h-32 bg-[#faeaff]/30 rounded-full blur-xl"></div>
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

    <!-- Customer Reviews Section -->
    <div class="py-20 bg-[#fdf7ff] dark:bg-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    お客様の声
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    実際にご利用いただいたお客様からの感想をご紹介します
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-[#4e3291] rounded-full flex items-center justify-center text-white font-bold text-lg">
                            A
                        </div>
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">田中さん（30代女性）</h4>
                            <div class="flex text-yellow-400">
                                ★★★★★
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">
                        「四柱推命と西洋占星術の両方で分析してもらえて、とても納得できる結果でした。今後の人生設計の参考になります。」
                    </p>
                </div>
                
                <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-[#4e3291] rounded-full flex items-center justify-center text-white font-bold text-lg">
                            B
                        </div>
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">佐藤さん（40代男性）</h4>
                            <div class="flex text-yellow-400">
                                ★★★★★
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">
                        「数秘術で自分の本質を知ることができました。仕事での人間関係が改善され、とても感謝しています。」
                    </p>
                </div>
                
                <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-[#4e3291] rounded-full flex items-center justify-center text-white font-bold text-lg">
                            C
                        </div>
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">山田さん（20代女性）</h4>
                            <div class="flex text-yellow-400">
                                ★★★★★
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">
                        「AIチャットボットがとても親切で、いつでも相談できるのが嬉しいです。恋愛の悩みも解決できました。」
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    よくある質問
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    サービスについてよくお寄せいただく質問にお答えします
                </p>
            </div>
            
            <div class="space-y-6">
                <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        Q. 無料でどの程度の鑑定ができますか？
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        A. 基本的な運勢や今日の運勢は無料でご利用いただけます。より詳細な鑑定や相性分析、AI生成レポートは有料プランでご利用いただけます。
                    </p>
                </div>
                
                <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        Q. 複数の占術を組み合わせるメリットは何ですか？
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        A. 各占術には得意分野があります。四柱推命は性格分析、西洋占星術は人間関係、数秘術は人生の方向性など、複数の角度から分析することで、より精度の高い鑑定が可能になります。
                    </p>
                </div>
                
                <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        Q. 個人情報は安全に管理されていますか？
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        A. はい、お客様の個人情報は暗号化され、厳重に管理されています。鑑定に必要な情報のみを使用し、第三者に提供することは一切ありません。
                    </p>
                </div>
                
                <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        Q. いつでも鑑定を受けられますか？
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        A. はい、24時間いつでもご利用いただけます。AIチャットボットも常時稼働しており、深夜でもお気軽にご相談ください。
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- How to Use Section -->
    <div class="py-20 bg-[#fffade] dark:bg-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    利用の流れ
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    簡単3ステップで、あなたの運勢をチェック
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-[#4e3291] rounded-full flex items-center justify-center text-white font-bold text-2xl mx-auto mb-6">
                        1
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">プロフィール登録</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        生年月日、出生時刻、出生地などの基本情報を入力してください
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-[#4e3291] rounded-full flex items-center justify-center text-white font-bold text-2xl mx-auto mb-6">
                        2
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">鑑定選択</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        四柱推命、西洋占星術、数秘術など、お好みの占術を選択してください
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-[#4e3291] rounded-full flex items-center justify-center text-white font-bold text-2xl mx-auto mb-6">
                        3
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">結果確認</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        詳細な鑑定結果とアドバイスを確認し、今後の参考にしてください
                    </p>
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
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-[#4e3291] hover:bg-[#9a89b4] text-white px-8 py-3 rounded-lg text-lg font-medium transition-colors">
                        ダッシュボードへ
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-[#4e3291] hover:bg-[#9a89b4] text-white px-8 py-3 rounded-lg text-lg font-medium transition-colors">
                        無料で始める
                    </a>
                    <a href="{{ route('login') }}" class="border border-[#4e3291] text-[#4e3291] hover:bg-[#fffade] dark:text-[#9a89b4] dark:hover:bg-zinc-800 px-8 py-3 rounded-lg text-lg font-medium transition-colors">
                        ログイン
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-50 dark:bg-zinc-900 border-t border-gray-200 dark:border-zinc-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-[#4e3291] rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">FC</span>
                        </div>
                        <span class="text-xl font-semibold text-gray-900 dark:text-white">FortuneCompass</span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-4 max-w-md">
                        四柱推命、紫微斗数、西洋占星術、数秘術など複数の占術を横断し、あなたの人生の羅針盤を提供するサービスです。
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-[#4e3291] transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-[#4e3291] transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-[#4e3291] transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Services -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">サービス</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('four-pillars.chart') }}" class="text-gray-600 dark:text-gray-300 hover:text-[#4e3291] transition-colors">四柱推命</a></li>
                        <li><a href="{{ route('ziwei.chart') }}" class="text-gray-600 dark:text-gray-300 hover:text-[#4e3291] transition-colors">紫微斗数</a></li>
                        <li><a href="{{ route('western.chart') }}" class="text-gray-600 dark:text-gray-300 hover:text-[#4e3291] transition-colors">西洋占星術</a></li>
                        <li><a href="{{ route('numerology.chart') }}" class="text-gray-600 dark:text-gray-300 hover:text-[#4e3291] transition-colors">数秘術</a></li>
                        <li><a href="{{ route('compatibility.chart') }}" class="text-gray-600 dark:text-gray-300 hover:text-[#4e3291] transition-colors">相性占い</a></li>
                    </ul>
                </div>
                
                <!-- Support -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">サポート</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 dark:text-gray-300 hover:text-[#4e3291] transition-colors">よくある質問</a></li>
                        <li><a href="#" class="text-gray-600 dark:text-gray-300 hover:text-[#4e3291] transition-colors">お問い合わせ</a></li>
                        <li><a href="#" class="text-gray-600 dark:text-gray-300 hover:text-[#4e3291] transition-colors">利用規約</a></li>
                        <li><a href="#" class="text-gray-600 dark:text-gray-300 hover:text-[#4e3291] transition-colors">プライバシーポリシー</a></li>
                        <li><a href="{{ route('pricing') }}" class="text-gray-600 dark:text-gray-300 hover:text-[#4e3291] transition-colors">料金プラン</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-200 dark:border-zinc-700 mt-8 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                        &copy; 2024 FortuneCompass. All rights reserved.
                    </p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-[#4e3291] text-sm transition-colors">利用規約</a>
                        <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-[#4e3291] text-sm transition-colors">プライバシーポリシー</a>
                        <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-[#4e3291] text-sm transition-colors">Cookie設定</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
