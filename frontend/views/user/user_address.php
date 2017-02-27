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
     <select id="cons_province" class="select_ssq">
      <option>北京省</option>
     </select>
     <select id="cons_city" class="select_ssq">
     <option>北京市</option>
     </select>
     <select id="cons_district" class="select_ssq">
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
     <td><input type="text" id="cons_name" required value="<?php echo $val['cons_name']?>" class="input_name"></td>
    </tr>
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right">街道地址：</td>
     <td><input type="text" required size="50" id="cons_address" value="<?php echo $val['cons_address']?>" class="input_addr"></td>
    </tr>
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right">邮政编码：</td>
     <td><input type="text" required size="10" id="cons_zipcode" pattern="[0-9]{6}" value="<?php echo $val['cons_zipcode']?>" class="input_zipcode"></td>
    </tr>
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right">手机号码：</td>
     <td><input type="text" id="cons_phone" required pattern="[0-9]{11}" value="<?php echo $val['cons_phone']?>" class="input_tel"></td>
    </tr>
    <tr>
     <td align="right"  width="30%" class="Font14 FontW Lineheight35"></td>
     <td class="Lineheight35"><input type="button" id="sub" value="确认修改" userid="<?php echo $val['user_id']?>" consid="<?php echo $val['cons_id']?>" class="Submit"><input type="button" name="del" consid="<?php echo $val['cons_id']?>" value="删除" class="Submit"></td>
    </tr>
   </table>
   <?php }?> 
   <?php if (count($arr)>=2) {?>
   用户最多可有两个收货地址(您只能修改或删除)
   <?php }else{?>
   <table style="margin-top:10px;">
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right">选择所在地：</td>
     <td>
     <select id="cons_province" class="select_ssq">
      <option>北京省</option>
     </select>
     <select id="cons_city" class="select_ssq">
     <option>北京市</option>
     </select>
     <select id="cons_district" class="select_ssq">
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
     <td><input type="text" id="cons_name" required  class="input_name"></td>
    </tr>
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right">街道地址：</td>
     <td><input type="text" required id="cons_address" class="input_addr"></td>
    </tr>
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right">邮政编码：</td>
     <td><input type="text" required pattern="[0-9]{6}" id="cons_zipcode" class="input_zipcode"></td>
    </tr>
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right">手机号码：</td>
     <td><input type="text" id="cons_phone" required pattern="[0-9]{11}" class="input_tel"></td>
    </tr>
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right"></td>
     <td class="Font14 Font Lineheight35"><input id="add" type="button" value="新增收货地址(最多只能有两个地址)"  class="Submit"></td>
    </tr>
   </table>
   <?php }?> 
   </form>
    <?php }else{?>
   <!--add new address-->
   <form action="#" id="ha">
    <table style="margin-top:10px;">
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right">选择所在地：</td>
     <td>
     <select id="cons_province" class="select_ssq">
      <option>北京省</option>
     </select>
     <select id="cons_city" class="select_ssq">
     <option>北京市</option>
     </select>
     <select id="cons_district" class="select_ssq">
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
     <td><input type="text" id="cons_name" required  class="input_name"></td>
    </tr>
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right">街道地址：</td>
     <td><input type="text" required id="cons_address" class="input_addr"></td>
    </tr>
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right">邮政编码：</td>
     <td><input type="text" required pattern="[0-9]{6}" id="cons_zipcode" class="input_zipcode"></td>
    </tr>
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right">手机号码：</td>
     <td><input type="text" id="cons_phone" required pattern="[0-9]{11}" class="input_tel"></td>
    </tr>
    <tr>
     <td width="30%" class="Font14 FontW Lineheight35" align="right"></td>
     <td class="Font14 Font Lineheight35"><input id="add" type="button" value="新增收货地址(最多只能有两个地址)"  class="Submit"></td>
    </tr>
   </table>
   </form>
   <?php }?>
  </section>
 </article>
</section>
<!--End content-->
<script type="text/javascript">
  $(function(){
    /*删除地址*/
    $("input[name=del]").click(function(){
      var cons_id=$(this).attr("consid");
      $.ajax({
        type:'get',
        url:'?r=user/del_address',
        data:'cons_id='+cons_id,
        success:function(msg)
        {
          if (msg==1) 
          {
            alert('删除成功');location.href="?r=user/user_address";
          }
        }
      })
    })



    /*修改地址*/
    $(document).delegate("#sub","click",function(){
      var cons_id=$(this).attr('consid');
      var user_id=$(this).attr('userid');
      var cons_name=$(this).parent().parent().parent().find("#cons_name").val();
      var cons_province=$(this).parent().parent().parent().find("#cons_province").val();
      var cons_city=$(this).parent().parent().parent().find("#cons_city").val();
      var cons_district=$(this).parent().parent().parent().find("#cons_district").val();
      var cons_address=$(this).parent().parent().parent().find("#cons_address").val();
      var cons_zipcode=$(this).parent().parent().parent().find("#cons_zipcode").val();
      var cons_phone=$(this).parent().parent().parent().find("#cons_phone").val();
      $.ajax({
        type:'get',
        url:'?r=user/update_cons',
        data:'cons_id='+cons_id+"&user_id="+user_id+"&cons_name="+cons_name+"&cons_province="+cons_province+"&cons_city="+cons_city+"&cons_district="+cons_district+"&cons_address="+cons_address+"&cons_zipcode="+cons_zipcode+"&cons_phone="+cons_phone,
        success:function(msg)
        {
            if (msg==1) 
            {
              alert('修改成功');location.href="?r=user/user_address";
            }
            else
            {
              alert('修改成功');location.href="?r=user/user_address";
            }
        }
      })
    })


    /*添加地址*/
    $(document).delegate("#add","click",function(){
      var cons_name=$(this).parent().parent().parent().find("#cons_name").val();
      var cons_province=$(this).parent().parent().parent().find("#cons_province").val();
      var cons_city=$(this).parent().parent().parent().find("#cons_city").val();
      var cons_district=$(this).parent().parent().parent().find("#cons_district").val();
      var cons_address=$(this).parent().parent().parent().find("#cons_address").val();
      var cons_zipcode=$(this).parent().parent().parent().find("#cons_zipcode").val();
      var cons_phone=$(this).parent().parent().parent().find("#cons_phone").val();
      $.ajax({
          type:'get',
          url:'?r=user/address_add',
          data:"cons_name="+cons_name+"&cons_province="+cons_province+"&cons_city="+cons_city+"&cons_district="+cons_district+"&cons_address="+cons_address+"&cons_zipcode="+cons_zipcode+"&cons_phone="+cons_phone,
          success:function(msg)
          {
              if (msg==1) 
              {
                  alert('添加成功');location.href="?r=user/user_address";
              }
              else
              {
                alert('添加失败');
              }
          }
      })
    })



  })
</script>