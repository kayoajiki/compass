<x-layouts.app :title="'詳細運勢カレンダー - FortuneCompass'">
    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    詳細運勢カレンダー
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    あなた専用の詳細な運勢分析とアドバイス
                </p>
            </div>

            @if(!auth()->user()->hasActiveSubscription())
                <!-- Non-subscriber view -->
                <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                    <div class="text-center py-12">
                        <div class="mb-6">
                            <div class="w-20 h-20 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">サブスクリプションが必要です</h2>
                            <p class="text-gray-600 dark:text-gray-300 mb-6">
                                詳細運勢カレンダーをご覧いただくには、<br>
                                月額プランまたは年額プランへのご加入が必要です
                            </p>
                        </div>
                        
                        <div class="space-y-4">
                            <a href="{{ route('pricing') }}" class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg font-medium transition-colors">
                                料金プランを見る
                            </a>
                            <div>
                                <a href="{{ route('calendar.chart') }}" class="text-purple-600 hover:text-purple-500 dark:text-purple-400 dark:hover:text-purple-300 text-sm underline">
                                    基本カレンダーに戻る
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Subscriber view -->
                <div class="space-y-8">
                    <!-- Detailed Calendar -->
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">詳細運勢カレンダー</h2>
                        
                        <!-- Advanced Calendar with detailed fortune -->
                        <div class="grid grid-cols-7 gap-2 mb-6">
                            <!-- Day headers -->
                            <div class="text-center text-sm font-medium text-gray-500 dark:text-gray-400 py-2">日</div>
                            <div class="text-center text-sm font-medium text-gray-500 dark:text-gray-400 py-2">月</div>
                            <div class="text-center text-sm font-medium text-gray-500 dark:text-gray-400 py-2">火</div>
                            <div class="text-center text-sm font-medium text-gray-500 dark:text-gray-400 py-2">水</div>
                            <div class="text-center text-sm font-medium text-gray-500 dark:text-gray-400 py-2">木</div>
                            <div class="text-center text-sm font-medium text-gray-500 dark:text-gray-400 py-2">金</div>
                            <div class="text-center text-sm font-medium text-gray-500 dark:text-gray-400 py-2">土</div>

                            <!-- Calendar days with detailed fortune -->
                            @for($day = 1; $day <= 31; $day++)
                                @php
                                    $date = now()->setDay($day);
                                    $isToday = $date->isToday();
                                    $isWeekend = $date->isWeekend();
                                    $fortuneLevel = rand(1, 5);
                                    $luckyColor = ['red', 'blue', 'green', 'yellow', 'purple'][rand(0, 4)];
                                    $luckyNumber = rand(1, 99);
                                @endphp
                                <div class="relative group">
                                    <div class="aspect-square flex items-center justify-center text-sm font-medium rounded-lg border cursor-pointer hover:shadow-md transition-shadow
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

                                    <!-- Tooltip on hover -->
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity z-10 whitespace-nowrap">
                                        <div>ラッキーカラー: {{ $luckyColor }}</div>
                                        <div>ラッキーナンバー: {{ $luckyNumber }}</div>
                                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Monthly Analysis -->
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">今月の運勢分析</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Good Days -->
                            <div class="p-6 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                <h3 class="text-lg font-semibold text-green-900 dark:text-green-100 mb-3">吉日</h3>
                                <ul class="space-y-2">
                                    <li class="text-green-800 dark:text-green-200">5日（月） - 新しいスタートに最適</li>
                                    <li class="text-green-800 dark:text-green-200">12日（月） - 重要な決断の日</li>
                                    <li class="text-green-800 dark:text-green-200">18日（日） - 人間関係の運気上昇</li>
                                    <li class="text-green-800 dark:text-green-200">25日（日） - 金運が最高潮</li>
                                </ul>
                            </div>

                            <!-- Caution Days -->
                            <div class="p-6 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                <h3 class="text-lg font-semibold text-red-900 dark:text-red-100 mb-3">要注意日</h3>
                                <ul class="space-y-2">
                                    <li class="text-red-800 dark:text-red-200">8日（木） - 健康管理に注意</li>
                                    <li class="text-red-800 dark:text-red-200">15日（木） - 大きな支出は避ける</li>
                                    <li class="text-red-800 dark:text-red-200">22日（木） - 人間関係に配慮</li>
                                    <li class="text-red-800 dark:text-red-200">29日（木） - 慎重な行動を心がける</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Personalized Advice -->
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">あなたへの特別なアドバイス</h2>
                        
                        <div class="space-y-4">
                            <div class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                <h3 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">今月のテーマ</h3>
                                <p class="text-purple-800 dark:text-purple-200">「新しい挑戦」が今月のキーワードです。これまで躊躇していたことに勇気を出して取り組んでみてください。</p>
                            </div>
                            
                            <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                <h3 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">ラッキーアイテム</h3>
                                <p class="text-blue-800 dark:text-blue-200">青いアクセサリーを身につけることで、あなたの直感力が高まり、良い判断ができるようになります。</p>
                            </div>
                            
                            <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                                <h3 class="font-semibold text-yellow-900 dark:text-yellow-100 mb-2">運気アップの方法</h3>
                                <p class="text-yellow-800 dark:text-yellow-200">朝日を浴びながらの散歩や、感謝の気持ちを込めた瞑想が、あなたの運気をさらに高めてくれます。</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="text-center">
                        <a href="{{ route('calendar.chart') }}" class="inline-block border border-purple-600 text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-purple-900/20 px-6 py-2 rounded-lg font-medium transition-colors">
                            基本カレンダーに戻る
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
