<?php
namespace addons\YunWechat\common\services\fans;


use addons\YunWechat\common\models\fans\FansTags;
use common\components\Service;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

class FansTagsService extends Service
{
    /**
     * @param array $createData
     * @param array $updateData
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function syncSave($createData = [], $updateData = [])
    {
        // 更新标签
        foreach ($updateData as $key => $value) {
            if (empty($value)) {
                throw new NotFoundHttpException('标签内容不能为空');
            }

            Yii::$app->wechat->app->user_tag->update($key, $value);
        }

        // 插入标签
        foreach ($createData as $datum) {
            Yii::$app->wechat->app->user_tag->create($datum);
        }

        return $this->getList(true);
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function findById($id)
    {
        $tags = $this->getList();
        foreach ($tags as $vo) {
            if ($vo['id'] == $id) {
                return $vo;
            }
        }

        return false;
    }

    /**
     *
     * @param bool $reacquire
     * @return mixed
     * @throws \EasyWeChat\Kernel\Exceptions\HttpException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \yii\web\UnprocessableEntityHttpException
     */
    public function getList($reacquire = false)
    {
        if (empty(($model = FansTags::find()->filterWhere(['merchant_id' => $this->getMerchantId()])->one()))) {
            $model = new FansTags();
        }


        if ($model->isNewRecord || true === $reacquire) {
            $account = Yii::$app->yunWechatService->account->getAccount();
            $list = $account->user_tag->list();
            if( isset($list['errcode']) && $list['errcode'] == 48001 ){
                return $list;
            }
            Yii::$app->debris->getWechatError($list);
            $tags = isset($list['tags']) ? $list['tags'] : [];
            $model->tags = serialize($tags);
            $model->save();
        }

        return unserialize($model->tags);


    }
}