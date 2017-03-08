<!--Start content-->
<section class="Psection MT20" id="Cflow">

    <!--如果用户未添加收货地址，则显示如下-->
    <div class="confirm_addr_f">
        <span class="flow_title">收货地址：</span>
        <!--如果未添加地址，则显示此表单-->
        <form class="add_address" action="#" style="display:none;">
            <p><i>收件人姓名：</i><input type="text" name="" required></p>
            <p>
                <i>选择所在地：</i>
                <select name="">
                    <option>陕西省</option>
                </select>
                <select name="">
                    <option>西安市</option>
                </select>
                <select name="">
                    <option>莲湖区</option>
                </select>
            </p>
            <p><i>街道地址：</i><input type="text" required size="50"></p>
            <p><i>邮政编码：</i><input type="text" required size="10" pattern="[0-9]{6}"></p>
            <p><i>手机号码：</i><input type="text" name="" required pattern="[0-9]{11}"></p>
            <p><i></i><input name="" type="submit" value="确定"></p>
        </form>
        <!--已保存的地址列表-->
        <form action="#">
            <ul class="address">
                <?php if ($address): ?>
                    <?php foreach ($address as $k => $v): ?>
                        <li id="style1"><input type="radio" checked value="<?php echo $v['cons_id'] ?>" name="rdColor"
                                               onclick="changeColor(1)"/><label
                                for="1"> <?php echo $v['cons_province'] ?> <?php echo $v['cons_city'] ?> <?php echo $v['cons_district'] ?> <?php echo $v['cons_address'] ?>
                                （<?PHP echo $v['cons_name'] ?>收）<span
                                    class="fontcolor"><?php echo str_replace(substr($v['cons_phone'], 4, 4), '****', $v['cons_phone']) ?></span></label>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
                <li><a href="javascript:void(0)"
                       onclick="document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'"><img
                            src="images/newaddress.png"/></a></li>
            </ul>
        </form>
        <!--add new address-->
        <form action="#">
            <div id="light" class="O-L-content">
                <ul>
                    <li><span><label for="">选择所在地：</label></span>
                        <p><em>*</em><select name="">
                                <option>陕西省</option>
                            </select> <select name="">
                                <option>西安市</option>
                            </select> <select name="">
                                <option>雁塔区</option>
                            </select></p>
                    </li>
                    <li><span><label for="">邮政编码：</label></span>
                        <p><em>*</em><input name="" type="text" class="Y_N" pattern="[0-9]{6}" required></p></li>
                    <li><span><label for="">街道地址：</label></span>
                        <p><em>*</em><textarea name="" cols="80" rows="5"></textarea></p></li>
                    <li><span><label for="">收件人姓名：</label></span>
                        <p><em>*</em><input name="" type="text"></p></li>
                    <li><span><label for="">手机号码：</label></span>
                        <p><em>*</em><input name="" type="text" pattern="[0-9]{11}" required></p></li>
                    <div class="button-a"><input type="button" value="确 定" class="C-button"/><a
                            href="javascript:void(0)"
                            onclick="document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"><span><input
                                    name="" type="button" value="取 消" class="Cancel-b"/></a></div>
                    <div class="close-botton"><a href="javascript:void(0)"
                                                 onclick="document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"></a>
                    </div>
            </div>
            <div id="fade" class="overlay"></div>
            </ul>

            <!--End add new address-->
        </form>
    </div>
    <!--配送方式及支付，则显示如下-->
    <!--check order or add other information-->
    <div class="pay_delivery">
        <span class="flow_title">配送方式：</span>
        <table>
            <th width="30%">配送方式</th>
            <th width="30%">运费</th>
            <th width="40%">说明</th>
            <?php foreach ($ships as $k => $v): ?>
                <tr>

                    <td><input type="radio" checked name="ships"
                               value="<?php echo $v['ship_id'] ?>"><?php echo $v['ship_name'] ?></td>
                    <td>￥<span><?php echo $v['ship_cost'] ?></span></td>
                    <td><?php echo $v['ship_desc'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <span class="flow_title">在线支付方式：</span>
        <form action="#">
            <ul>
                <li><input type="radio" name="pay" checked id="alipay" value="1"/><label for="alipay"><i
                            class="alipay"></i></label></li>
            </ul>
        </form>
    </div>

    <div class="inforlist">
        <span class="flow_title">商品清单</span>
        <table>
            <th>名称</th>
            <th>数量</th>
            <th>价格</th>
            <th>小计</th>

            <?php foreach ($res as $k => $va): ?>
                <tbody class="td">
                <tr style="background-color: darkgrey">
                    <td colspan="4">店铺：<?php echo substr($k, '0', strrpos($k, ',')) ?>
                        <span style="float: right;margin-top: 5px;">店铺优惠：
        <select name="tickets" seller="<?php echo substr($k, strrpos($k, ',') + 1) ?>" lower="<?php echo $k ?>">
            <option tic="0" value="0">不使用优惠卷</option>
            <?php if (isset($va['store'])): ?>
                <?php foreach ($va['store'] as $ks => $vs): ?>
                    <option tic="<?php echo $vs['tic_id'] ?>" value="<?php echo $vs['tic_cost'] ?>">
                        ￥<?php echo $vs['tic_cost'] . '元' . $vs['tic_desc'] ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select></span>
                    </td>
                </tr>

                <?php foreach ($va['food'] as $ka => $v): ?>
                    <tr>
                        <td>
                            <div style="height:50px;"><img style="width: 80px;" src="<?php echo $v['food_image'] ?>"
                                                           title="<?php echo $v['food_name'] ?>">
                            </div><?php echo $v['food_name'] ?></td>
                        <td><?php echo $v['buy_number'] ?></td>
                        <td>￥<?php echo $v['price'] ?></td>
                        <td>￥<?php echo $v['sumprice'] ?></td>
                        <input type="hidden" name="cart" value="<?php echo $v['cart_id'] ?>">
                    </tr>
                <?php endforeach; ?>
                </tbody>

            <?php endforeach; ?>
        </table>
        <div class="Order_M">
            <p><em>订单附言:</em><input name="leaving" type="text"></p>
            <?php if (!empty($fullCourt)): ?>
            <p><em>优惠券:</em>
                <select name="fullCourt" tic="全场">
                    <option tic='0' value="0">不使用优惠劵</option>
                    <?php foreach ($fullCourt as $k => $v): ?>
                        <option tic="<?php echo $v['tickets']['tic_id'] ?>"
                                value="<?php echo $v['tickets']['tic_cost'] ?>">
                            ￥<?php echo $v['tickets']['tic_cost'] ?><?php echo $v['tickets']['tic_desc'] ?></option>
                    <?php endforeach; ?>
                </select>
                <?php endif; ?>
            </p>
        </div>
        <div class="Sum_infor">
            <p class="p1">配送费用：￥<span id="ships">0</span>.00+商品费用：￥<?php echo $sumPrice ?>-优惠券：￥<span
                    id="discount">0</span>.00</p>
            <p class="p2">合计：￥<span><?php echo $sumPrice ?>.00</span></p>
            <input type="submit" value="提交订单" class="p3button">
        </div>
    </div>
    </div>

</section>
<script>
    //Test code,You can delete this script /2014-9-21DeathGhost/
    $("input[name=ships]").click(function () {
        var price = $(this).parent().next('td').find('span').text();
        $("#ships").text(price);
    })
    $(".p3button").click(function () {

        var address = $("input[name=rdColor]:checked").val();
        if (!address) {
            alert('请选择收货地址');
            return false;
        }
        var payment = $("input[name=pay]:checked").val();
        if (!payment) {
            alert('请选择支付方式');
            return false;
        }
        var ships = $("input[name=ships]:checked").val();
        if (!ships) {
            alert('请选择配货方式');
            return false;
        }

        var fullCourt = $('select[name="fullCourt"] option:selected').attr('tic');
        var count = $('.td').size();

        var lower = [];

        for (var i = 0; i < count; i++) {
            var num = $('select[name=tickets]').eq(i).parents('.td').find('input[name=cart]').size();
            var cart = '';
            for (var a = 0; a < num; a++) {
                if (cart == '') {
                    cart += $('select[name=tickets]').eq(i).parents('.td').find('input[name=cart]').eq(a).val();
                } else {
                    cart += ',' + $('select[name=tickets]').eq(i).parents('.td').find('input[name=cart]').eq(a).val();
                }
            }
            var seller = {
                'lower': $('select[name=tickets]').eq(i).find('option:selected').attr('tic'),
                'seller': $('select[name=tickets]').eq(i).attr('seller'),
                'cart': cart,
            }
            lower[i] = seller;
        }

        var leaving = $("input[name=leaving]").val();

        $.ajax({
            type: "POST",
            url: "<?=\yii\helpers\Url::toRoute('order/setorder')?>",
            data: {
                lower: lower,
                fullCourt: fullCourt,
                payment: payment,
                address: address,
                leaving: leaving,
                ships: ships
            },
            async: false,
            dataType: 'json',
            success: function (data) {
                if (data.status == 0) {
                    alert(data.msg);
                    return false;
                } else {
                    $("#payss").attr('href', data.url);
                    $('.CorRed').text(data.order);
                    $('.money').text('￥' + data.sum);
                    $("#Cflow").hide();
                    $("#Aflow").show();
                }
            }
        });

    });
    var arr = [];
    $('select[name=fullCourt]').change(function () {
        var price = $(this).val();
        var obj = $('#discount');
        var lower = $(this).attr('tic');

        if (arr[lower]) {
            if (price == '0') {
                var money = arr[lower];
                obj.text((obj.text() - money));
                delete arr[lower];
            } else {
                var money = arr[lower];

                obj.text((obj.text() - money));
                delete arr[lower];
                arr[lower] = price;
                var sum = parseInt(obj.text()) + parseInt(price);
                obj.text(sum);
                arr[lower] = price;
            }
        } else {
            var sum = parseInt(obj.text()) + parseInt(price);
            obj.text(sum);
            arr[lower] = price;
        }
    })

    $('select[name="tickets"]').change(function () {
        var lower = $(this).attr('lower');
        var price = $(this).val();
        var obj = $('#discount');
        if (arr[lower]) {
            if (price == '0') {
                var money = arr[lower];
                obj.text((obj.text() - money));
                delete arr[lower];
            } else {
                var money = arr[lower];
                obj.text((obj.text() - money));
                delete arr[lower];
                arr[lower] = price;
                var sum = parseInt(obj.text()) + parseInt(price);
                obj.text(sum);
                arr[lower] = price;
            }

        } else {
            var sum = parseInt(obj.text()) + parseInt(price);
            obj.text(sum);
            arr[lower] = price;
        }
    })

</script>
<section class="Psection MT20 Textcenter" style="display:none;" id="Aflow">
    <!-- 订单提交成功后则显示如下 -->
    <p class="Font14 Lineheight35 FontW">恭喜你！订单提交成功！</p>
    <p class="Font14 Lineheight35 FontW">您的订单编号为：<span class="CorRed"></span></p>
    <p class="Font14 Lineheight35 FontW">共计金额：<span class="money"></span></p>
    <p><span style="background-color: #b3b4a8;height: 50px;" class="Lineheight35"><a id="payss" onclick="#">支付宝立即支付</a></span>
        <button type="button" class="Lineheight35"><a href="user_center.html">进入用户中心</button>
    </p>
</section>
<!--End content-->