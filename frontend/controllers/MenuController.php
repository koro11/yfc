<?php
namespace frontend\controllers;

use yii\web\Controller;
class MenuController extends Controller
{
    //菜的分类简介
    public function actionCate()
    {
        return $this->render('cate');
    }
    
    //根据菜的分类 菜单列表
    public function actionList()
    {
        return $this->render('list');
    }

    //菜的详情页
    public function actionDetails()
    {
        return $this->render('details');
    }
}
