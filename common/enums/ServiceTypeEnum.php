<?php


namespace addons\YunWechat\common\enums;


use common\enums\BaseEnum;

class ServiceTypeEnum extends BaseEnum
{
    const SUB = 0;
    const OLD = 1;
    const SERVICE = 2;

    /**
     * @return array
     */
    public static function getMap(): array
    {
        return [
            self::SUB => '订阅号',
            self::OLD => '由历史老帐号升级后的订阅号',
            self::SERVICE => '服务号',
        ];
    }
}