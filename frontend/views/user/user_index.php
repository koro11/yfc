<?php use \yii\helpers\Url;?>
 <article class="U-article Overflow">
  <!--"引用“user_page/user_index.html”"-->
  <section class="usercenter">
   <span class="Weltitle Block Font16 CorRed FontW Lineheight35">Welcome欢迎光临！</span>
   <div class="U-header MT20 Overflow">
    <?php if (empty($user['user_image'])){?>
    <img src="upload/testuser.jpg">
    <?php }else{?>
    <img src="<?= $user['user_image']?>">
    <?php }?>
    <p class="Font14 FontW"><?= $user['user_name']?>&nbsp;&nbsp;&nbsp;&nbsp;欢迎您回到 用户中心！</p>
    <p class="Font12">您的上一次登录时间:<time><?= date('Y-m-d,H:i:s',$user['users']['last_logintime'])?> </time></p>
    <p class="Font12 CorRed FontW">我的优惠券( <?= $user['ticket']?> ) | 我的积分( <?= $user['user_score']?>)</p>
   </div>
    <ul class="s-States Overflow FontW" id="Lbn">
     <li class="Font14 FontW">幸福业务在线提醒：</li>
     <li><a href="<?=Url::to(['user/user_orderlist','key'=>'pay_status','value'=>0,'k'=>'shipping_status','v'=>0])?>">待付款( <?= $order['pay']?> )</a></li>
     <li><a href="<?=Url::to(['user/user_orderlist','key'=>'pay_status','value'=>1,'k'=>'shipping_status','v'=>0])?>">待发货( <?= $order['ship']?> )</a></li>
     <li><a href="<?=Url::to(['user/user_orderlist','key'=>'pay_status','value'=>1,'k'=>'shipping_status','v'=>1])?>">待收货( <?= $order['shipping']?> )</a></li>
     <li><a href="<?=Url::to(['user/user_orderlist','key'=>'shipping_status','value'=>2,'k'=>'order_speak','v'=>0])?>">待评价( <?= $order['speak']?> )</a></li>
    </ul>
  </section>
 </article>
</section>
<!--End content-->

