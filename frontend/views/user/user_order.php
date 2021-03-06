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
  
    </tr>
    <?php }?>
     
   </table>
  <span class="Font14 FontW Lineheight35 Block">收件地址：</span>
  <form action="#">
   <table class="U-order-A">
    <tr>
     <td width="30%" align="right" class="FontW">收件地址：</td>
     <td>
     <select name="" class="select_ssq">

      <option><?php echo $address['cons_province']?>省</option>
     </select>
     <select name="" class="select_ssq">
      <option><?php echo $address['cons_city']?>市</option>
     </select>
     <select name="" class="select_ssq">
      <option><?php echo $address['cons_district']?></option>

     </select>
     </td>
    </tr>
    <?php if ($arr[0]['orders']['pay_status']==1) {?>
    <tr>
     <td width="30%" align="right" class="FontW">邮政编码：</td>

     <td><input type="text" name="" class="input_zipcode"  value="<?php echo $address['cons_zipcode']?>" required pattern="[0-9]{6}"></td>
    </tr>
    <tr>
     <td width="30%" align="right" class="FontW">街道地址：</td>
     <td><input type="text" name="" class="input_addr" value="<?php echo $address['cons_address']?>" required></td>
    </tr>
    <tr>
     <td width="30%" align="right" class="FontW">收件人姓名：</td>
     <td><input type="text" name="" class="input_name" value="<?php echo $address['cons_name']?>" required></td>
    </tr>
    <tr>
     <td width="30%" align="right" class="FontW">手机号码：</td>
     <td><input type="text" name="" class="input_tel" value="<?php echo $address['cons_phone']?>" required pattern="[0-9]{11}"></td>
    </tr>
    <tr>
     <td width="30%" align="right" class="FontW">订单备注：</td>
     <td><input type="text" name="" class="input_mark" value="<?php echo $arr[0]['date_speak']?>"></td>

    </tr>
    <?php }else{?>
   <tr>
     <td width="30%" align="right" class="FontW">邮政编码：</td>
     <td><input type="text" id="cons_zipcode" class="input_zipcode"  value="<?php echo $address['cons_zipcode']?>" required pattern="[0-9]{6}"></td>
    </tr>
    <tr>
     <td width="30%" align="right" class="FontW">街道地址：</td>
     <td><input type="text" id="cons_address" class="input_addr" value="<?php echo $address['cons_address']?>" required></td>
    </tr>
    <tr>
     <td width="30%" align="right" class="FontW">收件人姓名：</td>
     <td><input type="text" id="cons_name" class="input_name" value="<?php echo $address['cons_name']?>" required></td>
    </tr>
    <tr>
     <td width="30%" align="right" class="FontW">手机号码：</td>
     <td><input type="text" id="cons_phone" class="input_tel" value="<?php echo $address['cons_phone']?>" required pattern="[0-9]{11}"></td>
    </tr>
    <tr>
     <td width="30%" align="right" class="FontW">订单备注：</td>
     <td><input type="text" name="" class="input_mark" value="<?php echo $arr[0]['date_speak']?>"></td>
    </tr>
    <input type="hidden" name="user_id" value="<?php echo $arr[0]['orders']['user_id']?>">
    <input type="hidden" id="cons_id" value="<?php echo $arr[0]['orders']['address_id']?>">

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
    var user_id=$("input[name=user_id]").val();
    var cons_id=$("#cons_id").val();
    $.ajax({
            type:'get',
            url:"<?=Url::to('user/update_cons')?>",
            data:'cons_zipcode='+cons_zipcode+'&cons_address='+cons_address+'&cons_name='+cons_name+'&cons_phone='+cons_phone+'&user_id='+user_id+'&cons_id='+cons_id,
            success:function(msg)
            {
                if (msg==1) {alert('修改成功'); location.href="<?=Url::to('user/user_orderlist')?>"}
                else
                {
                  alert('修改失败');return false;
                }
            }
    })
  })
</script>
