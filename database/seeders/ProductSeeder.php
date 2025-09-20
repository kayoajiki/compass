<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 鑑定商品（サービス）
        $readingProducts = [
            [
                'sku' => 'reading_four_pillars_detail',
                'name' => '四柱推命 詳細鑑定',
                'type' => 'service',
                'price_cents' => 9800,
                'currency' => 'JPY',
                'stock' => null, // unlimited
                'is_active' => true,
                'metadata' => [
                    'duration' => '約30分',
                    'description' => '生年月日時から導き出す本質的な性格と運命の流れを詳細に鑑定',
                    'features' => ['性格分析', '運勢予測', '相性診断', '開運アドバイス']
                ],
            ],
            [
                'sku' => 'reading_ziwei_detail',
                'name' => '紫微斗数 詳細鑑定',
                'type' => 'service',
                'price_cents' => 9800,
                'currency' => 'JPY',
                'stock' => null,
                'is_active' => true,
                'metadata' => [
                    'duration' => '約30分',
                    'description' => '紫微星を中心とした運命分析で人生の流れを読み解く',
                    'features' => ['命宮分析', '運勢予測', '性格診断', '開運方法']
                ],
            ],
            [
                'sku' => 'reading_western_detail',
                'name' => '西洋占星術 詳細鑑定',
                'type' => 'service',
                'price_cents' => 9800,
                'currency' => 'JPY',
                'stock' => null,
                'is_active' => true,
                'metadata' => [
                    'duration' => '約30分',
                    'description' => '惑星の配置から見る運勢と性格の深層心理を分析',
                    'features' => ['ホロスコープ分析', '性格診断', '運勢予測', '恋愛アドバイス']
                ],
            ],
            [
                'sku' => 'reading_numerology_detail',
                'name' => '数秘術 詳細鑑定',
                'type' => 'service',
                'price_cents' => 9800,
                'currency' => 'JPY',
                'stock' => null,
                'is_active' => true,
                'metadata' => [
                    'duration' => '約30分',
                    'description' => '数字の神秘的な力で導く人生の指針と運命の流れ',
                    'features' => ['ライフパス分析', '性格診断', '運勢予測', '開運数字']
                ],
            ],
        ];

        // 物販商品
        $merchProducts = [
            [
                'sku' => 'lucky_crystal_clear',
                'name' => 'クリスタル クリアストーン',
                'type' => 'physical',
                'price_cents' => 3500,
                'currency' => 'JPY',
                'stock' => 50,
                'is_active' => true,
                'metadata' => [
                    'description' => '浄化力が高く、心を清らかにしてくれるクリスタルストーン。ネガティブなエネルギーを除去し、ポジティブな気持ちをもたらします。',
                    'size' => '約3cm',
                    'material' => '天然水晶',
                    'benefits' => ['浄化', '心の安定', '集中力向上'],
                    'image_url' => 'https://images.unsplash.com/photo-1518709268805-4e9042af2176?w=500&h=500&fit=crop&crop=center',
                    'category' => 'パワーストーン',
                    'recommend_tags' => ['ストレス解消', '集中力向上', '心の浄化'],
                    'target_audience' => ['学生', 'ビジネスパーソン', '瞑想愛好家'],
                    'price_range' => 'entry',
                    'popularity_score' => 95
                ],
            ],
            [
                'sku' => 'lucky_rose_quartz',
                'name' => 'ローズクォーツ ハートストーン',
                'type' => 'physical',
                'price_cents' => 4200,
                'currency' => 'JPY',
                'stock' => 30,
                'is_active' => true,
                'metadata' => [
                    'description' => '愛と癒しのエネルギーを持つピンクの石。恋愛運向上と人間関係の改善に効果的で、心に温かさをもたらします。',
                    'size' => '約4cm',
                    'material' => '天然ローズクォーツ',
                    'benefits' => ['恋愛運向上', '人間関係改善', '心の癒し'],
                    'image_url' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=500&h=500&fit=crop&crop=center',
                    'category' => 'パワーストーン',
                    'recommend_tags' => ['恋愛運', '人間関係', '心の癒し'],
                    'target_audience' => ['恋愛中の方', '人間関係に悩む方', '癒しを求める方'],
                    'price_range' => 'mid',
                    'popularity_score' => 88
                ],
            ],
            [
                'sku' => 'lucky_amethyst',
                'name' => 'アメジスト パワーストーン',
                'type' => 'physical',
                'price_cents' => 3800,
                'currency' => 'JPY',
                'stock' => 25,
                'is_active' => true,
                'metadata' => [
                    'description' => '直感力と精神力を高める紫色の石。深い眠りと精神的なバランスをサポートし、第六感を研ぎ澄ませます。',
                    'size' => '約3.5cm',
                    'material' => '天然アメジスト',
                    'benefits' => ['直感力向上', '精神安定', '睡眠改善'],
                    'image_url' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=500&h=500&fit=crop&crop=center',
                    'category' => 'パワーストーン',
                    'recommend_tags' => ['直感力', '睡眠改善', '精神安定'],
                    'target_audience' => ['不眠で悩む方', '直感力を高めたい方', 'スピリチュアル愛好家'],
                    'price_range' => 'mid',
                    'popularity_score' => 82
                ],
            ],
            [
                'sku' => 'fortune_omamori',
                'name' => '開運お守り セット',
                'type' => 'physical',
                'price_cents' => 2800,
                'currency' => 'JPY',
                'stock' => 100,
                'is_active' => true,
                'metadata' => [
                    'description' => '総合運・金運・恋愛運・健康運の4つセット。人生のあらゆる側面をサポートし、全体的な運気向上を図ります。',
                    'size' => '各約8cm',
                    'material' => '布製',
                    'benefits' => ['総合運向上', '金運アップ', '恋愛成就', '健康祈願'],
                    'image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500&h=500&fit=crop&crop=center',
                    'category' => 'お守り',
                    'recommend_tags' => ['総合運', '金運', '恋愛運', '健康運'],
                    'target_audience' => ['運気全般を上げたい方', '初心者の方', 'バランス重視の方'],
                    'price_range' => 'budget',
                    'popularity_score' => 92
                ],
            ],
            [
                'sku' => 'lucky_bracelet',
                'name' => '開運ブレスレット',
                'type' => 'physical',
                'price_cents' => 5500,
                'currency' => 'JPY',
                'stock' => 40,
                'is_active' => true,
                'metadata' => [
                    'description' => '天然石を使用した美しい開運ブレスレット。日常的に身につけて運気を向上させ、おしゃれも楽しめます。',
                    'size' => 'フリーサイズ（調整可能）',
                    'material' => '天然石・シルバー',
                    'benefits' => ['運気向上', 'おしゃれ', 'パワーストーン効果'],
                    'image_url' => 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=500&h=500&fit=crop&crop=center',
                    'category' => 'アクセサリー',
                    'recommend_tags' => ['おしゃれ', '日常使い', '運気向上'],
                    'target_audience' => ['ファッション重視の方', '日常的に身につけたい方', 'アクセサリー愛好家'],
                    'price_range' => 'premium',
                    'popularity_score' => 85
                ],
            ],
            [
                'sku' => 'fortune_planner',
                'name' => '開運手帳 2025',
                'type' => 'physical',
                'price_cents' => 3200,
                'currency' => 'JPY',
                'stock' => 80,
                'is_active' => true,
                'metadata' => [
                    'description' => '運勢カレンダー付きの特別な手帳。スケジュール管理と運勢記録を同時に行い、開運への道筋をサポートします。',
                    'size' => 'A5サイズ',
                    'material' => '上質紙・レザーカバー',
                    'benefits' => ['運勢管理', 'スケジュール管理', '開運記録'],
                    'image_url' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=500&h=500&fit=crop&crop=center',
                    'category' => '文具',
                    'recommend_tags' => ['手帳好き', 'スケジュール管理', '運勢記録'],
                    'target_audience' => ['手帳愛好家', 'スケジュール管理したい方', '記録好きの方'],
                    'price_range' => 'mid',
                    'popularity_score' => 78
                ],
            ],
            [
                'sku' => 'lucky_earrings',
                'name' => 'クリスタル イヤリング',
                'type' => 'physical',
                'price_cents' => 4800,
                'currency' => 'JPY',
                'stock' => 35,
                'is_active' => true,
                'metadata' => [
                    'description' => '上品なクリスタルを使用したイヤリング。美しさと運気を同時にアップさせ、特別な日の装いをサポートします。',
                    'size' => '約2cm',
                    'material' => 'クリスタル・シルバー',
                    'benefits' => ['美しさ向上', '運気アップ', '上品な印象'],
                    'image_url' => 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?w=500&h=500&fit=crop&crop=center',
                    'category' => 'アクセサリー',
                    'recommend_tags' => ['上品', '特別な日', '美しさ向上'],
                    'target_audience' => ['フォーマルな場面が多い方', '上品な装いを求める方', '特別な日の準備をしたい方'],
                    'price_range' => 'premium',
                    'popularity_score' => 80
                ],
            ],
            [
                'sku' => 'fortune_incense',
                'name' => '開運お香 セット',
                'type' => 'physical',
                'price_cents' => 2500,
                'currency' => 'JPY',
                'stock' => 60,
                'is_active' => true,
                'metadata' => [
                    'description' => '心を浄化し、運気を上げる特別なお香。空間全体を浄化し、リラックス効果と運気向上を同時に実現します。',
                    'size' => '20本入り',
                    'material' => '天然香料',
                    'benefits' => ['空間浄化', 'リラックス', '運気向上'],
                    'image_url' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=500&h=500&fit=crop&crop=center',
                    'category' => '香り',
                    'recommend_tags' => ['リラックス', '空間浄化', '癒し'],
                    'target_audience' => ['リラックス重視の方', '空間を浄化したい方', '香り好きの方'],
                    'price_range' => 'budget',
                    'popularity_score' => 75
                ],
            ],
        ];

        // 商品をデータベースに挿入（重複チェック付き）
        foreach (array_merge($readingProducts, $merchProducts) as $productData) {
            Product::updateOrCreate(
                ['sku' => $productData['sku']],
                $productData
            );
        }
    }
}
