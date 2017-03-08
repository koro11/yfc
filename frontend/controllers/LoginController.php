<?php
namespace frontend\controllers;

use yii\web\Controller;
class LoginController extends Controller
{
	public $layout = false;
    //登陆
    public function actionLogin()
    {
        return $this->render('login');
    }
    
    public function actionRegister()
    {
        return $this->render('register');
    }
}
