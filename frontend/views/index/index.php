<?php use yii\helpers\Url ;?>
<!--轮播图样式-->
<link rel="stylesheet" type="text/css" href="css/demo.css" />
<link rel="stylesheet" type="text/css" href="css/slicebox.css" />
<link rel="stylesheet" type="text/css" href="css/custom.css" />
<!--Start content-->
<section class="Cfn">
 <aside class="C-left">
<div class="S-time">服务时间：全天24小时<!--  周一~周六<time>09:00</time>-<time>23:00</time>--></div>
  <div class="C-time">
   <img src="upload/dc.jpg"/>
  </div>
  <a href="<?=Url::to(['search/search']);?>" target="_blank"><img src="images/by_button.png"></a>
  <a href="<?=Url::to(['search/search']);?>" target="_blank"><img src="images/dc_button.png"></a>
 </aside>
 <div class="F-middle">
<!-- <ul class="rslides f426x240">-->
<!--         <li><a href="javascript:"><img src="" /></a></li>-->
<!--    </ul>-->

  <div class="wrapper">

   <ul id="sb-slider" class="sb-slider">
    <?php foreach ($shuffing as $key => $val): ?>
    <li>
     <a href="<?=$val['shuffing_link'];?>" target="_blank"><img src="<?='http://www.luo.com/big1/yfc/backend/web/'.$val['path'];?>" /></a>
     <div class="sb-description">
      <h3><?=$val['shuffing_desc'];?></h3>
     </div>
    </li>
    <?php endforeach ?>
   </ul>

   <div id="shadow" class="shadow"></div>

   <div id="nav-arrows" class="nav-arrows">
    <a href="#" class="other" id="next">Next</a>
    <a href="#" class="other">Previous</a>
   </div>

   <div id="nav-dots" class="nav-dots">
    <?php foreach ($shuffing as $key => $val): ?>
     <span class="other"></span>
    <?php endforeach ?>

   </div>
  </div><!-- /wrapper -->

 </div>
 <aside class="N-right">
  <div class="N-title">公司新闻 <i>COMPANY NEWS</i></div>
  <ul class="Newslist">
   <li><i></i><a href="article_read.html" target="_blank" title="">欢迎访问来这儿，有饭吃...</a></li>
   <li><i></i><a href="article_read.html" target="_blank" title="">来这儿，就吃了。竭诚服务，用心服务，...</a></li>
  </ul>
  <div class="myOrder">
  <ul class="Orderlist" id="UpRoll">
   <?php foreach ($shuffing as $key => $val): ?>
    <li>
     <p>订单编号：2014090912978</p>
     <p>收件人：张小姐</p>
     <p>订单状态：<i class="State01">已发货</i><i class="State02">已签收</i><i class="State03">已点评</i></p>
    </li>
   <?php endforeach ?>
     </div>
  </ul>

 </aside>
</section>
<section class="Sfainfor">
 <article class="Sflist">
  <div id="Indexouter">
   <ul id="Indextab">
    <li class="current">点菜</li>
    <li>餐馆</li>
    <p class="class_B">
    <a href="javascript:void(0);" class="close" cate_id="" >全部<img src="./images/ch.png"></a>
    <span ><a href="javascript:void(0);" class="showbtn">more ></a></span>
    <span ><a href="javascript:void(0);" class="showbtn">高级查询 ></a></span>
    </p>
   </ul>
      <!--遮罩层-->
      <div id="bg"></div>
      <div class="box" style="display:none">
          <h2><a href="javascript:void(0);" class="close">关闭</a></h2>
          <div class="list">
              <div class="seekarea fodcate">
                  <?php foreach ($foodcate as $key => $val): ?>
                      <a href="javascript:void(0);" class="close" cate_id="<?=$val['cate_id']?>" ><?=$val['cate_name'];?><img src="./images/ch.png"></a>
                  <?php endforeach ?>
              </div>
              <h2><a href="javascript:void(0);" class="close selectcate">确定</a></h2>
          </div>
      </div>
   <div id="Indexcontent">
   <ul style="display:block;">
    <li>
<!--        地区-->
     <p class="seekarea foodaddress">
      <?php foreach ($district as $key => $val): ?>
         <a href="javascript:void(0);" d_id="<?=$val['d_id']?>" ><?=$val['d_name'];?><img src="./images/ch.png"></a>
      <?php endforeach ?>
     </p>
     <div class="SCcontent">
     <?php foreach ($food as $key => $val): ?>
         <a href="<?=Url::to(['menu/details','id'=>$val['food_id']]);?>" target="_blank" title="<?=$val['food_mername'].'-'.$val['food_name'];?>">
             <figure>
                 <img src="<?=$val['food_image'];?>">
                 <figcaption>
                     <span class="title">
                         <p><?=$val['food_mername'];?></p>
                         <p><?=$val['food_name'];?></p>
                     </span>
                     <span class="price"><i>￥</i>
                         <?php if (empty($val['discount_price'])): ?>
                            <?=$val['food_price'];?>
                         <?php else: ?>
                            <?=$val['discount_price'];?>
                         <?php endif ?>
                     </span>
                 </figcaption>
             </figure>
         </a>
     <?php endforeach ?>
     </div>
     <div class="bestshop">
     <?php foreach ($merlogo as $key => $val): ?>
         <a href="<?=Url::to(['index/shop_index','mer'=>$val['mer_id']]);?>" target="_blank" title="<?=$val['mer_name'];?>">
             <figure>
                 <img src="<?=$val['mer_logo'];?>">
             </figure>
         </a>
     <?php endforeach ?>
     </div>
    </li>
   </ul>
   <ul>
    <li>
        <p class="seekarea foodaddress">
            <?php foreach ($district as $key => $val): ?>
                <a href="javascript:void(0);" d_id="<?=$val['d_id']?>" ><?=$val['d_name'];?><img src="./images/ch.png"></a>
            <?php endforeach ?>
        </p>
     <div class="DCcontent">
     <?php foreach ($merchant as $key => $val): ?>
        <a href="<?=Url::to(['index/shop_index','mer'=>$val['mer_id']]);?>" target="_blank" title="<?=$val['mer_name'];?>">
               <figure>
                   <img src="<?=$val['merinfo']['info_image'];?>">
                   <figcaption>
                       <span class="title"><?=$val['mer_name'];?></span>
                       <span class="price"><?=$val['mer_phone'];?></span>
                   </figcaption>
                   <p class="p1">优惠信息：<q><?=$val['merinfo']['info_favorable'];?></q></p>
                   <p class="p2">
                       店铺评分：
                       <img src="images/star-on.png">
                       <img src="images/star-on.png">
                       <img src="images/star-on.png">
                       <img src="images/star-on.png">
                       <img src="images/star-off.png">
                   </p>
                   <p class="p3">店铺地址：<?=$val['mer_address'];?>...</p>
               </figure>
           </a>
     <?php endforeach ?>

       
     </div>
  </li>
  </ul>
 </div>
 </div>
 </article>
 <aside class="A-infor">
  <img src="upload/2014911.jpg">
     <span>用户菜品点评</span>
  <div class="usercomment">
   <ul>
    <?php foreach ($speak as $key => $val): ?>
        <li>
            <img src="<?=$val['food_image'];?>">
            <a href="<?=Url::to(['menu/details','id'=>$val['food_id']])?>">用户“<?=$val['user_name'];?>”对[ <?=$val['mer_name'];?> ]“<?=$val['food_name'];?>”评说：<?=mb_substr($val['speak_body'],0,21,'utf-8');?>...</a>
        </li>
    <?php endforeach ?>

   </ul>
  </div>
 </aside>
</section>
<input type="hidden" id="get_orders" value="<?=Url::to(['index/get_orders']);?>">
<input type="hidden" id="foodurl" value="<?=Url::to(['index/s_food']);?>">
<input type="hidden" id="shopurl" value="<?=Url::to(['index/s_shop']);?>">
<input type="hidden" id="cateurl" value="<?=Url::to(['index/get_cate']);?>">

<!--End content-->
<script type="text/javascript" src="js/modernizr.custom.46884.js"></script>
<script type="text/javascript" src="js/jquery.slicebox.js"></script>
<script type="text/javascript" src="js/index.js"></script>

