<?php
namespace frontend\controllers;

use frontend\models\Orders;
use libs\alipay\AlipayNotify;
use libs\alipay\AlipaySubmit;

use yii\web\Controller;
use frontend\models\Consignee;

class OrderController extends CommonController
{
    /**
     * 生成订单
     * @author Dx
     * @param
     * @return string
     */
    public $enableCsrfValidation = false;

    public function actionOrder()
    {
        $param = urldecode(\Yii::$app->request->get('buycart'));
        if (empty($param)) exit('缺少参数,不正确');
        $session = \Yii::$app->session;
        $uid     = $session->get('user_id');
        if (empty($uid)) \Yii::$app->view->renderFile('@app/views/login/login.php');
        $obj     = new Consignee();
        $address = $obj->getAddress($uid);
        var_dump($address);
        die;
        return $this->render('order');
    }

    //确认提交订单
    public function actionSub_order()
    {
        return $this->render('sub_order');
    }

    public function actionPay()
    {
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
