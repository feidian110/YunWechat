<?php

namespace addons\YunWechat\common\models\base;

use common\behaviors\MerchantBehavior;
use common\helpers\StringHelper;
use Yii;

/**
 * This is the model class for table "yun_net_wechat_mass_record".
 *
 * @property int $id
 * @property int $merchant_id 商户id
 * @property int $msg_id 微信消息id
 * @property string $msg_data_id 图文消息数据id
 * @property int $tag_id 标签id
 * @property string $tag_name 标签名称
 * @property int $fans_num 粉丝数量
 * @property string $module 模块类型
 * @property string $data
 * @property int $send_type 发送类别 1立即发送2定时发送
 * @property int $send_time 发送时间
 * @property int $send_status 0未发送 1已发送
 * @property int $final_send_time 最终发送时间
 * @property string $error_content 报错原因
 * @property int $status 状态[-1:删除;0:禁用;1启用]
 * @property int $created_at
 * @property int $updated_at 修改时间
 */
class MassRecord extends \common\models\base\BaseModel
{
    use MerchantBehavior;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%wechat_mass_record}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tag_id'], 'required'],
            [['send_type', 'fans_num', 'msg_id', 'msg_data_id', 'tag_id', 'send_status', 'final_send_time', 'status', 'created_at', 'updated_at'], 'integer'],
            [['tag_name', 'module'], 'string', 'max' => 50],
            [['error_content'], 'string'],
            [['send_time'], 'safe'],
            [['data'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fans_num' => '粉丝数量',
            'msg_id' => '消息ID',
            'tag_id' => '粉丝标签',
            'tag_name' => '标签名称',
            'send_type' => '发送类型',
            'send_time' => '发送时间',
            'send_status' => '发送状态',
            'final_send_time' => '实际发送时间',
            'error_content' => '报错原因',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachment()
    {
        return $this->hasOne(Attachment::class, ['id' => 'data']);
    }

    public function beforeSave($insert)
    {
        $this->send_time = StringHelper::dateToInt($this->send_time);
        return parent::beforeSave($insert);
    }
}
