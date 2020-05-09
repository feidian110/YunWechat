<?php


namespace addons\YunWechat\merchant\controllers;


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

        return $this->render('index', [
            'tags' => Yii::$app->yunWechatService->fansTags->getList()
        ]);
    }
}