<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Session;
use yii\helpers\Url;

class CommonController extends Controller
{
    public function init()
    {
        $session = \Yii::$app->session;
        //取出存入的session值
        $user_id = $session->get('user_id');
        $mer_id  = $session->get('mer_id');
        //判断是否有登录session
        if (!isset($user_id) && !isset($mer_id)) {
            
            return $this->redirect(Url::to('/login/choice'), 301);
        }
    }
}