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
<?php use yii\helpers\Url;?>
<!--Start content-->
<section class="slp">
 <section class="food-hd">
  <div class="foodpic">
   <img src="<?php echo $details['food_image']?>" id="showimg">
    <ul class="smallpic">
     <li><img src="upload/02.jpg" onmouseover="show(this)" onmouseout="hide()"></li>
     <li><img src="<?php echo $details['food_image']?>" onmouseover="show(this)" onmouseout="hide()"></li>
    </ul>
  </div>
  <div class="foodtext" style="width: 555px;">
   <div class="foodname_a">
    <h1><?php echo $details['food_name']?></h1>
    <p><?php echo $details['mer_address']?></p>
   </div>
   <div class="price_a">
    <?php if($details['is_discount']):?>
        <p class="price01">促销：￥<span><?php echo $details['discount_price']?></span></p>
        <p class="price02">价格：￥<s><?php echo $details['food_price']?></s></p>
    <?php else:?>
        <p class="price01">价格：￥<span><?php echo $details['food_price']?></span></p>
    <?php endif;?>
   </div>
   <div class="Freight">
    <span>配送费用：</span>
    <span><i>未央区</i>至<i>莲湖区</i></span>
    <span>10.00</span>
   </div>
   <ul class="Tran_infor">
     <li>
      <p class="Numerical"><?php echo $details['food_saled']?></p>
      <p>月销量</p>
     </li>
     <li class="line">
      <p class="Numerical"><?php echo $num?></p>
      <p>累计评价</p>
     </li>
     <li>
     <?php if($details['is_score']):?>
      <p class="Numerical"><?php echo $details['food_score']?></p>
      <p>送幸福积分</p>
     <?php else:?>
       <p style="margin-top: 10px;"><font color="red">此商品积分已送完</font></p>
     <?php endif;?>
     </li>
   </ul>
   <div class="BuyNo">
    <span>我要买：<input type="number" name="Number" required autofocus min="1" value="1"/>份</span>
    <span>商家状态：<?php echo $details['mer_status']?'停止营业':'正在营业' ?></span>
    <div class="Buybutton">
     <input type="hidden" name="food" value="<?php echo $details['food_id']?>">
     <button class="BuyB">加入购物车</button>
     <a href="<?=Url::to(['index/shop_index','mer'=>$details['food_mer']])?>"><span class="Backhome">进入店铺首页</span></a>
    </div>

   </div>
  </div>
  <div class="viewhistory">
   <span class="VHtitle">浏览历史</span>
   <ul class="Fsulist">
    <?php if($list):?>
    <?php foreach($list as $k=>$v):?>
    <li>
     <a href="detailsp.html" target="_blank" title="<?php echo $v['food_name']?>"><img src="<?php echo $v['food_image']?>"></a>
     <p><?php echo $v['food_name']?></p>
     <p>￥<?php echo $v['food_price']?></p>
    </li>
    <?php endforeach;?>
    <?php endif;?>
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
      <li>评价详情（<?php echo $num?>）</li>
      <p><b></b></p>
    </ul>
  </div>
  <div class="menutab-wrap">
    <!--case1-->
    <div class="menutab show">
      <div class="cont_padding">
       <img src="<?php echo $details['food_image']?>">
       <p><?php echo $details['food_desc']?></p>
      </div>
    </div>
    <!--case2-->

    <div class="menutab">
     <div class="cont_padding">
      <table class="Dcomment">
       <th width="80%">评价内容</th>
       <th width="20%" style="text-align:right">评价人</th>
        <?php if(!empty($content)):?>
       <tbody id="td">
       <?php foreach($content as $k=>$v):?>
           <tr>
               <td>
                   <?php echo $v['speak_body']?>
                   <time><?php echo $v['create_time']?></time>
               </td>
               <td align="right"><?php echo $v['user_name']?></td>
           </tr>
       <?php endforeach;?>
       </tbody>
       <?php else:?>
            <tr>
               <td colspan="2"><center><font color="red">暂无评论</font></center></td>
            </tr>
       <?php endif;?>
      </table>
      <div class="TurnPage">

         <?php echo $page?>

       </div>
     </div>
    </div>
    <!--case4-->

  </article>
  <!--ad&other infor-->
  <aside>
   <!--广告位或推荐位-->
   <a href="#" title="广告位占位图片" target="_blank"><img src="upload/2014912.jpg"></a>
  </aside>
 </section>
</section>
<!--End content-->
<script>
    $(function(){
        var food = $("input[name='food']").val();

        //页码点击
        $(document).delegate(".PNumber",'click',function(){
            var now = $(this).text();
            if(now == '')return false;

            page(now);
        })
        //首页点击
        $(document).delegate(".Prev",'click',function(){
            var now = $(this).attr('page');
            if(now == '')return false;
            page(now);

        })
        //尾页点击
        $(document).delegate(".Next",'click',function(){
            var now =  $(this).attr('page');
            if(now == '')return false;
            page(now);

        })

        function page(page){
            if(page == '')return false;
            if(food == '')return false;

            $.get('<?=Url::to('menu/details')?>',{now:page,id:food,status:1},function(data){
                if(data.status==1){
                    var str = '';
                    $.each(data.content.comment,function(k,v){
                        str += '<tr><td>'+v['speak_body']+'<time>'+v['create_time']+'</time></td> <td align="right">'+v['user_name']+'</td></tr>';
                    })
                    $(".TurnPage").html(data.content.page);
                    $("#td").html(str);
                }
            },'json')
        }
        //加入购物车
        $('.BuyB').click(function(){
            var id = $('input[name="food"]').val();
            var num = $('input[name="Number"]').val();
            $.get('<?=Url::to('menu/addcart')?>',{id:id,num:num},function(data){
//                alert(data);return false;
                if(data.status == 1){
                    if(window.confirm('成功加入购物车,是否进行结算')){
                        document.location = '<?=Url::to('cart/cart')?>';
                    }
                }else if(data.status == '-1'){
                    if(window.confirm('此商品已经存在购物车中,是否进入购物车')){
                        document.location = '<?=Url::to('cart/cart')?>';
                    }
                }else{
                    alert(data.msg);
                }
            },'json')
        })
    })
</script>
