<?php if(isset($status) && $status == '-1'):?>
  <section class="Psection MT20 Textcenter"  >
    <!-- 订单提交成功后则显示如下 -->
    <p class="Font14 Lineheight35 FontW">支付失败</p>
    <p class="Font14 Lineheight35 FontW">失败原因可能是：<span class="CorRed"><?php echo $msg?></span></p>
    <p><button type="button" class="Submit"><a href="user_center.html">进入用户中心</button></p>
  </section>
<?php else:?>
<!--提交成功之后，将显示如下信息-->
<section class="Psection MT20 Textcenter"  >
  <!-- 订单提交成功后则显示如下 -->
  <p class="Font14 Lineheight35 FontW">支付成功</p>
  <p class="Font14 Lineheight35 FontW">您的订单编号为：<span class="CorRed"><?php echo $order?></span></p>
  <p class="Font14 Lineheight35 FontW">共计金额：<span class="CorRed">￥<?php echo $money?></span></p>
  <p><button type="button" class="Submit"><a href="user_center.html">进入用户中心</button></p>
</section>
<!--End content-->
<?php endif;?>
