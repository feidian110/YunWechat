<?php
namespace addons\YunWechat\common\services;

use common\components\Service;

/**
 * Class Application
 * @package addons\YunWechat\common\services
 * @property \addons\YunWechat\common\services\base\AccountService $account 菜单
 * @property \addons\YunWechat\common\services\base\MenuService $menu 菜单
 * @property \addons\YunWechat\common\services\fans\fansService $fans 粉丝
 * @property \addons\YunWechat\common\services\fans\fansStatService $fansStat
 * @property \addons\YunWechat\common\services\fans\FansTagsService $fansTags 粉丝标签
 * @property \addons\YunWechat\common\services\fans\FansTagMapService $fansTagMap
 * @property \addons\YunWechat\common\services\rule\RuleService $rule
 * @property \addons\YunWechat\common\services\rule\RuleStatService $ruleStat
 * @property \addons\YunWechat\common\services\rule\KeywordService $ruleKeyword
 * @property \addons\YunWechat\common\services\rule\RuleKeywordStatService $ruleKeywordStat
 * @property \addons\YunWechat\common\services\base\MessageService $message
 * @property \addons\YunWechat\common\services\base\MsgHistoryService $msgHistory
 * @property \addons\YunWechat\common\services\base\ReplyDefaultService $replyDefault
 * @property \addons\YunWechat\common\services\base\SettingService $setting
 * @property \addons\YunWechat\common\services\base\AttachmentService $attachment
 * @property \addons\YunWechat\common\services\base\AttachmentNewsService $attachmentNews
 */
class Application extends Service
{
    public $childService = [
        'account' => 'addons\YunWechat\common\services\base\AccountService',
        'menu' => 'addons\YunWechat\common\services\base\MenuService',
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