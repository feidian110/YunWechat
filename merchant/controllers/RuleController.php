<?php


namespace addons\YunWechat\merchant\controllers;


use addons\YunWechat\common\models\rule\Keyword;
use addons\YunWechat\common\models\rule\Rule;
use addons\YunWechat\merchant\forms\RuleForm;
use common\enums\StatusEnum;
use common\traits\MerchantCurd;
use Yii;
use yii\data\Pagination;
use yii\helpers\Json;

class RuleController extends BaseController
{
    use MerchantCurd;

    public $modelClass = Rule::class;

    public function actionIndex()
    {
        $request = Yii::$app->request;
        $module = $request->get('module', null);
        $keyword = $request->get('keyword', null);

        $data = Rule::find()
            ->where(['>=', 'status', StatusEnum::DISABLED])
            ->andWhere(['in', 'module', array_keys(Rule::$moduleExplain)])
            ->andFilterWhere(['module' => $module])
            ->andWhere(['merchant_id' => $this->getMerchantId()])
            ->andFilterWhere(['like', 'name', $keyword]);

        $pages = new Pagination(['totalCount' => $data->count(), 'pageSize' => $this->pageSize]);
        $models = $data->offset($pages->offset)
            ->orderBy('sort desc, created_at desc')
            ->with('ruleKeyword')
            ->limit($pages->limit)
            ->all();

        return $this->render($this->action->id, [
            'models' => $models,
            'pages' => $pages,
            'modules' => Rule::$moduleExplain,
            'module' => $module,
            'keyword' => $keyword,
        ]);
    }

    public function actionEdit()
    {
        $request = Yii::$app->request;
        $id = $request->get('id');
        $model = $this->findModel($id);
        $defaultRuleKeywords = Yii::$app->yunWechatService->ruleKeyword->getType($model->ruleKeyword);
        $postData = Yii::$app->request->post();

        $this->activeFormValidate($model);
        if ($model->load($postData)) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                if (!$model->save()) {
                    throw new \Exception($this->getError($model));
                }

                // 全部关键字
                $ruleKey = $postData['ruleKey'] ?? [];
                $ruleKey[Keyword::TYPE_MATCH] = explode(',', $model->keyword);
                // 更新关键字
                Yii::$app->yunWechatService->ruleKeyword->update($model, $ruleKey, $defaultRuleKeywords);
                $transaction->commit();

                return $this->redirect(['index', 'module' => $model->module]);
            } catch (\Exception $e) {
                $transaction->rollBack();
                return $this->message($e->getMessage(), $this->redirect(['index']), 'error');
            }
        }

        return $this->render($this->action->id, [
            'model' => $model,
            'ruleKeywords' => $defaultRuleKeywords,
            'modules' => Json::encode(Rule::$moduleExplain),
            'apiList' => Yii::$app->yunWechatService->rule->getApiList(),
        ]);
    }

    protected function findModel($id)
    {
        if (empty($id) || empty(($model = RuleForm::findOne(['id' => $id, 'merchant_id' => $this->getMerchantId()])))) {
            $model = new RuleForm();
            return $model->loadDefaultValues();
        }

        return $model;
    }
}