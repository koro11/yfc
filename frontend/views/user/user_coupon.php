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
  <!--user Coupon-->
  <section class="M-coupon Overflow">
   <span class="coupontitle Block Font14 FontW Lineheight35">我的优惠券</span>
   <?php if (empty($user['tickets'])) {?>
   <ul>
    <?php foreach ($user as $key => $val) {?>

  <?php if(date('Ymd',$val['tickets']['tic_end'])<date('Ymd',time())){?>

    <a href="?r=shop/shop&mer=<?php echo $val['tickets']['tic_merchant']?>" class="Fontfff" target="_blank">
    <li>
     <p ><i>￥</i><?php echo $val['tickets']['tic_cost']?><span class="Font14 FontW">全店通用</span></p>
     <p>发行店铺：<?php echo $val['tickets']['tic_mername']?></p>
     <p>有效期：<?php echo date('Y-m-d',$val['tickets']['tic_start'])?>至<?php echo date('Y-m-d',$val['tickets']['tic_end'])?></p>
     <p class="U-price FontW">已过期</p><a href="javascript:void(0)" id="del" ticid="<?php echo $val['cun_id']?>">删除</a>
    </li>
    </a>
  <?php }else{?>
     <a href="?r=shop/shop&mer=<?php echo $val['tickets']['tic_merchant']?>" class="Fontfff" target="_blank">
    <li>
     <p class="U-price FontW"><i>￥</i><?php echo $val['tickets']['tic_cost']?><span class="Font14 FontW">全店通用</span></p>
     <p>发行店铺：<?php echo $val['tickets']['tic_mername']?></p>
     <p>使用条件：满<?php echo $val['tickets']['tic_cond']?>元即可使用</p>
     <p>有效期：<?php echo date('Y-m-d',$val['tickets']['tic_start'])?>至<?php echo date('Y-m-d',$val['tickets']['tic_end'])?></p>
    </li>
    </a> 
  <?php }?>



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
        var cun_id=$(this).attr("ticid");
        $.ajax({
          type:'get',
          url:"?r=user/del_tic",
          data:'cun_id='+cun_id,
          success:function(msg)
          {
              if (msg==1) 
              {
                alert('删除成功');location.href="?r=user/user_coupon";
              }
          }
        })
    })
</script>
