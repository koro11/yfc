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
    <?php foreach ($arr as $key => $value) {?>
     <tr>
     <td><?php echo $value['orders']['order_sn']?></td>
     <td><a href="" target="_blank" title=""><?php echo $value['food_name']?></a></td>
     <td><?php echo $value['food_num']?></a></td>
     <td>￥<?php echo $value['sum_price']/$value['food_num']?></td>
     <td>￥<?php echo $value['sum_price']?></td>
     <td>￥0.00</td>
     <td>￥<?php echo $value['sum_price']?></td>
     <td><?php echo $value['orders']['pay_way']?></td>
     <!--如果未付款，则显示立即付款按钮-->
     </tr>
    <?php }?>
   </table>
   <form action="<?=Url::to('user/speak_save')?>" method="post">
   <table>
   <tr>
     <td>
       <textarea name="speak_body" id="" cols="109" rows="5"></textarea>
     </td>
   </tr>
   <tr>
    <?php 
      for ($i=0; $i <count($arr) ; $i++) 
      { 
        $food_id[$i]=$arr[$i]['food_id'];
      }
      $ha=implode(',',$food_id);
      echo "<input type='hidden' name='food_id' value='$ha'>";
    ?>
    <input type="hidden" name="speak_user" value="<?php echo $arr[0]['orders']['user_id']?>">
    <input type="hidden" name="order_id" value="<?php echo $arr[0]['orders']['order_id']?>">
     <td><input type="submit" value="提交评论"></td>
   </tr>
   </table>
   </form>
 </article>
</section>
<!--End content-->
