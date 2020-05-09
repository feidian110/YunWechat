<?php
namespace addons\YunWechat\common\services\base;

use addons\YunWechat\common\models\base\ReplyDefault;
use common\components\Service;

class ReplyDefaultService extends Service
{
    public function findOne()
    {
        if (empty(($model = ReplyDefault::find()->andFilterWhere(['merchant_id' => $this->getMerchantId()])->one()))) {
            return new ReplyDefault();
        }

        return $model;
    }
}