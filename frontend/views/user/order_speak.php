<?php use \yii\helpers\Url;?>
 <article class="U-article Overflow">
  <span class="Font14 FontW Lineheight35 Block">订单信息：</span>
   <table class="U-order-D">
    <th>订单编号</th>
    <th>订单产品</th>
    <th>订购数量</th>
    <th>单价</th>
    <th>小计</th>
    <th>配送费用</th>
    <th>共计金额</th>
    <th>付款方式</th>
    <tr>
     <td><?php echo $arr['order_sn']?></td>
     <td><a href="" target="_blank" title=""><?php echo $arr['date']['food_name']?></a></td>
     <td><?php echo $arr['date']['food_num']?></td>
     <td>￥<?php echo $arr['food']['food_price']?></td>
     <td>￥<?php echo $arr['food_amount']?></td>
     <td>￥2.00</td>
     <td><?php echo $arr['order_amount']?></td>
     <td><?php echo $arr['pay_way']?></td>
     <!--如果未付款，则显示立即付款按钮-->
     </tr>
   </table>
   <form action="<?=Url::to('user/speak_save')?>" method="post">
   <table>
   <tr>
     <td>
       <textarea name="speak_body" id="" cols="109" rows="5"></textarea>
     </td>
   </tr>
   <tr>
    <input type="hidden" name="food_id" value="<?php echo $arr['date']['food_id']?>">
    <input type="hidden" name="speak_user" value="<?php echo $arr['user_id']?>">
    <input type="hidden" name="order_id" value="<?php echo $arr['order_id']?>">
     <td><input type="submit" value="提交评论"></td>
   </tr>
   </table>
   </form>
 </article>
</section>
<!--End content-->
