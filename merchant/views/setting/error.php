<?php

?>

<div class="text-center">

    <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> 错误码#<?= $code;?></h3>

        <p>
            <?php if( $code == 48001 ){
                echo "api 功能未授权，请确认公众号已获得该接口,认证服务号才能使用此功能";
            }?>
        </p>

    </div>
</div>
