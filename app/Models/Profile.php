<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'birth_date',
        'birth_time',
        'birth_place_pref',
        'sex',
        'longitude_adjust',
        'is_completed',
        'completed_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'birth_time' => 'datetime:H:i',
        'longitude_adjust' => 'boolean',
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    /**
     * ユーザーとのリレーション
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * プロフィール完成時の処理
     */
    public function markAsCompleted(): void
    {
        $this->update([
            'is_completed' => true,
            'completed_at' => now(),
        ]);
    }

    /**
     * 出生情報が完全かチェック
     */
    public function isComplete(): bool
    {
        return !empty($this->name) && 
               !empty($this->birth_date) && 
               !empty($this->birth_place_pref) &&
               !empty($this->sex);
    }

    /**
     * 生年月日から年齢を計算
     */
    public function getAgeAttribute(): int
    {
        return $this->birth_date ? $this->birth_date->age : 0;
    }

    /**
     * 出生時刻が不明かチェック
     */
    public function isBirthTimeUnknown(): bool
    {
        return is_null($this->birth_time);
    }

    /**
     * 都道府県の表示名を取得
     */
    public function getBirthPlaceNameAttribute(): string
    {
        $prefectures = $this->getPrefectures();
        return $prefectures[$this->birth_place_pref] ?? $this->birth_place_pref;
    }

    /**
     * 都道府県コードから経度補正を自動計算
     */
    public function calculateLongitudeAdjustment(): bool
    {
        // 都道府県コードから経度を取得し、兵庫県（東経135度）との差を計算
        $longitudeMap = [
            '01' => 141.35, // 北海道（札幌）
            '02' => 140.74, // 青森（青森市）
            '03' => 141.15, // 岩手（盛岡市）
            '04' => 140.87, // 宮城（仙台市）
            '05' => 140.10, // 秋田（秋田市）
            '06' => 140.36, // 山形（山形市）
            '07' => 140.47, // 福島（福島市）
            '08' => 140.45, // 茨城（水戸市）
            '09' => 139.88, // 栃木（宇都宮市）
            '10' => 139.39, // 群馬（前橋市）
            '11' => 139.65, // 埼玉（さいたま市）
            '12' => 140.10, // 千葉（千葉市）
            '13' => 139.69, // 東京（東京都）
            '14' => 139.64, // 神奈川（横浜市）
            '15' => 138.18, // 新潟（新潟市）
            '16' => 137.21, // 富山（富山市）
            '17' => 136.66, // 石川（金沢市）
            '18' => 136.22, // 福井（福井市）
            '19' => 138.57, // 山梨（甲府市）
            '20' => 138.18, // 長野（長野市）
            '21' => 136.72, // 岐阜（岐阜市）
            '22' => 138.38, // 静岡（静岡市）
            '23' => 136.91, // 愛知（名古屋市）
            '24' => 136.51, // 三重（津市）
            '25' => 135.87, // 滋賀（大津市）
            '26' => 135.77, // 京都（京都市）
            '27' => 135.50, // 大阪（大阪市）
            '28' => 135.00, // 兵庫（神戸市）- 基準
            '29' => 135.83, // 奈良（奈良市）
            '30' => 135.17, // 和歌山（和歌山市）
            '31' => 134.24, // 鳥取（鳥取市）
            '32' => 133.93, // 島根（松江市）
            '33' => 133.93, // 岡山（岡山市）
            '34' => 132.46, // 広島（広島市）
            '35' => 131.47, // 山口（山口市）
            '36' => 134.56, // 徳島（徳島市）
            '37' => 134.04, // 香川（高松市）
            '38' => 132.77, // 愛媛（松山市）
            '39' => 133.53, // 高知（高知市）
            '40' => 130.42, // 福岡（福岡市）
            '41' => 130.30, // 佐賀（佐賀市）
            '42' => 129.87, // 長崎（長崎市）
            '43' => 130.74, // 熊本（熊本市）
            '44' => 131.61, // 大分（大分市）
            '45' => 131.42, // 宮崎（宮崎市）
            '46' => 130.56, // 鹿児島（鹿児島市）
            '47' => 127.68, // 沖縄（那覇市）
        ];

        $longitude = $longitudeMap[$this->birth_place_pref] ?? 139.69; // デフォルトは東京
        
        // 兵庫県（東経135度）を基準として、経度の差分を時刻に反映
        $timeDifference = ($longitude - 135) * 4; // 1度 = 4分
        return abs($timeDifference) >= 1;
    }

    /**
     * 47都道府県のリストを取得
     */
    public static function getPrefectures(): array
    {
        return [
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
    }
}
