<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
/**
 * Common controller
 */
class CommonController extends Controller
{
	public function init()
	{
		$admin = Yii::$app->session['admin'];
		if(!isset($admin)){
			return $this->redirect('?r=alogin/alogin');
		}
	}
}