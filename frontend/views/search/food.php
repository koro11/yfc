<?php use \yii\helpers\Url;?>
<section class="Psection MT20">
    <article class="Searchlist Overflow">
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
        <ul class="Overflow">
            <?php foreach($food as $v):?>
            <li>
                <a href="<?=Url::to(['menu/details','id'=>$v['food_id']])?>" title="<?=$v['food_name']?>"><img src="<?=$v['food_image']?>"></a>
                <p class="P-price FontW Font16"><span>￥<?=$v['food_price']?></span></p>
                <p class="P-title"><a href="<?=Url::to(['menu/details','id'=>$v['food_id']])?>" target="_blank" target="_blank" title="<?=$v['food_name']?>"><?=$v['food_name']?></a></p>
                <p class="P-shop Overflow">
                    <span class="sa"><a href="<?=Url::to(['menu/details','id'=>$v['food_id']])?>" target="_blank" target="_blank"
                      title="<?=$v['food_name']?>"><?=$v['food_mername']?></a></span><span class="sp"><?=$v['mer_address']?></span>
                </p>
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
    </article>
    <aside class="Sraside">
        <div class="bestproduct">
            <span class="Bpt Block FontW Font14">热销商品推荐</span>
            <ul>
                <?php
                if ($this->beginCache('hot_food', ['duration' => 3600])) {
                    $hot = \frontend\controllers\SearchController::hotFood();
                    foreach($hot as $v) {
                ?>
                <li>
                    <a href="<?=Url::to(['menu/details','id'=>$v['food_id']])?>" title="<?=$v['food_name']?>" target="_blank"><img src="<?=$v['food_image']?>"></a>
                    <p>
                        <span class="Block FontW Font16 CorRed">￥<?=$v['food_price']?></span>
                        <span class="Block Overflow"><a href="<?=Url::to(['menu/details','id'=>$v['food_id']])?>" title="<?=$v['food_name']?>" target="_blank"><?=$v['food_name']?></a></span>
                        <span class="Block Overflow">累计销量：<i><?=$v['food_saled']?></i>笔</span>
                    </p>
                </li>
                <?php
                    }
                    $this->endCache();
                }
                ?>
            </ul>
        </div>
        <!--广告位或其他推荐版块-->
        <img src="upload/ggw.jpg">
    </aside>
</section>
<!--End content-->
