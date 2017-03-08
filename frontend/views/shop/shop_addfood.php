<?php use yii\helpers\Url; ?>
<!--Start content-->

 <article class="U-article Overflow">
  <!--user Account-->
  <section class="AccManage Overflow">
   <span class="AMTitle Block Font14 FontW Lineheight35">添加菜谱</span>
  
   <form action="<?=Url::to(['shop/shop_addfood_act'])?>" method="post" enctype="multipart/form-data">
    <table >
    <input type="hidden" name="food_mer" value="<?=$merchant['mer_id']?>">
    <input type="hidden" name="food_mername" value="<?=$merchant['mer_name']?>">
    <tr>
    <td width="30%" align="right">*菜名：</td>
    <td><input type="text" name="food_name" ></td>
    </tr>
    <tr>
    <td width="30%" align="right">*所属菜系：</td>
    <td>&nbsp;
    <select name="food_cate" size="5">
    	<?php foreach ($food_category as $ck => $cv): ?>
    		<option value="<?=$cv['cate_id']?>"><?=$cv['cate_name']?></option>
    	<?php endforeach ?>
    </select>
    </td>
    </tr>
   <tr>
    <td width="30%" align="right">*餐饮图片：</td>
    <td><input type="file" name="food_image" id=""></td>
    </tr>
    <tr>
    <td width="30%" align="right">*餐饮价格：</td>
    <td><input type="text" name="food_price" >元
    </td>
    </tr>
    <tr>
    <td width="30%" align="right">*是否促销：</td>
    <td><input type="radio" name="is_discount" value="0" checked="">不促销
    <input type="radio" name="is_discount" value="1">促销
    </td>
    </tr>
    <tr class="discount_show" style="display:none">
    <td width="30%" align="right">*促销价格：</td>
    <td><input type="text" name="discount_price" size="3" >元</td>
    </tr>
    <tr class="discount_show" style="display:none">
    <td width="30%" align="right">*促销时间：</td>
    <td><input type="text" name="discount_start" class="add_date">&nbsp;─<input class="add_date" type="text" name="discount_end" ></td>	
    </tr>
    <tr>
    <td width="30%" align="right">*排序：</td>
    <td><input type="text" name="food_sort" value="50"></td>
    </tr>
    <tr>
    <td width="30%" align="right">*是否新菜：</td>
    <td><input type="radio" name="is_new" value="0" checked="">不是
    <input type="radio" name="is_new" value="1">是
    </td>
    </tr>
    <tr>
    <td width="30%" align="right">*推出时间：</td>
    <td><input type="text" name="food_addtime" disabled="" class="new_show" >
    </td>
    <tr>
    <td width="30%" align="right">*购买是否送积分：</td>
    <td><input type="radio" name="is_score" value="0" checked="">不送
    <input type="radio" name="is_score" value="1">送
    </td>
    <tr>
    <td width="30%" align="right">*购买送积分额：</td>
    <td><input type="text" name="food_score" disabled="" size="3" class="score_show">分
    </td>
    <tr>
    <td width="30%" align="right">*餐饮描述：</td>
    <td><textarea name="food_desc" id="" cols="50" rows="3"></textarea>
    </td>
    <tr>
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
  	 // 时间插件
	 $(".add_date,.new_show").click(function(){
	 	WdatePicker();
	 })

  	//是否促销
     $("input[name='is_discount']").click(function(){
      var discount_show = $(this).val();
      if (discount_show == 1) 
        {
        	//促销
           $('.discount_show').show();
        }
        else
        { 
           $('.discount_show').hide();
        } 
     })

  	//是否新菜
     $("input[name='is_new']").click(function(){
      var new_show = $(this).val();
      if (new_show == 1) 
        {
        	//新菜
           $('.new_show').removeAttr('disabled');
        }
        else
        {
           $('.new_show').attr('disabled',true);
        }
     })

     //是否送积分
     $("input[name='is_score']").click(function(){
      var score_show = $(this).val();
      if (score_show == 1) 
        {
        	//新菜
           $('.score_show').removeAttr('disabled');
        }
        else
        {
           $('.score_show').attr('disabled',true);
        }
     })

  })
</script>
