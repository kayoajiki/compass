<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>紫微斗数命盤</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/ziwei.css') }}">
    <style>
        @media print {
            body { margin: 0; }
            .page-break { page-break-before: always; }
        }
    </style>
</head>
<body class="bg-white">
    <div class="p-8">
        <!-- ヘッダー -->
        <div class="text-center mb-8 border-b pb-4">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">紫微斗数命盤</h1>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                <div><span class="font-semibold">生年月日:</span> {{ $chart['meta']['input_date'] }}</div>
                <div><span class="font-semibold">出生時間:</span> {{ $chart['meta']['input_time'] }}</div>
                <div><span class="font-semibold">地方時:</span> {{ $chart['meta']['local_time'] }}</div>
                <div><span class="font-semibold">旧暦:</span> {{ $chart['meta']['lunar']['year'] }}年{{ $chart['meta']['lunar']['month'] }}月{{ $chart['meta']['lunar']['day'] }}日</div>
                <div><span class="font-semibold">年干支:</span> {{ $chart['meta']['lunar']['year_ganzhi'] }}</div>
                <div><span class="font-semibold">時支:</span> {{ $chart['meta']['lunar']['time_branch'] }}</div>
            </div>
        </div>

        <!-- 命盤 -->
        <div class="mb-8">
            <div class="grid grid-cols-4 gap-2 mb-6">
                @foreach($chart['palaces'] as $index => $palace)
                    <div class="border-2 border-gray-300 rounded-lg p-3 text-center min-h-[120px] relative
                        @if($palace['name'] === '命宮') bg-yellow-50 border-yellow-400 @endif">
                        
                        <!-- 上段: 地支と宮名 -->
                        <div class="text-xs font-bold text-gray-700 mb-1">
                            {{ $palace['zhi'] }}
                        </div>
                        <div class="text-xs font-semibold text-gray-800 mb-2">
                            {{ $palace['name'] }}
                        </div>
                        <div class="text-xs text-gray-600 mb-2">
                            {{ $palace['stem'] ?? '?' }}
                        </div>

                        <!-- 中段: 主星 -->
                        <div class="mb-2">
                            @if(isset($palace['stars']))
                                @foreach($palace['stars'] as $star)
                                    @if($star['type'] === 'main')
                                        <div class="text-sm font-bold text-red-600 mb-1 relative">
                                            {{ $star['label'] }}
                                            @if(isset($star['transform']))
                                                <span class="absolute -top-1 -right-1 text-xs px-1 py-0.5 rounded
                                                    @if($star['transform'] === '禄') bg-green-100 text-green-800
                                                    @elseif($star['transform'] === '権') bg-purple-100 text-purple-800
                                                    @elseif($star['transform'] === '科') bg-blue-100 text-blue-800
                                                    @elseif($star['transform'] === '忌') bg-red-100 text-red-800
                                                    @endif">
                                                    {{ $star['transform'] }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>

                        <!-- 下段: 副星 -->
                        <div class="text-xs">
                            @if(isset($palace['stars']))
                                @foreach($palace['stars'] as $star)
                                    @if($star['type'] !== 'main')
                                        <div class="mb-1 
                                            @if($star['type'] === 'lucky') text-blue-600
                                            @elseif($star['type'] === 'malefic') text-red-600
                                            @endif">
                                            {{ $star['label'] }}
                                            @if(isset($star['transform']))
                                                <span class="ml-1 text-xs px-1 py-0.5 rounded
                                                    @if($star['transform'] === '禄') bg-green-100 text-green-800
                                                    @elseif($star['transform'] === '権') bg-purple-100 text-purple-800
                                                    @elseif($star['transform'] === '科') bg-blue-100 text-blue-800
                                                    @elseif($star['transform'] === '忌') bg-red-100 text-red-800
                                                    @endif">
                                                    {{ $star['transform'] }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- 中央の情報エリア -->
            <div class="text-center">
                <div class="bg-gray-50 rounded-lg p-6 max-w-md mx-auto">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">基本情報</h3>
                    <div class="space-y-2 text-sm">
                        <div><span class="font-semibold">五行局:</span> {{ $chart['meta']['five_elements_ju'] }}</div>
                        <div><span class="font-semibold">命宮:</span> {{ $chart['meta']['ming_palace'] }}</div>
                        <div><span class="font-semibold">総星数:</span> {{ $chart['statistics']['total_stars'] }}個</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 四化情報 -->
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4">四化（禄権科忌）</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach(['禄', '権', '科', '忌'] as $transformType)
                    <div class="border rounded-lg p-4 text-center
                        @if($transformType === '禄') border-green-300 bg-green-50
                        @elseif($transformType === '権') border-purple-300 bg-purple-50
                        @elseif($transformType === '科') border-blue-300 bg-blue-50
                        @elseif($transformType === '忌') border-red-300 bg-red-50
                        @endif">
                        <div class="font-bold text-lg mb-2">{{ $transformType }}</div>
                        @php
                            $transformStars = collect($chart['transforms'])->where('type', $transformType);
                        @endphp
                        @if($transformStars->count() > 0)
                            @foreach($transformStars as $transform)
                                <div class="text-sm">{{ $transform['star'] }}</div>
                                <div class="text-xs text-gray-600">{{ $transform['palace'] }}</div>
                            @endforeach
                        @else
                            <div class="text-sm text-gray-500">なし</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 凡例 -->
        <div class="border-t pt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">凡例</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                <div>
                    <h4 class="font-semibold mb-2">星の種類</h4>
                    <ul class="space-y-1">
                        <li><span class="text-red-600">● 主星</span> - 14主星（紫微、天府など）</li>
                        <li><span class="text-blue-600">● 吉星</span> - 六吉星（左輔、右弼など）</li>
                        <li><span class="text-red-600">● 凶星</span> - 四煞星（擎羊、陀羅など）</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-2">四化</h4>
                    <ul class="space-y-1">
                        <li><span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">禄</span> - 財運・才能</li>
                        <li><span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">権</span> - 権力・地位</li>
                        <li><span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">科</span> - 名声・学問</li>
                        <li><span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">忌</span> - 障害・困難</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-2">十二宮</h4>
                    <ul class="space-y-1 text-xs">
                        <li>命宮 - 性格・才能</li>
                        <li>父母宮 - 両親・上司</li>
                        <li>福德宮 - 精神・趣味</li>
                        <li>田宅宮 - 不動産・家庭</li>
                        <li>官祿宮 - 仕事・地位</li>
                        <li>僕役宮 - 部下・友人</li>
                        <li>遷移宮 - 旅行・移動</li>
                        <li>疾厄宮 - 健康・病気</li>
                        <li>財帛宮 - 金運・財産</li>
                        <li>子女宮 - 子供・部下</li>
                        <li>夫妻宮 - 配偶者・結婚</li>
                        <li>兄弟宮 - 兄弟・友人</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- フッター -->
        <div class="mt-8 pt-4 border-t text-center text-xs text-gray-500">
            <p>Generated by FortuneCompass - {{ now()->format('Y年m月d日 H:i') }}</p>
        </div>
    </div>
</body>
</html>
