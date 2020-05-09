<?php

namespace addons\YunWechat\common\models\base;

use Yii;

/**
 * This is the model class for table "yun_net_wechat_qrcode".
 *
 * @property int $id
 * @property int $merchant_id 商户id
 * @property string $name 场景名称
 * @property string $keyword 关联关键字
 * @property int $scene_id 场景ID
 * @property string $scene_str 场景值
 * @property int $model 类型
 * @property string $ticket ticket
 * @property int $expire_seconds 有效期
 * @property int $subnum 扫描次数
 * @property string $type 二维码类型
 * @property int $extra
 * @property string $url url
 * @property int $end_time
 * @property int $status 状态(-1:已删除,0:禁用,1:正常)
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 */
class Qrcode extends \common\models\base\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%wechat_qrcode}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['merchant_id', 'scene_id', 'model', 'expire_seconds', 'subnum', 'extra', 'end_time', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['keyword'], 'string', 'max' => 100],
            [['scene_str'], 'string', 'max' => 64],
            [['ticket'], 'string', 'max' => 250],
            [['type'], 'string', 'max' => 10],
            [['url'], 'string', 'max' => 80],
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
            'name' => 'Name',
            'keyword' => 'Keyword',
            'scene_id' => 'Scene ID',
            'scene_str' => 'Scene Str',
            'model' => 'Model',
            'ticket' => 'Ticket',
            'expire_seconds' => 'Expire Seconds',
            'subnum' => 'Subnum',
            'type' => 'Type',
            'extra' => 'Extra',
            'url' => 'Url',
            'end_time' => 'End Time',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
