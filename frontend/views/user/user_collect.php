<!--Start content-->
<section class="Psection MT20">
<nav class="U-nav Font14 FontW">
   <ul>
   <li><i></i><a href="?r=user/user_index">用户中心首页</a></li>
   <li><i></i><a href="?r=user/user_orderlist">我的订单</a></li>
   <li><i></i><a href="?r=user/user_address">收货地址</a></li>
   <li><i></i><a href="?r=user/user_message">我的留言</a></li>
   <li><i></i><a href="?r=user/user_coupon">我的优惠券</a></li>
   <li><i></i><a href="?r=user/user_collect">我的收藏</a></li>
   <li><i></i><a href="?r=user/user_account">账户管理</a></li>
   <li><i></i><a href="#">安全退出</a></li>
  </ul>
 </nav>
 <article class="U-article Overflow">
  <!--user Favorites-->
  <section class="ShopFav Overflow">
   <span class="ShopFavtitle Block Font14 FontW Lineheight35">我的收藏</span>
    <?php if (!empty($arr)) {?>
    <ul>
    <?php foreach ($arr as $key => $val) {?>
    <a href="?r=shop/shop&mer=$val['merchant']['mer_id']" target="_blank">
    <li>
     <img src="<?php echo $val['merchant']['mer_logo']?>">
     <p><?php echo $val['merchant']['mer_name']?> <a href="javascript:void(0)" id="del" collectid="<?php echo $val['collect_id']?>">( 删除 )</a></p>
    </li>
    </a>
    <?php }?>
    </ul>
    <?php }else{?>
    <ul>
      暂无
    </ul>
    <?php }?>
   
  </section>
 </article>
</section>
<!--End content-->
<script type="text/javascript">
  $(document).delegate("#del","click",function(){
    var collect_id=$(this).attr("collectid");
    $.ajax({
      type:'get',
      url:'?r=user/del_collect',
      data:'collect_id='+collect_id,
      success:function(msg)
      {
          if (msg==1) 
          {
            alert('删除成功');location.href="?r=user/user_collect";
          }
          else
          {
            alert('删除失败');
          }
      }
    })
  })
</script>