<?php


namespace addons\YunWechat\merchant\controllers;


use addons\YunWechat\common\models\base\MsgHistory;
use addons\YunWechat\common\models\rule\Rule;
use common\enums\StatusEnum;
use common\models\base\SearchModel;
use common\traits\MerchantCurd;
use Yii;

class MsgHistoryController extends BaseController
{
    use MerchantCurd;

    public $modelClass = MsgHistory::class;

    public function actionIndex()
    {
        $searchModel = new SearchModel([
            'model' => $this->modelClass,
            'scenario' => 'default',
            'partialMatchAttributes' => ['message'], // 模糊查询
            'defaultOrder' => [
                'id' => SORT_DESC
            ],
            'pageSize' => $this->pageSize
        ]);

        $dataProvider = $searchModel
            ->search(Yii::$app->request->queryParams);
        $dataProvider->query
            ->andWhere(['>=', 'status', StatusEnum::DISABLED])
            ->andWhere(['merchant_id' => $this->getMerchantId()])
            ->with(['fans', 'rule']);

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'moduleExplain' => Rule::$moduleExplain,
        ]);
    }
}