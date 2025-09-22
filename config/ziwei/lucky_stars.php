<?php

return [
    // 左輔・右弼（月基準）
    'zuofu' => [
        'name' => '左輔',
        'type' => 'lucky',
        'base_palace' => '辰',
        'direction' => '順行',
        'calculation' => 'month_based'
    ],
    'youbi' => [
        'name' => '右弼',
        'type' => 'lucky',
        'base_palace' => '戌',
        'direction' => '逆行',
        'calculation' => 'month_based'
    ],
    
    // 天魁・天鉞（年干基準）
    'tiankui' => [
        'name' => '天魁',
        'type' => 'lucky',
        'calculation' => 'year_stem_based',
        'positions' => [
            '甲' => '丑', '乙' => '子', '丙' => '亥', '丁' => '亥', '戊' => '丑',
            '己' => '子', '庚' => '丑', '辛' => '午', '壬' => '卯', '癸' => '巳'
        ]
    ],
    'tianyue' => [
        'name' => '天鉞',
        'type' => 'lucky',
        'calculation' => 'year_stem_based',
        'positions' => [
            '甲' => '未', '乙' => '申', '丙' => '酉', '丁' => '酉', '戊' => '未',
            '己' => '申', '庚' => '未', '辛' => '子', '壬' => '巳', '癸' => '卯'
        ]
    ],
    
    // 文昌・文曲（時支基準）
    'wenchang' => [
        'name' => '文昌',
        'type' => 'lucky',
        'base_palace' => '戌',
        'direction' => '逆行',
        'calculation' => 'time_branch_based'
    ],
    'wenqu' => [
        'name' => '文曲',
        'type' => 'lucky',
        'base_palace' => '辰',
        'direction' => '順行',
        'calculation' => 'time_branch_based'
    ]
];
