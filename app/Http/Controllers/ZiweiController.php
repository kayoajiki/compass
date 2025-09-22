<?php

namespace App\Http\Controllers;

use App\Services\Ziwei\ZiweiChartService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ZiweiController extends Controller
{
    private ZiweiChartService $ziweiChartService;

    public function __construct(ZiweiChartService $ziweiChartService)
    {
        $this->ziweiChartService = $ziweiChartService;
    }

    /**
     * 入力フォームを表示
     */
    public function index(): View
    {
        $prefectures = $this->ziweiChartService->getAvailablePrefectures();
        
        // ユーザーのプロフィール情報を取得
        $user = auth()->user();
        $profile = $user->profile;
        
        // プロフィール情報をフォーム用に整形
        $profileData = null;
        if ($profile && $profile->isComplete()) {
            $profileData = [
                'name' => $profile->name,
                'birth_date' => $profile->birth_date?->format('Y-m-d'),
                'birth_time' => $profile->birth_time?->format('H:i'),
                'prefecture_code' => $profile->birth_place_pref,
                'prefecture_name' => $this->getPrefectureNameFromCode($profile->birth_place_pref),
            ];
        }
        
        return view('ziwei.input', compact('prefectures', 'profileData'));
    }

    /**
     * プロフィール情報から直接命盤を表示
     */
    public function chart(): View
    {
        $user = auth()->user();
        $profile = $user->profile;
        
        if (!$profile || !$profile->isComplete()) {
            return redirect()->route('ziwei.index')
                ->with('error', 'プロフィール情報が未完了です。まずプロフィールを設定してください。');
        }
        
        try {
            // プロフィール情報から命盤を生成
            $prefectureName = $this->getPrefectureNameFromCode($profile->birth_place_pref);
            
            $chart = $this->ziweiChartService->generateChart(
                $profile->birth_date->format('Y-m-d'),
                $profile->birth_time ? $profile->birth_time->format('H:i') : '00:00',
                $prefectureName
            );
            
            return view('ziwei.chart', compact('chart'));
            
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('ziwei.index')
                ->with('error', '命盤の生成に失敗しました: ' . $e->getMessage());
        }
    }

    /**
     * 命盤を生成して表示
     */
    public function generate(Request $request): View|JsonResponse
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'prefecture' => 'required|string'
        ]);

        try {
            $chart = $this->ziweiChartService->generateChart(
                $request->input('date'),
                $request->input('time'),
                $request->input('prefecture')
            );

            if ($request->expectsJson()) {
                return response()->json($chart);
            }

            return view('ziwei.chart', compact('chart'));

        } catch (\InvalidArgumentException $e) {
            if ($request->expectsJson()) {
                return response()->json(['error' => $e->getMessage()], 400);
            }

            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * 命盤の詳細情報を取得（API）
     */
    public function details(Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'prefecture' => 'required|string'
        ]);

        try {
            $chart = $this->ziweiChartService->generateChart(
                $request->input('date'),
                $request->input('time'),
                $request->input('prefecture')
            );

            $details = $this->ziweiChartService->getChartDetails($chart);

            return response()->json($details);

        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * PDF出力用の命盤を表示
     */
    public function pdf(Request $request): View
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'prefecture' => 'required|string'
        ]);

        try {
            $chart = $this->ziweiChartService->generateChart(
                $request->input('date'),
                $request->input('time'),
                $request->input('prefecture')
            );

            return view('ziwei.pdf', compact('chart'));

        } catch (\InvalidArgumentException $e) {
            abort(400, $e->getMessage());
        }
    }

    /**
     * 利用可能な都道府県を取得（API）
     */
    public function prefectures(): JsonResponse
    {
        $prefectures = $this->ziweiChartService->getAvailablePrefectures();
        
        return response()->json($prefectures);
    }

    /**
     * 命盤の統計情報を取得（API）
     */
    public function statistics(Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'prefecture' => 'required|string'
        ]);

        try {
            $chart = $this->ziweiChartService->generateChart(
                $request->input('date'),
                $request->input('time'),
                $request->input('prefecture')
            );

            return response()->json($chart['statistics']);

        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * 命盤の検証（API）
     */
    public function validate(Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'prefecture' => 'required|string'
        ]);

        try {
            // 基本的な検証のみ実行
            $this->ziweiChartService->generateChart(
                $request->input('date'),
                $request->input('time'),
                $request->input('prefecture')
            );

            return response()->json(['valid' => true]);

        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'valid' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * 都道府県コードから都道府県名を取得
     */
    private function getPrefectureNameFromCode(?string $code): ?string
    {
        if (!$code) {
            return null;
        }

        $prefectureMap = [
            '01' => '北海道',
            '02' => '青森県',
            '03' => '岩手県',
            '04' => '宮城県',
            '05' => '秋田県',
            '06' => '山形県',
            '07' => '福島県',
            '08' => '茨城県',
            '09' => '栃木県',
            '10' => '群馬県',
            '11' => '埼玉県',
            '12' => '千葉県',
            '13' => '東京都',
            '14' => '神奈川県',
            '15' => '新潟県',
            '16' => '富山県',
            '17' => '石川県',
            '18' => '福井県',
            '19' => '山梨県',
            '20' => '長野県',
            '21' => '岐阜県',
            '22' => '静岡県',
            '23' => '愛知県',
            '24' => '三重県',
            '25' => '滋賀県',
            '26' => '京都府',
            '27' => '大阪府',
            '28' => '兵庫県',
            '29' => '奈良県',
            '30' => '和歌山県',
            '31' => '鳥取県',
            '32' => '島根県',
            '33' => '岡山県',
            '34' => '広島県',
            '35' => '山口県',
            '36' => '徳島県',
            '37' => '香川県',
            '38' => '愛媛県',
            '39' => '高知県',
            '40' => '福岡県',
            '41' => '佐賀県',
            '42' => '長崎県',
            '43' => '熊本県',
            '44' => '大分県',
            '45' => '宮崎県',
            '46' => '鹿児島県',
            '47' => '沖縄県',
        ];

        return $prefectureMap[$code] ?? null;
    }

    /**
     * 都道府県名から都道府県コードを取得
     */
    private function getPrefectureCodeFromName(string $name): ?string
    {
        $prefectureMap = [
            '北海道' => '01',
            '青森県' => '02',
            '岩手県' => '03',
            '宮城県' => '04',
            '秋田県' => '05',
            '山形県' => '06',
            '福島県' => '07',
            '茨城県' => '08',
            '栃木県' => '09',
            '群馬県' => '10',
            '埼玉県' => '11',
            '千葉県' => '12',
            '東京都' => '13',
            '神奈川県' => '14',
            '新潟県' => '15',
            '富山県' => '16',
            '石川県' => '17',
            '福井県' => '18',
            '山梨県' => '19',
            '長野県' => '20',
            '岐阜県' => '21',
            '静岡県' => '22',
            '愛知県' => '23',
            '三重県' => '24',
            '滋賀県' => '25',
            '京都府' => '26',
            '大阪府' => '27',
            '兵庫県' => '28',
            '奈良県' => '29',
            '和歌山県' => '30',
            '鳥取県' => '31',
            '島根県' => '32',
            '岡山県' => '33',
            '広島県' => '34',
            '山口県' => '35',
            '徳島県' => '36',
            '香川県' => '37',
            '愛媛県' => '38',
            '高知県' => '39',
            '福岡県' => '40',
            '佐賀県' => '41',
            '長崎県' => '42',
            '熊本県' => '43',
            '大分県' => '44',
            '宮崎県' => '45',
            '鹿児島県' => '46',
            '沖縄県' => '47',
        ];

        return $prefectureMap[$name] ?? null;
    }
}
