<?php use yii\helpers\Url ;?>
<style>
  .login_wrap{
  background: url(../images/logo_bg.jpg) no-repeat center;
  background-size: 100%;
}
.logo{
  width: 500px;
  height: 150px;
  margin: 0px auto;
  background: url(../images/logowz.png) no-repeat center;
}
.login_box{
  width: 360px;
  background: #FFFFFF;
  margin: 0px auto;
}
.login_title{
  font-size: 18px;
  text-align: center;
  color: #888888;
  padding: 15px 0;
  width: 300px;
  margin: 0 auto;
  border-bottom: solid 1px #CCCCCC;
}
.form_text_ipt{
  width: 300px;
  height: 40px;
  border: solid 1px #CCCCCC;
  margin: 20px auto 0 auto;
  background: #FFFFFF;
}
.form_check_ipt{
  width: 300px;
  margin:  10px auto;
  overflow: hidden;
}
.form_text_ipt input{
  width: 290px;
  height: 30px;
  margin: 5px;
  border: none;
  font-family: "微软雅黑";
  font-size: 15px;
  color: #666;
}
.check_left label{
  cursor: pointer;
}
.check_left label input{
  position: relative;
  top: 2px;
}
.form_btn{
  width: 300px;
  height: 40px;
  margin:  10px auto;
}
.form_btn button{
  width: 100%;
  height: 100%;
  border: none;
  color: #FFFFFF;
  font-size: 14px;
  background: red;
  cursor: pointer;
}
.form_reg_btn{
  width: 300px;
  margin: 0 auto;
  font-size: 14px;
  color: #666;
}
.other_login{
  overflow: hidden;
  width: 300px;
  height: 80px;
  line-height: 80px;
  margin: 0px auto;
}
.other_left{
  font-size: 14px;
  color: #999;
}
.state1{
    color:#aaa;
}
.state2{
    color:#000;
}
.state3{
    color:red;
}
.state4{
    color:green;
}
</style>
<script src="http://api.map.baidu.com/api?v=2.0&ak=rLwK3QfoqXKyQvHGtkcM6A77GYSm4ys4"></script>
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
  var mt = 0;
window.onload = function () {
 var Topcart = document.getElementById("Topcart");
   var mt = Topcart.offsetTop;
    window.onscroll = function () {
     var t = document.documentElement.scrollTop || document.body.scrollTop;
      if (t > mt) {
      Topcart.style.position = "fixed";
        Topcart.style.margin = "";
         Topcart.style.top = "200px";
     Topcart.style.right = "191px";
     Topcart.style.boxShadow ="0px 0px 20px 5px #cccccc";
     Topcart.style.top="0";
     Topcart.style.border="1px #636363 solid";
         }
         else { 
         Topcart.style.position = "static";
     Topcart.style.boxShadow ="none";
     Topcart.style.border="";
          }
          }
        }
</script>

<!--Start content-->
<section class="Shop-index">
 <article>
  <div class="shopinfor">
   <div class="title">
    <img src="upload/wpjnewlogo.jpg" class="shop-ico">
    <span><?=$shop_info['merchant']['mer_name']?></span>
    <span>
     <img src="images/star-on.png">
     <img src="images/star-on.png">
     <img src="images/star-on.png">
     <img src="images/star-on.png">
     <img src="images/star-off.png">
    </span>
    <span>4.8</span>
   </div>
   <div class="imginfor">
    <div class="shopimg">
     <img src="<?=$shop_info['info_image']?>" id="showimg">
     
    </div>
    <div class="shoptext">
     <p><span>地址：</span><?=$shop_info['merchant']['mer_address']?></p>
     <p><span>电话：</span><?=$shop_info['merchant']['mer_phone']?></p>
     <p><span>特色菜品：</span><?=$shop_info['info_specialty']?></p>
     <p><span>优惠活动：</span><?=$shop_info['info_favorable']?></p>
     <p><span>停车位：</span>
     <?php if ($shop_info['info_park'] == 0): ?>
       暂无停车位
     <?php else: ?>
      <?=$shop_info['info_park_num']?>个停车位
        <?php if ($shop_info['info_price'] == 0): ?>
       （免费）
        <?php else: ?>
        <?=$shop_info['info_park_price']?>&nbsp;元/小时
        <?php endif ?>
     <?php endif ?>
     </p>
     <p><span>营业时间：</span><?=$shop_info['info_business']?></p>
     <p><span>WIFI：</span>
       <?php if ($shop_info['is_wifi'] == 0): ?>
       免费WIFI
        <?php endif ?>  
     </p>
     <p><span>人均消费：</span><?=$shop_info['merchant']['info_catipa']?>元</p>
     <div class="Button">

     <?php if ($shop_info['merchant']['mer_status'] == 1): ?>      
        <font color="red">该商家目前暂不提供服务，请耐心等候...</font>
        <?php endif ?>

     </div>
     <div class="otherinfor">
     <a href="javascript:void(0)" class="icoa" mid="<?=$shop_info['info_mer']?>"><img src="images/collect.png">收藏店铺（<?=$shop_collect_num?>）</a>
     <div class="bshare-custom"><a title="分享" class="bshare-more bshare-more-icon more-style-addthis">分享</a></div>
   <script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=1&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
     </div>
   </div>
  </div>
  <div class="shopcontent">
  <div class="title2 cf">
    <ul class="title-list fr cf ">
      <li class="on">菜谱</li>
      <li>累计评论（<?=$shop_comment_num?>）</li>
      <li>商家详情</li>
      <li>店铺留言</li>
      <p><b></b></p>
    </ul>
  </div>
  <div class="menutab-wrap">
   <div name="ydwm">
    <!--case1-->
    <div class="menutab show">
     <ul class="products">

    <?php foreach ($shop_foods as $key => $value): ?>    
    <li>
     <a href="<?php echo $shop_info['merchant']['mer_status'] == 1 ? Url::to(['index/shop_index','mer'=>$shop_info['info_mer']]): Url::to(['menu/details','id'=>$value['food_id']]);?>" target="_blank" title="<?=$value['food_name']?>">
         <img src="<?=$value['food_image']?>" class="foodsimgsize">
         </a>
          <div class="item">
     <div>
      <p><?=$value['food_name']?></p>
      <p class="AButton">拖至购物车:￥<?=$value['food_price']?></p>
     </div>
     </div>
    </li>
    <?php endforeach ?>
    <div class="TurnPage">
    <?=$shop_foods_pages?>
    </div> 
   </ul>
   
    </div>
    </div>
    <!--case2-->
    <div class="menutab">
     <?php foreach ($shop_comment as $ck => $cv): ?>
       
     <div class="shopcomment">
      <div class="Spname">
       <a href="<?=Url::to(['menu/details','id'=>$cv['food_id']]);?>" target="_blank" title="<?=$cv['food_name']?>"><img src="<?=$cv['food_image']?>" width="70"></a>
      </div>
      <div class="C-content">
       <q><?=$cv['speak_body']?></q>
       <i><?=date('Y-m-d H:i:s',$cv['create_time'])?> </i>
      </div>
      <div class="username">
      <?=$cv['user_name']?>
      </div>
     </div>
     <?php endforeach ?>

    </div>
    <!--case4-->
    <div class="menutab">
     <div class="shopdetails">
     <div class="shopmaparea">
      <div id="allmap"></div><!--此处占位图调用动态地图后将其删除即可-->
     </div>
     <div class="shopdetailsT">
      <p><span>店铺：<?=$shop_info['merchant']['mer_name']?></span></p>
      <p><span>地址：</span><?=$shop_info['merchant']['mer_address']?></p>
      <p><span>电话：</span><?=$shop_info['merchant']['mer_phone']?></p>
      <p><span>乘车路线：</span><?=$shop_info['info_riding']?></p>
      <p><span>店铺介绍：</span><?=$shop_info['info_desc']?></p>
     </div>
    </div>
    </div>
    <!--case5-->
    <div class="menutab">
     <div class="message_list">
      <?php foreach ($shop_message as $k => $v): ?>
        
     <span class="Ask"><i><?=$v['user_name']?></i>:<?=$v['m_message']?>-<i>于<?=$v['m_addtime']?></i></span>
      <?php if ($v['back']!=''): ?>
        
     <span class="Answer"><i><?=$v['back']['mer_name']?>回复</i>：<?=$v['back']['m_message']?>-<i><?=$v['back']['m_addtime']?></i></span>
      <?php endif ?>
      <?php endforeach ?>
     </div>

    <div>
      <input type="hidden" class="user_id">
      <input type="hidden" class="mer_status" value="<?=$shop_info['merchant']['mer_status']?>">
      <input type="hidden" class="mer_address" value="<?=$shop_info['merchant']['mer_address']?>">
      <input type="hidden" class="mer_id" value="<?=$shop_info['info_mer']?>">
      <textarea class="user_message" id="" cols="50" rows="3"></textarea>
      <button class="show_btn" >留言</button>
    </div>

    </div>
  </div>
</div>
 </article>
 <div id="bg_bg"></div>
<div class="box_mask" style="display:none">
    <h2><a href="#" class="close">关闭</a></h2>
    <div class="list">
            <div class="login_box"> 
          
             <div class="login_title">
              YFC 检测到您还未登录哦！
             </div>
            <form action="" method="post">       
              <div class="form_text_ipt">
                <input name="username" type="text" class="username" placeholder="手机号" ><br>
                <span class="state1"></span>
              </div>
              
              <div class="form_text_ipt">
                <input name="password" type="password" placeholder="密码"><br>
              </div>
              <div class="ececk_warning"><span>数据不能为空</span></div>
              <div class="form_check_ipt">
                <div class="left check_left">
                  <label><input name="" type="checkbox"> 下次自动登录</label>
                </div>
                <div class="right check_right">
                  <a href="#">忘记密码</a>
                </div>
              </div>
              <div class="form_btn">
                <button type="button" class="log_btn">登录</button>
              </div>
              <div class="form_reg_btn">
                <span>还没有帐号？</span><a href="<?=Url::to(['register/user_register'])?>">马上注册</a>
              </div>
            </form>
            <div class="other_login">
              <div class="left other_left">
                <span>其它登录方式</span>
              </div>
              <div class="right other_right">
                <a href="#">QQ登录</a>
                <a href="#">微信登录</a>
                <a href="#">微博登录</a>
              </div>
           </div>
        </div>
    </div>
</div>
<aside>
  <div class="cart" id="Topcart">
  <span class="Ctitle Block FontW Font14"><a href="cart.html" target="_blank">我的购物车</a></span>
  <table id="cartcontent" fitColumns="true">
  <thead>
  <tr>
  <th width="33%" align="center" field="name">商品</th>
  <th width="33%" align="center" field="quantity">数量</th>
  <th width="33%" align="center" field="price">价格</th>
  </tr>
  </thead>
  </table>
  <p class="Ptc"><span class="Cbutton"><a href="cart.html" target="进入购物车">进入购物车</a></span><span class="total">共计金额: ￥0</span></p>
  </div>
  
  <div class="Nearshop">
   <span class="Nstitle">附近其他店铺</span>
   <ul>
    <li>
     <img src="upload/cc.jpg">
     <p>
     <span class="shopname" title="动态调用完整标题"><a href="detailsp.html" target="_blank" title="肯德基">肯德基</a></span>
     <span class="Discolor">距离：1.2KM</span>
     <span title="完整地址title">地址：西安市雁塔区2000号...</span>
     </p>
    </li>
   </ul>
  </div>
  
  <div class="History">
   <span class="Htitle">浏览历史</span>
   <ul class="history_list">
   <?php if ($shop_history): ?>   
   <?php foreach ($shop_history as $sk => $sv): ?> 
    <li>
    <a href="<?=Url::to(['index/shop_index','mer'=>$sv['info_mer']]);?>" target="_blank" title="<?=$sv['info_mername']?>"><img src="<?=$sv['info_image']?>"></a>
    <p>
     <span class="shopname" title="动态调用完整标题">
     <a href="<?=Url::to(['index/shop_index','mer'=>$sv['info_mer']]);?>" target="_blank" title="<?=$sv['info_mername']?>"><?=$sv['info_mername']?></a>
     <br>
     <span><?=$sv['info_address']?></span>
     </span>
    </p>
    </li>
   <?php endforeach ?>
    <span>[ <a href="javascript:void(0)" class="clear_history">清空历史记录</a> ]</span>
   <?php endif ?>
   </ul>
  </div>
 </aside>
<input type="hidden" class="page_url" value="<?=Url::to(['index/get_ajax']);?>">
<input type="hidden" class="this_url" value="<?=Url::to(['index/shop_index']);?>">
<input type="hidden" class="clear_url" value="<?=Url::to(['index/clear_history']);?>">
</section>
<!--End content-->
<script type="text/javascript">
  // 百度地图API功能
  var map = new BMap.Map("allmap");
  var point = new BMap.Point(116.331398,39.897445);
  map.centerAndZoom(point,12);
  // 创建地址解析器实例
  var myGeo = new BMap.Geocoder();
  var mer_address = $('.mer_address').val();
  // 将地址解析结果显示在地图上,并调整地图视野
  myGeo.getPoint(mer_address, function(point){
    if (point) {
      map.centerAndZoom(point, 16);
      map.addOverlay(new BMap.Marker(point));
    }else{
      alert("您选择地址没有解析到结果!");
    }
  }, "北京市");

   //分页
  function page(p){
    
    var mid = $(".mer_id").val();
    var page_url = $('.page_url').val();
    // alert(mid);return false;
    $.ajax({
       type: "GET",
       url: page_url,
       data: {p:p,mid:mid},
       dataType:'json',
       success: function(msg){
            str1(msg);
            $('.TurnPage').html(msg.page);
       }
    });

  }

  function str1(data)
  {
    var str = '';
    var this_url = $('.this_url').val();
    var mer_status = $('.mer_status').val();
    // alert(mer_status);return false;
    if (mer_status == 1) 
      {
        $.each(data.msg,function(k,v){
         str+='<li>'
            + '<a href="'+this_url+'" target="_blank" title="'+v.food_name+'"><img src="'+v.food_image+'" class="foodsimgsize"></a>'
            + '<a href="#" class="item">'
            + '<div>'
            + '<p>'+v.food_name+'</p>'
            + '<p class="AButton">拖至购物车:￥'+v.food_price+'</p></div>'
            + '</a></li><div class="TurnPage"></div>'   
        })
         $('.products').html(str);
         
      }
      else
      {
        $.each(data.msg,function(k,v){
         str+='<li>'
            + '<a href="menu/details?&id='+v.food_id+'" target="_blank" title="'+v.food_name+'"><img src="'+v.food_image+'" class="foodsimgsize"></a>'
            + '<a href="#" class="item">'
            + '<div>'
            + '<p>'+v.food_name+'</p>'
            + '<p class="AButton">拖至购物车:￥'+v.food_price+'</p></div>'
            + '</a></li><div class="TurnPage"></div>'   
        })
        // alert(data.page);return false;
         $('.products').html(str);
        }

  }
$(function(){
      //清除浏览记录
    $('.clear_history').click(function(){
      
      $.get("<?=Url::to(['index/clear_history']);?>",function(data){
        if (data == 1) { 
         alert('清除浏览记录成功')
         $('.history_list').hide();
        };
      })
    })

      //留言
     $(".show_btn").click(function () {
        $.get("<?=Url::to(['index/check_login']);?>",function(data){
            if(data == 0)
            {
              showDiv();
            }
            else
            {
              $('.user_id').val(data);
              var user_id = data;
              var user_message = $(".user_message").val();
              var mer_id = $(".mer_id").val();
              if (user_message == '')
              {
                alert('留言不能为空')
              }
              if (user_id && user_message) 
              {
                
                   $.ajax({
                     type: "POST",
                     url: "<?=Url::to(['message/message_add']);?>",
                     data: 
                     {
                      m_user:user_id,
                      m_mer:mer_id,
                      m_message:user_message,
                     },
                     dataType:'json',
                     success: function(msg){
                      var str = '';   
                       if (msg!=0) {
                        for (var i = 0; i < msg.length; i++) {       
                           str +='<span class="Ask"><i>'+msg[i]['user_name']+'</i>:'+msg[i]['m_message']+'-<i>于'+msg[i]['m_addtime']+'</i></span>';
                           if (msg[i]['back']) 
                            {
                           str +='<span class="Answer"><i>'+msg[i]['back']['mer_name']+'回复</i>：'+msg[i]['back']['m_message']+'-<i>'+msg[i]['back']['m_addtime']+'</i></span>';
                            };
                        }
                        // alert(str);
                        $('.message_list').html(str);
                       };
                     }
                    });
              }
            }
        })
        
    });

     //遮罩层显示
     function showDiv()
     {
      $("#bg_bg").css({
            display: "block", height: $(document).height()
        });
        var $box = $('.box_mask');
        $box.css({
            //设置弹出层距离左边的位置
            left: ($("body").width() - $box.width()) / 2 - 20 + "px",
            //设置弹出层距离上面的位置
            top: ($(window).height() - $box.height()) / 2 + $(window).scrollTop() + "px",
            display: "block"
        });
     }
    obj = new Object();
    
    obj['userpass']  = $('.userpass').val();

     var ok1 = false;
     var ok2 = false;
     //验证手机号
      $(".username").focus(function(){
           // alert(obj)
            this_phone = $(this);
            this_phone.next().next().html('请输入一个可以使用的手机号').removeClass('state1').addClass('state2');
        }).blur(function(){
            obj['username']  = this_phone.val();
            var reg_phone = /^1[3|5|7|8][0-9]{9}$/;
            
            if (!reg_phone.test(obj['username']) ) {           
            this_phone.next().next().html('请输入一个可以使用的手机号').removeClass('state1').addClass('state3');
            }
            else
            {
              $.get("<?=Url::to(['index/check_user_phone']);?>",{user_phone:obj['username']},function(phone_msg){
                if(phone_msg == 1)
                {
                  this_phone.next().next().text('该手机号尚未注册').removeClass('state1').addClass('state3');
                }
                else
                {
                  // alert('输入cheng')
                  this_phone.next().next().text('输入成功').removeClass('state1').addClass('state4');
                  ok1 = true;
                }
              })
            }
        });


     $('.log_btn').click(function(){
      
      obj['userpass']  = $("input[name=password]").val();
      $.get("<?=Url::to(['index/check_user_login']);?>",obj,function(usr_data){
       if (usr_data == 0) {
        alert('密码错误')
        $("input[name=password]").focus()
       }
       else
       {
        $('.user_id').val(usr_data);
        // $("#bg_bg,.box_mask").css("display", "none");
        window.history.go(0)
       }
      })
     })

    //点击关闭按钮的时候，遮罩层关闭
    $(".close").click(function () {
        $("#bg_bg,.box_mask").css("display", "none");
    });
  })
</script>
 
 
