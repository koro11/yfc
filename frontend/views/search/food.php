<!--Start content-->
<section class="Psection MT20">
    <article class="Searchlist Overflow">
        <section class="Fslmenu slt" style="margin-bottom:5px">
            <a href="#" title="默认排序">
   <span>
   <span>默认排序</span>
   </span>
            </a>
            <a href="#" title="评价">
   <span>
   <span>评价</span>
   <span class="s-up"></span>
   </span>
            </a>
            <a href="#" title="销量">
   <span>
   <span>销量</span>
   <span class="s-up"></span>
   </span>
            </a>
            <a href="#" title="价格排序">
   <span>
   <span>价格</span>
   <span class="s-down"></span>
   </span>
            </a>
            <a href="#" title="发布时间排序">
   <span>
   <span>发布时间</span>
   <span class="s-up"></span>
   </span>
            </a>
        </section>
        <ul class="Overflow">
            <?php foreach($food as $v):?>
            <li>
                <a href="detailsp.html" target="_blank" target="_blank" title="<?=$v['food_name']?>"><img src="<?=$v['food_image']?>"></a>
                <p class="P-price FontW Font16"><span>￥<?=$v['food_price']?></span></p>
                <p class="P-title"><a href="detailsp.html" target="_blank" target="_blank" title="<?=$v['food_name']?>"><?=$v['food_name']?></a></p>
                <p class="P-shop Overflow">
                    <span class="sa"><a href="shop.html" target="_blank" target="_blank"
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
                <li>
                    <a href="detailsp.html" title="酸辣土豆丝" target="_blank"><img src="upload/02.jpg"></a>
                    <p>
                        <span class="Block FontW Font16 CorRed">￥59.00</span>
                        <span class="Block Overflow"><a href="detailsp.html" title="酸辣土豆丝" target="_blank">酸辣土豆丝</a></span>
                        <span class="Block Overflow">累计销量：<i>255</i>笔</span>
                    </p>
                </li>
            </ul>
        </div>
        <!--广告位或其他推荐版块-->
        <img src="upload/ggw.jpg">
    </aside>
</section>
<!--End content-->
