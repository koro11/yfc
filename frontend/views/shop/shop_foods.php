<?php use yii\helpers\Url; ?>
<!-- 菜谱页面 -->
<article class="U-article Overflow">
  <!--user Account-->
  <section class="AccManage Overflow">
   <span class="AMTitle Block Font14 FontW Lineheight35">本店菜谱</span>
<table>
    <tr class="U-order-D">
	<th>餐饮图片</th>
	<th>餐饮名字</th>
	<th>餐饮价格</th>
	<th>餐饮操作</th>
    </tr>
    <?php foreach ($foods as $key => $value): ?>  	
	<tr>
		<td width="30%" align="center"><img src="<?=$value['food_image']?>" width="200"></td>
		<td align="center"><?=$value['food_name']?></td>
		<td align="center"><p class="AButton">￥<?=$value['food_price']?></p></td>
		<td align="center" fid="<?=$value['food_id']?>">
		<?php if ($value['is_delete']): ?>
		<span class='is_delete' fst="<?=$value['is_delete']?>"><font color="blue">继续做</font></span>
		<?php else: ?>
		<span class='is_delete' fst="<?=$value['is_delete']?>"><font color="blue">不做了</font></span>
		<?php endif ?>
		</td>
	</tr>
    <?php endforeach ?>
</table>
<div class="TurnPage">
    <?php echo \yii\widgets\LinkPager::widget([
	'pagination' => $pages,
	'firstPageLabel'=>'首页',
    'prevPageLabel'=>'上一页',
    'nextPageLabel'=>'下一页',
    'lastPageLabel'=>'最后一页',
    'pageCssClass'=>'PNumber',//数字
	'firstPageCssClass'=>'Prev',//首页
	'lastPageCssClass'=>'Next',//尾页
	'prevPageCssClass'=>'Prev',//上一页
	'nextPageCssClass'=>'Next',//下一页
	'label'=>'span',
          ]);
 ?></div>
</section>
</article>
<!--End content-->
<script>
	$(function(){
		$(document).on('click','.is_delete',function(){
			var _this = $(this);
			var fid   = _this.parent().attr('fid');
			var fst   = _this.attr('fst');
		        fst   = fst==1 ? 0 : 1;
			// alert(fst);return false;
			$.get("<?=Url::to(['shop/shop_delete_food']);?>",{fid:fid,fst:fst},function(data){
	        if (data == 1) { 
	        	if (fst == 1) {
	             _this.parent().html('<span class="is_delete" fst="'+fst+'"><font color="blue">还是做吧</font></span>');		
	        	}else{
	             _this.parent().html('<span class="is_delete" fst="'+fst+'"><font color="blue">不做了</font></span>');
	        	}
	        };
	      })
		})
	})
</script>