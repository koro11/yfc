<?php
use \yii\helpers\Url;
$this->beginContent('@app/views/layouts/main.php');
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
    <script type="text/javascript" src="js/WdatePicker.js"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=Ixk1wsRY3ffwS12GLtYmvjyHYkUfu0Uu"></script>
</head>

<style>
    .p3button{
        cursor: pointer;
    }
</style>
<body>


<section class="Psection MT20">
<nav class="U-nav Font14 FontW">
  <ul>
   <li><i></i><a href="<?=Url::to(['shop/shop_center'])?>">商家中心首页</a></li>
   <li><i></i><a href="<?=Url::to(['shop/shop_complete_info'])?>">完善信息</a></li>
   <li><i></i><a href="<?=Url::to(['shop/shop_foods'])?>">菜谱</a></li>
   <li><i></i><a href="<?=Url::to(['shop/shop_addfood'])?>">添加菜谱</a></li>
   <li><i></i><a href="<?=Url::to(['shop/shop_orders'])?>">订单</a></li>
   <li><i></i><a href="<?=Url::to(['shop/shop_tickets'])?>">优惠券</a></li>
   <li><i></i><a href="<?=Url::to(['shop/shop_issue_tickets'])?>">发行优惠券</a></li>
   <li><i></i><a href="<?=Url::to(['shop/shop_messages'])?>">顾客留言</a></li>
   <!-- <li><i></i><a href="user_account.html">账户管理</a></li> -->
   <li><i></i><a href="<?=Url::to(['shop/login_out'])?>">安全退出</a></li>
  </ul>
 </nav>
<?= $content ?>

<?php $this->endContent();?>