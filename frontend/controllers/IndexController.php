<?php
namespace frontend\controllers;

use Yii;
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

}