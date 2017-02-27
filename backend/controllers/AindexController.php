<?php
namespace backend\controllers;

use yii;
use yii\web\Controller;

/**
 * Aindex controller
 */
class AindexController extends  CommonController
{
	public $layout = false;

    /**
     *后台首页
     */
    public function actionAindex()
    {
        $admin = Yii::$app->session['admin'];
    	return $this->render('admin_index',['admin'=>$admin]);
    }

	/**
     *后台首页主题
     */
    public function actionAmain()
    {
    	return $this->render('admin_main');
    }    
}