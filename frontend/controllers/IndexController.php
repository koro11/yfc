<?php
namespace frontend\controllers;

use Yii;
//use yii\base\InvalidParamException;
//use yii\web\BadRequestHttpException;
use yii\web\Controller;
use app\models\Shuffing;
use app\models\Hot_word;
//use yii\filters\VerbFilter;
//use yii\filters\AccessControl;

/**
 * Site controller
 */
class IndexController extends Controller
{
    public $enableCsrfValidation = false;

	//首页
	public function actionIndex()
	{

        $request=Yii::$app->request;
        //轮播图
        $shuffing=Shuffing::find()->where(['is_show'=>0])->orderBy('sort DESC')->limit(3)->asArray()->all();

        $data['shuffing']=$shuffing;
		return $this->render('index',$data);
	}

	//热搜
    public function actionHot_word()
    {
        $request=\Yii::$app->request;
        $hotWords=Hot_word::find()->where(['show_status'=>0,'word_type'=>$request->post('type')])->orderBy('hot_length DESC')->limit(5)->asArray()->all();
        echo json_encode($hotWords);
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