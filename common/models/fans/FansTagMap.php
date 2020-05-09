<?php

namespace addons\YunWechat\common\models\fans;

use Yii;

/**
 * This is the model class for table "yun_net_wechat_fans_tag_map".
 *
 * @property int $id
 * @property int $merchant_id 商户id
 * @property int $fans_id 粉丝id
 * @property int $tag_id 标签id
 */
class FansTagMap extends \common\models\base\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%wechat_fans_tag_map}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['merchant_id', 'fans_id', 'tag_id'], 'integer'],
            [['fans_id', 'tag_id'], 'unique', 'targetAttribute' => ['fans_id', 'tag_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'merchant_id' => 'Merchant ID',
            'fans_id' => 'Fans ID',
            'tag_id' => 'Tag ID',
        ];
    }
}
