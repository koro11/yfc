<?php
namespace frontend\controllers;
use yii\web\Controller;
use frontend\models\Consignee;
use yii\web\Session;
use yii\db\Query;
class OrderController extends CommonController
{
   // public $layout = false;
    public $enableCsrfValidation = false;
    /**
     * 生成订单
     * @author Dx
     * @param
     * @return string
     */
    public function actionOrder()
    {
       /* $param = urldecode(\Yii::$app->request->get('buycart'));
        if(empty($param))exit('缺少参数,不正确');
        $session = \Yii::$app->session;
        $uid = $session->get('user_id');
        if(empty($uid))\Yii::$app->view->renderFile('@app/views/login/login.php');
        $obj = new Consignee();
        $address = $obj->getAddress($uid);
        var_dump($address);die;*/
        $session = \Yii::$app->session;
        $uid = $session->get('user_id');
        $query = new Query;
        $area = $query->select('*')->from('yfc_district')->all();
        $address = $query->select('*')->from('yfc_consignee')->where(['user_id'=>$uid])->all();
        return $this->render('order',['address'=>$address,'area'=>$area]);
    }
 
 	//确认提交订单
 	public function actionSub_order()
    {
        return $this->render('sub_order');
    }    
    //添加收货人地址
    public function actionAdd_address()
    {
        $session = \Yii::$app->session;
        $uid = $session->get('user_id');
        $address = \Yii::$app->request->post();
        $address['user_id'] = $uid;
        $res = \Yii::$app->db->createCommand()->insert('yfc_consignee',$address)->execute();
        if($res)
        {
            return $this->redirect('?r=order/order', 301);
        }
        else
        {
            echo "no";
        }
    }
}
