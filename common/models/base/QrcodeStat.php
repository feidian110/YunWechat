<?php

namespace addons\YunWechat\common\models\base;

use addons\YunWechat\common\models\fans\Fans;
use common\behaviors\MerchantBehavior;
use Yii;

/**
 * This is the model class for table "yun_net_wechat_qrcode_stat".
 *
 * @property int $id
 * @property int $merchant_id 商户id
 * @property int $qrcord_id 二维码id
 * @property string $openid 微信openid
 * @property int $type 1:关注;2:扫描
 * @property string $name 场景名称
 * @property string $scene_str 场景值
 * @property int $scene_id 场景ID
 * @property int $status 状态(-1:已删除,0:禁用,1:正常)
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 */
class QrcodeStat extends \common\models\base\BaseModel
{
    use MerchantBehavior;

    const TYPE_ATTENTION = 1;
    const TYPE_SCAN = 2;

    /**
     * @var array
     */
    public static $typeExplain = [
        self::TYPE_ATTENTION => '关注',
        self::TYPE_SCAN => '扫描',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%wechat_qrcode_stat}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['merchant_id', 'qrcord_id', 'type', 'scene_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['openid', 'name'], 'string', 'max' => 50],
            [['scene_str'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'qrcord_id' => '二维码id',
            'openid' => '用户openid',
            'type' => '二维码类别',
            'name' => '二维码名称',
            'scene_str' => '场景值',
            'scene_id' => '场景id',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

    public function getFans()
    {
        return $this->hasOne(Fans::class, ['openid' => 'openid'])->select('openid, nickname, follow');
    }
}
