<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
/**
 * Alogin controller
 */
class AloginController extends Controller
{
	public $layout = false;
    /**
     *后台登陆 
     */
    public function actionAlogin()
    {
    	$request=Yii::$app->request;
    	if($request->isPost){
    		$admin_name = $request->post('admin_name');
    		$admin_pwd = $request->post('admin_pwd');
    		//密码加密 crypt 利用不同散列加密
    		if (CRYPT_BLOWFISH == 1) {
    			$admin_pwd = crypt('$admin_pwd', '$y$f$c$');
    			$admin_pwd = md5($admin_pwd);
			}

			$db = new \yii\db\Query;
			$admin = $db->select('*')->from('yfc_admin')->where(['admin_name'=>$admin_name,'admin_pwd'=>$admin_pwd])->one();
			if($admin){
				//修改登陆时间，获取登陆ip,获取上次登陆时间
	    		$map = array(
					'login_time' => time(),
					'login_ip'=>$_SERVER["REMOTE_ADDR"],
					'last_time'=>$admin['login_time'],
				);
	    		$admin_id = $admin['admin_id'];
	    		Yii::$app->db->createCommand()->update('yfc_admin',$map,['admin_id'=>$admin_id])->execute();

	    		//设置session
    			Yii::$app->session['admin'] = $admin['admin_name'];
    			//$name = Yii::$app->session['admin'];
    			//var_dump($name);

				return $this->redirect('?r=aindex/aindex');
			}else{
				return $this->redirect('?r=alogin/alogin');
			}
    	}else{
    		return $this->render('admin_login');
    	}
    }

    /**
     *后台退出 销毁session 
     */
    public function actionEnd()
    {
    	unset(Yii::$app->session['admin']);
    	return $this->redirect('?r=alogin/alogin');
    }
}