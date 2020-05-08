<?php

namespace addons\YunWechat\merchant\controllers;

use addons\YunWechat\common\models\account\Bind;
use Yii;
use common\helpers\ArrayHelper;
use common\interfaces\AddonsSetting;
use addons\YunWechat\common\models\SettingForm;

/**
 * 参数设置
 *
 * Class SettingController
 * @package addons\YunWechat\merchant\controllers
 */
class SettingController extends BaseController implements AddonsSetting
{
    /**
     * @return mixed|string
     */
    public function actionDisplay()
    {
        $request = Yii::$app->request;
        $model = new SettingForm();
        $model->attributes = $this->getConfig();
        if ($model->load($request->post()) && $model->validate()) {
            $this->setConfig(ArrayHelper::toArray($model));
            return $this->message('修改成功', $this->redirect(['display']));
        }

        return $this->render('display',[
            'model' => $model,
        ]);
    }

    public function actionHistoryStat()
    {
        $app = Yii::$app->wechat->getOpenPlatform();
        $url = $app->getPreAuthorizationUrl('http://zebra.yun-net.com/merchant/yun-wechat/setting/call-back?merchantid='.Yii::$app->services->merchant->getId());
        return $this->render( $this->action->id,[
            'url' =>$url
        ] );
    }

    public function actionCallBack()
    {
        $request = Yii::$app->request->get();
        $authCode =$request['auth_code'];

        $openPlatform = Yii::$app->wechat->getOpenPlatform();
        $data = $openPlatform->handleAuthorize((string)$authCode);
        $info =$openPlatform->getAuthorizer((string)$data['authorization_info']['authorizer_appid']);

        $model = Bind::findOne(['merchant_id'=>Yii::$app->services->merchant->getId(),'appid'=>$data['authorization_info']['authorizer_appid']]);
        if( $model == null ){
            $model = new Bind();
            $model->merchant_id = Yii::$app->services->merchant->getId();
            $model-> appid = $data['authorization_info']['authorizer_appid'];
        }
        $model-> access_token = $data['authorization_info']['authorizer_access_token'] ?? null;
        $model-> refresh_token = $data['authorization_info']['authorizer_refresh_token'] ?? null;
        $model-> access_token_expires = $data['authorization_info']['expires_in'] ?? null;
        $model-> nick_name = $info['authorizer_info']['nick_name'];
        $model-> head_img = $info['authorizer_info']['head_img'];
        $model-> service_type_info = $info['authorizer_info']['service_type_info']['id'];
        $model-> verify_type_info = $info['authorizer_info']['verify_type_info']['id'];
        $model-> user_name = $info['authorizer_info']['user_name'];
        $model-> alias = $info['authorizer_info']['alias'] ?? "";
        $model-> qrcode_url = $info['authorizer_info']['qrcode_url'];
        $model-> principal_name = $info['authorizer_info']['principal_name'];
        $model-> signature = $info['authorizer_info']['signature'];
        $model-> open_store = $info['authorizer_info']['business_info']['open_store'];
        $model-> open_scan = $info['authorizer_info']['business_info']['open_scan'];
        $model-> open_shake = $info['authorizer_info']['business_info']['open_shake'];
        $model-> open_card = $info['authorizer_info']['business_info']['open_card'];
        $model-> open_pay = $info['authorizer_info']['business_info']['open_pay'];
        if( $model->save() ){
            return $this->redirect( ['history-stat'] );
        }
        return $this->redirect( ["/site/error"] );
    }
}