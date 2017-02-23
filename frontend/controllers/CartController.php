<?php
namespace frontend\controllers;

use yii\web\Controller;
class CartController extends Controller
{
    //购物车
    public function actionCart()
    {
        echo 'asdasd';
        return $this->render('cart');
    }
    
}
