<?php

namespace addons\YunWechat\common\models\base;

use Yii;

/**
 * This is the model class for table "yun_net_demo_data".
 *
 * @property int $id
 * @property string $data1
 * @property string $data2
 * @property string $data3
 * @property string $data4
 * @property string $data5
 * @property string $data6
 * @property int $created_at
 * @property int $updated_at
 */
class DemoData extends \common\models\base\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%demo_data}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data1', 'data2', 'data3', 'data4', 'data5', 'data6'], 'required'],
            [['data1', 'data2', 'data3', 'data4', 'data5', 'data6'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data1' => 'Data1',
            'data2' => 'Data2',
            'data3' => 'Data3',
            'data4' => 'Data4',
            'data5' => 'Data5',
            'data6' => 'Data6',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
