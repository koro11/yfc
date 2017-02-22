<?php
namespace frontend\controllers;

use yii\web\Controller;
class UserController extends Controller
{
    //用户中心首页
    public function actionUser_index()
    {
        return $this->render('user_index');
    }
    
    //用户优惠券
    public function actionUser_coupon()
    {
        return $this->render('user_coupon');
    }

    //用户收获地址
    public function actionUser_address()
    {
        return $this->render('user_address');
    }

    //用户账户管理
    public function actionUser_account()
    {
        return $this->render('user_account');
    }

    //用户收藏
    public function actionUser_collect()
    {
        return $this->render('user_collect');
    }

    //我的留言
    public function actionUser_message()
    {
        return $this->render('user_message');
    }

	//订单信息
    public function actionUser_order()
    {
        return $this->render('user_order');
    }

    //订单列表
    public function actionUser_orderlist()
    {
        return $this->render('user_orderlist');
    }     
}
