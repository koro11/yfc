<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Users;
use yii\web\Session;
use \yii\db\Query;
use frontend\functions\Functions;
class LoginController extends Controller
{
	public $layout = false;
	public $enableCsrfValidation = false;
    /**
     * 选择登录
     */
    public function actionChoice()
    {
        return $this->render('choice');
    }
    /**
     *登陆
     */ 
    public function actionLogin()
    {
        return $this->render('login');
    }
    /**
     * 处理登录
     */
    public function actionLogin_do()
    {
//      $session = Yii::$app->session;
//        $session->remove('user_id');die;
    	$arr = Yii::$app->request->post();
    	$pwd = md5($arr['user_password']);
    	$query = new Query;
    	$data = $query->select('*')->from('yfc_users')->where(['user_phone'=>$arr['user_phone'],'user_password'=>$pwd])->one();
    	if($data)
    	{
            //购物信息入库

            if(isset($_COOKIE['cart'])){
                $class = new Functions();
                $cartMsg = unserialize($_COOKIE['cart']);
                $num = count($cartMsg);
                for($i=0; $i<$num; $i++){
                    $res[$i]['food']['user_id'] = $data['user_id'];
                    $res[$i]['food']['food_price'] = $cartMsg[$i]['food']['food_price'];
                    $res[$i]['food']['buy_number'] = $cartMsg[$i]['buy_number'];
                    $res[$i]['food']['food_market'] = $cartMsg[0]['food']['is_discount'] ? $cartMsg[0]['food']['discount_price'] : $cartMsg[0]['food']['food_price'];
                    $res[$i]['food']['food_id'] = $cartMsg[$i]['food']['food_id'];
                }
//                var_dump($res);die;
                $sql = $class->adds('yfc_carts',$res);

                $addCart = \Yii::$app->db->createCommand($sql)->execute();
                //清除cookie购物信息
                if(!$addCart)exit('购物信息入库失败,请重试');
                setcookie('cart','');
            }

    		$session = Yii::$app->session;
    		$session->set('user_id',$data['user_id']);
    		$time = $query->select('*')->from('yfc_users')->where(['user_id'=>$data['user_id']])->one();
    		if(!empty($time['now_logintime']))
    		{
    			$arr1['last_logintime'] = $time['now_logintime'];
    		} 
    		else
    		{
    			$arr1['last_logintime'] = time();
    		}
    		$arr1['now_logintime'] = time();
    		$db=\Yii::$app->db ->createCommand()->update('yfc_users',$arr1,'user_id = '.$data['user_id']) ->execute();
    		return $this->redirect('?r=index/index', 301);
    	}
    	else
    	{
    		return $this->redirect('?r=login/login', 301);
    	}
    }
    /**
     * 商家登录
     */
    public function actionMer_login()
    {
        return $this->render('merchant_login');
    }
    /**
     * 商家登录处理
     */
    public function actionMer_login_do()
    {
        $arr = Yii::$app->request->post();
        $pwd = md5($arr['mer_pass']);
        $query = new Query;
        $data = $query->select('*')->from('yfc_merchant')->where(['mer_phone'=>$arr['mer_phone'],'mer_pass'=>$pwd])->one();
        if($data)
        {
            $session = Yii::$app->session;
            $session->set('mer_id',$data['mer_id']);
            $time = $query->select('*')->from('yfc_merchant')->where(['mer_id'=>$data['mer_id']])->one();
            if(!empty($time['mer_now_login']))
            {
                $arr1['mer_last_login'] = $time['mer_now_login'];
            } 
            else
            {
                $arr1['mer_last_login'] = time();
            }
            $arr1['mer_now_login'] = time();
            $db=\Yii::$app->db ->createCommand()->update('yfc_merchant',$arr1,'mer_id = '.$data['mer_id'])->execute();
            //echo "ok";die;
            return $this->redirect('?r=index/index', 301);
        }
        else
        {
            return $this->redirect('?r=login/mer_login', 301);
        }
    }
    /**
     * 退出登录
     */
    public function actionOut()
    {
        $session = Yii::$app->session;
        unset($session['user_id']);
        unset($session['mer_id']);
        return $this->redirect('?r=login/choice', 301);
    }
    
}
