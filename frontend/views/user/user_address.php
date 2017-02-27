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
   <li><i></i><a href="#">安全退出</a></li>
  </ul>
 </nav>
 <article class="U-article Overflow">
  <!--user Address-->
  <section class="Myaddress Overflow">
   <span class="MDtitle Font14 FontW Block Lineheight35">收货人信息</span>
    <?php if (!empty($arr)) {?>
   <form action="#">
      <?php foreach ($arr as $key => $val) {?>
   <table>
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right">选择所在地：</td>
     <td>
     <select name="" class="select_ssq">
      <option>北京省</option>
     </select>
     <select name="" class="select_ssq">
     <option>北京市</option>
     </select>
     <select name="" class="select_ssq">
     <option value="<?php echo $val['cons_district']?>"><?php echo $val['cons_district']?></option>
     <option value="朝阳区">朝阳区</option>
     <option value="海淀区">海淀区</option>
     <option value="大兴区">大兴区</option>
     <option value="房山区">房山区</option>
     <option value="昌平区">昌平区</option>
     <option value="通州区">通州区</option>
     <option value="丰台区">丰台区</option>
     </select>
     </td>
    </tr>
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right">收件人姓名：</td>
     <td><input type="text" name="" required value="<?php echo $val['cons_name']?>" class="input_name"></td>
    </tr>
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right">街道地址：</td>
     <td><input type="text" required size="50" value="<?php echo $val['cons_address']?>" class="input_addr"></td>
    </tr>
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right">邮政编码：</td>
     <td><input type="text" required size="10" pattern="[0-9]{6}" value="<?php echo $val['cons_zipcode']?>" class="input_zipcode"></td>
    </tr>
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right">手机号码：</td>
     <td><input type="text" name="" required pattern="[0-9]{11}" value="<?php echo $val['cons_phone']?>" class="input_tel"></td>
    </tr>
    <tr>
     <td align="right"  width="30%" class="Font14 FontW Lineheight35"></td>
     <td class="Lineheight35"><input type="button" id="sub" value="确认修改" consid="<?php echo $val['cons_id']?>" class="Submit"><input type="button" id="del" consid="<?php echo $val['cons_id']?>" value="删除" class="Submit"></td>
    </tr>
   </table>
   <?php }?> 
   <?php if (count($arr)>=2) {?>
   用户最多可有两个收货地址(您只能修改或删除)
   <?php }else{?>
   <tr id="kan">
     <td width="30%" class="Font14 FontW Lineheight35" align="right"></td>
     <td class="Font14 Font Lineheight35"><input name="" id="add" type="button"  value="新增收货地址(用户最多可有两个收货地址)"  class="Submit"></td>
    </tr>
   <?php }?> 
   </form>
    <?php }else{?>
   <!--add new address-->
   <form action="#" id="ha">
    <table style="margin-top:10px;">
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right">选择所在地：</td>
     <td>
     <select name="" class="select_ssq">
      <option>北京省</option>
     </select>
     <select name="" class="select_ssq">
     <option>北京市</option>
     </select>
     <select name="" class="select_ssq">
     <option value="朝阳区">朝阳区</option>
     <option value="海淀区">海淀区</option>
     <option value="大兴区">大兴区</option>
     <option value="房山区">房山区</option>
     <option value="昌平区">昌平区</option>
     <option value="通州区">通州区</option>
     <option value="丰台区">丰台区</option>
     </select>
     </td>
    </tr>
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right">收件人姓名：</td>
     <td><input type="text" name="" required  class="input_name"></td>
    </tr>
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right">街道地址：</td>
     <td><input type="text" required  class="input_addr"></td>
    </tr>
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right">邮政编码：</td>
     <td><input type="text" required pattern="[0-9]{6}"  class="input_zipcode"></td>
    </tr>
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right">手机号码：</td>
     <td><input type="text" name="" required pattern="[0-9]{11}" class="input_tel"></td>
    </tr>
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right"></td>
     <td class="Font14 Font Lineheight35"><input name="" type="submit" value="新增收货地址"  class="Submit"></td>
    </tr>
   </table>
   </form>
   <?php }?>
  </section>
 </article>
</section>
<!--End content-->
<script type="text/javascript">

</script>