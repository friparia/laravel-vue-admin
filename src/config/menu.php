<?php
return [
    [
        'name' => '首页',
        'url' => '/admin',
    ],
    [
        'name' => '子菜单',
        'url' => '/aa',
        'submenus' => [
            [
                'name' => '子菜单1',
                'url' => '/sub1',
            ],
            [
                'name' => '子菜单2',
                'url' => '/sub2',
            ],
        ]
    ]
];
?>
