<?php

namespace addons\YunWechat\common\models\fans;

use Yii;

/**
 * This is the model class for table "yun_net_wechat_fans_stat".
 *
 * @property int $id
 * @property int $merchant_id 商户id
 * @property int $new_attention 今日新关注
 * @property int $cancel_attention 今日取消关注
 * @property int $cumulate_attention 累计关注
 * @property string $date
 * @property int $status 状态[-1:删除;0:禁用;1启用]
 * @property int $created_at 添加时间
 * @property int $updated_at 修改时间
 */
class FansStat extends \common\models\base\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yun_net_wechat_fans_stat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['merchant_id', 'new_attention', 'cancel_attention', 'cumulate_attention', 'status', 'created_at', 'updated_at'], 'integer'],
            [['date'], 'required'],
            [['date'], 'safe'],
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
            'new_attention' => 'New Attention',
            'cancel_attention' => 'Cancel Attention',
            'cumulate_attention' => 'Cumulate Attention',
            'date' => 'Date',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
