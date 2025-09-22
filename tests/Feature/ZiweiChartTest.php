<?php

use App\Services\Ziwei\ZiweiChartService;
use App\Services\Ziwei\TimeAdjuster;
use App\Services\Ziwei\LunarConverter;
use App\Services\Ziwei\PalaceCalculator;
use App\Services\Ziwei\StarAllocator;
use App\Services\Ziwei\TransformApplier;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->timeAdjuster = new TimeAdjuster();
    $this->lunarConverter = new LunarConverter();
    $this->palaceCalculator = new PalaceCalculator();
    $this->starAllocator = new StarAllocator();
    $this->transformApplier = new TransformApplier();
    
    $this->ziweiChartService = new ZiweiChartService(
        $this->timeAdjuster,
        $this->lunarConverter,
        $this->palaceCalculator,
        $this->starAllocator,
        $this->transformApplier
    );
});

test('紫微斗数命盤の入力フォームが表示される', function () {
    $response = $this->get('/ziwei');
    
    $response->assertStatus(200);
    $response->assertViewIs('ziwei.input');
    $response->assertSee('紫微斗数命盤');
    $response->assertSee('生年月日');
    $response->assertSee('出生時間');
    $response->assertSee('都道府県');
});

test('都道府県の一覧を取得できる', function () {
    $response = $this->get('/ziwei/prefectures');
    
    $response->assertStatus(200);
    $response->assertJsonStructure(['北海道', '青森県', '東京都', '沖縄県']);
});

test('命盤生成APIが正常に動作する', function () {
    $response = $this->postJson('/ziwei/generate', [
        'date' => '1990-01-01',
        'time' => '12:00',
        'prefecture' => '東京都'
    ]);
    
    $response->assertStatus(200);
    $response->assertViewIs('ziwei.chart');
});

test('命盤生成APIがJSONで正常に動作する', function () {
    $response = $this->postJson('/ziwei/generate', [
        'date' => '1990-01-01',
        'time' => '12:00',
        'prefecture' => '東京都'
    ], [
        'Accept' => 'application/json'
    ]);
    
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'meta' => [
            'input_date',
            'input_time',
            'local_date',
            'local_time',
            'lunar' => [
                'year',
                'month',
                'day',
                'year_ganzhi',
                'time_branch',
                'is_leap_month'
            ],
            'five_elements_ju',
            'ming_palace'
        ],
        'palaces' => [],
        'transforms' => [],
        'statistics' => [
            'total_stars',
            'transform_stats',
            'transform_distribution'
        ]
    ]);
});

test('命盤詳細APIが正常に動作する', function () {
    $response = $this->postJson('/ziwei/details', [
        'date' => '1990-01-01',
        'time' => '12:00',
        'prefecture' => '東京都'
    ]);
    
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'basic_info',
        'palace_analysis',
        'star_analysis',
        'transform_analysis'
    ]);
});

test('命盤統計APIが正常に動作する', function () {
    $response = $this->postJson('/ziwei/statistics', [
        'date' => '1990-01-01',
        'time' => '12:00',
        'prefecture' => '東京都'
    ]);
    
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'total_stars',
        'transform_stats' => [
            '禄',
            '権',
            '科',
            '忌'
        ],
        'transform_distribution'
    ]);
});

test('命盤検証APIが正常に動作する', function () {
    $response = $this->postJson('/ziwei/validate', [
        'date' => '1990-01-01',
        'time' => '12:00',
        'prefecture' => '東京都'
    ]);
    
    $response->assertStatus(200);
    $response->assertJson(['valid' => true]);
});

test('無効な入力でエラーが返される', function () {
    $response = $this->postJson('/ziwei/generate', [
        'date' => 'invalid-date',
        'time' => 'invalid-time',
        'prefecture' => '存在しない都道府県'
    ]);
    
    $response->assertStatus(400);
    $response->assertJsonStructure(['error']);
});

test('都道府県の経度補正が正しく動作する', function () {
    // 東京都の経度補正テスト
    $result = $this->ziweiChartService->generateChart('1990-01-01', '12:00', '東京都');
    
    // 地方時が補正されていることを確認
    expect($result['meta']['local_time'])->not->toBe('12:00');
});

test('命盤に12宮が正しく配置される', function () {
    $result = $this->ziweiChartService->generateChart('1990-01-01', '12:00', '東京都');
    
    expect($result['palaces'])->toHaveCount(12);
    
    $palaceNames = collect($result['palaces'])->pluck('name')->toArray();
    expect($palaceNames)->toContain('命宮');
    expect($palaceNames)->toContain('父母宮');
    expect($palaceNames)->toContain('福德宮');
    expect($palaceNames)->toContain('田宅宮');
    expect($palaceNames)->toContain('官祿宮');
    expect($palaceNames)->toContain('僕役宮');
    expect($palaceNames)->toContain('遷移宮');
    expect($palaceNames)->toContain('疾厄宮');
    expect($palaceNames)->toContain('財帛宮');
    expect($palaceNames)->toContain('子女宮');
    expect($palaceNames)->toContain('夫妻宮');
    expect($palaceNames)->toContain('兄弟宮');
});

test('四化が正しく適用される', function () {
    $result = $this->ziweiChartService->generateChart('1990-01-01', '12:00', '東京都');
    
    expect($result['transforms'])->toBeArray();
    
    // 四化の統計を確認
    $transformStats = $result['statistics']['transform_stats'];
    expect($transformStats)->toHaveKeys(['禄', '権', '科', '忌']);
});

test('PDF出力ページが正常に動作する', function () {
    $response = $this->get('/ziwei/pdf?date=1990-01-01&time=12:00&prefecture=東京都');
    
    $response->assertStatus(200);
    $response->assertViewIs('ziwei.pdf');
});

test('TimeAdjusterが正しく動作する', function () {
    $prefectures = $this->timeAdjuster->getAvailablePrefectures();
    
    expect($prefectures)->toContain('東京都');
    expect($prefectures)->toContain('大阪府');
    expect($prefectures)->toContain('沖縄県');
    
    $longitude = $this->timeAdjuster->getLongitude('東京都');
    expect($longitude)->toBe(139.76);
});

test('PalaceCalculatorが正しく動作する', function () {
    $mingPalace = $this->palaceCalculator->calculateMingPalace(1, '子');
    expect($mingPalace)->toBeString();
    
    $palaces = $this->palaceCalculator->calculatePalaces('寅');
    expect($palaces)->toHaveCount(12);
});

test('StarAllocatorが正しく動作する', function () {
    $palaces = $this->palaceCalculator->getCompletePalaces('甲', 1, '子');
    
    // 14主星を配置
    $palaces = $this->starAllocator->allocateMainStars($palaces, '水二局', 1);
    
    // 主星が配置されていることを確認
    $hasMainStars = false;
    foreach ($palaces as $palace) {
        if (isset($palace['stars'])) {
            foreach ($palace['stars'] as $star) {
                if ($star['type'] === 'main') {
                    $hasMainStars = true;
                    break 2;
                }
            }
        }
    }
    
    expect($hasMainStars)->toBeTrue();
});

test('TransformApplierが正しく動作する', function () {
    $palaces = $this->palaceCalculator->getCompletePalaces('甲', 1, '子');
    $palaces = $this->starAllocator->allocateMainStars($palaces, '水二局', 1);
    
    $result = $this->transformApplier->applyTransforms($palaces, '甲');
    
    expect($result)->toHaveKeys(['palaces', 'transforms']);
    expect($result['transforms'])->toBeArray();
});
