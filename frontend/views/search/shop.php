<!--Start content-->
<?php use \yii\helpers\Url;?>
<section class="Psection">
    <section class="fslist_navtree">
        <ul class="select">
            <li class="select-list">
                <dl id="select1">
                    <dt>分类：</dt>
                    <dd class="select-all selected"><a href="javascript:;" url="cate=">全部</a></dd>
                    <? foreach($cate as $v):?>
                    <dd <? if($v['cat_id'] == (isset($_GET['cate']) ? $_GET['cate'] : 0)){echo 'class="selected"';}?>>
                        <a href="javascript:;" url="<?='cate='.$v['cat_id']?>"><?=$v['cat_name']?></a>
                    </dd>
                    <? endforeach;?>
                </dl>
            </li>
            <li class="select-list">
                <dl id="select2">
                    <dt>位置：</dt>
                    <dd class="select-all selected"><a href="javascript:" url="dis=">全部</a></dd>
                    <? foreach($dis as $v):?>
                    <dd <? if($v['d_id'] == (isset($_GET['dis']) ? $_GET['dis'] : 0)){echo 'class="selected"';}?>>
                        <a href="javascript:" url="<?='dis='.$v['d_id']?>"><?=$v['d_name']?></a>
                    </dd>
                    <? endforeach;?>
                </dl>
            </li>
            <!--<li class="select-list">
                <dl id="select3">
                    <dt>餐点：</dt>
                    <dd class="select-all selected"><a href="javascript:">全部</a></dd>
                    <dd><a href="javascript:">早餐</a></dd>
                </dl>
            </li>-->
            <li class="select-list">
                <dl id="select4">
                    <dt>价位区间：</dt>
                    <dd class="select-all selected"><a href="javascript:" url="catipa=">全部</a></dd>
                    <dd <?php if((isset($_GET['catipa']) ? $_GET['catipa'] : '') == '0-20'){echo 'class="selected"';}?>><a href="javascript:" url="catipa=0-20">20元以下</a></dd>
                    <dd <?php if((isset($_GET['catipa']) ? $_GET['catipa'] : '') == '20-40'){echo 'class="selected"';}?>><a href="javascript:" url="catipa=20-40">20-40元</a></dd>
                    <dd <?php if((isset($_GET['catipa']) ? $_GET['catipa'] : '') == '40-60'){echo 'class="selected"';}?>><a href="javascript:" url="catipa=40-60">40-60元</a></dd>
                    <dd <?php if((isset($_GET['catipa']) ? $_GET['catipa'] : '') == '60-80'){echo 'class="selected"';}?>><a href="javascript:" url="catipa=60-80">60-80元</a></dd>
                    <dd <?php if((isset($_GET['catipa']) ? $_GET['catipa'] : '') == '80-100'){echo 'class="selected"';}?>><a href="javascript:" url="catipa=80-100">80-100元</a></dd>
                </dl>
            </li>
            <!--<li class="select-result">
                <dl>
                    <dd class="select-no">已选择：</dd>
                </dl>
            </li>-->
        </ul>
    </section>
    <script>
        $(function(){
            var _li = $('.select-list');
            for(var i=0;i<_li.size();i++){
                var _size = _li.eq(i).children().children('.selected').size();
                if(_size>1){
                    _li.eq(i).children().children('.selected').first().removeClass('selected');
                }
            }

            //点击条件搜索
            $('.select-list a').click(function(){
                var arr = getUrl();
                var _this = $(this).attr('url');
                var a = _this.split('=');
                var b = a[0];
                arr[b] = a[1] ? a[1] : '';
                var str = '';
                $.each(arr,function(k,v){
                    str += '&'+k+'='+v;
                });
                str = '?'+str.substr(1);

//                alert(str);
                location.href = '<?=Url::to('search/search')?>'+str;
                return false;
            });

            //排序
            $('.Fslmenu a').click(function(){
                var arr = getUrl();
                var _this = $(this);
                var _order = _this.attr('order');
                var _span = _this.children().children().last();
                var _class = _span.attr('class');
//                _this.children().children().last().removeClass('s-up').addClass('s-down');
                if(_order != ''){
                    if(arr.order != undefined){
                        if(arr.order.indexOf(_order) != -1){
                            if(_class == 's-up'){
                                _span.removeClass('s-up').addClass('s-down');
                                _class = 's-down';
                            }else{
                                _span.removeClass('s-down').addClass('s-up');
                                _class = 's-up';
                            }
                        }
                    }
                    arr.order = _order + '-' + ((_class == 's-up') ? 'asc' : 'desc');
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
                _spans = $('.s-up');
                for(var i=0;i<_spans.size();i++){
                    if(ar.order.indexOf(_spans.eq(i).parents('a').attr('order')) != -1){
                        if(ar.order.indexOf('desc') != -1){
                            _spans.eq(i).removeClass('s-up').addClass('s-down');
                        }
                    }
                }
            }

        });
    </script>
    <section class="Fslmenu">
        <a href="javascript:;" order="" title="默认排序">
            <span>
                <span>默认排序</span>
                <span></span>
            </span>
        </a>
        <a href="javascript:;" order="grade" title="评价">
            <span>
                <span>评价&nbsp;</span>
                <span class="s-up"></span>
            </span>
        </a>
        <a href="javascript:;" order="sales" title="销量">
            <span>
                <span>销量</span>
                <span class="s-up"></span>
            </span>
        </a>
        <a href="javascript:;" order="info_catipa" title="价格排序">
            <span>
                <span>价格</span>
                <span class="s-up"></span>
            </span>
        </a>
    </section>

    <section class="Fsl">
        <ul>
            <?php if(empty($shop)){ ?>
                没有找到符合条件的数据...
            <?php } ?>
            <? foreach($shop as $v): ?>
            <li>
                <a href="<?=Url::to(['index/shop_index','mer'=>$v['mer_id']])?>" target="_blank" title="调用产品名/店铺名"><img src="<?=$v['info_image']?>"></a>
                <hgroup>
                    <h3><?=$v['mer_name'];?></h3>
                    <h4></h4>
                </hgroup>
                <p>菜系：<?=$v['cat_name'];?></p>
                <p>地址：<?=$v['mer_address'];?></p>
                <p>人均：<?=$v['info_catipa'];?>元</p>
                <p>
                    <span class="Score-l">
                        <img src="images/star-on.png">
                        <img src="images/star-on.png">
                        <img src="images/star-on.png">
                        <img src="images/star-on.png">
                        <img src="images/star-off.png">
                        <span class="Score-v">4.8</span>
                    </span>
                    <span class="DSBUTTON"><a href="<?=Url::to(['index/shop_index','mer'=>$v['mer_id']])?>" target="_blank" class="Fontfff">点外卖</a></span>
                </p>
            </li>
            <? endforeach;?>
        </ul>
        <aside>
            <div class="title">热门商家</div>
            <?php
            if ($this->beginCache('hot_shop', ['duration' => 3600])) {
                $hot = \frontend\controllers\SearchController::hotShop();
                foreach($hot as $v) {
            ?>
            <div class="C-list">
                <a href="<?=Url::to(['index/shop_index','mer'=>$v['mer_id']])?>" target="_blank" title="<?=$v['mer_name']?>"><img style="width: 284px;height: 200px;" src="<?=$v['info_image']?>"></a>
                <p><a href="<?=Url::to(['index/shop_index','mer'=>$v['mer_id']])?>" target="_blank"><?=$v['mer_name']?></a></p>
                <p>
                    <span>人均：<?=$v['info_catipa']?>元</span>
                    <span style=" float:right">
                        <img src="images/star-on.png">
                        <img src="images/star-on.png">
                        <img src="images/star-on.png">
                        <img src="images/star-on.png">
                        <img src="images/star-off.png">
                        <span class="ALscore">4.8</span>
                    </span>
                </p>
            </div>
            <?php
                }
                $this->endCache();
            }
            ?>
        </aside>

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

</section>

<!--End content-->
