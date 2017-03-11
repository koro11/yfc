<?php
use \yii\helpers\Url;
$this->beginContent('@app/views/layouts/main.php');
?>
<section class="Psection MT20">
    <nav class="U-nav Font14 FontW">
        <ul>
            <li><i></i><a href="<?=Url::to('user/user_index')?>">用户中心首页</a></li>
            <li><i></i><a href="<?=Url::to('user/user_orderlist')?>">我的订单</a></li>
            <li><i></i><a href="<?=Url::to('user/user_address')?>">收货地址</a></li>
            <li><i></i><a href="<?=Url::to('user/user_message')?>">我的留言</a></li>
            <li><i></i><a href="<?=Url::to('user/user_coupon')?>">我的优惠券</a></li>
            <li><i></i><a href="<?=Url::to('user/user_collect')?>">我的收藏</a></li>
            <li><i></i><a href="<?=Url::to('user/user_account')?>">账户管理</a></li>
            <li><i></i><a href="<?=Url::to('login/out')?>">安全退出</a></li>
        </ul>
    </nav>
<?= $content ?>

<div class="F-link">
    <!--<span>友情链接：</span>
    <a href="http://www.deathghost.cn" target="_blank" title="DeathGhost">DeathGhost</a>
    <a href="http://www.sucaihuo.com/pins/15966.html" target="_blank" title="免费后台管理模板">绿色清爽版通用型后台管理模板免费下载</a>
    <a href="http://www.sucaihuo.com/pins/17567.html" target="_blank" title="果蔬菜类模板源码">HTML5果蔬菜类模板源码</a>
    <a href="http://www.sucaihuo.com/pins/14931.html" target="_blank" title="黑色的cms商城网站后台管理模板">黑色的cms商城网站后台管理模板</a>-->
</div>
<?php $this->endContent();?>