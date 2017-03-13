<?php
use \yii\helpers\Url;
$this->beginContent('@app/views/layouts/main.php');
?>
<section class="Psection MT20">
<nav class="U-nav Font14 FontW">
  <ul>
   <li><i></i><a href="<?=Url::to(['shop/shop_center'])?>">商家中心首页</a></li>
   <li><i></i><a href="<?=Url::to(['shop/shop_complete_info'])?>">完善信息</a></li>
   <li><i></i><a href="<?=Url::to(['shop/shop_foods'])?>">菜谱</a></li>
   <li><i></i><a href="<?=Url::to(['shop/shop_addfood'])?>">添加菜谱</a></li>
   <li><i></i><a href="<?=Url::to(['shop/shop_orders'])?>">订单</a></li>
   <li><i></i><a href="<?=Url::to(['shop/shop_tickets'])?>">优惠券</a></li>
   <li><i></i><a href="<?=Url::to(['shop/shop_issue_tickets'])?>">发行优惠券</a></li>
   <li><i></i><a href="<?=Url::to(['shop/shop_messages'])?>">顾客留言</a></li>
   <!-- <li><i></i><a href="user_account.html">账户管理</a></li> -->
   <li><i></i><a href="<?=Url::to(['shop/login_out'])?>">安全退出</a></li>
  </ul>
 </nav>
<?= $content ?>

<?php $this->endContent();?>