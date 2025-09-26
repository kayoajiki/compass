<div class="bg-white dark:bg-zinc-900 rounded-xl sm:rounded-2xl shadow-sm border border-[#9a89b4]/30 dark:border-zinc-700 p-4 sm:p-6">
    <div class="text-center mb-4">
        <div class="text-2xl sm:text-3xl mb-2 sm:mb-3">🤖</div>
        <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-1 sm:mb-2">AI相談ボット</h3>
        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mb-3 sm:mb-4">命式に基づく個別アドバイス</p>
    </div>

    <!-- テーマ選択 -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">相談テーマ</label>
        <select wire:model="theme" class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-[#4e3291] focus:border-transparent dark:bg-zinc-800 dark:text-white">
            @foreach($this->themes as $key => $label)
                <option value="{{ $key }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <!-- 質問入力 -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ご相談内容</label>
        <textarea 
            wire:model="question" 
            rows="3" 
            class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-[#4e3291] focus:border-transparent dark:bg-zinc-800 dark:text-white resize-none"
            placeholder="例：転職すべきか迷っています..."
        ></textarea>
        @error('question')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- 送信ボタン -->
    <button 
        wire:click="askQuestion" 
        wire:loading.attr="disabled"
        class="w-full bg-[#4e3291] hover:bg-[#9a89b4] disabled:bg-gray-400 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors"
    >
        <span wire:loading.remove>相談する</span>
        <span wire:loading>
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            分析中...
        </span>
    </button>

    <!-- 結果表示 -->
    @if($result)
        <div class="mt-6 p-4 bg-[#fdf7ff] dark:bg-zinc-800 rounded-lg border border-[#9a89b4]/20">
            <div class="flex justify-between items-start mb-3">
                <h4 class="font-semibold text-gray-900 dark:text-white">{{ $result['title'] }}</h4>
                <button wire:click="clearResult" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                {{ $result['message'] }}
            </div>
        </div>
    @endif

    <!-- エラー表示 -->
    @if($error)
        <div class="mt-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg">
            <p class="text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
        </div>
    @endif
</div>