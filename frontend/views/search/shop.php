<!--Start content-->
<? $url = $_SERVER["QUERY_STRING"];?>
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
            <li class="select-result">
                <dl>
                    <dd class="select-no">已选择：</dd>
                </dl>
            </li>
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

            $('.select-list a').click(function(){
                var href = top.location.href;
                var _index = href.indexOf('?');
                var str = href.substr(_index+1);
                str = str.split('&');
                var arr = new Object();
                for(var i=0;i<str.length;i++){
                    var a = str[i];
                    a = a.split('=');
                    var b = a[0];
                    arr[b] = a[1] ? a[1] : '';
                }
                var _this = $(this).attr('url');
                a = _this.split('=');
                var c = a[0];
                arr[c] = a[1] ? a[1] : '';
                var str = '';
                $.each(arr,function(k,v){
                    str += '&'+k+'='+v;
                });
                str = '?'+str.substr(1);
                location.href = str;
//                alert(str);
                return false;
            });
        });
    </script>
    <section class="Fslmenu">
        <a href="#" title="默认排序">
            <span>
                <span>默认排序</span>
                <span></span>
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
    <section class="Fsl">
        <ul>
            <? foreach($shop as $v): ?>
            <li>
                <a href="shop.html" target="_blank" title="调用产品名/店铺名"><img src="<?=$v['info_image']?>"></a>
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
                    <span class="DSBUTTON"><a href="shop.html" target="_blank" class="Fontfff">点外卖</a></span>
                </p>
            </li>
            <? endforeach;?>
        </ul>
        <aside>
            <div class="title">热门商家</div>

            <div class="C-list">
                <a href="shop.html" target="_blank" title="店铺名称"><img src="upload/cc.jpg"></a>
                <p><a href="shop.html" target="_blank">[大雁塔]店铺名称</a></p>
                <p>
                    <span>人均：20~50元</span>
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
            ])
            ?>
        </div>

    </section>

</section>

<!--End content-->
