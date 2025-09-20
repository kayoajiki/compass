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
                <div class="overflow-x-auto">
                    <table class="w-full" role="table">
                        <!-- 曜日ヘッダー -->
                        <thead>
                            <tr class="bg-gray-100 dark:bg-zinc-800" role="row">
                                <th scope="col" class="px-2 py-3 text-center text-sm font-medium text-red-600 dark:text-red-400 border-r border-gray-200 dark:border-zinc-600">日</th>
                                <th scope="col" class="px-2 py-3 text-center text-sm font-medium text-gray-900 dark:text-white border-r border-gray-200 dark:border-zinc-600">月</th>
                                <th scope="col" class="px-2 py-3 text-center text-sm font-medium text-gray-900 dark:text-white border-r border-gray-200 dark:border-zinc-600">火</th>
                                <th scope="col" class="px-2 py-3 text-center text-sm font-medium text-gray-900 dark:text-white border-r border-gray-200 dark:border-zinc-600">水</th>
                                <th scope="col" class="px-2 py-3 text-center text-sm font-medium text-gray-900 dark:text-white border-r border-gray-200 dark:border-zinc-600">木</th>
                                <th scope="col" class="px-2 py-3 text-center text-sm font-medium text-gray-900 dark:text-white border-r border-gray-200 dark:border-zinc-600">金</th>
                                <th scope="col" class="px-2 py-3 text-center text-sm font-medium text-blue-600 dark:text-blue-400">土</th>
                            </tr>
                        </thead>
                        
                        <!-- 月間カレンダー -->
                        <tbody>
                            @php
                                $firstDay = now()->startOfMonth();
                                $lastDay = now()->endOfMonth();
                                $startDate = $firstDay->copy()->startOfWeek(\Carbon\Carbon::SUNDAY);
                                $endDate = $lastDay->copy()->endOfWeek(\Carbon\Carbon::SATURDAY);
                                $currentDate = $startDate->copy();
                            @endphp
                            
                            @while($currentDate->lte($endDate))
                                <tr role="row">
                                    @for($i = 0; $i < 7; $i++)
                                        @php
                                            $isCurrentMonth = $currentDate->month === now()->month;
                                            $isToday = $currentDate->isToday();
                                            $isWeekend = $currentDate->isWeekend();
                                            
                                            // Mock data for Step 5
                                            $dayNumber = abs($currentDate->diffInDays(\Carbon\Carbon::parse('1900-01-01')));
                                            $rokuyo = ['大安', '赤口', '先勝', '友引', '先負', '仏滅'][$dayNumber % 6];
                                            $tenkan = ['甲', '乙', '丙', '丁', '戊', '己', '庚', '辛', '壬', '癸'][$dayNumber % 10];
                                            $chishi = ['子', '丑', '寅', '卯', '辰', '巳', '午', '未', '申', '酉', '戌', '亥'][$dayNumber % 12];
                                            $tsuhensei = ['比肩', '劫財', '食神', '傷官', '偏財', '正財', '偏官', '正官', '偏印', '正印'][$dayNumber % 10];
                                            $juuniun = ['長生', '沐浴', '冠帯', '建禄', '帝旺', '衰', '病', '死', '墓', '絶', '胎', '養'][$dayNumber % 12];
                                            $luckRank = ['大吉', '吉', '中吉', '小吉', '凶'][$dayNumber % 5];
                                        @endphp
                                        
                                        <td class="px-1 py-3 text-center border-r border-b border-gray-200 dark:border-zinc-600 w-1/7 min-w-[100px]
                                                   {{ $isToday ? 'bg-yellow-100 dark:bg-yellow-900/20' : ($isCurrentMonth ? 'bg-white dark:bg-zinc-900' : 'bg-gray-50 dark:bg-zinc-800') }}
                                                   {{ $currentDate->dayOfWeek === 0 ? 'border-l border-gray-200 dark:border-zinc-600' : '' }}"
                                            aria-label="{{ $currentDate->format('Y年n月j日') }}（{{ ['日', '月', '火', '水', '木', '金', '土'][$currentDate->dayOfWeek] }}） {{ $rokuyo }}／{{ $tenkan }}・{{ $chishi }}／{{ $tsuhensei }}／{{ $juuniun }}／{{ $luckRank }}">
                                            
                                            @if($isCurrentMonth)
                                                <!-- 日付（右上） -->
                                                <div class="text-right mb-1">
                                                    <span class="text-sm font-bold {{ $currentDate->dayOfWeek === 0 ? 'text-red-600 dark:text-red-400' : ($currentDate->dayOfWeek === 6 ? 'text-blue-600 dark:text-blue-400' : 'text-gray-900 dark:text-white') }}">
                                                        {{ $currentDate->day }}
                                                    </span>
                                                </div>

                                                <!-- 六曜（左上） -->
                                                <div class="text-left mb-1 h-3 flex items-center">
                                                    <span class="text-xs {{ $rokuyo === '大安' ? 'text-red-600 dark:text-red-400' : ($rokuyo === '仏滅' ? 'text-gray-500 dark:text-gray-400' : 'text-gray-900 dark:text-white') }}">
                                                        {{ $rokuyo }}
                                                    </span>
                                                </div>

                                                <!-- 祝日名（固定高さで段落揃え） -->
                                                <div class="text-left mb-1 h-3 flex items-center">
                                                    @php
                                                        $holidayService = new \App\Domain\Calendar\Services\JapaneseHolidayService();
                                                        $holiday = $holidayService->getDayHoliday($currentDate);
                                                    @endphp
                                                    @if($holiday)
                                                        <span class="text-xs font-medium text-red-600 dark:text-red-400">
                                                            {{ $holiday }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- 十干・十二支 -->
                                                <div class="text-left mb-1 h-3 flex items-center">
                                                    <span class="text-xs text-gray-700 dark:text-gray-300">
                                                        {{ $tenkan }} {{ $chishi }}
                                                    </span>
                                                </div>

                                                <!-- 通変星 -->
                                                <div class="text-left mb-1 h-3 flex items-center">
                                                    <span class="text-xs text-gray-700 dark:text-gray-300">
                                                        {{ $tsuhensei }}
                                                    </span>
                                                </div>

                                                <!-- 十二運 -->
                                                <div class="text-left mb-1 h-3 flex items-center">
                                                    <span class="text-xs text-gray-700 dark:text-gray-300">
                                                        {{ $juuniun }}
                                                    </span>
                                                </div>

                                                <!-- 運勢ランク -->
                                                <div class="text-left h-3 flex items-center">
                                                    <span class="text-xs font-semibold {{ $luckRank === '大吉' ? 'text-red-600 dark:text-red-400' : ($luckRank === '凶' ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white') }}">
                                                        {{ $luckRank }}
                                                    </span>
                                                </div>
                                            @else
                                                <span class="text-xs text-gray-400 dark:text-gray-500">
                                                    {{ $currentDate->day }}
                                                </span>
                                            @endif
                                        </td>
                                        
                                        @php $currentDate->addDay(); @endphp
                                    @endfor
                                </tr>
                            @endwhile
                        </tbody>
                    </table>
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
