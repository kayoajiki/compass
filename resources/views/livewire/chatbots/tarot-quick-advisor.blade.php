<div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm p-5 border border-purple-100 dark:border-zinc-700 {{ !$canUse && $todayUsageCount > 0 ? 'opacity-40 blur-[2px] pointer-events-none' : '' }}">
    <!-- ヘッダー -->
    <div class="flex items-center mb-4">
        <span class="text-2xl mr-3">🃏</span>
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">タロット簡易アドバイス</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">日々の悩みや疑問をタロットで占ってみましょう</p>
        </div>
    </div>

    @if($canUse || $todayUsageCount === 0)
        <!-- フォーム -->
        <div class="space-y-4">
            <!-- 質問入力 -->
            <div>
                <label for="question" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">質問を入力してください</label>
                <textarea wire:model="question" 
                          id="question"
                          rows="3"
                          maxlength="200"
                          placeholder="例：転職すべきでしょうか？ 今日の運勢は？"
                          class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
                          aria-describedby="question-help"></textarea>
                <p id="question-help" class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    {{ strlen($question) }}/200文字
                </p>
            </div>

            <!-- 送信ボタン -->
            <button wire:click="submit" 
                    wire:loading.attr="disabled"
                    class="w-full bg-[#4e3291] hover:bg-[#9a89b4] disabled:opacity-50 disabled:cursor-not-allowed text-white px-4 py-2 rounded-lg font-medium transition-colors"
                    aria-label="タロット占いを実行">
                <span wire:loading.remove>タロットを引く</span>
                <span wire:loading>占い中...</span>
            </button>

            <!-- エラーメッセージ -->
            @error('general')
                <div class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</div>
            @enderror

            <!-- レスポンス -->
            @if($response && is_array($response))
                <div class="mt-4 p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-700">
                    @if(isset($response['card']))
                        <div class="text-center mb-3">
                            <h4 class="text-lg font-semibold text-purple-900 dark:text-purple-100 mb-1">
                                {{ $response['card'] }}
                                @if(isset($response['reversed']) && $response['reversed'])
                                    <span class="text-sm text-red-600 dark:text-red-400">（逆位置）</span>
                                @endif
                            </h4>
                        </div>
                    @endif
                    
                    @if(isset($response['keywords']) && is_array($response['keywords']))
                        <div class="flex flex-wrap gap-2 mb-3">
                            @foreach($response['keywords'] as $keyword)
                                <span class="px-2 py-1 bg-purple-100 dark:bg-purple-800 text-purple-800 dark:text-purple-200 text-xs rounded-full">
                                    {{ $keyword }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                    
                    @if(isset($response['advice']))
                        <p class="text-purple-800 dark:text-purple-200 text-sm leading-relaxed">
                            {{ $response['advice'] }}
                        </p>
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
