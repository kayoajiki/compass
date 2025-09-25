<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>四柱推命デモ</title>
    <style>
        body {
            font-family: 'Hiragino Sans', 'ヒラギノ角ゴシック', 'Yu Gothic', 'メイリオ', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .fp {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .fp th, .fp td {
            border: 2px solid #222;
            padding: 8px;
            text-align: center;
        }
        
        .fp .head {
            background: #cfe8ff;
            font-weight: 700;
        }
        
        .fp .side {
            background: #e6f4ff;
            font-weight: 700;
        }
        
        .box {
            margin-top: 18px;
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>四柱推命デモ</h1>
        
        {{-- 命式表 --}}
        <table class="fp">
            <tr>
                <td colspan="4">西暦{{ date('Y年n月j日', strtotime('1992-05-17')) }}　（{{ '15時2分' }}）生</td>
                <td>男性</td><td>{{ \Carbon\Carbon::parse('1992-05-17')->age }}歳</td>
            </tr>
            <tr class="head"><th>時柱</th><th>日柱</th><th>月柱</th><th>年柱</th><th class="side">　</th><th class="side">　</th></tr>
            <tr>
                <td>{{ $result->hour?->stem->value }}{{ $result->hour?->branch->value }}</td>
                <td>{{ $result->day->stem->value }}{{ $result->day->branch->value }}</td>
                <td>{{ $result->month->stem->value }}{{ $result->month->branch->value }}</td>
                <td>{{ $result->year->stem->value }}{{ $result->year->branch->value }}</td>
                <td class="side">天干地支</td><td></td>
            </tr>
            <tr>
                <td>{{ implode('・', array_map(fn($x)=>$x->value, $result->hour?->hiddenStems ?? [])) }}</td>
                <td>{{ implode('・', array_map(fn($x)=>$x->value, $result->day->hiddenStems)) }}</td>
                <td>{{ implode('・', array_map(fn($x)=>$x->value, $result->month->hiddenStems)) }}</td>
                <td>{{ implode('・', array_map(fn($x)=>$x->value, $result->year->hiddenStems)) }}</td>
                <td class="side">蔵干</td><td></td>
            </tr>
            <tr>
                <td>{{ $result->hour?->stemTss ?? '' }}</td>
                <td>{{ $result->day->stemTss ?? '' }}</td>
                <td>{{ $result->month->stemTss ?? '' }}</td>
                <td>{{ $result->year->stemTss ?? '' }}</td>
                <td class="side">天干通変星</td><td></td>
            </tr>
            <tr>
                <td>{{ implode('・', $result->hour?->hiddenStemsTss ?? []) }}</td>
                <td>{{ implode('・', $result->day->hiddenStemsTss) }}</td>
                <td>{{ implode('・', $result->month->hiddenStemsTss) }}</td>
                <td>{{ implode('・', $result->year->hiddenStemsTss) }}</td>
                <td class="side">蔵干通変星</td><td></td>
            </tr>
            <tr>
                <td>{{ $result->hour?->twelveStage }}</td>
                <td>{{ $result->day->twelveStage }}</td>
                <td>{{ $result->month->twelveStage }}</td>
                <td>{{ $result->year->twelveStage }}</td>
                <td class="side">十二運星</td><td></td>
            </tr>
        </table>
        
        <table class="fp">
            <tr class="head"><th colspan="4">大運</th></tr>
            <tr><th>年齢帯</th><th>干支</th><th>通変星</th><th>十二運</th></tr>
            @foreach($result->daiun as $du)
            <tr>
                <td>{{ $du['start_age'] }}才〜{{ $du['end_age'] }}才</td>
                <td>{{ $du['pillar']['stem'] }}{{ $du['pillar']['branch'] }}</td>
                <td>{{ $du['tss'] ?? '' }}</td>
                <td>{{ $du['twelveStage'] ?? '' }}</td>
            </tr>
            @endforeach
        </table>

        {{-- 年運 --}}
        <div class="box">
            <table class="fp">
                <tr class="head"><th>西暦</th><th>年齢</th><th>年干支</th><th>通変星</th><th>十二運</th></tr>
                @foreach($result->annual as $row)
                <tr>
                    <td>{{ $row['year'] }}年</td>
                    <td>{{ $row['year'] - 1992 }}歳</td>
                    <td>{{ $row['pillar']['stem'] }}{{ $row['pillar']['branch'] }}</td>
                    <td>{{ $row['tss'] }}</td>
                    <td>{{ $row['twelveStage'] }}</td>
                </tr>
                @endforeach
            </table>
        </div>

        {{-- 月運 --}}
        <div class="box">
            <table class="fp">
                <tr class="head"><th>西暦</th><th>月</th><th>月干支</th><th>通変星</th><th>十二運</th></tr>
                @foreach($result->monthly as $row)
                @php [$y,$m]=explode('-',$row['ym']); @endphp
                <tr>
                    <td>{{ $y }}年</td><td>{{ intval($m) }}月</td>
                    <td>{{ $row['pillar']['stem'] }}{{ $row['pillar']['branch'] }}</td>
                    <td>{{ $row['tss'] }}</td>
                    <td>{{ $row['twelveStage'] }}</td>
                </tr>
                @endforeach
            </table>
        </div>

        {{-- 五行 --}}
        <div class="box" style="width: 260px">
            <table class="fp">
                <tr class="head"><th>五行</th><th>数</th></tr>
                @if(isset($result->fiveElementsCount) && is_array($result->fiveElementsCount))
                    @foreach ($result->fiveElementsCount as $k => $v)
                        <tr>
                            <td>{{ $k }}</td>
                            <td>{{ $v }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="2">五行データがありません</td></tr>
                    <tr><td colspan="2">デバッグ: {{ gettype($result->fiveElementsCount ?? 'null') }}</td></tr>
                    <tr><td colspan="2">データ: {{ json_encode($result->fiveElementsCount ?? 'null') }}</td></tr>
                @endif
            </table>
        </div>
    </div>
</body>
</html>