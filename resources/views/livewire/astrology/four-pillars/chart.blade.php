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

            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
                @if($isLoading)
                    <!-- Loading state -->
                    <div class="flex items-center justify-center py-12">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600"></div>
                        <span class="ml-3 text-gray-600 dark:text-gray-300">四柱推命を計算中...</span>
                    </div>
                @else
                    <!-- Person Switcher -->
                    <x-person-switcher :selectedPersonId="$selectedPersonId" />

                    <!-- Header -->
                    <div class="text-center mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">四柱推命</h1>
                        <p class="text-gray-600 dark:text-gray-300">生年月日時から導き出す本質</p>
                    </div>

                    <!-- プロフィール情報が不完全な場合のメッセージ -->
                    @if($profileIncomplete)
                        <div class="mb-6 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-lg">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <h3 class="text-sm font-medium text-amber-800 dark:text-amber-200">プロフィール情報が不完全です</h3>
                                    <p class="mt-1 text-sm text-amber-700 dark:text-amber-300">
                                        四柱推命の正確な鑑定を行うためには、生年月日、出生時刻、出生地、性別の情報が必要です。
                                        現在はデモデータを表示しています。
                                    </p>
                                    <div class="mt-3">
                                        <a href="{{ route('settings.profile') }}" 
                                           class="inline-flex items-center px-3 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium rounded-md transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            プロフィール設定へ
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- 四柱推命表 -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">命式表</h2>
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border border-gray-300 dark:border-zinc-600" role="table" aria-label="四柱推命表">
                                <thead>
                                    <tr class="bg-purple-50 dark:bg-purple-900/20">
                                        <th scope="col" class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">柱</th>
                                        <th scope="col" class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">天干地支</th>
                                        <th scope="col" class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">蔵干</th>
                                        <th scope="col" class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">天干通変星</th>
                                        <th scope="col" class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">蔵干通変星</th>
                                        <th scope="col" class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">十二運星</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row" class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-zinc-800">年柱</th>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-lg font-bold text-purple-600 dark:text-purple-400">{{ $chartData['year']['stem'] }}{{ $chartData['year']['branch'] }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ implode('・', $chartData['year']['hiddenStems']) }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ $chartData['year']['stemTss'] ?? '' }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ implode('・', $chartData['year']['hiddenStemsTss']) }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ $chartData['year']['twelveStage'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-zinc-800">月柱</th>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-lg font-bold text-purple-600 dark:text-purple-400">{{ $chartData['month']['stem'] }}{{ $chartData['month']['branch'] }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ implode('・', $chartData['month']['hiddenStems']) }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ $chartData['month']['stemTss'] ?? '' }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ implode('・', $chartData['month']['hiddenStemsTss']) }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ $chartData['month']['twelveStage'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-zinc-800">日柱</th>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-lg font-bold text-purple-600 dark:text-purple-400">{{ $chartData['day']['stem'] }}{{ $chartData['day']['branch'] }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ implode('・', $chartData['day']['hiddenStems']) }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ $chartData['day']['stemTss'] ?? '' }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ implode('・', $chartData['day']['hiddenStemsTss']) }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ $chartData['day']['twelveStage'] ?? '' }}</td>
                                    </tr>
                                    @if($chartData['hour'])
                                    <tr>
                                        <th scope="row" class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-zinc-800">時柱</th>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-lg font-bold text-purple-600 dark:text-purple-400">{{ $chartData['hour']['stem'] }}{{ $chartData['hour']['branch'] }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ implode('・', $chartData['hour']['hiddenStems']) }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ $chartData['hour']['stemTss'] ?? '' }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ implode('・', $chartData['hour']['hiddenStemsTss']) }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ $chartData['hour']['twelveStage'] ?? '' }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 五行バランス -->
                    @if(!empty($fiveElementsCount))
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">五行バランス</h2>
                        <div class="grid grid-cols-5 gap-4 max-w-md mx-auto">
                            @foreach($fiveElementsCount as $element => $count)
                            <div class="text-center p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $count }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-300">{{ $element }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- 大運 -->
                    @if(!empty($daiun))
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">大運</h2>
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border border-gray-300 dark:border-zinc-600">
                                <thead>
                                    <tr class="bg-purple-50 dark:bg-purple-900/20">
                                        <th class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">年齢帯</th>
                                        <th class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">干支</th>
                                        <th class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">通変星</th>
                                        <th class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">十二運</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($daiun as $du)
                                    <tr>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ $du['start_age'] }}才〜{{ $du['end_age'] }}才</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm font-bold text-purple-600 dark:text-purple-400">{{ $du['pillar']['stem'] }}{{ $du['pillar']['branch'] }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ $du['tss'] ?? '' }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ $du['twelveStage'] ?? '' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- 年運 -->
                    @if(!empty($annual))
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">年運</h2>
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border border-gray-300 dark:border-zinc-600">
                                <thead>
                                    <tr class="bg-purple-50 dark:bg-purple-900/20">
                                        <th class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">西暦</th>
                                        <th class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">年干支</th>
                                        <th class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">通変星</th>
                                        <th class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">十二運</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($annual as $row)
                                    <tr>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ $row['year'] }}年</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm font-bold text-purple-600 dark:text-purple-400">{{ $row['pillar']['stem'] }}{{ $row['pillar']['branch'] }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ $row['tss'] }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ $row['twelveStage'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- 月運 -->
                    @if(!empty($monthly))
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">月運</h2>
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border border-gray-300 dark:border-zinc-600">
                                <thead>
                                    <tr class="bg-purple-50 dark:bg-purple-900/20">
                                        <th class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">西暦</th>
                                        <th class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">月</th>
                                        <th class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">月干支</th>
                                        <th class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">通変星</th>
                                        <th class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">十二運</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($monthly as $row)
                                    @php [$y,$m]=explode('-',$row['ym']); @endphp
                                    <tr>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ $y }}年</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ intval($m) }}月</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm font-bold text-purple-600 dark:text-purple-400">{{ $row['pillar']['stem'] }}{{ $row['pillar']['branch'] }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ $row['tss'] }}</td>
                                        <td class="border border-gray-300 dark:border-zinc-600 px-4 py-3 text-center text-sm text-gray-600 dark:text-gray-300">{{ $row['twelveStage'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- 鑑定サマリー -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 text-center">鑑定サマリー</h2>
                        <div class="bg-gradient-to-r from-purple-50 to-blue-50 dark:from-purple-900/20 dark:to-blue-900/20 rounded-lg p-6 border border-purple-200 dark:border-purple-700">
                            <div class="text-center mb-4">
                                <div class="inline-flex items-center px-4 py-2 bg-purple-100 dark:bg-purple-800 rounded-full text-purple-800 dark:text-purple-200 text-sm font-medium">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    基本情報
                                </div>
                            </div>
                            <div class="space-y-3 text-gray-700 dark:text-gray-300">
                                <p class="text-center">
                                    <span class="font-semibold text-purple-600 dark:text-purple-400">{{ $chartData['day']['stem'] }}{{ $chartData['day']['branch'] }}</span> 
                                    の日柱を持つあなたは、<span class="font-semibold">{{ $chartData['day']['stemTss'] ?? '比肩' }}</span>の性質が強く表れています。
                                </p>
                                <p class="text-center">
                                    五行バランスでは<span class="font-semibold text-purple-600 dark:text-purple-400">
                                    @if(isset($fiveElementsCount))
                                        @php
                                            $maxElement = array_keys($fiveElementsCount, max($fiveElementsCount));
                                            $minElement = array_keys($fiveElementsCount, min($fiveElementsCount));
                                        @endphp
                                        {{ $maxElement[0] }}({{ max($fiveElementsCount) }})が最も強く
                                    @else
                                        金(5)が最も強く
                                    @endif
                                    </span>、全体的にバランスの取れた命式となっています。
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- 区切り線 -->
                    <div class="border-t border-dashed border-gray-300 dark:border-gray-600 my-8"></div>
                    
                    <!-- ここから先の表示 -->
                    <div class="text-center mb-6">
                        <span class="text-gray-600 dark:text-gray-400 text-sm">ここから先は</span>
                    </div>
                    
                    <!-- 文字数と画像数の表示 -->
                    <div class="text-center mb-4">
                        <span class="text-gray-500 dark:text-gray-400 text-sm">412字 / 1画像</span>
                    </div>
                    
                    <!-- 価格表示 -->
                    <div class="text-center mb-6">
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">¥980</span>
                    </div>
                    
                    <!-- 透けて見えるコンテンツ -->
                    <div class="relative mb-8">
                        <!-- ぼかし効果を適用したコンテンツ -->
                        <div class="blur-sm select-none pointer-events-none opacity-60">
                            <div class="space-y-4 text-gray-700 dark:text-gray-300">
                                <p>
                                    <span class="font-semibold text-purple-600 dark:text-purple-400">{{ $chartData['day']['stem'] }}{{ $chartData['day']['branch'] }}</span>の日柱を持つあなたは、
                                    <span class="font-semibold">{{ $chartData['day']['stemTss'] ?? '比肩' }}</span>の性質により、協調性があり、人との調和を大切にする性格です。
                                </p>
                                <p>
                                    また、<span class="font-semibold">{{ $chartData['day']['twelveStage'] ?? '建禄' }}</span>の十二運星の影響で、
                                    物事に対して積極的で行動力のある一面も持っています。
                                </p>
                                <p>
                                    五行バランスから見ると、あなたの人生には
                                    @if(isset($fiveElementsCount))
                                        @php
                                            $maxElement = array_keys($fiveElementsCount, max($fiveElementsCount));
                                        @endphp
                                        <span class="font-semibold text-purple-600 dark:text-purple-400">{{ $maxElement[0] }}</span>の要素が強く影響し、
                                    @else
                                        <span class="font-semibold text-purple-600 dark:text-purple-400">金</span>の要素が強く影響し、
                                    @endif
                                    安定感と堅実さを重視する傾向があります。
                                </p>
                                
                                <!-- スコア表示セクション -->
                                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-zinc-700">
                                    <div class="grid grid-cols-5 gap-4">
                                        <div class="text-center">
                                            <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">94</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">総合運</div>
                                            <div class="h-1 bg-purple-600 rounded"></div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">89</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">恋愛運</div>
                                            <div class="h-1 bg-purple-600 rounded"></div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">82</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">仕事運</div>
                                            <div class="h-1 bg-purple-600 rounded"></div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">96</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">金運</div>
                                            <div class="h-1 bg-purple-600 rounded"></div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">87</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">健康運</div>
                                            <div class="h-1 bg-purple-600 rounded"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-6">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">開運アドバイス</h4>
                                    <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                                        <li class="flex items-start">
                                            <span class="text-purple-600 dark:text-purple-400 mr-2">•</span>
                                            <span>あなたの強みを活かすために、協調性を重視した環境で活動することをお勧めします。</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="text-purple-600 dark:text-purple-400 mr-2">•</span>
                                            <span>大運の流れを見ると、今後10年間は特に重要な転機が訪れる可能性があります。</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="text-purple-600 dark:text-purple-400 mr-2">•</span>
                                            <span>年運・月運の詳細な分析により、最適なタイミングで行動を起こすことができます。</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- オーバーレイ -->
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/80 to-white dark:via-zinc-900/80 dark:to-zinc-900"></div>
                    </div>
                    
                    <!-- 購入ボタン -->
                    <div class="text-center">
                        <a href="{{ route('four-pillars.reading') }}" 
                           class="inline-block w-full max-w-md bg-gray-800 hover:bg-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600 text-white font-medium py-4 px-6 rounded-lg transition-colors duration-200 text-center">
                            購入手続きへ
                        </a>
                    </div>

                @endif
            </div>
        </div>
    </div>
</div>