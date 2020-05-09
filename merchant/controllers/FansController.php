<?php


namespace addons\YunWechat\merchant\controllers;


use addons\YunWechat\common\models\fans\Fans;
use common\helpers\ArrayHelper;
use Yii;
use yii\data\Pagination;

class FansController extends BaseController
{
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $follow = $request->get('follow', 1);
        $tag_id = $request->get('tag_id', null);
        $keyword = $request->get('keyword', null);

        $where = $keyword ? ['or', ['like', 'f.openid', $keyword], ['like', 'f.nickname', $keyword]] : [];

        // 关联角色查询
        $data = Fans::find()
            ->where($where)
            ->alias('f')
            ->andWhere(['f.follow' => $follow])
            ->joinWith("tags AS t", true, 'LEFT JOIN')
            ->filterWhere(['t.tag_id' => $tag_id])
            ->andFilterWhere(['f.merchant_id' => $this->getMerchantId()]);

        $pages = new Pagination(['totalCount' => $data->count(), 'pageSize' => $this->pageSize]);
        $models = $data->offset($pages->offset)
            ->with('tags', 'member')
            ->orderBy('followtime desc, unfollowtime desc')
            ->limit($pages->limit)
            ->all();

        // 全部标签
        $tags = Yii::$app->yunWechatService->fansTags->getList();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
            'follow' => $follow,
            'keyword' => $keyword,
            'tag_id' => $tag_id,
            'all_fans' => Yii::$app->yunWechatService->fans->getCountFollow(),
            'fansTags' => $tags,
            'allTag' => ArrayHelper::map($tags, 'id', 'name'),
        ]);
    }
}