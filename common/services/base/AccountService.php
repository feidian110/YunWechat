<?php
namespace addons\YunWechat\common\services\base;

use addons\YunStore\common\enums\StateEnum;
use addons\YunWechat\common\models\account\Bind;
use common\components\Service;
use Yii;

class AccountService extends Service
{

    /**
     * 获取商家绑定微信账号实例
     * @param $merchantId
     * @return \EasyWeChat\OfficialAccount\Application|\EasyWeChat\OpenPlatform\Authorizer\OfficialAccount\Application
     */
    public function getAccount($merchantId)
    {
        $app = $this->getBindInfo($merchantId);
        $openPlatform = Yii::$app->wechat->getOpenPlatform();
        return $openPlatform->officialAccount((string)$app['appid'], (string)$app['refresh_token']);
    }

    public function getBindInfo($merchantId)
    {
        $app = Bind::findOne(['merchant_id'=>$merchantId,'status'=>StateEnum::ENABLED]);
        return $app;
    }


}