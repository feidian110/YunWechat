<?php
namespace addons\YunWechat\common\services;

use common\components\Service;

/**
 * Class Application
 * @package addons\YunWechat\common\services
 * @property \addons\YunWechat\common\services\base\AccountService $account 菜单
 * @property \addons\YunWechat\common\services\base\MenuService $menu 菜单
 * @property \addons\YunWechat\common\services\base\MenuProvincesService $menuProvinces 个性菜单地区
 * @property \addons\YunWechat\common\services\base\QrcodeService $qrcode 二维码
 * @property \addons\YunWechat\common\services\base\QrcodeStatService $qrcodeStat 二维码场景
 * @property \addons\YunWechat\common\services\fans\fansService $fans 粉丝
 * @property \addons\YunWechat\common\services\fans\fansStatService $fansStat 粉丝统计
 * @property \addons\YunWechat\common\services\fans\FansTagsService $fansTags 粉丝标签
 * @property \addons\YunWechat\common\services\fans\FansTagMapService $fansTagMap 粉丝标签关联
 * @property \addons\YunWechat\common\services\rule\RuleService $rule 规则
 * @property \addons\YunWechat\common\services\rule\RuleStatService $ruleStat 规则统计
 * @property \addons\YunWechat\common\services\rule\KeywordService $ruleKeyword  规则关键字
 * @property \addons\YunWechat\common\services\rule\RuleKeywordStatService $ruleKeywordStat 规则关键字统计
 * @property \addons\YunWechat\common\services\base\MessageService $message 微信消息
 * @property \addons\YunWechat\common\services\base\MsgHistoryService $msgHistory  历史消息
 * @property \addons\YunWechat\common\services\base\ReplyDefaultService $replyDefault  默认回复
 * @property \addons\YunWechat\common\services\base\SettingService $setting  参数设置
 * @property \addons\YunWechat\common\services\base\AttachmentService $attachment  资源
 * @property \addons\YunWechat\common\services\base\AttachmentNewsService $attachmentNews 资源图文
 */
class Application extends Service
{
    public $childService = [
        'account' => 'addons\YunWechat\common\services\base\AccountService',
        'menu' => 'addons\YunWechat\common\services\base\MenuService',
        'menuProvinces' => 'addons\YunWechat\common\services\base\MenuProvincesService',
        'qrcode' => 'addons\YunWechat\common\services\base\QrcodeService',
        'qrcodeStat' => 'addons\YunWechat\common\services\base\QrcodeStatService',
        'fans' => 'addons\YunWechat\common\services\fans\FansService',
        'fansStat' => 'addons\YunWechat\common\services\fans\FansStatService',
        'fansTags' => 'addons\YunWechat\common\services\fans\FansTagsService',
        'fansTagMap' => 'addons\YunWechat\common\services\fans\FansTagMapService',
        'rule' => 'addons\YunWechat\common\services\rule\RuleService',
        'ruleStat' => 'addons\YunWechat\common\services\rule\RuleStatService',
        'ruleKeyword' => 'addons\YunWechat\common\services\rule\KeywordService',
        'ruleKeywordStat' => 'addons\YunWechat\common\services\rule\RuleKeywordStatService',
        'message' => 'addons\YunWechat\common\services\base\MessageService',
        'msgHistory' => 'addons\YunWechat\common\services\base\MsgHistoryService',
        'replyDefault' => 'addons\YunWechat\common\services\base\ReplyDefaultService',
        'setting' => 'addons\YunWechat\common\services\base\SettingService',
        'attachment' => 'addons\YunWechat\common\services\base\AttachmentService',
        'attachmentNews' => 'addons\YunWechat\common\services\base\AttachmentNewsService'

    ];
}