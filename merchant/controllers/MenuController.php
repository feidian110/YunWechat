<?php
namespace addons\YunWechat\merchant\controllers;

use addons\YunWechat\common\models\account\Bind;
use addons\YunWechat\common\models\account\Menu;
use common\helpers\ResultHelper;
use Yii;
use yii\data\Pagination;

class MenuController extends BaseController
{

    /**
     * 菜单列表
     * @return string
     * @throws \EasyWeChat\Kernel\Exceptions\HttpException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \yii\web\UnprocessableEntityHttpException
     */
    public function actionIndex()
    {
        $type = Yii::$app->request->get('type', Menu::TYPE_CUSTOM);
        $data = Menu::find()
            ->where(['type' => $type])
            ->andWhere(['merchant_id' => $this->getMerchantId()]);
        $pages = new Pagination(['totalCount' => $data->count(), 'pageSize' => $this->pageSize]);
        $models = $data->offset($pages->offset)
            ->orderBy('status desc, id desc')
            ->limit($pages->limit)
            ->all();

        $openPlatform = Yii::$app->wechat->getOpenPlatform();
        $app = Bind::findOne(['merchant_id'=>Yii::$app->services->merchant->getId()]);
        $account = $openPlatform->officialAccount((string)$app['appid'], (string)$app['refresh_token']);
        // 查询下菜单
        !$models && Yii::$app->debris->getWechatError($account->menu->list());
        return $this->render( $this->action->id,[
            'pages' => $pages,
            'models' => $models,
            'type' => $type,
            'types' => Menu::$typeExplain,
        ] );
    }

    public function actionSync()
    {
        try {
            $openPlatform = Yii::$app->wechat->getOpenPlatform();
            $app = Bind::findOne(['merchant_id'=>Yii::$app->services->merchant->getId()]);
            $account = $openPlatform->officialAccount((string)$app['appid'], (string)$app['refresh_token']);
            $account->menu->sync();
            return ResultHelper::json(200, '同步菜单成功');
        } catch (\Exception $e) {
            return ResultHelper::json(422, $e->getMessage());
        }
    }
}