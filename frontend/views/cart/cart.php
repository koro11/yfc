<!--Start content-->
<?php use \yii\helpers\Url;?>
<form action="#">
    <div class="gwc" style=" margin:auto;">
        <table cellpadding="0" cellspacing="0" class="gwc_tb1">
            <tr>
                <td class="tb1_td1"><input id="Checkbox1" type="checkbox" class="allselect"/></td>
                <td class="tb1_td1">全选</td>
                <td class="tb1_td3">商品</td>
                <td class="tb1_td4">原价</td>
                <td class="tb1_td5">数量</td>
                <td class="tb1_td6">单价</td>
                <td class="tb1_td7">操作</td>
            </tr>
        </table>
        <?php if(!empty($res)):?>
        <?php foreach ($res as $k => $va) { ?>
            <table cellpadding="0" cellspacing="0" class="gwc_tb2" class="table1">
                <tr>
                    <td colspan="7"  class="shopname Font14 FontW">店铺：<?php echo $k ?></td>
                </tr>
                <?php foreach ($va as $key => $v) { ?>
                    <table ellpadding="0" cellspacing="0" class="gwc_tb2" class="table1">
                        <tr>
                            <td class="tb2_td1"><input sellerId="<?php echo $v['food']['food_mer']?>" type="checkbox" cartid="<?php echo isset($v['cart_id'])?$v['cart_id']:''?>"  value="<?php echo $v['food']['price']*$v['food']['buy_number'] ?>" name="newslist" class="newslist-1"/></td>
                            <td class="tb2_td2"><a href="detailsp.html" target="_blank"><img src="<?php echo $v['food']['food_image']?>"/></a>
                            </td>
                            <td class="tb2_td3"><a href="detailsp.html" target="_blank" style="margin-left: 20px;"><?php echo $v['food']['food_name'] ?></a>
                            </td>
                            <?php if ($v['food']['is_discount']): ?>
                                <td class="tb1_td4"><s>￥<?php echo $v['food']['food_price'] ?></s></td>
                            <?php else: ?>
                                <td class="tb1_td4"><s><font color="red">促销活动</font</s>></td>
                            <?php endif; ?>
                            <td class="tb1_td5">
                                <input class="min1" name="" style="width:30px; height:30px;border:1px solid #ccc;" type="button" value="-"/>
                                <input calss="text_box1" status="0" name="text_box1" type="text" value="<?php echo $v['food']['buy_number'] ?>" style=" width:40px;height:28px; text-align:center; border:1px solid #ccc;"/>
                                <input class="add1" name="" style="width:30px; height:30px;border:1px solid #ccc;" type="button" value="+"/>
                            </td>
                            <td class="tb1_td6"><label class="tot" style="color:#ff5500;font-size:14px; font-weight:bold;"><?php echo $v['food']['price'] ?></label>
                            </td>
                            <td class="tb1_td7"><a href="javascript:;" foodid="<?php echo isset($v['cart_id'])?$v['cart_id']:''?>" calss="delcart">删除</a></td>
                        </tr>
                    </table>
                <?php } ?>
            </table>
        <?php } ?>
        <?php else:?>
            <table  cellpadding="0" cellspacing="0" class="gwc_tb2" class="table1">
                <tr>
                    <td style="line-height:300px;" colspan="7"  class="shopname Font14 FontW"><center><font color="red">您的购物车是空的,快去选餐吧!</font></center></td>
                </tr>
            </table>
        <?php endif;?>
        <table cellpadding="0" cellspacing="0" class="gwc_tb3">
            <tr>
                <td class="tb1_td1"><input id="checkAll" class="allselect" type="checkbox"/></td>
                <td class="tb1_td1">全选</td>
                <td class="tb3_td1"><input id="invert" type="checkbox"/>
                    反选
                    <input id="cancel" type="checkbox"/>
                    取消
                </td>
                <td class="tb3_td2 GoBack_Buy Font14"><a href="<?=Url::to('index/index')?>" target="_blank">继续购物</a></td>
                <td class="tb3_td2">已选商品
                    <label id="shuliang" style="color:#ff5500;font-size:14px; font-weight:bold;">0</label>
                    件
                </td>
                <td class="tb3_td3">合计(不含运费):<span>￥</span><span style=" color:#ff5500;">
        <label id="zong1" style="color:#ff5500;font-size:14px; font-weight:bold;">0.00</label>
        </span></td>
                <td class="tb3_td4"><span id="jz1">结算</span><a href="javascript:;" style=" display:none;" class="jz2" id="jz2">结算</a></td>
            </tr>
        </table>
    </div>
</form>
<!--End content-->