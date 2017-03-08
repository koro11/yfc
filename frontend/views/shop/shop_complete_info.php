<!--Start content-->

 <article class="U-article Overflow">
  <!--user Account-->
  <section class="AccManage Overflow">
   <span class="AMTitle Block Font14 FontW Lineheight35">完善信息</span>
  
   <form action="?r=shop/shop_complete_act" method="post" enctype="multipart/form-data">
    <table >
    
    <input type="hidden" name="info_mer" value="<?=$info_mer?>">
    <tr>
    <td width="30%" align="right">*特色菜：</td>
    <td><textarea name="info_specialty" id="" cols="50" rows="3"></textarea></td>
    </tr>
    <tr>
    <td width="30%" align="right">*优惠信息：</td>
    <td><textarea name="info_favorable" id="" cols="50" rows="3">暂无</textarea></td>
    </tr>
    <tr>
    <td width="30%" align="right">*是否有停车位：</td>
    <td><input type="radio" name="info_park" value="0" checked="">没有
    <input type="radio" name="info_park" value="1">有
    </td>
    </tr>
    <tr class="park_info" style="display:none">
      <td width="30%" align="right">*停车位</td>
      <td><input type="text" name="info_park_num" size="3">个</td>
    </tr>
    <tr class="park_info" style="display:none">
      <td width="30%" align="right">*停车位价格</td>
      <td><input type="text" name="info_park_price" size="3">元/小时</td>
    </tr>
    <tr>
    <td width="30%" align="right">*营业时间：</td>
    <td><input type="tel" name="info_business" value="">(格式：09：00-21：00)</td>
    </tr>
    <tr>
    <td width="30%" align="right">*是否有wifi：</td>
    <td><input type="radio" name="is_wifi" value="0" >没有
    <input type="radio" name="is_wifi" value="1" checked="">有
    </td>
    </tr>
    <tr>
    <td width="30%" align="right">*乘车路线：</td>
    <td><textarea name="info_riding" id="" cols="50" rows="3"></textarea></td>
    </tr>
    <tr>
    <td width="30%" align="right">*商家描述：</td>
    <td><textarea name="info_desc" id="" cols="50" rows="3"></textarea></td>
    </tr>
    <tr>
    <td width="30%" align="right">*店铺图片：</td>
    <td><input type="file" name="info_image" id=""></td>
    </tr>
    <tr>
    <td></td>
    <td><input type="submit" value="保 存">&nbsp;&nbsp;&nbsp;&nbsp;<input  type="reset" value="取 消"></td>
    </tr>
    </table>
   </form>
  </section>
 </article>
</section>
<!--End content-->
<script>
  $(function(){
     $("input[name='info_park']").click(function(){
      var is_show = $(this).val();
      if (is_show == 1) 
        {
          $('.park_info').show();
        }
        else
        {
          $('.park_info').hide();
        }
      
     })
  })
</script>
