<?php
namespace frontend\controllers;

use yii\web\Controller;
class RegController extends Controller
{
	public $layout = false;
    //注册
    public function actionReg()
    {
        return $this->render('reg');
    }
    
}
