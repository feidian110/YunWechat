<?php


namespace addons\YunWechat\common\services\rule;


use addons\YunWechat\common\models\rule\KeywordStat;
use common\components\Service;

class RuleKeywordStatService extends Service
{
    /**
     * 插入关键字统计
     *
     * @param $rule_id
     * @param $keyword_id
     */
    public function set($rule_id, $keyword_id)
    {
        $ruleKeywordStat = KeywordStat::find()
            ->where([
                'rule_id' => $rule_id,
                'keyword_id' => $keyword_id,
                'created_at' => strtotime(date('Y-m-d'))
            ])
            ->andFilterWhere(['merchant_id' => $this->getMerchantId()])
            ->one();

        if ($ruleKeywordStat) {
            $ruleKeywordStat->hit += 1;
        } else {
            $ruleKeywordStat = new KeywordStat();
            $ruleKeywordStat->rule_id = $rule_id;
            $ruleKeywordStat->keyword_id = $keyword_id;
        }

        $ruleKeywordStat->save();
    }
}