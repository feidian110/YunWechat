<?php

namespace addons\YunWechat\merchant\controllers;

use Yii;
class AuthController extends  BaseController
{
    public function actionIndex()
    {
        //$app = Yii::$app->wechat->getApp();
        $app = Yii::$app->yunWechatService->account->getAccount();
        $list = $app->user->list();
        var_dump($list);die;
    }
}