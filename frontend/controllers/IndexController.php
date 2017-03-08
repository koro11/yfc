<?php
namespace frontend\controllers;

use Yii;
use yii\web\Request; 
use DB;
//use yii\base\InvalidParamException;
//use yii\web\BadRequestHttpException;
use yii\web\Controller;
//use yii\filters\VerbFilter;
//use yii\filters\AccessControl;

/**
 * Site controller
 */
class IndexController extends Controller
{	
	//首页
	public function actionIndex()
	{
		
		return $this->render('index');


	}

	//食物搜索
	public function actionS_food()
	{
		return $this->render('search_food');
	}

	//店铺搜索
	public function actionS_shop()
	{
		return $this->render('search_shop');
	}


	/*添加用户经纬度*/
	public function actionAdd_coor()
	{
		$arr=Yii::$app->request->get();unset($arr['r']);
		$res=Yii::$app->db->createCommand("select * from yfc_user_coor where user_id=".$arr['user_id']."")->queryOne();
		if (empty($res)) 
		{
			$resa=Yii::$app->db->createCommand()->update("yfc_user_coor",$arr)->execute();
		}
		else
		{
			$resa=Yii::$app->db->createCommand()->update("yfc_user_coor",$arr,"user_id=:user_id",[":user_id"=>$arr['user_id']])->execute();
		}
		$resb=$resa ? 1  : 0;
		return $resb;
	}

	
}