<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Users;
use yii\web\Session;
use \yii\db\Query;
use yii\helpers\Url;
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
     * qq登录
     */
    public function actionQqlogin()
    {
        require($_SERVER['HTTP_HOST'].'/../qq/API/qqConnectAPI.php');

        $a = new \QC();
        var_dump($a);die;
    }
    /**
     * 处理登录
     */
    public function actionLogin_do()
    {
//      $session = Yii::$app->session;
//      $session->remove('user_id');die;
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
                $db = new Query();

                $num = count($cartMsg);
                for($i=0; $i<$num; $i++){
                    $food = $db->from('yfc_food')->where(['food_id'=>$cartMsg[$i]['food']['food_id']])->one();
                    $res[$i]['food']['user_id'] = $data['user_id'];
                    $res[$i]['food']['food_price'] = $food['food_price'];
                    $res[$i]['food']['buy_number'] = $cartMsg[$i]['buy_number'];
                    $res[$i]['food']['food_market'] = $food['is_discount'] ? $food['discount_price'] : $food['food_price'];
                    $res[$i]['food']['food_id'] = $cartMsg[$i]['food']['food_id'];
                }
                //var_dump($res);die;
                $sql = $class->adds('yfc_carts',$res);

                $addCart = \Yii::$app->db->createCommand($sql)->execute();
                //清除cookie购物信息
                if(!$addCart)exit('购物信息入库失败,请重试'); 
                unset($_COOKIE['cart']);
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
    		return 'ok';
    	}
    	else
    	{
    		return 'no';
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
            return 'ok';

        }
        else
        {
            return 'no';
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
        return $this->redirect(Url::to('/login/login'), 301);
    }
    
    public function actionRegister()
    {
        return $this->render('register');
    }
}
