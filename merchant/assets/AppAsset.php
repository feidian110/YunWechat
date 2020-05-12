<?php

namespace addons\YunWechat\merchant\assets;

use yii\web\AssetBundle;

/**
 * 静态资源管理
 *
 * Class AppAsset
 * @package addons\YunWechat\merchant\assets
 */
class AppAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@addons/YunWechat/merchant/resources/';

    public $css = [
        'css/wechat.css'
    ];

    public $js = [
        'js/vue.min.js',
        'js/vuedraggable.min.js',
    ];

    public $depends = [
    ];
}