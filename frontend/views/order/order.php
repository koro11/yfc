<!--Start content-->
<section class="Psection MT20" id="Cflow">
<!--如果用户未添加收货地址，则显示如下-->
<div class="confirm_addr_f">
<span class="flow_title">收货地址：</span>
  <?php if(empty($address)){?>
  <!--如果未添加地址，则显示此表单-->
  <form class="add_address" action="?r=order/add_address" method="post">
   <p><i>收件人姓名：</i><input type="text" name="cons_name" required></p>
   <p>
   <i>选择所在地：</i> 
   <select name="cons_city" selected="selected">
    <option>北京市</option>
   </select>
   <select name="cons_district">
   <?php foreach($area as $key => $val){?>
    <option><?php echo $val['d_name'];?></option>
   <?php }?>
   </select>
   </p>
   <p><i>街道地址：</i><input type="text" required size="50" name="cons_address"></p>
   <p><i>邮政编码：</i><input type="text" required size="10" pattern="[0-9]{6}" name="cons_zipcode"></p>
   <p><i>手机号码：</i><input type="text" required pattern="[0-9]{11}" name="cons_phone"></p>
   <p><i></i><input type="submit" value="确定"></p>
  </form>
  <?php }else{?>
  <!--已保存的地址列表-->
  
  <form action="#">
   <ul class="address">
   <?php foreach($address as $key => $val){?>
    <li id="style1"><input type="radio" value="" id="1" name="rdColor" onclick="changeColor(1)"/><label for="1"> <?php echo $val['cons_province']?> <?php echo $val['cons_city']?> <?php echo $val['cons_district']?> <?php echo $val['cons_address']?>（<?php echo $val['cons_name']?>收）<span class="fontcolor"><?php echo $val['cons_phone']?></span></label></li>
     <?php }?>
     <li><a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'"><img src="images/newaddress.png"/></a></li>
   </ul>
   </form>
  
   <?php }?>
   <!--add new address-->
   <form action="?r=order/add_address" method="post">
   <div id="light" class="O-L-content">
    <ul>
     <li><span><label for="">选择所在地：</label></span><p><em>*</em>
     <select name="cons_city" selected="selected">
    <option>北京市</option>
   </select>
   <select name="cons_district">
   <?php foreach($area as $key => $val){?>
    <option><?php echo $val['d_name'];?></option>
   <?php }?>
   </select></p></li>
     <li><span><label for="">邮政编码：</label></span><p><em>*</em><input name="cons_zipcode" type="text"  class="Y_N"  pattern="[0-9]{6}" required></p></li>
     <li><span><label for="">街道地址：</label></span><p><em>*</em><textarea name="cons_address" cols="80" rows="5"></textarea></p></li>
     <li><span><label for="">收件人姓名：</label></span><p><em>*</em><input name="cons_name" type="text"></p></li>
     <li><span><label for="">手机号码：</label></span><p><em>*</em><input name="cons_phone" type="text" pattern="[0-9]{11}" required></p></li>
     <div class="button-a"><input type="submit" value="确 定" class="C-button" /><a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"><span><input name="" type="button" value="取 消"  class="Cancel-b"/></a></div>
    <div class="close-botton"><a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"></a></div>
   </div> 
   <div id="fade" class="overlay"></div>
    </ul>
    
   <!--End add new address-->
   </form>
 </div>
<!--配送方式及支付，则显示如下-->
<!--check order or add other information-->
 <div class="pay_delivery">
  <span class="flow_title">配送方式：</span>
  <table>
   <th width="30%">配送方式</th>
   <th width="30%">运费</th>
   <th width="40%">说明</th>
   <tr>
    <td>送货上门</td>
    <td>￥0.00</td>
    <td>配送说明信息...</td>
   </tr>
  </table>
  <span class="flow_title">在线支付方式：</span>
   <form action="#">
    <ul>
    <li><input type="radio" name="pay" id="alipay" value="alipay" /><label for="alipay"><i class="alipay"></i></label></li>
    </ul>
   </form>
  </div>
  <form action="#">
  <div class="inforlist">
   <span class="flow_title">商品清单</span>
   <table>
    <th>名称</th>
    <th>数量</th>
    <th>价格</th>
    <th>小计</th>
    <tr>
     <td>酸辣土豆丝</td>
     <td>2</td>
     <td>￥59</td>
     <td>￥118</td>
    </tr>
    <tr>
     <td>鱼香肉丝</td>
     <td>1</td>
     <td>￥59</td>
     <td>￥59</td>
    </tr>
   </table>
    <div class="Order_M">
     <p><em>订单附言:</em><input name=""  type="text"></p>
     <p><em>优惠券:</em>
     <select name="">
      <option>￥10元优惠券</option>
     </select>
     </p>
    </div>
    <div class="Sum_infor">
    <p class="p1">配送费用：￥0.00+商品费用：￥177.00-优惠券：￥10.00</p>
    <p class="p2">合计：<span>￥167.00</span></p>
    <input type="submit" value="提交订单" / class="p3button">
    </div>
   </div>
   </form>
 </div>
</section>
<script>
//Test code,You can delete this script /2014-9-21DeathGhost/
$(document).ready(function(){
 var submitorder =$.noConflict();
 submitorder(".p3button").click(function(){
	 submitorder("#Cflow").hide();
	 submitorder("#Aflow").show();
	 });
});
</script>
<section class="Psection MT20 Textcenter" style="display:none;" id="Aflow">
  <!-- 订单提交成功后则显示如下 -->
  <p class="Font14 Lineheight35 FontW">恭喜你！订单提交成功！</p>
  <p class="Font14 Lineheight35 FontW">您的订单编号为：<span class="CorRed">201409205134</span></p>
  <p class="Font14 Lineheight35 FontW">共计金额：<span class="CorRed">￥359</span></p>
  <p><button type="button" class="Lineheight35"><a href="#" target="_blank">支付宝立即支付</a></button><button type="button" class="Lineheight35"><a href="user_center.html">进入用户中心</button></p>
</section>
<!--End content-->
