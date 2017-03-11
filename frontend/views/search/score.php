<?php use \yii\helpers\Url;?>
<section class="Psection">
	<section class="CateL Overflow">
		<section class="Fslmenu slt" style="margin-bottom:5px">
			<a href="javascript:;" order="" title="默认排序">
                <span>
                    <span>默认排序</span>
                </span>
			</a>
			<a href="javascript:;" order="grade"  title="评价">
                <span>
                    <span>评价</span>
                    <span class="s-down"></span>
                </span>
			</a>
			<a href="javascript:;" order="food_saled" title="销量">
                <span>
                    <span>销量</span>
                    <span class="s-down"></span>
                </span>
			</a>
			<a href="javascript:;" order="food_price" title="价格排序">
                <span>
                    <span>价格</span>
                    <span class="s-down"></span>
                </span>
			</a>
			<a href="javascript:;" order="food_addtime" title="发布时间排序">
                <span>
                    <span>发布时间</span>
                    <span class="s-down"></span>
                </span>
			</a>
		</section>
		<script>
			//排序
			$('.Fslmenu a').click(function(){
				var arr = getUrl();
				var _this = $(this);
				var _order = _this.attr('order');
				var _span = _this.children().children().last();
				var _class = _span.attr('class');
//                _this.children().children().last().removeClass('s-down').addClass('s-up');
				if(_order != ''){
					if(arr.order != undefined){
						if(arr.order.indexOf(_order) != -1){
							if(_class == 's-down'){
								_span.removeClass('s-down').addClass('s-up');
								_class = 's-up';
							}else{
								_span.removeClass('s-up').addClass('s-down');
								_class = 's-down';
							}
						}
					}
					arr.order = _order + '-' + ((_class == 's-down') ? 'asc' : 'desc');
				}else{
					delete arr.order;
				}
				var str = '';
				$.each(arr,function(k,v){
					str += '&'+k+'='+v;
				});
				str = '?'+str.substr(1);
				location.href = '<?=Url::to('search/search')?>'+str;
				return false;
			});

			ar = getUrl();
			if(ar.order != undefined){
				_spans = $('.s-down');
				for(var i=0;i<_spans.size();i++){
					if(ar.order.indexOf(_spans.eq(i).parents('a').attr('order')) != -1){
						if(ar.order.indexOf('desc') != -1){
							_spans.eq(i).removeClass('s-down').addClass('s-up');
						}
					}
				}
			}
		</script>
		<ul>
			<?php foreach($food as $v):?>
			<li>
				<a href="<?=Url::to(['menu/details','id'=>$v['food_id']])?>" title="<?=$v['food_name']?>">
					<img src="<?=$v['food_image']?>">
					<p class="Overflow"><?=$v['food_name']?><span>￥<?=$v['food_price']?></span></p>
					<p class="Overflow">赠送：<span class="CorRed Font16"><?=$v['food_score']?></span>积分<i></i></p>
					<p class="Overflow"><?=$v['food_mername']?></p>
					<p class="Overflow">地址：<?=$v['mer_address']?></p>
				</a>
			</li>
			<?php endforeach;?>
		</ul>
		<div class="TurnPage">
			<?php
			echo \yii\widgets\LinkPager::widget([
				'pagination'=>$pages,
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
			])
			?>
		</div>
	</section>
	<aside class="CateR">
		<!--广告位或推荐位-->
		<div>
			<a href="#" target="_blank"><img src="upload/ad.jpg"></a>
		</div>
		<div class="Hot_shop">
			<span class="Hshoptile Font14 FontW Block">热门商家</span>
			<ul>
				<?php
				if ($this->beginCache('score_hot_shop', ['duration' => 3600])) {
					$hot = \frontend\controllers\SearchController::hotShop();
					foreach($hot as $v) {
				?>
					<li>
						<a href="<?=Url::to(['index/shop_index','mer'=>$v['mer_id']])?>" target="_blank" title="<?=$v['mer_name']?>"><img src="<?=$v['info_image']?>"></a>
						<p class="Font14 FontW Overflow Lineheight35">
							<a href="<?=Url::to(['index/shop_index','mer'=>$v['mer_id']])?>" target="_blank" title="<?=$v['mer_name']?>"><?=$v['mer_name']?></a>
						</p>
						<p class="Lineheight35 Overflow"><span><?=$v['mer_address']?></span>
						</p>
					</li>
				<?php
					}
					$this->endCache();
				}

				?>

			</ul>
		</div>
	</aside>
</section>