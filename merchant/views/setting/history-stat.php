<?php

use addons\YunWechat\common\enums\ServiceTypeEnum;

use common\helpers\ImageHelper;
$this->title = '绑定微信公众号';
?>

    <div class="row" style="align-content: center">
        <div class="col-md-4">
            <?php if( $bind == null ):?>
                <a href="<?=$url;?>" class="btn btn-info btn-sm">绑定公众号</a>
            <?php else:?>
                <div class="box box-widget widget-user-2">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-aqua">
                        <div class="widget-user-image">
                            <img class="img-circle" src="<?= ImageHelper::default($bind['head_img']);?>" alt="User Avatar">
                        </div>
                        <!-- /.widget-user-image -->
                        <h3 class="widget-user-username"><?=$bind['nick_name'];?></h3>
                        <h5 class="widget-user-desc" style="padding-top: 10px"><?= $bind['verify_type_info'] >= 0 ? '<i class="fa fa-fw fa-check-circle"></i> 已认证' : '<i class="fa fa-fw fa-check-circle text-gray"></i> 未认证';?>
                            <?= ServiceTypeEnum::getValue($bind['service_type_info']);?>
                         </h5>
                    </div>
                    <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                            <li><a href="#">Projects <span class="pull-right badge bg-blue">31</span></a></li>
                            <li><a href="#">Tasks <span class="pull-right badge bg-aqua">5</span></a></li>
                            <li><a href="#">Completed Projects <span class="pull-right badge bg-green">12</span></a></li>
                            <li><a href="#">Followers <span class="pull-right badge bg-red">842</span></a></li>
                        </ul>
                    </div>
                </div>
            <?php endif;?>

        </div>
    </div>



