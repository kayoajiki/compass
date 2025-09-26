<div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm p-5 border border-purple-100 dark:border-zinc-700 {{ !$canUse && $todayUsageCount > 0 ? 'opacity-40 blur-[2px] pointer-events-none' : '' }}">
    <!-- ヘッダー -->
    <div class="flex items-center mb-4">
        <span class="text-2xl mr-3">📝</span>
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">気分・日記のサポート</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">今日の気分を記録して、寄り添いのメッセージを受け取りましょう</p>
        </div>
    </div>

    @if($canUse || $todayUsageCount === 0)
        <!-- フォーム -->
        <div class="space-y-4">
            <!-- 気分スコア -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">今日の気分</label>
                <div class="flex space-x-2" role="radiogroup" aria-label="気分スコア選択">
                    @for($i = 1; $i <= 5; $i++)
                        <label class="cursor-pointer">
                            <input type="radio" 
                                   wire:model="moodScore" 
                                   value="{{ $i }}" 
                                   class="sr-only"
                                   aria-label="気分スコア{{ $i }}">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg transition-colors
                                       {{ $moodScore == $i ? 'bg-purple-600 text-white' : 'bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-zinc-700' }}">
                                @if($i == 1) 😢
                                @elseif($i == 2) 😕
                                @elseif($i == 3) 😐
                                @elseif($i == 4) 😊
                                @else 😄
                                @endif
                            </div>
                        </label>
                    @endfor
                </div>
            </div>

            <!-- 一言日記 -->
            <div>
                <label for="memo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">一言日記（任意）</label>
                <textarea wire:model="memo" 
                          id="memo"
                          rows="3"
                          maxlength="140"
                          placeholder="今日の出来事や気持ちを書いてみてください..."
                          class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
                          aria-describedby="memo-help"></textarea>
                <p id="memo-help" class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    {{ strlen($memo) }}/140文字
                </p>
            </div>

            <!-- 送信ボタン -->
            <button wire:click="submit" 
                    wire:loading.attr="disabled"
                    class="w-full bg-[#4e3291] hover:bg-[#9a89b4] disabled:opacity-50 disabled:cursor-not-allowed text-white px-4 py-2 rounded-lg font-medium transition-colors"
                    aria-label="気分と日記を送信">
                <span wire:loading.remove>送信する</span>
                <span wire:loading>送信中...</span>
            </button>

            <!-- エラーメッセージ -->
            @error('general')
                <div class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</div>
            @enderror

            <!-- レスポンス -->
            @if($response)
                <div class="mt-4 p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-700">
                    <h4 class="text-sm font-medium text-purple-900 dark:text-purple-100 mb-2">今日のメッセージ</h4>
                    <p class="text-purple-800 dark:text-purple-200 text-sm leading-relaxed">{{ $response }}</p>
                </div>
            @endif
        </div>
    @else
        <!-- 制限時の表示 -->
        <div class="text-center py-8">
            <div class="text-4xl mb-4">🔒</div>
            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">今日は1回まで</h4>
            <p class="text-gray-600 dark:text-gray-300 mb-4">サブスク登録で無制限にご利用いただけます</p>
            <a href="{{ route('pricing') }}" 
               class="inline-block bg-[#4e3291] hover:bg-[#9a89b4] text-white px-6 py-2 rounded-lg font-medium transition-colors"
               aria-label="サブスク登録ページに移動">
                サブスクに登録する
            </a>
        </div>
    @endif
</div>
