<x-layouts.app :title="'数秘術 詳細鑑定 - FortuneCompass'">
    <div class="min-h-screen bg-gradient-to-br from-purple-50 to-amber-50 dark:from-zinc-900 dark:to-zinc-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                <div class="text-center">
                    <div class="text-6xl mb-4">🔢</div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">数秘術 詳細鑑定</h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">有料会員限定の詳細な鑑定です</p>
                    <a href="{{ route('numerology.chart') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        盤面に戻る
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
