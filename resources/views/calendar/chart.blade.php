<div class="min-h-screen bg-gray-50 dark:bg-zinc-900">
    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back to Dashboard Button -->
            <div class="mb-6">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    ダッシュボードに戻る
                </a>
            </div>

            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    運勢カレンダー
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    あなたの日々の運勢をカレンダー形式で確認できます
                </p>
            </div>

            <!-- Calendar Widget -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6 mb-8">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">今月の運勢</h2>
                    <p class="text-gray-600 dark:text-gray-300">{{ now()->format('Y年n月') }}</p>
                </div>

                <!-- Calendar Grid -->
                <div class="grid grid-cols-7 gap-2 mb-4">
                    <!-- Day headers -->
                    <div class="text-center text-sm font-medium text-gray-500 dark:text-gray-400 py-2">日</div>
                    <div class="text-center text-sm font-medium text-gray-500 dark:text-gray-400 py-2">月</div>
                    <div class="text-center text-sm font-medium text-gray-500 dark:text-gray-400 py-2">火</div>
                    <div class="text-center text-sm font-medium text-gray-500 dark:text-gray-400 py-2">水</div>
                    <div class="text-center text-sm font-medium text-gray-500 dark:text-gray-400 py-2">木</div>
                    <div class="text-center text-sm font-medium text-gray-500 dark:text-gray-400 py-2">金</div>
                    <div class="text-center text-sm font-medium text-gray-500 dark:text-gray-400 py-2">土</div>

                    <!-- Calendar days -->
                    @for($day = 1; $day <= 31; $day++)
                        @php
                            $date = now()->setDay($day);
                            $isToday = $date->isToday();
                            $isWeekend = $date->isWeekend();
                            $fortuneLevel = rand(1, 5); // Mock data
                        @endphp
                        <div class="relative">
                            <div class="aspect-square flex items-center justify-center text-sm font-medium rounded-lg border
                                @if($isToday) bg-purple-100 border-purple-300 text-purple-900 dark:bg-purple-900/30 dark:border-purple-700 dark:text-purple-100 @endif
                                @if($isWeekend && !$isToday) bg-gray-50 border-gray-200 text-gray-600 dark:bg-zinc-800 dark:border-zinc-600 dark:text-zinc-300 @endif
                                @if(!$isToday && !$isWeekend) bg-white border-gray-200 text-gray-900 dark:bg-zinc-900 dark:border-zinc-700 dark:text-white @endif">
                                {{ $day }}
                            </div>
                            
                            <!-- Fortune indicator -->
                            <div class="absolute -top-1 -right-1 w-3 h-3 rounded-full
                                @if($fortuneLevel >= 4) bg-green-400 @endif
                                @if($fortuneLevel == 3) bg-yellow-400 @endif
                                @if($fortuneLevel <= 2) bg-red-400 @endif">
                            </div>
                        </div>
                    @endfor
                </div>

                <!-- Legend -->
                <div class="flex justify-center space-x-6 text-sm">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-400 rounded-full mr-2"></div>
                        <span class="text-gray-600 dark:text-gray-300">大吉</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-yellow-400 rounded-full mr-2"></div>
                        <span class="text-gray-600 dark:text-gray-300">中吉</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-red-400 rounded-full mr-2"></div>
                        <span class="text-gray-600 dark:text-gray-300">要注意</span>
                    </div>
                </div>
            </div>

            <!-- 今日の運勢（無料） -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">今日の運勢</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                        <div class="text-2xl mb-2">😊</div>
                        <h3 class="font-medium text-gray-900 dark:text-white mb-1">総合運</h3>
                        <div class="text-lg font-bold text-green-600">大吉</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                        <div class="text-2xl mb-2">💼</div>
                        <h3 class="font-medium text-gray-900 dark:text-white mb-1">仕事運</h3>
                        <div class="text-lg font-bold text-yellow-600">中吉</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                        <div class="text-2xl mb-2">💕</div>
                        <h3 class="font-medium text-gray-900 dark:text-white mb-1">恋愛運</h3>
                        <div class="text-lg font-bold text-green-600">大吉</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                        <div class="text-2xl mb-2">💰</div>
                        <h3 class="font-medium text-gray-900 dark:text-white mb-1">金運</h3>
                        <div class="text-lg font-bold text-yellow-600">中吉</div>
                    </div>
                </div>
            </div>

            <!-- 鑑定サマリー（無料） -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">鑑定サマリー</h2>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-center">
                    今月は全体的に運気が上昇傾向にあります。特に中旬から下旬にかけて、新しい出会いやチャンスが訪れる可能性が高いです。今日は総合運が大吉のため、重要な決断や行動に最適な日といえるでしょう。
                </p>
            </div>

            <!-- 点線区切り -->
            <div class="border-t-2 border-dashed border-gray-300 dark:border-gray-600 my-8"></div>

            <!-- note風ペイウォール -->
            <div class="text-center py-8">
                <div class="mb-6">
                    <p class="text-lg font-bold text-gray-900 dark:text-white mb-2">ここから先は</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">634字 / 1画像</p>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white mb-6">¥980</div>
                </div>
                
                <!-- ぼかし表示 -->
                <div class="relative mb-6">
                    <div class="opacity-30 blur-sm select-none pointer-events-none">
                        <div class="space-y-6 mb-8">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    週間運勢詳細
                                </h3>
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                    今週は特に月曜日と金曜日に運気のピークを迎えます。月曜日は新しいプロジェクトの開始に最適で、金曜日は人間関係の深化や重要な会議での成功が期待できます。水曜日は少し注意が必要で、重要な決断は避けることをお勧めします。
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    月間運勢の流れ
                                </h3>
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                    今月は上旬に新しい出会いが多く、中旬から下旬にかけて仕事運と金運が特に向上します。月末にかけては恋愛運も上昇し、既存の関係の深化や新しい恋の始まりが期待できるでしょう。特に28日から31日にかけては、重要な決断を行うのに最適な時期です。
                                </p>
                            </div>
                        </div>

                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">運勢スコア</h2>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                    <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Overall</div>
                                    <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">88</div>
                                    <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: 88%"></div>
                                    </div>
                                </div>
                                <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                    <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Career</div>
                                    <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">85</div>
                                    <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: 85%"></div>
                                    </div>
                                </div>
                                <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                    <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Love</div>
                                    <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">92</div>
                                    <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: 92%"></div>
                                    </div>
                                </div>
                                <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                    <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Money</div>
                                    <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">79</div>
                                    <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: 79%"></div>
                                    </div>
                                </div>
                                <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                    <div class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Health</div>
                                    <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">83</div>
                                    <div class="w-full bg-gray-200 dark:bg-zinc-600 rounded-full h-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: 83%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">開運アドバイス</h2>
                            <div class="space-y-4">
                                <div class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                    <h3 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">
                                        今月の一歩目
                                    </h3>
                                    <p class="text-purple-800 dark:text-purple-200">
                                        新しい人間関係を築くことに積極的に取り組むことで、運気がさらに上昇します。特に中旬以降は、重要な出会いやビジネスチャンスが訪れる可能性が高いでしょう。
                                    </p>
                                </div>
                                <div class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                    <h3 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">
                                        注意点
                                    </h3>
                                    <p class="text-purple-800 dark:text-purple-200">
                                        上旬は特に金運に注意が必要です。大きな投資や支出は避け、慎重な判断を心がけてください。また、水曜日は全体的に運気が低めなので、重要な決断は避けることをお勧めします。
                                    </p>
                                </div>
                                <div class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                    <h3 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">
                                        開運のポイント
                                    </h3>
                                    <p class="text-purple-800 dark:text-purple-200">
                                        朝の時間を有効活用し、東向きで朝日を浴びながら瞑想することで運気が活性化されます。また、緑色のアイテムを持つと、特に仕事運と金運の向上に効果的です。
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('pricing') }}" 
                   class="inline-block w-full max-w-xs mx-auto bg-gray-900 hover:bg-gray-800 text-white px-8 py-3 rounded-lg font-medium transition-colors"
                   aria-label="サブスク登録ページに移動">
                    購入手続きへ
                </a>
            </div>
        </div>
    </div>
</div>
