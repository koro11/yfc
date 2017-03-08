<?php use yii\helpers\Url; ?>
<!--Start content-->

 <article class="U-article Overflow">
  <!--user Account-->
  <section class="AccManage Overflow">
   <span class="AMTitle Block Font14 FontW Lineheight35">发行优惠券</span>
  
   <form action="<?=Url::to(['shop/shop_issue_act'])?>" method="post" >
    <table >
    <input type="hidden" name="tic_merchant" value="<?=$merchant['mer_id']?>">
    <input type="hidden" name="tic_mername" value="<?=$merchant['mer_name']?>">
    <tr>
    <td width="30%" align="right">*优惠券简介：</td>
    <td><input type="text" name="tic_desc" ></td>
    </tr>

   <tr>
    <td width="30%" align="right">*优惠条件额度：</td>
    <td>消费满<input type="text" name="tic_cond" size="5">&nbsp;元即可使用该券</td>
    </tr>
    <tr>
    <td width="30%" align="right">*优惠抵额：</td>
    <td><input type="text" name="tic_cost" size="5" >&nbsp;元
    </td>
    </tr>  
    <tr class="discount_show" >
    <td width="30%" align="right">*使用期限：</td>
    <td><input type="text" name="tic_start" class="add_date">&nbsp;─<input class="add_date" type="text" name="tic_end" ></td>	
    </tr> 
    <tr>
    <td width="30%" align="right">*发行数量：</td>
    <td><input type="text" name="tic_num" size="3" value="1000" >张
    </td>
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
