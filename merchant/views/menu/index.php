<?php

use yii\widgets\LinkPager;
use common\helpers\Url;
use common\helpers\Html;
use common\helpers\Auth;
use addons\Wechat\common\enums\MenuSex;
use addons\Wechat\common\enums\MenuLanguageEnum;
use addons\Wechat\common\enums\MenuClientPlatformTypeEnum;
use addons\Wechat\common\models\Menu;

$this->title = Menu::$typeExplain[$type];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<div class="row">
    <div class="col-sm-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <?php foreach ($types as $key => $value) { ?>
                    <li <?php if ($key == $type){ ?>class="active"<?php } ?>><a
                            href="<?= Url::to(['index', 'type' => $key]) ?>"> <?= $value ?></a></li>
                <?php } ?>
                <li class="pull-right">
                    <div class="row">
                        <div class="col-lg-12 normalPaddingTop">
                            <!-- 权限校验判断 -->
                            <?php if (Auth::verify('/yun-wechat/menu/sync')) { ?>
                                <a class="btn btn-primary btn-xs" id="getNewMenu">
                                    <i class="fa fa-cloud-download"></i> 同步
                                </a>
                            <?php } ?>
                            <?= Html::create(['edit', 'type' => $type]) ?>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="tab-content">
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-warning"></i> 提示!</h4>
                    <?php if( $type == 1 ){
                        echo '<ul>
                        <li>使用本模块生成微信端，必须在微信公众平台申请自定义菜单使用的AppId和AppSecret</li>
                        <li>微信端最多创建3 个一级菜单，每个一级菜单下最多可以创建 5 个二级菜单，菜单最多支持两层。（多出部分会生成前3个一级菜单）</li>
                        <li>如果您绑定的是订阅号，自定菜单是不可用的</li>
                    </ul>';
                    }else{
                        echo '<ul>
<li>必须在微信公众平台申请自定义菜单使用的AppId和AppSecret</li>
<li>最多创建3 个一级菜单，每个一级菜单下最多可以创建 5 个二级菜单，菜单最多支持两层。（多出部分会生成前3个一级菜单）</li>
<li>该功能开放给已认证订阅号和已认证服务号。</li>
<li>当公众号创建多个个性化菜单时，将按照生成菜单时间顺序，由新到旧逐一匹配，如果全部个性化菜单都没有匹配成功，则显示默认菜单</li>
<li>必须要有一个默认菜单才可以添加个性化自定义菜单，点击进入【自定义菜单】来设置默认菜单。</li>
<li>个性化菜单要求用户的微信客户端版本在iPhone6.2.2，Android 6.2.4以上。</li>
<li>最多只能设置为跳转到3个域名下的链接</li>
</ul>';
                    }?>

                </div>
                <div class="active tab-pane">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>标题</th>
                            <th>显示对象</th>
                            <th>是否在微信生效</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($models as $model) { ?>
                            <tr>
                                <td><?= $model->id ?></td>
                                <td><?= $model->title ?></td>
                                <td>
                                    <?php if ($model->type == 1) { ?>
                                        全部粉丝
                                    <?php } else { ?>
                                        性别: <?= MenuSex::getValue($model->sex); ?><br>
                                        手机系统: <?= MenuClientPlatformTypeEnum::getValue($model->client_platform_type); ?>
                                        <br>
                                        语言: <?= MenuLanguageEnum::getValue($model->language); ?><br>
                                        标签: <?= empty($model->tag_id) ? '全部粉丝' : Yii::$app->wechatService->fansTags->findById($model->tag_id)['name']; ?>
                                        <br>
                                        地区: <?= empty($model->province . $model->city) ? '不限' : $model->province . '·' . $model->city; ?>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($model->status == 1) { ?>
                                        <span class="text-success">菜单生效中</span>
                                    <?php } else { ?>
                                        <a href="<?= Url::to(['save', 'id' => $model->id]) ?>" class="color-default">生效并置顶</a>
                                    <?php } ?>
                                </td>
                                <td><?= Yii::$app->formatter->asDatetime($model->created_at) ?></td>
                                <td>
                                    <?= Html::edit(['edit', 'id' => $model->id, 'type' => $model->type],
                                        $model->type == 2 ? '查看' : '编辑'); ?>
                                    <?php if ($model->status == 0 || $model->type == 2) { ?>
                                        <?= Html::delete(['delete', 'id' => $model->id, 'type' => $model->type]); ?>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-12">
                            <?= LinkPager::widget([
                                'pagination' => $pages,
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
    // 获取资源
    $("#getNewMenu").click(function () {
        rfAffirm('同步中,请不要关闭当前页面');
        sync();
    });

    // 同步菜单
    function sync() {
        $.ajax({
            type: "get",
            url: "<?= Url::to(['sync'])?>",
            dataType: "json",
            success: function (data) {
                if (data.code == 200) {
                    rfAffirm(data.message);
                    window.location.reload();
                } else {
                    rfAffirm(data.message);
                }
            }
        });
    }
</script>