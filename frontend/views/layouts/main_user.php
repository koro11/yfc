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

<?php $this->endContent();?>