<?php
namespace addons\YunWechat\merchant\controllers;

use addons\YunWechat\common\models\base\MassRecord;
use addons\YunWechat\merchant\forms\SendForm;
use common\enums\StatusEnum;
use common\traits\MerchantCurd;
use Yii;
use yii\data\Pagination;
use yii\web\UnprocessableEntityHttpException;

class MassRecordController extends BaseController
{
    use MerchantCurd;

    /**
     * @var MassRecord
     */
    public $modelClass = MassRecord::class;

    /**
     * 列表页面
     * @return string
     */
    public function actionIndex()
    {
        $data = MassRecord::find()->where(['merchant_id' => $this->getMerchantId()]);
        $pages = new Pagination(['totalCount' => $data->count(), 'pageSize' => $this->pageSize]);
        $models = $data->offset($pages->offset)
            ->orderBy('id desc')
            ->limit($pages->limit)
            ->all();

        return $this->render($this->action->id, [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    /**
     * 创建或者编辑页面
     * @return mixed|string|\yii\web\Response
     * @throws UnprocessableEntityHttpException
     * @throws \EasyWeChat\Kernel\Exceptions\HttpException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \yii\base\ExitException
     */
    public function actionEdit()
    {
        $request = Yii::$app->request;
        $id = $request->get('id', null);
        $model = $this->findModel($id);
        $model->send_status == StatusEnum::DISABLED && $model->send_type = 2;

        $this->activeFormValidate($model);
        if ($model->load($request->post())) {
            try {
                if (!$model->save()) {
                    throw new UnprocessableEntityHttpException($this->getError($model));
                }

                return $this->redirect(['index']);
            } catch (\Exception $e) {
                return $this->message($e->getMessage(), $this->redirect(['index']), 'error');
            }
        }

        return $this->render($this->action->id, [
            'model' => $model,
            'tags' => Yii::$app->yunWechatService->fansTags->getList(),
        ]);
    }

    protected function findModel($id)
    {
        if (empty($id) || empty(($model = SendForm::findOne($id)))) {
            $model = new SendForm();
            return $model->loadDefaultValues();
        }

        return $model;
    }
}