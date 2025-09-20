<?php

return [
    /*
    |--------------------------------------------------------------------------
    | FortuneCompass Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for the FortuneCompass application
    | including subscription plans, astrology settings, and other app-specific
    | configurations.
    |
    */

    'plans' => [
        'monthly' => [
            'label' => '月額',
            'price' => 980,
            'currency' => 'JPY',
            'stripe_price_id' => env('STRIPE_PRICE_MONTHLY'),
            'interval' => 'month',
            'features' => [
                '詳細鑑定結果',
                '他者プロフィール追加',
                '月次レポート',
                '優先サポート'
            ]
        ],
        'yearly' => [
            'label' => '年額',
            'price' => 9800,
            'currency' => 'JPY',
            'stripe_price_id' => env('STRIPE_PRICE_YEARLY'),
            'interval' => 'year',
            'note' => '2ヶ月分お得',
            'features' => [
                '詳細鑑定結果',
                '他者プロフィール追加',
                '月次レポート',
                '優先サポート',
                '特別レポート'
            ]
        ]
    ],

    'free_features' => [
        '基本鑑定結果',
        '今日の運勢',
        'プロフィール管理'
    ],

    'subscription_features' => [
        '詳細鑑定結果',
        '他者プロフィール追加',
        '月次レポート',
        '優先サポート'
    ],

    'ai' => [
        'dify' => [
            'base_url' => env('DIFY_BASE_URL'),
            'api_key' => env('DIFY_API_KEY'),
        ],
        'apps' => [
            'chat_mood_coach' => 'chat_mood_coach_v1',
            'chat_tarot_quick' => 'chat_tarot_quick_v1',
            'chat_strength_booster' => 'chat_strength_booster_v1',
        ],
    ],

    'chatbots' => [
        'free_daily_limit' => 1,
        'bots' => [
            'mood' => [
                'name' => '気分・日記のサポート',
                'icon' => '📝',
                'description' => '今日の気分を記録して、寄り添いのメッセージを受け取りましょう'
            ],
            'tarot' => [
                'name' => 'タロット簡易アドバイス',
                'icon' => '🃏',
                'description' => '日々の悩みや疑問をタロットで占ってみましょう'
            ],
            'strength' => [
                'name' => '今日の褒めポイント',
                'icon' => '✨',
                'description' => 'あなたの生年月日から今日の強みと活かし方を見つけましょう'
            ]
        ]
    ]
];
