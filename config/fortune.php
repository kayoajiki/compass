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
    ]
];
