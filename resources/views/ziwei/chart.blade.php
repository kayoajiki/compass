<x-layouts.app.sidebar>

<x-slot>
<div class="min-h-screen bg-gradient-to-br from-purple-900 via-blue-900 to-indigo-900 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- ヘッダー -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-4">紫微斗数命盤</h1>
            <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-lg p-4 max-w-2xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-white text-sm">
                    <div>
                        <span class="font-semibold">生年月日:</span>
                        {{ $chart['meta']['input_date'] }}
                    </div>
                    <div>
                        <span class="font-semibold">出生時間:</span>
                        {{ $chart['meta']['input_time'] }}
                    </div>
                    <div>
                        <span class="font-semibold">地方時:</span>
                        {{ $chart['meta']['local_time'] }}
                    </div>
                    <div>
                        <span class="font-semibold">旧暦:</span>
                        {{ $chart['meta']['lunar']['year'] }}年{{ $chart['meta']['lunar']['month'] }}月{{ $chart['meta']['lunar']['day'] }}日
                    </div>
                    <div>
                        <span class="font-semibold">年干支:</span>
                        {{ $chart['meta']['lunar']['year_ganzhi'] }}
                    </div>
                    <div>
                        <span class="font-semibold">時支:</span>
                        {{ $chart['meta']['lunar']['time_branch'] }}
                    </div>
                </div>
            </div>
        </div>

        <!-- 命盤 -->
        <div class="bg-white rounded-lg shadow-2xl p-8 mb-8">
            <div class="ziwei-chart-container">
                <!-- 12宮の配置（3x4グリッド、中央2x2は空白） -->
                <div class="ziwei-palace-grid">
                    @foreach($chart['palaces'] as $index => $palace)
                        @php
                            // 12宮の配置を3x4グリッドで管理
                            // インデックス0-11を3x4グリッドに配置
                            $row = intval($index / 3);
                            $col = $index % 3;
                            $isCenter = ($row === 1 && $col === 1) || ($row === 2 && $col === 1);
                        @endphp
                        
                        @if($isCenter)
                            <!-- 中央空白 -->
                            <div class="ziwei-palace-center"></div>
                        @else
                            <!-- 各宮 -->
                            <div class="ziwei-palace ziwei-palace-{{ $index }} @if($palace['name'] === '命宮') ziwei-palace-ming @endif">
                                <div class="ziwei-palace-header">
                                    <div class="ziwei-zhi">{{ $palace['zhi'] }}</div>
                                    <div class="ziwei-palace-name">{{ $palace['name'] }}</div>
                                    <div class="ziwei-stem">{{ $palace['stem'] ?? '?' }}</div>
                                </div>

                                <div class="ziwei-main-stars">
                                    @if(isset($palace['stars']))
                                        @foreach($palace['stars'] as $star)
                                            @if($star['type'] === 'main')
                                                <div class="ziwei-main-star relative">
                                                    {{ $star['label'] }}
                                                    @if(isset($star['transform']))
                                                        <span class="ziwei-transform ziwei-transform-{{ $star['transform'] === '禄' ? 'lu' : ($star['transform'] === '権' ? 'quan' : ($star['transform'] === '科' ? 'ke' : 'ji')) }}">
                                                            {{ $star['transform'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>

                                <div class="ziwei-sub-stars">
                                    @if(isset($palace['stars']))
                                        @foreach($palace['stars'] as $star)
                                            @if($star['type'] !== 'main')
                                                <div class="ziwei-star ziwei-{{ $star['type'] }}-star relative">
                                                    {{ $star['label'] }}
                                                    @if(isset($star['transform']))
                                                        <span class="ziwei-transform ziwei-transform-{{ $star['transform'] === '禄' ? 'lu' : ($star['transform'] === '権' ? 'quan' : ($star['transform'] === '科' ? 'ke' : 'ji')) }}">
                                                            {{ $star['transform'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- 中央の情報エリア -->
                <div class="ziwei-center-panel">
                    <div class="ziwei-center-content">
                        <h3 class="ziwei-center-title">命盤情報</h3>
                        <div class="ziwei-center-info">
                            <div class="ziwei-center-item">
                                <span class="ziwei-center-label">五行局:</span> {{ $chart['meta']['five_elements_ju'] }}
                            </div>
                            <div class="ziwei-center-item">
                                <span class="ziwei-center-label">命宮:</span> {{ $chart['meta']['ming_palace'] }}
                            </div>
                            <div class="ziwei-center-item">
                                <span class="ziwei-center-label">総星数:</span> {{ $chart['statistics']['total_stars'] }}個
                            </div>
                        </div>
                        
                        <!-- 四化の凡例 -->
                        <div class="ziwei-transform-legend">
                            <h4 class="text-sm font-semibold mb-2">四化</h4>
                            <div class="flex flex-wrap gap-2 text-xs">
                                <span class="ziwei-transform ziwei-transform-lu">禄</span>
                                <span class="ziwei-transform ziwei-transform-quan">権</span>
                                <span class="ziwei-transform ziwei-transform-ke">科</span>
                                <span class="ziwei-transform ziwei-transform-ji">忌</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 四化情報 -->
        <div class="bg-white rounded-lg shadow-xl p-6 mb-8">
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

        <!-- アクションボタン -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
            <a href="{{ route('ziwei.index') }}" 
               class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition duration-150 text-center">
                新しい命盤を作成
            </a>
            
            <a href="{{ route('ziwei.pdf', request()->query()) }}" 
               target="_blank"
               class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition duration-150 text-center">
                PDF出力
            </a>
            
            <button onclick="window.print()" 
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-150">
                印刷
            </button>
        </div>

        <!-- 凡例 -->
        <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-lg p-6">
            <h3 class="text-lg font-semibold text-white mb-4">凡例</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-white text-sm">
                <div>
                    <h4 class="font-semibold mb-2">星の種類</h4>
                    <ul class="space-y-1">
                        <li><span class="text-red-400">● 主星</span> - 14主星（紫微、天府など）</li>
                        <li><span class="text-blue-400">● 吉星</span> - 六吉星（左輔、右弼など）</li>
                        <li><span class="text-red-400">● 凶星</span> - 四煞星（擎羊、陀羅など）</li>
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
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    .bg-gradient-to-br {
        background: white !important;
    }
}
</style>
</x-slot>
</x-layouts.app.sidebar>
