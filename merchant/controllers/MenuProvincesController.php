<?php

namespace addons\YunWechat\merchant\controllers;



use common\helpers\Html;
use common\helpers\ResultHelper;
use Yii;
use yii\filters\AccessControl;

class MenuProvincesController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],// 登录
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($title)
    {
        $model = Yii::$app->yunWechatService->menuProvinces->getListByTitle($title);

        $str = Html::tag('option', '不限', ['value' => '']);
        foreach ($model as $value => $name) {
            $str .= Html::tag('option', Html::encode($name), ['value' => $value]);
        }

        return ResultHelper::json(200, '查询成功', $str);
    }
}