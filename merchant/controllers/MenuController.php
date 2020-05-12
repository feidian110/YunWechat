<?php
namespace addons\YunWechat\merchant\controllers;

use addons\YunWechat\common\models\base\Menu;
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

        $account = Yii::$app->yunWechatService->account->getAccount();
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
            Yii::$app->yunWechatService->menu->sync();
            return ResultHelper::json(200, '同步菜单成功');
        } catch (\Exception $e) {
            return ResultHelper::json(422, $e->getMessage());
        }

    }

    public function actionEdit()
    {
        $request = Yii::$app->request;
        $id = $request->get('id');
        $type = $request->get('type');
        $model = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            $postInfo = Yii::$app->request->post();
            $model = $this->findModel($postInfo['id']);
            $model->attributes = $postInfo;

            if (!isset($postInfo['list'])) {
                return ResultHelper::json(422, '请添加菜单');
            }

            try {
                Yii::$app->yunWechatService->menu->createSave($model, $postInfo['list']);
                return ResultHelper::json(200, "修改成功");
            } catch (\Exception $e) {
                return ResultHelper::json(422, $e->getMessage());
            }
        }
        if( $type == 2 ){
            $tags =  Yii::$app->yunWechatService->fansTags->getList();
            if( isset($tags['errcode']) ){
                return $this->redirect( ['setting/error','code'=>$tags['errcode']] );
            }
        }

        return $this->render('edit', [
            'model' => $model,
            'menuTypes' => Menu::$menuTypes,
            'type' => $type,
            'fansTags' => $tags ?? ""
        ]);

    }

    public function actionSave($id)
    {

        if ($id) {
            $model = $this->findModel($id);
            $model->save();

            // 创建微信菜单
            $createReturn = Yii::$app->yunWechatService->account->getAccount()
                ->menu->create($model->menu_data);
            // 解析微信接口是否报错
            if ($error = Yii::$app->debris->getWechatError($createReturn, false)) {
                return $this->message($error, $this->redirect(['index']), 'error');
            }
        }

        return $this->redirect(['index']);
    }

    public function actionDelete($id, $type)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            // 个性化菜单删除
            !empty($model['menu_id']) && Yii::$app->yunWechatService->account->getAccount()->menu->delete($model['menu_id']);
            return $this->message("删除成功", $this->redirect(['index', 'type' => $type]));
        }

        return $this->message("删除失败", $this->redirect(['index', 'type' => $type]), 'error');
    }

    protected function findModel($id)
    {
        if (empty($id) || empty(($model = Menu::findOne(['id' => $id, 'merchant_id' => $this->getMerchantId()])))) {
            $model = new Menu;
            return $model->loadDefaultValues();
        }

        return $model;
    }
}