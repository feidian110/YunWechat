<?php
namespace addons\YunWechat\common\services\fans;

use addons\YunWechat\common\models\fans\FansTagMap;
use common\components\Service;
use Yii;

class FansTagMapService extends Service
{
    public function add($fans_id, $data)
    {
        FansTagMap::deleteAll(['fans_id' => $fans_id]);

        $field = ['fans_id', 'tag_id', 'merchant_id'];
        return Yii::$app->db->createCommand()->batchInsert(FansTagMap::tableName(), $field, $data)->execute();
    }
}