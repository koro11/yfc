<?php foreach ($orders as $key => $val): ?>
    <li>
        <p>菜品：<?=$val['food_name'];?></p>
        <p>收件人：<?=$val['consignee'];?></p>
        <p>订单状态：<i class="State01">已支付</i>
        <?php if ($val['shipping_status']==0): ?>
                        <i class="State01">配货中</i>
                    <?php elseif ($val['shipping_status']==1): ?>
                        <i class="State02">配送中</i>
                    <?php else: ?>
                        <i class="State03">已收货</i>
                    <?php endif ?>
    </li>
<?php endforeach ?>