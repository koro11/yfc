<?php
namespace frontend\controllers;

use yii\web\Controller;
class OrderController extends Controller
{
    //提交订单 准备支付
    public function actionOrder()
    {
        $param = urldecode(\Yii::$app->request->get('buycart'));
        var_dump($param);die;
        return $this->render('order');
    }
 
 	//确认提交订单
 	public function actionSub_order()
    {
        return $this->render('sub_order');
    }
}
