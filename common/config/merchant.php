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
                [
                    'title' => '素材库',
                    'route' => 'attachment/index',
                ],
            ],
        ],
        [
            'title' => '粉丝管理',
            'route' => 'fans',
            'icon' => 'fa fa-heart',
            'child' => [
                [
                    'title' => '粉丝列表',
                    'route' => 'fans/index',
                ],
                [
                    'title' => '粉丝标签',
                    'route' => 'fans-tags/index',
                ],
                [
                    'title' => '历史消息',
                    'route' => 'msg-history/index',

                ],
                [
                    'title' => '定时群发',
                    'route' => 'mass-record/index',

                ],
            ],
        ],

        [
            'title' => '数据统计',
            'route' => 'dataStatistics',
            'icon' => 'fa fa-pie-chart',
            'child' => [
                [
                    'title' => '粉丝关注统计',
                    'route' => 'stat/fans-follow',
                ],
                [
                    'title' => '回复规则使用量',
                    'route' => 'stat/rule',
                ],
                [
                    'title' => '关键字命中规则',
                    'route' => 'stat/rule-keyword',
                ],
            ],
        ],
        [
            'title' => '公众号绑定',
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