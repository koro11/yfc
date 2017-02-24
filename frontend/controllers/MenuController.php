<?php
namespace frontend\controllers;

use yii\web\Controller;
class MenuController extends Controller
{
    //菜的详情页
    public function actionDetails()
    {
        return $this->render('details');
    }
}
