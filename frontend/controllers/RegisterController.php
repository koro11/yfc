<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use yii\web\Request;
use frontend\models\Users;
use yii\web\Session;  
use yii\db\Query;
use yii\web\UploadedFile;
use yii\helpers\Url;
class RegisterController extends Controller
{
	public $layout = false;
	public $enableCsrfValidation = false;
	/**
	 * 用户注册
	 */
	public function actionUser_register()
	{
		return $this->render('user_register');
	}
	/**
	 * 用户注册处理
	 */
	public function actionUser_register_do()
	{
		$arr = Yii::$app->request->post();
		$arr['user_password'] = md5($arr['user_password']);
		$arr['register_time'] = time();
		$res = \Yii::$app->db->createCommand()->insert('yfc_users',$arr)->execute();
		if($res)
		{
			$query = new Query;
    	    $data = $query->select('*')->from('yfc_users')->where(['user_phone'=>$arr['user_phone']])->one();
    	    $arr2['user_id'] = $data['user_id'];
    	    $arr2['user_name'] = 'yfc_'.rand(000000,999999);
    	    \Yii::$app->db->createCommand()->insert('yfc_user_info',$arr2)->execute();
			return $this->redirect(Url::to('/login/login'), 301);
		}
		else
		{
			return $this->redirect(Url::to('/regirect/user_register'), 301);
		}


	}
	/**
	 * 商家驻入
	 */
	public function actionMerchant_register()
	{
		$cate = \Yii::$app->db ->createCommand("select * from yfc_mer_category") ->queryAll(); 
		$district = \Yii::$app->db ->createCommand("select * from yfc_district") ->queryAll();
		return $this->render('merchant_register',['cate'=>$cate,'district'=>$district]);
	}
	/**
	 * 商家处理
	 */
	public function actionMerchant_register_do()
	{
		$post = Yii::$app->request->post();
		//var_dump($post);die;
		$upload=new UploadedFile;                      //实例化上传类       
        $file=$upload->getInstanceByName('mer_logo');  //获取文件原名称
        $name = $file->name;
        //var_dump($file);die;
        $suffix = substr($name, strrpos($name, '.'));      
        $img = $_FILES['mer_logo'];                    //获取上传文件参数
        $upload->tempName=$img['tmp_name'];              //设置上传的文件的临时名称
        $img_path='upload/mer_logo/'.'merchant'.'-'.time().$suffix; //设置上传文件的路径名称(这里的数据进行入库)        
        $arr=$upload->saveAs($img_path);                 //保存文件
        $post['mer_logo'] = $img_path;
        $post['mer_pass'] = md5($post['mer_pass']);
        $post['mer_register_time'] = time();
        $res = \Yii::$app->db->createCommand()->insert('yfc_merchant',$post)->execute();
        if($res)
        {
        	return $this->redirect(Url::to('/login/mer_login'), 301);
        }
        else
        {
        	return $this->redirect(Url::to('/regirect/user_register'), 301);
        }
	}
	/**
	 * 选择身份
	 */
	public function actionChoice()
	{
		return $this->render('choice');
	}
}