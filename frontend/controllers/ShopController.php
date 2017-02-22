<?php
namespace frontend\controllers;

use yii\web\Controller;
class ShopController extends Controller
{
    //商家简介
    public function actionShop_intro()
    {
        return $this->render('shop_intro');
    }
    
    //关于商家的信息
    public function actionShop_info()
    {
        return $this->render('shop_info');
    }

    //店铺详情页
    public function actionShop()
    {
        return $this->render('shop');
    }
}
