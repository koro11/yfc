<?php use \yii\helpers\Url; ?>
<article class="U-article Overflow">
    <!--user Coupon-->
    <section class="M-coupon Overflow">
        <span class="coupontitle Block Font14 FontW Lineheight35">我的优惠券</span>
        <?php if (empty($user['tickets'])) { ?>
            <ul>
                <?php foreach ($user as $key => $val) { ?>

                    <?php if (date('Ymd', $val['tickets']['tic_end']) < date('Ymd', time())) { ?>

                        <a href="<?= Url::to(['shop/shop', 'mer' => $val['tickets']['tic_merchant']]) ?>" class="Fontfff" target="_blank">
                            <li>
                                <p><i>￥</i><?= $val['tickets']['tic_cost'] ?><span class="Font14 FontW">全店通用</span></p>
                                <p>发行店铺：<?= $val['tickets']['tic_mername'] ?></p>
                                <p>有效期：<?= date('Y-m-d', $val['tickets']['tic_start']) ?>
                                    至<?php echo date('Y-m-d', $val['tickets']['tic_end']) ?></p>
                                <p class="U-price FontW">已过期</p>
                                <a href="javascript:void(0)" id="del" ticid="<?php echo $val['cun_id'] ?>">删除</a>
                            </li>
                        </a>
                    <?php } else { ?>
                        <a href="<?= Url::to(['shop/shop', 'mer' => $val['tickets']['tic_merchant']]) ?>" class="Fontfff" target="_blank">
                            <li>
                                <p class="U-price FontW"><i>￥</i><?= $val['tickets']['tic_cost'] ?>
                                    <span class="Font14 FontW">全店通用</span></p>
                                <p>发行店铺：<?php echo $val['tickets']['tic_mername'] ?></p>
                                <p>使用条件：满<?php echo $val['tickets']['tic_cond'] ?>元即可使用</p>
                                <p>有效期：<?php echo date('Y-m-d', $val['tickets']['tic_start']) ?>
                                    至<?php echo date('Y-m-d', $val['tickets']['tic_end']) ?></p>
                            </li>
                        </a>
                    <?php } ?>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <ul>
                暂无
            </ul>
        <?php } ?>
    </section>
</article>
</section>
<!--End content-->
<script type="text/javascript">
    $(document).delegate("#del", "click", function () {
        var cun_id = $(this).attr("ticid");
        $.ajax({
            type: 'get',
            url: "<?=Url::to('user/del_tic')?>",
            data: 'cun_id=' + cun_id,
            success: function (msg) {
                if (msg == 1) {
                    alert('删除成功');
                    location.href = "<?=Url::to('user/user_coupon')?>";
                }
            }
        })
    })
</script>
