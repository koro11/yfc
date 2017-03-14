<?php
use yii\web\Session;
use \yii\db\Query;
use \yii\helpers\Url;
?>
<!DOCTYPE html>
<html>
<head>
    <base href="/">
    <meta charset="utf-8"/>
    <title>DeathGhost</title>
    <meta name="keywords" content="有饭吃"/>
    <meta name="description" content="DeathGhost.cn::H5 WEB前端设计开发!"/>
    <meta name="author" content="DeathGhost"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="js/jquery-1.7.min.js"></script>
    <script type="text/javascript" src="js/jqpublic.js"></script>
    <script type="text/javascript" src="js/cart.js"></script>
    <script type="text/javascript" src="js/jquery.easyui.min.js"></script>
<!--    <link rel="stylesheet" href="css/example.css">-->

    <!-- This is what you need -->
    <script src="js/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="css/sweetalert.css">
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=Ixk1wsRY3ffwS12GLtYmvjyHYkUfu0Uu"></script>
</head>
<style>
    .p3button{
        cursor: pointer;
    }
</style>
<body>
<header>
 <section class="Topmenubg">
  <div class="Topnav">
   <div class="LeftNav">
    <?php
        $session = Yii::$app->session;
        $user_id = $session->get('user_id');
        $mer_id = $session->get('mer_id');
       /* var_dump($user_id);
        var_dump($mer_id);die;*/
        if($user_id!="")
        {
            $query = new Query;
            $username = $query->select('user_name')->from('yfc_user_info')->where(['user_id'=>$user_id])->one();
            echo '欢迎用户    <span id="user_id" user_id="'.$user_id.'">'.$username['user_name'].'</span>   登录';
        } 
        else if($mer_id!="")
        {
            $query = new Query;
            $mername = $query->select('mer_name')->from('yfc_merchant')->where(['mer_id'=>$mer_id])->one();
            echo '欢迎商家  '.$mername['mer_name'].'   登录';
        }
        else
        {
            echo '<a href="'.Url::to('register/user_register').'">注册</a>/<a href="'.Url::to('login/login').'">登录</a>';
        }
    ?>
    <a href="#">QQ客服</a><a href="#">微信客服</a><a href="#">手机客户端</a><a href="<?=Url::to('login/out')?>">退出</a>
   </div>
   <div class="RightNav">
   <?php if($user_id!=""){?>
    <a href="<?=Url::to('user/user_index')?>">用户中心</a>
   <?php }elseif($mer_id!=""){?>
    <a href="<?=Url::to('shop/shop_center')?>">商户中心</a>
   <?php }else{?>
   <a href="#"></a>
   <?php }?>
     <a href="<?=Url::to('user/user_orderlist')?>" title="我的订单">我的订单</a> <a href="<?=Url::to('cart/cart')?>">购物车（0）</a> <a href="user_favorites.html" target="_blank" title="我的收藏">我的收藏</a> <a href="#">商家入驻</a>
   </div>
  </div>
 </section>
    <div class="Logo_search">
        <div class="Logo">
            <a href="<?=Url::to('index/index')?>"><img src="images/logo1.jpg" title="DeathGhost" alt="模板"></a>
            <i></i>

            <?php $session = Yii::$app->session; $user_id = $session->get('user_id'); if (empty($user_id)) {?>
                <span id="adress">北京市</span>
            <?php }else{?>
            <?php 
                $coor=Yii::$app->db->createCommand("select * from yfc_user_coor where user_id=".$user_id."")->queryOne();
            if(empty($coor)){?>
                <span id="adress">北京市 请输入:<input type="text" placeholder="请手动输入详细地址" id="suggestId" size="20"  style="width:150px;" /></span>
             <div id="l-map" style="display:none"></div>
                     <div id="searchResultPanel" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>
             <?php }else{?>  
              <span id="adress"> <input type="text" id="suggestId" size="20" placeholder="<?php echo $coor['coor_address']?>"  style="width:150px;"  />&nbsp;&nbsp;&nbsp;&nbsp;<a herf="#" id="up">修改</a></span>
             <div id="l-map" style="display:none"></div>
            <div id="searchResultPanel" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>
            <?php }?>
            <?php }?>
        </div>

        <div class="Search">
            <form method="get" action="<?=Url::to('search/search')?>">
<!--                <input type="hidden" name="r" value="search/search">-->
                <div class="Search_nav" id="selectsearch">
                    <a href="javascript:;" onClick="selectsearch(this,'restaurant_name')" <?php if(!isset($_GET['search_type']) || $_GET['search_type']!='food'){echo 'class="choose"';}?>>餐厅</a>
                    <a href="javascript:;" onClick="selectsearch(this,'food_name')" <?php if(isset($_GET['search_type']) && $_GET['search_type']=='food'){echo 'class="choose"';}?>>食物名</a>
                </div>
                <input type="hidden" name="search_type" value="<?php if(isset($_GET['search_type']) && !
                    empty($_GET['search_type'])){echo $_GET['search_type'];}else{echo 'shop';}?>">
                <div class="Search_area">
                    <input type="search" id="fkeyword" name="keyword" <?php if(isset($_GET['keyword']) && !empty($_GET['keyword'])){echo 'value="'.$_GET['keyword'].'"';}?> placeholder="请输入您所需查找的餐厅名称或食物名称..." class="searchbox"/>
                    <input type="submit" class="searchbutton" value="搜 索"/>
                </div>
            </form>
            <p class="hotkeywords" id="hot_shop" <?php if(isset($_GET['search_type']) && $_GET['search_type']=='food'){echo 'style="display: none;"';} ?>></p>
            <p class="hotkeywords" id="hot_food" <?php if(!isset($_GET['search_type']) || $_GET['search_type']!='food'){echo 'style="display: none;"';} ?>></p>
            <input type="hidden" id="hoturl" value="<?=Url::to(['index/hot_word']);?>">
        </div>
    </div>
    <nav class="menu_bg">
        <ul class="menu">
            <li><a <?php if($_SERVER['REQUEST_URI']=='/index/index'){echo 'style="color:#fd5411;"';}?> href="<?=\yii\helpers\Url::toRoute('index/index')?>">首页</a></li>
            <li><a <?php if(isset($_GET['search_type']) && $_GET['search_type']=='food' && !isset($_GET['score'])){echo 'style="color:#fd5411;"';}?> href="<?=Url::to(['search/search','search_type'=>'food'])?>">美食</a></li>
            <li><a <?php if(!isset($_GET['search_type']) && $_SERVER['REDIRECT_URL']=='/search/search'){echo 'style="color:#fd5411;"';}?> href="<?=Url::to('search/search')?>">餐馆</a></li>
            <li><a <?php if(isset($_GET['score'])){echo 'style="color:#fd5411;"';}?> href="<?=Url::to(['search/search','search_type'=>'food','score'=>'score'])?>">积分商城</a></li>
            <li><a <?php if($_SERVER['REQUEST_URI']=='/index/about_us'){echo 'style="color:#fd5411;"';}?> href="<?=Url::to('index/about_us')?>">关于我们</a></li>
        </ul>
    </nav>
    <script type="text/javascript" src="js/public.js"></script>
</header>

<?= $content ?>

<div class="F-link">
    <!--<span>友情链接：</span>
    <a href="http://www.deathghost.cn" target="_blank" title="DeathGhost">DeathGhost</a>
    <a href="http://www.sucaihuo.com/pins/15966.html" target="_blank" title="免费后台管理模板">绿色清爽版通用型后台管理模板免费下载</a>
    <a href="http://www.sucaihuo.com/pins/17567.html" target="_blank" title="果蔬菜类模板源码">HTML5果蔬菜类模板源码</a>
    <a href="http://www.sucaihuo.com/pins/14931.html" target="_blank" title="黑色的cms商城网站后台管理模板">黑色的cms商城网站后台管理模板</a>-->
</div>
<footer>
    <section class="Otherlink">
        <aside>
            <div class="ewm-left">
                <p>手机扫描二维码：</p>
                <img src="images/Android_ico_d.gif">
                <img src="images/iphone_ico_d.gif">
            </div>
            <div class="tips">
                <p>客服热线</p>
                <p><i>1830927**73</i></p>
                <p>配送时间</p>
                <p>
                    <time>09：00</time>
                    ~
                    <time>22:00</time>
                </p>
                <p>网站公告</p>
            </div>
        </aside>
        <section>
            <div>
                <span><i class="i1"></i>配送支付</span>
                <ul>
                    <li><a href="article_read.html" target="_blank" title="标题">支付方式</a></li>
                    <li><a href="article_read.html" target="_blank" title="标题">配送方式</a></li>
                    <li><a href="article_read.html" target="_blank" title="标题">配送效率</a></li>
                    <li><a href="article_read.html" target="_blank" title="标题">服务费用</a></li>
                </ul>
            </div>
            <div>
                <span><i class="i2"></i>关于我们</span>
                <ul>
                    <li><a href="article_read.html" target="_blank" title="标题">招贤纳士</a></li>
                    <li><a href="article_read.html" target="_blank" title="标题">网站介绍</a></li>
                    <li><a href="article_read.html" target="_blank" title="标题">配送效率</a></li>
                    <li><a href="article_read.html" target="_blank" title="标题">商家加盟</a></li>
                </ul>
            </div>
            <div>
                <span><i class="i3"></i>帮助中心</span>
                <ul>
                    <li><a href="article_read.html" target="_blank" title="标题">服务内容</a></li>
                    <li><a href="article_read.html" target="_blank" title="标题">服务介绍</a></li>
                    <li><a href="article_read.html" target="_blank" title="标题">常见问题</a></li>
                    <li><a href="article_read.html" target="_blank" title="标题">网站地图</a></li>
                </ul>
            </div>
        </section>
    </section>
    <div class="copyright">© 版权所有 2016 DeathGhost
        技术支持：<a href="http://www.deathghost.cn" title="DeathGhost">DeathGhost</a></div>
</footer>
</body>
</html>
<script type="text/javascript">
    // 百度地图API功能
    function G(id) {
        return document.getElementById(id);
    }

    var map = new BMap.Map("l-map");
    map.centerAndZoom("北京",12);                   // 初始化地图,设置城市和地图级别。

    var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
        {"input" : "suggestId"
        ,"location" : map
    });

    ac.addEventListener("onhighlight", function(e) {  //鼠标放在下拉列表上的事件
    var str = "";
        var _value = e.fromitem.value;
        var value = "";
        if (e.fromitem.index > -1) {
            value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        }    
        str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;
        
        value = "";
        if (e.toitem.index > -1) {
            _value = e.toitem.value;
            value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        }    
        str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
        G("searchResultPanel").innerHTML = str;
    });

    var myValue;
    ac.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
    var _value = e.item.value;
        myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        G("searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;
        
        setPlace();
    });

    function setPlace(){
        map.clearOverlays();    //清除地图上所有覆盖物
        function myFun(){
            var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
            map.centerAndZoom(pp, 18);
            map.addOverlay(new BMap.Marker(pp));    //添加标注
        }
        $(document).delegate("#suggestId","blur",function(){
        var name=$(this).val();
        $("#adress").html(name);
        var adds = new Array();
        adds[0]=name;
        geocodeSearch(adds);
    })      
        
    }
    function geocodeSearch(add){
        var myGeo = new BMap.Geocoder();
        myGeo.getPoint(add, function(point){
            if (point) {
                var address = new BMap.Point(point.lng, point.lat);
                var user_id=$("#user_id").attr("user_id");
                var coor_address=add[0];
                var user_lng=address.lng;
                var user_lat=address.lat;
                $.ajax({
                    type:"get",
                    url:'?r=index/add_coor',
                    data:'user_id='+user_id+'&coor_address='+coor_address+'&user_lng='+user_lng+'&user_lat='+user_lat,
                    success:function(msg)
                    {
                        if (msg!=1) 
                        {
                            alert('地址设置失败');
                        }
                    }
                });
            }
        }, "北京市");
    }
    
</script>
<script type="text/javascript">
    $(document).delegate("#up","click",function(){
        $("#suggestId").attr({placeholder:"请输入"});
    })
</script>
