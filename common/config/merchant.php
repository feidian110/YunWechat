<?php

return [

    // ----------------------- 菜单配置 ----------------------- //
    'config' => [
        // 菜单配置
        'menu' => [
            'location' => 'default', // default:系统顶部菜单;addons:应用中心菜单
            'icon' => 'fa fa-puzzle-piece',
        ],
        // 子模块配置
        'modules' => [
        ],
    ],

    // ----------------------- 快捷入口 ----------------------- //

    'cover' => [

    ],

    // ----------------------- 菜单配置 ----------------------- //

    'menu' => [

        [
            'title' => '基础功能',
            'route' => 'function',
            'icon' => 'fa fa-superpowers',
            'child' => [
                [
                    'title' => '自动回复',
                    'route' => 'rule/index',
                ],
                [
                    'title' => '自定义菜单',
                    'route' => 'menu/index',
                ],
                [
                    'title' => '二维码/转化链接',
                    'route' => 'qrcode/index',
                ],
            ],
        ],
        [
            'title' => '参数配置',
            'route' => 'setting/history-stat',
            'icon' => 'fa fa-cog',
        ],
    ],

    // ----------------------- 权限配置 ----------------------- //

    'authItem' => [
        [
            'title' => '所有权限',
            'name' => '*',
        ],
    ],
];