<?php


namespace addons\YunWechat\merchant\controllers;


use addons\YunWechat\common\models\fans\FansTagMap;
use Yii;

class FansTagsController extends BaseController
{
    public function actionIndex()
    {
        if (Yii::$app->request->isPost) {
            try {
                $createData = Yii::$app->request->post('createData', []);
                $updateData = Yii::$app->request->post('updateData', []);
                Yii::$app->yunWechatService->fansTags->syncSave($createData, $updateData);

                return $this->message("保存成功", $this->redirect(['index']));
            } catch (\Exception $e) {
                return $this->message($e->getMessage(), $this->redirect(['index']), 'error');
            }
        }
        $tags = Yii::$app->yunWechatService->fansTags->getList();
        if( isset($tags['errcode']) ){
            return $this->redirect( ['setting/error','code'=>$tags['errcode']] );
        }
        return $this->render('index', [
            'tags' => $tags
        ]);
    }

    public function actionDelete($id)
    {
        $res = Yii::$app->yunWechatService->account->getAccount($this->getMerchantId())->user_tag->delete($id);
        if ($error = Yii::$app->debris->getWechatError($res, false)) {
            FansTagMap::deleteAll(['tag_id' => $id]);
            return $this->message($error, $this->redirect(['index']), 'error');
        }

        Yii::$app->yunWechatService->fansTags->getList(true);
        return $this->message('删除成功', $this->redirect(['index']));
    }

    /**
     * 同步标签
     * @return mixed|string
     * @throws \EasyWeChat\Kernel\Exceptions\HttpException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \yii\web\UnprocessableEntityHttpException
     */
    public function actionSynchro()
    {
        Yii::$app->yunWechatService->fansTags->getList(true);
        return $this->message("粉丝同步成功", $this->redirect(['index']));
    }
}