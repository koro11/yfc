<script>
$(function(){		
	$('.title-list li').click(function(){
		var liindex = $('.title-list li').index(this);
		$(this).addClass('on').siblings().removeClass('on');
		$('.menutab-wrap div.menutab').eq(liindex).fadeIn(150).siblings('div.menutab').hide();
		var liWidth = $('.title-list li').width();
		$('.shopcontent .title-list p').stop(false,true).animate({'left' : liindex * liWidth + 'px'},300);
	});
	
	$('.menutab-wrap .menutab li').hover(function(){
		$(this).css("border-color","#ff6600");
		$(this).find('p > a').css('color','#ff6600');
	},function(){
		$(this).css("border-color","#fafafa");
		$(this).find('p > a').css('color','#666666');
	});
	});
</script>

<!--Start content-->
<section class="slp">
 <section class="food-hd">
  <div class="foodpic">
   <img src="upload/02.jpg" id="showimg">
    <ul class="smallpic">
     <li><img src="upload/02.jpg" onmouseover="show(this)" onmouseout="hide()"></li>
    </ul>
  </div>
  <div class="foodtext">
   <div class="foodname_a">
    <h1>酸辣土豆丝</h1>
    <p>西安市丈八路220号</p>
   </div>
   <div class="price_a">
    <p class="price01">促销：￥<span>59.00</span></p>
    <p class="price02">价格：￥<s>69.00</s></p>
   </div>
   <div class="Freight">
    <span>配送费用：</span>
    <span><i>未央区</i>至<i>莲湖区</i></span>
    <span>10.00</span>
   </div>
   <ul class="Tran_infor">
     <li>
      <p class="Numerical">3</p>
      <p>月销量</p>
     </li>
     <li class="line">
      <p class="Numerical">58</p>
      <p>累计评价</p>
     </li>
     <li>
      <p class="Numerical">59</p>
      <p>送幸福积分</p>
     </li>
   </ul>
   <form action="cart.html">
   <div class="BuyNo">
    <span>我要买：<input type="number" name="Number" required autofocus min="1" value="1"/>份</span>
    <span>库存：3258</span>
    <div class="Buybutton">
     <input name="" type="submit" value="加入购物车" class="BuyB">
     <a href="shop.html"><span class="Backhome">进入店铺首页</span></a>
    </div>
   </div>
  </div>
  <div class="viewhistory">
   <span class="VHtitle">看了又看</span>
   <ul class="Fsulist">
    <li>
     <a href="detailsp.html" target="_blank" title="酱爆茄子"><img src="upload/03.jpg"></a>
     <p>酱爆茄子</p>
     <p>￥12.80</p>
    </li>
    <li>
     <a href="detailsp.html" target="_blank" title="酱爆茄子"><img src="upload/02.jpg"></a>
     <p>酱爆茄子</p>
     <p>￥12.80</p>
    </li>
   </ul>
  </div>
 </section>
 <!--bottom content-->
 <section class="Bcontent">
  <article>
   <div class="shopcontent">
  <div class="title2 cf">
    <ul class="title-list fr cf ">
      <li class="on">详细说明</li>
      <li>评价详情（5）</li>
      <li>成交记录（5）</li>
      <p><b></b></p>
    </ul>
  </div>
  <div class="menutab-wrap">
    <!--case1-->
    <div class="menutab show">
      <div class="cont_padding">
       <img src="upload/tds.jpg">
       <p>测试信息，可删除！</p>
       <p>1. 将土豆洗净刮皮。</p>
       <p>2. 先将土豆切成整齐的大薄片这样是切出均匀的丝的要点。</p>
       <p>3. 将土豆片切成细丝。</p>
       <p>4. 用清水将切好的土豆丝泡去淀粉，（这样炒出的土豆丝清爽不粘）</p>
       <p>5. 将葱切末、辣椒剪成小段、蒜切末、红椒切丝、姜切末。</p>
      </div>
    </div>
    <!--case2-->
    <div class="menutab">
     <div class="cont_padding">
      <table class="Dcomment">
       <th width="80%">评价内容</th>
       <th width="20%" style="text-align:right">评价人</th>
       <tr>
       <td>
        还不错，速度倒是挺速度倒是挺快速度倒是挺快速度倒是挺快速度倒是挺快速度倒是挺快速度倒是挺快速度倒是挺快速度倒是挺快速度倒是挺快速度倒是挺快速度倒是挺快快...
        <time>2016-05-31 22:30:39</time>
       </td>
       <td align="right">DEATHGHOST</td>
       </tr>
      </table>
      <div class="TurnPage">
         <a href="#">
          <span class="Prev"><i></i>首页</span>
         </a>
         <a href="#"><span class="PNumber">1</span></a>
         <a href="#"><span class="PNumber">2</span></a>
         <a href="#">
         <span class="Next">最后一页<i></i></span>
        </a>
       </div>
     </div>
    </div>
    <!--case4-->
    <div class="menutab">
     <div class="cont_padding">
     
      <table width="888">
       <th width="35%">买家</th>
       <th width="20%">价格</th>
       <th width="15%">数量</th>
       <th width="30%">成交时间</th>
       <tr height="40">
        <td>d***t</td>
        <td>￥59</td>
        <td>1</td>
        <td>2014-9-18 11:13:07</td>
       </tr>
      </table>
     
     </div>
       <div class="TurnPage">
         <a href="#">
          <span class="Prev"><i></i>首页</span>
         </a>
         <a href="#"><span class="PNumber">1</span></a>
         <a href="#"><span class="PNumber">2</span></a>
         <a href="#">
         <span class="Next">最后一页<i></i></span>
        </a>
       </div>
   </div>
  </article>
  <!--ad&other infor-->
  <aside>
   <!--广告位或推荐位-->
   <a href="#" title="广告位占位图片" target="_blank"><img src="upload/2014912.jpg"></a>
  </aside>
 </section>
</section>
<!--End content-->
