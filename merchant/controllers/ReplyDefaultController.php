<?php


namespace addons\YunWechat\merchant\controllers;


use addons\YunWechat\common\models\base\ReplyDefault;
use common\helpers\ArrayHelper;
use Yii;

class ReplyDefaultController extends BaseController
{
    /**
     * 首页
     *
     * @return mixed|string
     */
    public function actionIndex()
    {
        $model = $this->findModel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->message('修改成功', $this->redirect(['index']));
        }

        // 关键字
        $keyword = Yii::$app->wechatService->ruleKeyword->getList();
        $keyword = ArrayHelper::map($keyword, 'content', 'content');
        $keyword = ArrayHelper::merge([' ' => '不触发关键字'], $keyword);

        return $this->render('index', [
            'model' => $model,
            'keyword' => $keyword
        ]);
    }

    /**
     * 返回模型
     *
     * @return array|ReplyDefault|null|yii\db\ActiveRecord
     */
    protected function findModel()
    {
        if (empty(($model = ReplyDefault::findOne(['merchant_id' => $this->getMerchantId()])))) {
            return new ReplyDefault;
        }

        return $model;
    }
}