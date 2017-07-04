<?php
return [
    [
        'name' => '首页',
        'url' => '/',
    ],
    [
        'name' => '用户管理',
        'url' => '/user',
        'submenus' => [
            [
                'name' => '列表',
                'url' => '/user',
            ],
        ]
    ]
];
?>
