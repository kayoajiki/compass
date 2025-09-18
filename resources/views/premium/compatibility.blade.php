<x-layouts.app :title="'相性占い - FortuneCompass'">
    <div class="min-h-screen bg-gradient-to-br from-purple-50 to-amber-50 dark:from-zinc-900 dark:to-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    相性占い
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    有料会員限定の詳細な相性分析です
                </p>
            </div>
            
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-8">
                <div class="text-center">
                    <div class="text-6xl mb-4">💕</div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        有料機能にアクセス中
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        この機能は有料会員限定です。サブスクリプションにご加入いただき、ありがとうございます！
                    </p>
                    <a href="{{ route('dashboard') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        ダッシュボードに戻る
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
