<div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm p-5 border border-purple-100 dark:border-zinc-700 {{ !$canUse && $todayUsageCount > 0 ? 'opacity-40 blur-[2px] pointer-events-none' : '' }}">
    <!-- ヘッダー -->
    <div class="flex items-center mb-4">
        <span class="text-2xl mr-3">✨</span>
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">今日の褒めポイント</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">あなたの生年月日から今日の強みと活かし方を見つけましょう</p>
        </div>
    </div>

    @if($canUse || $todayUsageCount === 0)
        <!-- フォーム -->
        <div class="space-y-4">
            <!-- 実行ボタン -->
            <button wire:click="getStrengths" 
                    wire:loading.attr="disabled"
                    class="w-full bg-[#4e3291] hover:bg-[#9a89b4] disabled:opacity-50 disabled:cursor-not-allowed text-white px-4 py-2 rounded-lg font-medium transition-colors"
                    aria-label="今日の強みを取得">
                <span wire:loading.remove>強みを見つける</span>
                <span wire:loading>分析中...</span>
            </button>

            <!-- エラーメッセージ -->
            @error('general')
                <div class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</div>
            @enderror

            <!-- レスポンス -->
            @if($response && is_array($response))
                <div class="mt-4 p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-700">
                    @if(isset($response['title']))
                        <h4 class="text-lg font-semibold text-purple-900 dark:text-purple-100 mb-3">
                            {{ $response['title'] }}
                        </h4>
                    @endif
                    
                    @if(isset($response['body']))
                        <p class="text-purple-800 dark:text-purple-200 text-sm leading-relaxed mb-3">
                            {{ $response['body'] }}
                        </p>
                    @endif
                    
                    @if(isset($response['action']))
                        <div class="bg-purple-100 dark:bg-purple-800/50 p-3 rounded-lg">
                            <p class="text-purple-900 dark:text-purple-100 text-sm font-medium">
                                💡 {{ $response['action'] }}
                            </p>
                        </div>
                    @endif
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
