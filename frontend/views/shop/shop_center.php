<article class="U-article Overflow">
  <!--"引用“user_page/user_index.html”"-->
  <section class="usercenter">
   <span class="Weltitle Block Font16 CorRed FontW Lineheight35">Welcome欢迎光临！</span>
   <div class="U-header MT20 Overflow">
    <img src="upload/testuser.jpg">
    <p class="Font14 FontW"><?=$merchant['mer_name']?> 欢迎来到 商家中心！</p>
    <p class="Font12">您的上一次登录时间:<time> <?=$merchant['mer_last_login']?></time></p>
    <!-- <p class="Font12 CorRed FontW">我的优惠券( 0 ) | 我的积分( 0 )</p> -->
   </div>
    <ul class="s-States Overflow FontW" id="Lbn">
     <li class="Font14 FontW">幸福业务在线提醒：</li>
     <li><a href="?r=shop/shop_orders">新订单( <?=$merchant['unship']?> )</a></li> 
    </ul>
  </section>
 </article>
</section>
