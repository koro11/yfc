<!--Start content-->
<section class="Cfn">
 <aside class="C-left">
  <div class="S-time">服务时间：周一~周六<time>09:00</time>-<time>23:00</time></div>
  <div class="C-time">
   <img src="upload/dc.jpg"/>
  </div>
  <a href="list.html" target="_blank"><img src="images/by_button.png"></a>
  <a href="list.html" target="_blank"><img src="images/dc_button.png"></a>
 </aside>
 <div class="F-middle">
 <ul class="rslides f426x240">
        <li><a href="javascript:"><img src="upload/01.jpg"/></a></li>
        <li><a href="javascript:"><img src="upload/02.jpg" /></a></li>
        <li><a href="javascript:"><img src="upload/03.jpg"/></a></li>
    </ul>
 </div>
 <aside class="N-right">
  <div class="N-title">公司新闻 <i>COMPANY NEWS</i></div>
  <ul class="Newslist">
   <li><i></i><a href="article_read.html" target="_blank" title="这里调用新闻标题...">欢迎访问DeathGhost博客站...</a></li>
   <li><i></i><a href="article_read.html" target="_blank" title="这里调用新闻标题...">H5WEB前端开发 移动WEB模板设计...</a></li>
  </ul>
  <ul class="Orderlist" id="UpRoll">
   <li>
   <p>订单编号：2014090912973</p>
   <p>收件人：王先生</p>
   <p>订单状态：<i class="State01">已发货</i></p>
   </li>
   <li>
   <p>订单编号：2014090912978</p>
   <p>收件人：张小姐</p>
   <p>订单状态：<i class="State02">已签收</i><i class="State03">已点评</i></p>
   </li>
   <li>
   <p>订单编号：2014090912988</p>
   <p>收件人：龚先生</p>
   <p>订单状态：<i class="State02">已签收</i><i class="State03">已点评</i></p>
   </li>
  </ul>
  <script>
   var UpRoll = document.getElementById('UpRoll');
   var lis = UpRoll.getElementsByTagName('li');
   var ml = 0;
   var timer1 = setInterval(function(){
    var liHeight = lis[0].offsetHeight;
    var timer2 = setInterval(function(){
     UpRoll.scrollTop = (++ml);
     if(ml ==1){
        clearInterval(timer2);
        UpRoll.scrollTop = 0;
        ml = 0;
        lis[0].parentNode.appendChild(lis[0]);
    }
    },10); 
    },5000);
  </script>
 </aside>
</section>
<section class="Sfainfor">
 <article class="Sflist">
  <div id="Indexouter">
   <ul id="Indextab">
    <li class="current">点菜</li>
    <li>餐馆</li>
    <p class="class_B">
    <a href="#">中餐</a>
    <a href="#">西餐</a>
    <a href="#">甜点</a>
    <a href="#">日韩料理</a>
    <span><a href="#" target="_blank">more ></a></span>
    </p>
   </ul>
  <div id="Indexcontent">
   <ul style="display:block;">
    <li>
     <p class="seekarea">
     <a href="#">碑林区</a>
     <a href="#">新城区</a>
     <a href="#">未央区</a>
     <a href="#">雁塔区</a>
     <a href="#">莲湖区</a>
     <a href="#">高新区</a>
     <a href="#">灞桥区</a>
     <a href="#">高陵区</a>
     <a href="#">阎良区</a>
     <a href="#">临潼区</a>
     <a href="#">长安区</a>
     <a href="#">周至县</a>
     <a href="#">蓝田县 </a>
     </p>
     <div class="SCcontent">
     <a href="detailsp.html" target="_blank" title="菜品名称">
      <figure>
       <img src="upload/05.jpg">
       <figcaption>
       <span class="title">老李家的糖醋鲤鱼</span>
       <span class="price"><i>￥</i>169.00</span>
       </figcaption>
      </figure>
      </a>
     <a href="detailsp.html" target="_blank" title="菜品名称">
      <figure>
       <img src="upload/04.jpg">
       <figcaption>
       <span class="title">老李家的糖醋鲤鱼</span>
       <span class="price"><i>￥</i>169.00</span>
       </figcaption>
      </figure>
      </a>
     <a href="detailsp.html" target="_blank" title="菜品名称">
      <figure>
       <img src="upload/06.jpg">
       <figcaption>
       <span class="title">老李家的糖醋鲤鱼</span>
       <span class="price"><i>￥</i>169.00</span>
       </figcaption>
      </figure>
      </a>
     </div>
     <div class="bestshop">
      <a href="shop.html" target="_blank" title="店铺名称">
      <figure>
       <img src="upload/wpjnewlogo.jpg">
      </figure>
      </a>
      <a href="shop.html" target="_blank" title="店铺名称">
      <figure>
       <img src="upload/weijia.jpg">
      </figure>
      </a>
      <a href="shop.html" target="_blank" title="店铺名称">
      <figure>
       <img src="upload/wpjnewlogo.jpg">
      </figure>
      </a>
      <a href="shop.html" target="_blank" title="店铺名称">
      <figure>
       <img src="upload/weijia.jpg">
      </figure>
      </a>
      <a href="shop.html" target="_blank" title="店铺名称">
      <figure>
       <img src="upload/wpjnewlogo.jpg">
      </figure>
      </a>
     </div>
    </li>
   </ul>
   <ul>
  <li>
     <p class="seekarea">
     <a href="#">碑林区</a>
     <a href="#">新城区</a>
     <a href="#">未央区</a>
     <a href="#">雁塔区</a>
     <a href="#">莲湖区</a>
     <a href="#">高新区</a>
     <a href="#">灞桥区</a>
     <a href="#">高陵区</a>
     <a href="#">阎良区</a>
     <a href="#">临潼区</a>
     <a href="#">长安区</a>
     <a href="#">周至县</a>
     <a href="#">蓝田县 </a>
     </p>
     <div class="DCcontent">
       <a href="shop.html" target="_blank" title="TITLE:店名">
       <figure>
       <img src="upload/cc.jpg">
       <figcaption>
       <span class="title">老重庆川菜馆</span>
       <span class="price">预定折扣：<i>8.9折</i></span>
       </figcaption>
       <p class="p1"><q>仅售169元！价值289元的4-5人餐，提供免费WiFi。</q></p>
       <p class="p2">
       店铺评分：
       <img src="images/star-on.png">
       <img src="images/star-on.png">
       <img src="images/star-on.png">
       <img src="images/star-on.png">
       <img src="images/star-off.png">
       </p>
       <p class="p3">店铺地址：西安市雁塔区丈八路***老重庆川菜馆...</p>
       </figure>
      </a>
       <a href="shop.html" target="_blank" title="TITLE:店名">
       <figure>
       <img src="upload/cc.jpg">
       <figcaption>
       <span class="title">老重庆川菜馆</span>
       <span class="price">预定折扣：<i>8.9折</i></span>
       </figcaption>
       <p class="p1"><q>仅售169元！价值289元的4-5人餐，提供免费WiFi。</q></p>
       <p class="p2">
       店铺评分：
       <img src="images/star-on.png">
       <img src="images/star-on.png">
       <img src="images/star-on.png">
       <img src="images/star-on.png">
       <img src="images/star-off.png">
       </p>
       <p class="p3">店铺地址：西安市雁塔区丈八路***老重庆川菜馆...</p>
       </figure>
      </a>
       <a href="shop.html" target="_blank" title="TITLE:店名">
       <figure>
       <img src="upload/cc.jpg">
       <figcaption>
       <span class="title">老重庆川菜馆</span>
       <span class="price">预定折扣：<i>8.9折</i></span>
       </figcaption>
       <p class="p1"><q>仅售169元！价值289元的4-5人餐，提供免费WiFi。</q></p>
       <p class="p2">
       店铺评分：
       <img src="images/star-on.png">
       <img src="images/star-on.png">
       <img src="images/star-on.png">
       <img src="images/star-on.png">
       <img src="images/star-off.png">
       </p>
       <p class="p3">店铺地址：西安市雁塔区丈八路***老重庆川菜馆...</p>
       </figure>
      </a>
     </div>
  </li>
  </ul>
 </div>
 </div>
 </article>
 <aside class="A-infor">
  <img src="upload/2014911.jpg">
  <div class="usercomment">
   <span>用户菜品点评</span>
   <ul>
    <li>
     <img src="upload/01.jpg">
     用户“DeathGhost”对[ 老李川菜馆 ]“酸辣土豆丝”评说：味道挺不错，送餐速度挺快...
    </li>
    <li>
     <img src="upload/02.jpg">
     用户“DeathGhost”对[ 魏家凉皮 ]“酸辣土豆丝”评说：味道挺不错，送餐速度挺快...
    </li>
   </ul>
  </div>
 </aside>
</section>
<!--End content-->
