<div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
    @if($isLoading)
        <!-- Loading state -->
        <div class="flex items-center justify-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600"></div>
            <span class="ml-3 text-gray-600 dark:text-gray-300">運勢を読み込んでいます...</span>
        </div>
    @else
        <!-- Header -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                今日の運勢
            </h2>
            <p class="text-gray-600 dark:text-gray-300">
                {{ isset($fortuneData['date']) ? \Carbon\Carbon::parse($fortuneData['date'])->format('Y年m月d日') : now()->format('Y年m月d日') }}
            </p>
        </div>

        <!-- Total Score -->
        <div class="text-center mb-6">
            <div class="text-5xl font-bold text-purple-600 dark:text-purple-400 mb-2">
                {{ $fortuneData['total_score'] ?? 0 }}
                <span class="text-2xl text-gray-500 dark:text-gray-400">/100</span>
            </div>
            <p class="text-lg text-gray-700 dark:text-gray-300 mb-4">
                {{ $this->getScoreMessage() }}
            </p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-6">
            <div class="w-full bg-gray-200 dark:bg-zinc-700 rounded-full h-3">
                <div 
                    class="bg-gradient-to-r from-purple-500 to-purple-600 h-3 rounded-full transition-all duration-1000 ease-out"
                    style="width: {{ $fortuneData['total_score'] ?? 0 }}%"
                ></div>
            </div>
        </div>

        <!-- Categories -->
        <div class="grid grid-cols-5 gap-3 mb-6">
            @foreach(['love', 'study', 'money', 'health', 'work'] as $category)
                <div class="text-center p-3 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                    <div class="text-2xl mb-2">
                        {{ $this->getCategoryIcon($category) }}
                    </div>
                    <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-2">
                        {{ $this->getCategoryName($category) }}
                    </h3>
                    <div class="flex justify-center space-x-1">
                        @for($i = 1; $i <= 5; $i++)
                            <div class="w-3 h-3 rounded-full {{ $i <= ($fortuneData['categories'][$category] ?? 0) ? 'bg-purple-500' : 'bg-gray-300 dark:bg-zinc-600' }}"></div>
                        @endfor
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Action Button -->
        <div class="text-center">
            <button 
                wire:click="loadFortuneData"
                class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors"
            >
                運勢を更新
            </button>
        </div>
    @endif
</div>