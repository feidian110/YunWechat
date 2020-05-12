<?php

namespace addons\YunWechat\common\models\base;

use Yii;

/**
 * This is the model class for table "yun_net_wechat_form_id".
 *
 * @property int $id
 * @property int $merchant_id 商户id
 * @property int $member_id 用户id
 * @property string $form_id formid
 * @property int $stoped_at 失效时间
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 */
class FormId extends \common\models\base\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%wechat_form_id}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['merchant_id', 'member_id', 'stoped_at', 'created_at', 'updated_at'], 'integer'],
            [['member_id'], 'required'],
            [['form_id'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'merchant_id' => '商户id',
            'member_id' => '用户id',
            'form_id' => 'formid',
            'stoped_at' => '失效时间',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            // 小程序formid有效时间为7天
            $this->stoped_at = time() + 7 * 24 * 60 * 60 - 60;
        }

        return parent::beforeSave($insert);
    }
}
