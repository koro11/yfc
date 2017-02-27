<!--Start content-->
<?php
use yii\widgets\LinkPager;
?>
<style> 
    .pagination{margin:20px 0; overflow:hidden;line-height:30px;list-style:none;}
    .pagination a,.pagination span{height:30px; line-height:30px;margin:0 10px 10px 0; float:left;padding:0 10px; color:#fff; background:#91cebe;-webkit-transition: .2s;-moz-transition: .2s;transition: .2s;}
    .pagination a:hover,.pagination span:hover{background:#009875;-webkit-transition: .2s;-moz-transition: .2s;transition: .2s;}
    .pagination a.current,.pagination span.current,.pagination span.disabled{background:#009875;cursor:pointer;}
    .pagination input{border:1px solid #cbcbcb;margin:0 5px; height:28px;font-size:16px;line-height:28px;}
  </style>
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
  <!--user order list-->
  <section >
    <table class="Myorder">
     <th class="Font14 FontW">订单编号</th>
     <th class="Font14 FontW">下单时间</th>
     <th class="Font14 FontW">收件人</th>
     <th class="Font14 FontW">订单总金额</th>
     <th class="Font14 FontW">订单状态</th>
     <th class="Font14 FontW">操作</th>
     <?php foreach ($models as $key => $value) {?>
     <tr>
      <td class="FontW"><a href="user_order.html"><?php echo $value['order_sn']?></a></td>
      <td><?php echo date('Y-m-d,H:i',$value['order_paytime'])?></td>
      <td><?php echo $name?></td>
      <td>￥<?php echo $value['order_amount']?></td>
      <?php if($value['shipping_status']==0 && $value['pay_status']==0){?>
      <td>未付款,未配送</td>
      <?php }elseif($value['shipping_status']==0 && $value['pay_status']==1){?>
        <td>已付款,正在打包</td>
      <?php }elseif($value['shipping_status']==1 && $value['pay_status']==1){?>
        <td>已付款,正在配送</td>
      <?php }else{?>
        <td>已付款,用户已确认收货</td>
      <?php }?>

      <?php if ($value['shipping_status']==2 && $value['pay_status']==1 && $value['order_speak']!=0) {?>
      <td><a href="?r=user/user_order&order_id=<?php echo $value['order_id']?>">查看订单</a></td>
      <?php }elseif($value['shipping_status']==2 && $value['pay_status']==1 && $value['order_speak']==0){?>
      <td><a href="?r=user/user_order&order_id=<?php echo $value['order_id']?>">查看订单</a> | 
        <a href="?r=user/order_speak&order_id=<?php echo $value['order_id']?>">评价订单</a></td>
      <?php }elseif($value['pay_status']==0){?>
      <td> <a href="?r=order/order&order_id=<?php echo $value['order_id']?>">付款</a>
        |<a href="?r=user/user_order&order_id=<?php echo $value['order_id']?>">修改地址</a></td>
      <?php }else{?>
      <td><a href="?r=user/del_order&order_id=<?php echo $value['order_id']?>">取消订单</a>
      <?php }?>
     </tr>
     <?php }?>
    </table>
    <input type="button" id="ha">
    <div >
                <?php
          echo LinkPager::widget([
              'pagination' => $pages,
              'nextPageLabel'=>'下一页',
              'prevPageLabel'=>'上一页',
              'firstPageLabel'=>'首页',
              'lastPageLabel'=>'尾页'
           ]);?>
               </div>
  </section>
 </article>
</section>

<!--End content-->
