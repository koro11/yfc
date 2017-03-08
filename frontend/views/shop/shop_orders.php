
 <article class="U-article Overflow">
  <!--user order list-->
  <section>
    <table class="Myorder">
     <th class="Font14 FontW">订单编号</th>
     <th class="Font14 FontW">下单时间</th>
     <th class="Font14 FontW">收件人</th>
     <th class="Font14 FontW">配送方式</th>
     <th class="Font14 FontW">订单总金额</th>
     <th class="Font14 FontW">支付方式</th>
     <th class="Font14 FontW">订单状态</th>
     <th class="Font14 FontW">操作</th>
     <?php foreach ($orders as $key => $value): ?>     	
     <tr>
      <td class="FontW"><a href="user_order.html"><?=$value['order_sn']?></a></td>
      <td><?php echo date('Y-m-d H:i:s',$value['order_addtime']);?></td>
      <td><?=$value['consignee']?></td>
      <td><?=$value['ship_name']?></td>
      <td>￥<?=$value['food_amount']?></td>
      <td><?=$value['pay_way']?></td>
      <td>
      <?php if ($value['shipping_status'] == 0): ?>
      	未配送
        <?php else: ?>
      	已配送
      <?php endif ?>
      </td>
      <td><a href="#">取消订单</a> | <a href="#">配送</a></td>
     </tr>
     <?php endforeach ?>
    </table>
    <div class="TurnPage">
    <?php echo \yii\widgets\LinkPager::widget([
	'pagination' => $pages,
	'firstPageLabel'=>'首页',
    'prevPageLabel'=>'上一页',
    'nextPageLabel'=>'下一页',
    'lastPageLabel'=>'最后一页',
    'pageCssClass'=>'PNumber',//数字
	'firstPageCssClass'=>'Prev',//首页
	'lastPageCssClass'=>'Next',//尾页
	'prevPageCssClass'=>'Prev',//上一页
	'nextPageCssClass'=>'Next',//下一页
	'label'=>'span',
          ]);
 ?></div>
    
  </section>
 </article>
</section>
<!--End content-->
