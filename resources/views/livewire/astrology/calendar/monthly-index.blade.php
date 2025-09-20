<div class="min-h-screen bg-gray-50 dark:bg-zinc-900">
    <div class="py-4 sm:py-6 lg:py-8">
        <div class="max-w-6xl mx-auto px-3 sm:px-4 lg:px-8">
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
            <div class="text-center mb-6 sm:mb-8">
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-2 sm:mb-4">
                    月間運勢カレンダー
                </h1>
                <p class="text-base sm:text-lg text-gray-600 dark:text-gray-300">
                    {{ Carbon\Carbon::parse($monthData['month'])->format('Y年n月') }}の運勢
                </p>
            </div>

            <!-- Monthly Calendar -->
            <div class="bg-white dark:bg-zinc-900 rounded-xl sm:rounded-2xl shadow-sm border border-gray-200 dark:border-zinc-700 overflow-hidden mb-6 sm:mb-8">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[700px]" role="table">
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
                            @foreach($monthData['weeks'] as $week)
                                <tr role="row">
                                    @foreach($week['days'] as $day)
                                        <td class="px-1 py-3 text-center border-r border-b border-gray-200 dark:border-zinc-600 w-1/7 min-w-[100px]
                                                   {{ $day['is_today'] ? 'bg-yellow-100 dark:bg-yellow-900/20' : ($day['is_current_month'] ? 'bg-white dark:bg-zinc-900' : 'bg-gray-50 dark:bg-zinc-800') }}
                                                   {{ $day['wday'] === 0 ? 'border-l border-gray-200 dark:border-zinc-600' : '' }}"
                                            aria-label="{{ Carbon\Carbon::parse($day['date'])->format('Y年n月j日') }}（{{ ['日', '月', '火', '水', '木', '金', '土'][$day['wday']] }}） {{ $day['rokuyo'] }}／{{ $day['kan'] }}・{{ $day['shi'] }}／{{ $day['tsuhensei'] }}／{{ $day['juuniun'] }}／{{ $day['luck_rank'] }}">
                                            
                                            @if($day['is_current_month'])
                                                <!-- 日付（右上） -->
                                                <div class="text-right mb-1">
                                                    <span class="text-sm font-bold {{ $day['wday'] === 0 ? 'text-red-600 dark:text-red-400' : ($day['wday'] === 6 ? 'text-blue-600 dark:text-blue-400' : 'text-gray-900 dark:text-white') }}">
                                                        {{ Carbon\Carbon::parse($day['date'])->day }}
                                                    </span>
                                                </div>

                                                <!-- 六曜（左上） -->
                                                <div class="text-left mb-1 h-3 flex items-center">
                                                    <span class="text-xs {{ $day['rokuyo'] === '大安' ? 'text-red-600 dark:text-red-400' : ($day['rokuyo'] === '仏滅' ? 'text-gray-500 dark:text-gray-400' : 'text-gray-900 dark:text-white') }}">
                                                        {{ $day['rokuyo'] }}
                                                    </span>
                                                </div>

                                                <!-- 祝日名（固定高さで段落揃え） -->
                                                <div class="text-left mb-1 h-3 flex items-center">
                                                    @if($day['holiday'])
                                                        <span class="text-xs font-medium text-red-600 dark:text-red-400">
                                                            {{ $day['holiday'] }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- 十干・十二支 -->
                                                <div class="text-left mb-1 h-3 flex items-center">
                                                    <span class="text-xs text-gray-700 dark:text-gray-300">
                                                        {{ $day['kan'] }} {{ $day['shi'] }}
                                                    </span>
                                                </div>

                                                <!-- 通変星 -->
                                                <div class="text-left mb-1 h-3 flex items-center">
                                                    <span class="text-xs text-gray-700 dark:text-gray-300">
                                                        {{ $day['tsuhensei'] }}
                                                    </span>
                                                </div>

                                                <!-- 十二運 -->
                                                <div class="text-left mb-1 h-3 flex items-center">
                                                    <span class="text-xs text-gray-700 dark:text-gray-300">
                                                        {{ $day['juuniun'] }}
                                                    </span>
                                                </div>

                                                <!-- 運勢ランク -->
                                                <div class="text-left h-3 flex items-center">
                                                    <span class="text-xs font-semibold {{ $day['luck_rank'] === '大吉' ? 'text-red-600 dark:text-red-400' : ($day['luck_rank'] === '凶' ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white') }}">
                                                        {{ $day['luck_rank'] }}
                                                    </span>
                                                </div>
                                            @else
                                                <span class="text-xs text-gray-400 dark:text-gray-500">
                                                    {{ Carbon\Carbon::parse($day['date'])->day }}
                                                </span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex flex-col sm:flex-row justify-center items-center gap-3 sm:gap-4">
                <div class="flex space-x-2 sm:space-x-4">
                    <button wire:click="prevMonth" 
                            class="flex items-center px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-600 rounded-md sm:rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        前月
                    </button>
                    
                    <button wire:click="thisMonth" 
                            class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-md sm:rounded-lg transition-colors">
                        今月
                    </button>
                    
                    <button wire:click="nextMonth" 
                            class="flex items-center px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-600 rounded-md sm:rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                        翌月
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 ml-1 sm:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
