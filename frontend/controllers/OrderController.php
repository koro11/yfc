<?php
namespace frontend\controllers;

use frontend\models\Carts;
use frontend\models\Merchant;
use frontend\models\Orders;
use frontend\models\Date;
use frontend\models\Total_order;
use yii\db\Query;
use yii\web\Controller;
use frontend\models\Consignee;
use frontend\models\User_ticket;
use libs\alipay\AlipayNotify;
use libs\alipay\AlipaySubmit;


class OrderController extends CommonController
{
    public $enableCsrfValidation = false;

    /**
     * 订单展示
     * @author Dx
     * @param  string $cartId
     * @param  intval $uid
     * @return string
     */
    public function actionOrder()
    {
        //用户ID
        $session = \Yii::$app->session;
        $uid     = intval($session->get('user_id'));

        if (!$uid) echo \Yii::$app->view->renderFile('@app/views/login/login.php');
        //结算参数
        $param = \Yii::$app->request->get();
        if (empty($param)) exit('缺少参数,不正确');
        unset($param['r']);
        //商品ID
        $cartId = urldecode($param['buycart'] . $param['id'] . $param['param']);

        //获取要结算的商品
        $cart = new Carts();
        $data = $cart->getCart($cartId, $uid);
        if (empty($data)) exit('此商品已经下单喽');
        //收货地址
        $obj     = new Consignee();
        $address = $obj->getAddress($uid);

        $sumPrice = '';
        //优惠券
        $ticket = new User_ticket();
        //处理商品信息
        foreach ($data as $k => $v) {
            //餐饮价格和总价格
            if ($v['food']['is_discount']) {
                $v['price']    = $v['food']['discount_price'];
                $v['sumprice'] = ($v['buy_number'] * $v['food']['discount_price']);
                $sumPrice      = $sumPrice + ($v['buy_number'] * $v['food']['discount_price']);
            } else {
                $v['price']    = $v['food']['food_price'];
                $v['sumprice'] = ($v['buy_number'] * $v['food']['food_price']);
                $sumPrice      = $sumPrice + ($v['buy_number'] * $v['food']['food_price']);
            }
            $res[$v['food']['food_mername'] . ',' . $v['food']['food_mer']]['food'][$k] = $v;
        }

        //商户优惠券
        foreach ($res as $k => $v) {
            $food_mer = substr($k, strrpos($k, ',') + 1);
            $price    = '';
            foreach ($v['food'] as $ke => $va) {
                $price = $price + $va['price'];
            }
            $store = $ticket->getTicket($uid, $food_mer, $price);
//            var_dump($store);die;
            if ($store) {
                foreach ($store as $ks => $va) {
                    $res[$k]['store'][] = $va['tickets'];
                }
            }

        }
        $fullCourt = $ticket->getFullcourt($uid, $sumPrice);

        //配送
        $obj   = new Query();
        $ships = $obj->from('yfc_ships')->all();
//        var_dump($res);die;
        return $this->render('order', ['address' => $address, 'res' => $res, 'sumPrice' => $sumPrice, 'fullCourt' => $fullCourt, 'ships' => $ships]);
    }

    /**
     * 生成订单
     * @author Dx
     * @param
     * @return string
     */
    public function actionSetorder()
    {

        $session = \Yii::$app->session;
        $return  = array(
            'status' => 0,
            'msg'    => '',
        );
        if (!$session->has('user_id')) {
            $return['msg'] = '请重新登录,登录已过期';
            exit(json_encode($return));
        }
        $uid = intval($session->get('user_id'));
        //支付方式
        $obj   = new Query();
        $param = \Yii::$app->request->post();
        $ship  = $obj->select('ship_name,ship_id')->from('yfc_ships')->where(['ship_id' => $param['ships']])->one();
        if (!$ship) {
            $return['msg'] = '配送方式不存在';
            exit(json_encode($return));
        }
        $ticket = new User_ticket();
        //全场优惠券是否过期
        if (isset($param['fullCourt'])) {
            $res = $ticket->getCoupon($uid, $param['fullCourt']);
            if (!$res) {
                $return['msg'] = '全场优惠券过期啦';
                exit(json_encode($return));
            }
            if (!$ticket->delStore($res['tic_id'])) {
                $return['msg'] = '全场优惠券无法使用,请重试';
                exit(json_encode($return));
            }
        }

        $store = $param['lower'];
        if (!is_array($store)) {
            $return['msg'] = '参数不正确';
            exit(json_encode($return));
        }
        $count = count($store);

        //商家是否可以下单
        $cart     = new Carts();
        $business = new Merchant();
        $arr      = array();
        $cart_id  = array();
        $lower_id = '';
        for ($i = 0; $i < $count; $i++) {
            if (empty($store[$i]['seller'])) {
                $return['msg'] = '无法下单,重试';
                exit(json_encode($return));
            }

            $res = $business->checkOffline($store[$i]['seller']);
            if (!$res) {
                $return['msg'] = '商户已经不存在';
                exit(json_encode($return));
            }
            if ($res['mer_status'] == '1') {
                $return['msg'] = $res['mer_name'] . '商户未营业,请明日再来';
                exit(json_encode($return));
            }
            //商户优惠券是否过期
            if (!empty($store[$i]['lower']) || $store[$i]['lower']) {
                $Coupon = $ticket->getStore($uid, $store[$i]['lower'], $store[$i]['seller']);
                if (empty($Coupon)) {
                    $return['msg'] = $res['mer_name'] . '商户的优惠券已失效,请换一张';
                    exit($return);
                }
            }
            $food = $cart->getCart($store[$i]['cart'], $uid);
            if (empty($food)) {
                $return['msg'] = '商家已经下线,无法购买';
                exit($return);
            }

            foreach ($food as $k => $v) {
                if ($v['food_mer'] == $store[$i]['seller']) {
                    if (isset($Coupon) && $store[$i]['lower'] == $Coupon['tickets']['tic_id']) {
                        $lower_id .= empty($lower_id) ? $Coupon['tickets']['tic_id'] : ',' . $Coupon['tickets']['tic_id'];
                        //删除优惠券
                        if (!$ticket->delStore($lower_id)) {
                            $return['msg'] = '优惠券使用失败,请重试';
                            exit(json_encode($return));
                        }
                        $arr[$store[$i]['seller']]['discount_pay'] = $Coupon['tickets']['tic_cost'];
                    }
                    $arr[$store[$i]['seller']][] = $v;
                }
            }
            $cart_id[$i] = $store[$i]['cart'];
        }

        $address   = intval($param['address']);
        $consignee = Consignee::find()->select('cons_name')->where(['cons_id' => $address, 'user_id' => $uid])->one();
        if (!$consignee) {
            $return['msg'] = '收货地址错误';
            exit(json_encode($return));
        }

        $pay = $obj->select('pay_way')->from('yfc_pays')->where(['pay_id' => $param['payment']])->one();
        if (empty($pay)) {
            $return['msg'] = '支付方式不存在,请重新选择';
            exit(json_encode($return));
        }

        //购物车ID
        $cartid = implode(',', $cart_id);
        if (!$cart->delCart($cartid)) {
            $return['msg'] = '网络拥挤,结算购物车失败';
            exit(json_encode($return));
        }
        //订单
        $order    = new Orders();
        $details  = new Date();
        $data     = array();
        $money    = '';
        $order_sn = '';
        $order_id = '';
        foreach ($arr as $k => $v) {
            $data['merchant_id'] = $k;
            $data['order_sn']    = $this->actionGetorder_sn();
            $data['user_id']     = $uid;
            $data['ship_id']     = $ship['ship_id'];
            $data['ship_name']   = $ship['ship_name'];
            //留言
            if (!empty($param['leaving'])) {
                $data['Remarks'] = $param['leaving'];
            }
            $data['order_addtime'] = time();
            //优惠券
            if (isset($v['discount_pay'])) {
                $data['discount_pay'] = $v['discount_pay'];
            }
            //支付
            $data['pay_way']       = $pay['pay_way'];
            $data['pay_id']        = $param['payment'];
            $data['order_paytime'] = time();
            //收货
            $data['address_id'] = $address;
            $data['consignee']  = $consignee['cons_name'];
            //获取此商家消费价钱
            $fooddetails = $this->actinGetsumprice($v);
            //餐饮ID
            $data['food_id'] = $fooddetails['id'];
            //餐饮总计
            $data['food_amount'] = $fooddetails['sum'];
            //订单总计
            $money += $data['order_amount'] = isset($data['discount_pay']) ? $data['food_amount'] - $data['discount_pay'] : $data['food_amount'];
            $id = $order->setOrder($data);
            if (!$id) {
                $return['msg'] = '餐饮下单失败,请重试';
                exit(json_encode($return));
            }
            $order_id = empty($order_id) ? $id : $order_id . ',' . $id;
            $res      = $details->setOrderdetails($v, $id);
            if (!$res) {
                $return['msg'] = '餐饮下单失败,请联系商家';
                exit(json_encode($return));
            }
        }

        $total = new Total_order();
        $data  = array(
            'total_order_user'    => $uid,
            'total_order_sn'      => $order_sn = $this->actionGetorder_sn(),
            'total_creat_time'    => time(),
            'total_order_details' => $order_id,
        );
        if (!$total->setOrder($data)) {
            $return['msg'] = '中途出现了点差错,请联系管理员';
            exit(json_encode($return));
        };

        //支付宝
        $url              = $this->actionCreate_pay_url($order_sn, '0.01');
        $return['sum']    = $money;
        $return['order']  = $order_sn;
        $return['url']    = $url;
        $return['msg']    = '成功下单';
        $return['status'] = 1;
        exit(json_encode($return));
    }

    //支付宝签名创建
    public function actionCreate_pay_url($order_sn, $money)
    {
        $alipay_config['partner'] = '2088121321528708';
        //收款支付宝账号
        $alipay_config['seller_email'] = 'itbing@sina.cn';
        //安全检验码，以数字和字母组成的32位字符
        $alipay_config['key'] = '1cvr0ix35iyy7qbkgs3gwymeiqlgromm';
        //↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
        //签名方式 不需修改
        $alipay_config['sign_type'] = strtoupper('MD5');
        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        $alipay_config['transport'] = 'http';

        $parameter = array(
            "service"        => "create_direct_pay_by_user",
            "partner"        => $alipay_config['partner'], // 合作身份者id
            "seller_email"   => $alipay_config['seller_email'], // 收款支付宝账号
            "payment_type"   => '1', // 支付类型
            "notify_url"     => 'http://yy.8023i.com/order/pay_notify', // 服务器异步通知页面路径
            "return_url"     => 'http://www.img.com/order/pay_return', // 页面跳转同步通知页面路径
            "out_trade_no"   => $order_sn, // 商户网站订单系统中唯一订单号
            "subject"        => "8023i", // 订单名称
            "total_fee"      => $money, // 付款金额
            "body"           => "来这吃", // 订单描述 可选
            "_input_charset" => 'utf-8', // 字符编码格式
        );

        // 参数排序
        ksort($parameter);
        reset($parameter);
        $str = "";
        foreach ($parameter as $k => $v) {
            if (empty($str)) {
                $str .= $k . "=" . $v;
            } else {
                $str .= "&" . $k . "=" . $v;
            }
        }
        $parameter['sign']      = md5($str . $alipay_config['key']);    // 签名
        $parameter['sign_type'] = $alipay_config['sign_type'];
        // var_dump($parameter);die;
        $action_url = "https://mapi.alipay.com/gateway.do?";
        $pay        = '';
        foreach ($parameter as $k => $v) {
            if (empty($pay)) {
                $pay .= $k . "=" . $v;
            } else {
                $pay .= '&' . $k . "=" . $v;
            }
        }
        return $action_url . $pay;
    }

    //支付异步回调
    public function actionPay_notify()
    {
        $result = $_REQUEST;

        if ($result['trade_status'] == 'TRADE_FINISHED' || $result['trade_status'] == 'TRADE_SUCCESS') {
            $session = \Yii::$app->session;
            $total   = new Total_order();
            $order   = new Orders();
            $data    = $total->getOne($result['out_trade_no'], $session->get('user_id'));
            $res     = $order->savePay($data['total_order_details']);
            if ($res) {
                echo 'success';
            }
        }
    }

    //支付同步回调
    public function actionPay_return()
    {
        $result = $_REQUEST;

        if ($result['trade_status'] == 'TRADE_FINISHED' || $result['trade_status'] == 'TRADE_SUCCESS') {
            $session = \Yii::$app->session;
            $total   = new Total_order();
            $order   = new Orders();
            $data    = $total->getOne($result['out_trade_no'], $session->get('user_id'));
            $res     = $order->savePay($data['total_order_details']);
            if ($res) {
                echo 'success';
            } else {
                echo 'error';
            }
        } else {
            echo 'qqqq';
        }
    }

    public function actinGetsumprice($param)
    {
        if (empty($param)) exit('缺少参数');
        unset($param['food_id']);
        if (isset($param['discount_pay'])) unset($param['discount_pay']);
        $sumPrice = '';
        $id       = '';
        foreach ($param as $k => $v) {

            if ($v['food']['is_discount']) {
                $sumPrice += $v['buy_number'] * $v['food']['discount_price'];
            } else {
                $sumPrice += $v['buy_number'] * $v['food']['food_price'];
            }
            $id .= empty($id) ? $v['food']['food_id'] : ',' . $v['food']['food_id'];
        }
        $res['sum'] = $sumPrice;
        $res['id']  = $id;
        return $res;
    }

    /**
     * 订单号
     * @author Dx
     * @param
     * @return string
     */
    public function actionGetorder_sn()
    {
        $session = \Yii::$app->session;
        $uid     = $session->get('user_id');
        //订单号生成
        $orderNumber = 'LaiZhe' . rand(100000, 999999) . substr(time(), 5, 5) . $uid;
        $order       = new Orders();
        $res         = $order->getOrderNumber($orderNumber);
        if (!$res) $this->actionGetorder_sn();
        return $orderNumber;

    }

    //确认提交订单
    public function actionSub_order()
    {
        return $this->render('sub_order');
    }
    

    public function actionPay()
    {
        $time = date('Y-m-d H:i:s');
        echo date('Y-m-d H:i:s', strtotime("$time -1 day -1 hour"));
//        var_dump($this->getDir());
//        $out_trade_no = '654653';
//        $order = Orders::find()->where(['=','order_sn',$out_trade_no])->asArray()->one();
//        var_dump($order);
//        var_dump(json_decode('{"discount":"0.00","payment_type":"1","subject":"test\u5546\u54c1123","trade_no":"2017030321001004480295138195","buyer_email":"18335124292","gmt_create":"2017-03-03 11:36:34","notify_type":"trade_status_sync","quantity":"1","out_trade_no":"test20170303113520","seller_id":"2088121321528708","notify_time":"2017-03-03 11:36:42","body":"\u5373\u65f6\u5230\u8d26\u6d4b\u8bd5","trade_status":"TRADE_SUCCESS","is_total_fee_adjust":"N","total_fee":"0.01","gmt_payment":"2017-03-03 11:36:41","seller_email":"itbing@sina.cn","price":"0.01","buyer_id":"2088702194394489","notify_id":"77c7410071cf150498cf6c46f010d8djpe","use_coupon":"N","sign_type":"MD5","sign":"9ee577e265541725225f08cb4889eadb"}',true));
//        return $this->render('pay');
    }

    public function actionAlipay()
    {
        /***************************请求参数******************************************/
        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = $_POST['WIDout_trade_no'];

        //订单名称，必填
        $subject = $_POST['WIDsubject'];

        //付款金额，必填
        $total_fee = $_POST['WIDtotal_fee'];

        //商品描述，可空
        $body = $_POST['WIDbody'];

        $alipay_config = $this->payConfig();

        /****************************************************************************/
        //构造要请求的参数数组，无需改动
        $parameter = array(
            "service"      => $alipay_config['service'],
            "partner"      => $alipay_config['partner'],
            "seller_id"    => $alipay_config['seller_id'],
            "payment_type" => $alipay_config['payment_type'],
            "notify_url"   => $alipay_config['notify_url'],
            "return_url"   => $alipay_config['return_url'],

            "anti_phishing_key" => $alipay_config['anti_phishing_key'],
            "exter_invoke_ip"   => $alipay_config['exter_invoke_ip'],
            "out_trade_no"      => $out_trade_no,
            "subject"           => $subject,
            "total_fee"         => $total_fee,
            "body"              => $body,
            "_input_charset"    => trim(strtolower($alipay_config['input_charset']))
            //其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.kiX33I&treeId=62&articleId=103740&docType=1
            //如"参数名"=>"参数值"

        );

        //建立请求
        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text    = $alipaySubmit->buildRequestForm($parameter, "get", "确认");
        echo $html_text;

    }

    public function actionNotifypay()
    {
        $this->layout = false;
//        logResult('1'.json_encode($_POST));
        $alipay_config = $this->payConfig();
        $alipayNotify  = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();

        if ($verify_result) {
            //验证成功
            $out_trade_no = $_POST['out_trade_no'];//商户订单号
            $trade_no     = $_POST['trade_no'];//支付宝交易号
            $trade_status = $_POST['trade_status']; //交易状态

            if ($trade_status == 'TRADE_FINISHED') {//交易完成
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
                //如果有做过处理，不执行商户的业务程序

                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知


//                logResult(implode(',', $_POST));
            } else if ($trade_status == 'TRADE_SUCCESS') {//可以退款
                //判断该笔订单是否在商户网站中已经做过处理


                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
                //如果有做过处理，不执行商户的业务程序

                //注意：
                //付款完成后，支付宝系统发送该交易状态通知


//                logResult(json_encode($_POST));
            }
            echo "success";        //请不要修改或删除
        } else {
            //验证失败
            echo "fail";

            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }
    }

    public function actionReturnpay()
    {
        $alipay_config = $this->payConfig();
        $alipayNotify  = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyReturn();
        if ($verify_result) {
            //验证成功
            //请在这里加上商户的业务逻辑程序代码

            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

            //商户订单号
            $out_trade_no = $_GET['out_trade_no'];

            //支付宝交易号
            $trade_no = $_GET['trade_no'];

            //交易状态
            $trade_status = $_GET['trade_status'];

            if ($_GET['trade_status'] == 'trade_finished' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
            } else {
                echo "trade_status=" . $_GET['trade_status'];
            }

            echo "验证成功<br />";

            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } else {
            //验证失败
            //如要调试，请看alipay_notify.php页面的verifyReturn函数
            echo "验证失败";
        }

    }

    public function payConfig()
    {
        /*******************************构造配置来自alipay.config******************************************/
        //↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        //合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm
        $alipay_config['partner'] = '2088121321528708';//商户ID

        //收款支付宝账号，以2088开头由16位纯数字组成的字符串，一般情况下收款账号就是签约账号
        $alipay_config['seller_id'] = $alipay_config['partner'];

        // MD5密钥，安全检验码，由数字和字母组成的32位字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm
        $alipay_config['key'] = '1cvr0ix35iyy7qbkgs3gwymeiqlgromm'; //商户KEY

        // 服务器异步通知页面路径 需http://格式的完整路径，不能加?id=123这类2088421713316394自定义参数，必须外网可以正常访问
        $alipay_config['notify_url'] = "http://www.kuqingshu.com/order/notifypay";

        // 页面跳转同步通知页面路径 需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
        $alipay_config['return_url'] = "http://www.kuqingshu.com/order/returnpay";

        $alipay_config['sign_type'] = strtoupper('MD5');//签名方式

        $alipay_config['input_charset'] = strtolower('utf-8');//字符编码格式 目前支持 gbk 或 utf-8

        //ca证书路径地址，用于curl中ssl校验
        //请保证cacert.pem文件在当前文件夹目录中
        $alipay_config['cacert'] = getcwd() . '\\cacert.pem';

        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        $alipay_config['transport'] = 'http';

        // 支付类型 ，无需修改
        $alipay_config['payment_type'] = "1";

        // 产品类型，无需修改
        $alipay_config['service'] = "create_direct_pay_by_user";
        //↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

        //↓↓↓↓↓↓↓↓↓↓ 请在这里配置防钓鱼信息，如果没开通防钓鱼功能，为空即可 ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        // 防钓鱼时间戳 若要使用请调用类文件submit中的query_timestamp函数
        $alipay_config['anti_phishing_key'] = "";

        // 客户端的IP地址 非局域网的外网IP地址，如：221.0.0.1
        $alipay_config['exter_invoke_ip'] = "";
        //↑↑↑↑↑↑↑↑↑↑请在这里配置防钓鱼信息，如果没开通防钓鱼功能，为空即可 ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
        return $alipay_config;

    }
}
