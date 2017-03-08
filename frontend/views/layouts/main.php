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
            echo '欢迎用户    '.$username['user_name'].'   登录';
        } 
        else if($mer_id!="")
        {
            $query = new Query;
            $mername = $query->select('mer_name')->from('yfc_merchant')->where(['mer_id'=>$mer_id])->one();
            echo '欢迎商家  '.$mername['mer_name'].'   登录';
        }
        else
        {
            echo '<a href="'.Url::to('register/choice').'">注册</a>/<a href="'.Url::to('login/choice').'">登录</a>';
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
     <a href="user_orderlist.html" target="_blank" title="我的订单">我的订单</a> <a href="<?=Url::to('cart/cart')?>">购物车（0）</a> <a href="user_favorites.html" target="_blank" title="我的收藏">我的收藏</a> <a href="#">商家入驻</a>
   </div>
  </div>
 </section>
    <div class="Logo_search">
        <div class="Logo">
            <img src="images/logo.jpg" title="DeathGhost" alt="模板">
            <i></i>
            <span>北京市 [ <a href="#">海淀区</a> ]</span>
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
                    <input type="hidden" id="hoturl" value="<?=Url::to(['index/hot_word']);?>">
                </div>
            </form>
            <p class="hotkeywords">
<!--                <a href="#" title="酸辣土豆丝">酸辣土豆丝</a><a href="#" title="这里是产品名称">螃蟹炒年糕</a><a href="#" title="这里是产品名称">牛奶炖蛋</a><a href="#" title="这里是产品名称">芝麻酱凉面</a><a href="#" title="这里是产品名称">滑蛋虾仁</a><a href="#" title="这里是产品名称">蒜汁茄子</a>-->
            </p>
        </div>
    </div>
    <nav class="menu_bg">
        <ul class="menu">
            <li><a href="<?=\yii\helpers\Url::toRoute('index/index')?>">首页</a></li>
            <li><a href="<?=Url::to('search/search')?>">订餐</a></li>
            <li><a href="<?=Url::to(['search/search','search_type'=>'food','score'=>'score'])?>">积分商城</a></li>
            <li><a href="<?=Url::to('index/about_us')?>">关于我们</a></li>
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
