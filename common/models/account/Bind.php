<?php

namespace addons\YunWechat\common\models\account;

use Yii;

/**
 * This is the model class for table "yun_net_wechat_bind".
 *
 * @property string $id 主键
 * @property string $merchant_id 所属商家
 * @property string $appid 应用ID
 * @property string $access_token 接口调用令牌（在授权的公众号/小程序具备 API 权限时，才有此返回值）
 * @property int $access_token_expires access_token 的有效期（在授权的公众号/小程序具备API权限时，才有此返回值）
 * @property string $refresh_token 刷新令牌（在授权的公众号具备API权限时，才有此返回值），刷新令牌主要用于第三方平台获取和刷新已授权用户的 authorizer_access_token。一旦丢失，只能让用户重新授权，才能再次拿到新的刷新令牌。用户重新授权后，之前的刷新令牌会失效
 * @property string $nick_name 昵称
 * @property string $head_img 头像
 * @property int $service_type_info 类型[0:订阅号;1:由历史老帐号升级后的订阅号2:服务号]
 * @property int $verify_type_info 认证类型[-1:未认证,0:微信认证1:新浪微博认证2:腾讯微博认证;3:已资质认证通过但还未通过名称认证;4:已资质认证通过、还未通过名称认证，但通过了新浪微博认证;5:已资质认证通过、还未通过名称认证，但通过了腾讯微博认证;]
 * @property string $user_name 公众号原始ID
 * @property string $principal_name 公众号主体名称
 * @property string $alias 公众号微信号
 * @property string $qrcode_url 公众号二维码
 * @property int $open_store 是否开通微信门店功能[0:未开通，1:已开通]
 * @property int $open_scan 是否开通微信扫商品功能[0:未开通，1:已开通]
 * @property int $open_pay 是否开通微信支付功能[0:未开通，1:已开通]
 * @property int $open_card 是否开通微信卡券功能[0:未开通，1:已开通]
 * @property int $open_shake 是否开通微信摇一摇功能[0:未开通，1:已开通]
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class Bind extends \common\models\base\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%wechat_bind}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['merchant_id', 'access_token_expires', 'service_type_info', 'verify_type_info', 'open_store', 'open_scan', 'open_pay', 'open_card', 'open_shake', 'status', 'created_at', 'updated_at'], 'integer'],
            [['appid', 'nick_name', 'user_name'], 'string', 'max' => 64],
            [['access_token'], 'string', 'max' => 1000],
            [['refresh_token', 'alias'], 'string', 'max' => 100],
            [['head_img'], 'string', 'max' => 500],
            [['principal_name'], 'string', 'max' => 200],
            [['qrcode_url'], 'string', 'max' => 300],
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
            'appid' => 'Appid',
            'access_token' => 'Access Token',
            'access_token_expires' => 'Access Token Expires',
            'refresh_token' => 'Refresh Token',
            'nick_name' => 'Nick Name',
            'head_img' => 'Head Img',
            'service_type_info' => 'Service Type Info',
            'verify_type_info' => 'Verify Type Info',
            'user_name' => 'User Name',
            'principal_name' => 'Principal Name',
            'alias' => 'Alias',
            'qrcode_url' => 'Qrcode Url',
            'open_store' => 'Open Store',
            'open_scan' => 'Open Scan',
            'open_pay' => 'Open Pay',
            'open_card' => 'Open Card',
            'open_shake' => 'Open Shake',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
