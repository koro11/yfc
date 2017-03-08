<?php
namespace frontend\controllers;

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
    public function actionOrder()
    {
        $param = urldecode(\Yii::$app->request->get('buycart'));
        // if(empty($param))exit('缺少参数,不正确');
        $session = \Yii::$app->session;
        $uid = $session->get('user_id');
        if(empty($uid))\Yii::$app->view->renderFile('@app/views/login/login.php');
        $obj = new Consignee();
        $address = $obj->getAddress($uid);
        var_dump($address);die;
        return $this->render('order');
    }
 
 	//确认提交订单
 	public function actionSub_order()
    {
        return $this->render('sub_order');
    }
}
