<!--Start content-->
<section class="Psection MT20">
<nav class="U-nav Font14 FontW">
   <ul>
   <li><i></i><a href="?r=user/user_index">用户中心首页</a></li>
   <li><i></i><a href="?r=user/user_orderlist">我的订单</a></li>
   <li><i></i><a href="?r=user/user_address">收货地址</a></li>
   <li><i></i><a href="?r=user/user_message">我的留言</a></li>
   <li><i></i><a href="?r=user/user_coupon">我的优惠券</a></li>
   <li><i></i><a href="?r=user/user_collect">我的收藏</a></li>
   <li><i></i><a href="?r=user/user_account">账户管理</a></li>
   <li><i></i><a href="?r=login/login_out">安全退出</a></li>
  </ul>
 </nav>
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
     <td style="display:none;"><a href="#" target="_blank">立即付款</a></td>
    </tr>
   </table>
  <span class="Font14 FontW Lineheight35 Block">收件地址：</span>
  <form action="#">
   <table class="U-order-A">
    <tr>
     <td width="30%" align="right" class="FontW">收件地址：</td>
     <td>
     <select name="" class="select_ssq">
      <option><?php echo $arr['adress']['cons_province']?>省</option>
     </select>
     <select name="" class="select_ssq">
      <option><?php echo $arr['adress']['cons_city']?>市</option>
     </select>
     <select name="" class="select_ssq">
      <option><?php echo $arr['adress']['cons_district']?></option>
     </select>
     </td>
    </tr>
    <?php if ($arr['pay_status']==1) {?>
    <tr>
     <td width="30%" align="right" class="FontW">邮政编码：</td>
     <td><input type="text" name="" class="input_zipcode"  value="<?php echo $arr['adress']['cons_zipcode']?>" required pattern="[0-9]{6}"></td>
    </tr>
    <tr>
     <td width="30%" align="right" class="FontW">街道地址：</td>
     <td><input type="text" name="" class="input_addr" value="<?php echo $arr['adress']['cons_address']?>" required></td>
    </tr>
    <tr>
     <td width="30%" align="right" class="FontW">收件人姓名：</td>
     <td><input type="text" name="" class="input_name" value="<?php echo $arr['adress']['cons_name']?>" required></td>
    </tr>
    <tr>
     <td width="30%" align="right" class="FontW">手机号码：</td>
     <td><input type="text" name="" class="input_tel" value="<?php echo $arr['adress']['cons_phone']?>" required pattern="[0-9]{11}"></td>
    </tr>
    <tr>
     <td width="30%" align="right" class="FontW">订单备注：</td>
     <td><input type="text" name="" class="input_mark" value="<?php echo $arr['date']['date_speak']?>"></td>
    </tr>
    <?php }else{?>
   <tr>
     <td width="30%" align="right" class="FontW">邮政编码：</td>
     <td><input type="text" id="cons_zipcode" class="input_zipcode"  value="<?php echo $arr['adress']['cons_zipcode']?>" required pattern="[0-9]{6}"></td>
    </tr>
    <tr>
     <td width="30%" align="right" class="FontW">街道地址：</td>
     <td><input type="text" id="cons_address" class="input_addr" value="<?php echo $arr['adress']['cons_address']?>" required></td>
    </tr>
    <tr>
     <td width="30%" align="right" class="FontW">收件人姓名：</td>
     <td><input type="text" id="cons_name" class="input_name" value="<?php echo $arr['adress']['cons_name']?>" required></td>
    </tr>
    <tr>
     <td width="30%" align="right" class="FontW">手机号码：</td>
     <td><input type="text" id="cons_phone" class="input_tel" value="<?php echo $arr['adress']['cons_phone']?>" required pattern="[0-9]{11}"></td>
    </tr>
    <tr>
     <td width="30%" align="right" class="FontW">订单备注：</td>
     <td><input type="text" name="" class="input_mark" value="<?php echo $arr['date']['date_speak']?>"></td>
    </tr>
    <input type="hidden" id="user_id" value="<?php echo $arr['user_id']?>">
    <input type="hidden" id="cons_id" value="<?php echo $arr['address_id']?>">
     <td width="30%" align="right"></td>
     <!--未付款订单，可以修改地址！-->
     <td><input type="button" id="sub" value="确认修改地址" class="Submit">（未付款订单，可以修改地址！）</td>
    </tr>
    <?php } ?>
   </table>
   </form>
 </article>
</section>
<!--End content-->
<script type="text/javascript">
  $(document).delegate("#sub",'click',function(){
    var cons_zipcode=$("#cons_zipcode").val();
    var cons_address=$("#cons_address").val();
    var cons_name=$("#cons_name").val();
    var cons_phone=$("#cons_phone").val();
    var user_id=$("#user_id").val();
    var cons_id=$("#cons_id").val();
    $.ajax({
            type:'get',
            url:"?r=user/update_cons",
            data:'cons_zipcode='+cons_zipcode+'&cons_address='+cons_address+'&cons_name='+cons_name+'&cons_phone='+cons_phone+'&user_id='+user_id+'&cons_id='+cons_id,
            success:function(msg)
            {
                if (msg==1) {alert('修改成功'); location.href="?r=user/user_orderlist"}
                else
                {
                  alert('修改失败');return false;
                }
            }
    })
  })
</script>
