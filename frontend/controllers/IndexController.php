<?php
namespace frontend\controllers;

use Yii;
//use yii\base\InvalidParamException;
//use yii\web\BadRequestHttpException;
//use yii\filters\VerbFilter;
//use yii\filters\AccessControl;
use yii\web\Controller;
use frontend\models\Shuffing; 
use frontend\models\Hot_word;
use frontend\models\District;
use frontend\models\MerCategory;
use frontend\models\FoodCategory;
use frontend\models\Food;
use frontend\models\Merchant;
use yii\helpers\Url;


/**
 * Site controller
 */
class IndexController extends Controller
{
    public $enableCsrfValidation = false;

	//首页
	public function actionIndex()
	{
        //轮播图
        $shuffing = Shuffing::find()->where(['is_show'=>0])->orderBy('sort DESC')->limit(3)->asArray()->all();

        //订单
        $sql="SELECT consignee,food_name,shipping_status FROM yfc_orders as o JOIN yfc_food as f on o.food_id=f.food_id WHERE pay_status=1 AND order_status=0 ORDER BY order_paytime DESC";
        // LIMIT 0,3
        $orders = \Yii::$app->db->createCommand($sql)->queryAll();

        //地区
        $district = District::find()->limit(12)->asArray()->all();

        //获取菜品类型
        $foodcate = FoodCategory::find()->asArray()->all();

        //默认显示的菜品
        $food = Food::find()->select(['food_id','food_mername','food_name','food_image','food_price','is_discount','discount_price','is_new'])->where(['is_delete'=>0])->orderBy('food_saled DESC')->limit(3)->asArray()->all();

        //默认显示的店家logo
        $merlogo = Merchant::find()->select(['mer_logo','mer_name','mer_id'])->where(['mer_status'=>0])->limit(5)->asArray()->all();//->orderBy('评分 DESC')

        //获取商家主营类型
        $mercate = MerCategory::find()->asArray()->all();

        //默认显示的店家
        $merchant = Merchant::find()->select(['mer_id','mer_name','mer_address','mer_phone'])->with('merinfo')->where(['mer_status'=>0])->limit(3)->asArray()->all();

        //菜品点评
        $sql = "SELECT s.speak_body,s.food_id,f.food_image,food_name,u.user_name,m.mer_name from yfc_speak s join yfc_food f on s.food_id=f.food_id JOIN yfc_user_info u on s.speak_user=u.user_id JOIN yfc_merchant m on f.food_mer=m.mer_id";
        $speak = \Yii::$app->db->createCommand($sql)->queryAll();

        //SELECT mid,AVG(score) as c from yfc_mer_grade GROUP BY mid HAVING  c>10  评分
        $data['shuffing'] = $shuffing;
        $data['orders'] = $orders;
        $data['district'] = $district;
        $data['foodcate'] = $foodcate;
        $data['food'] = $food;
        $data['merlogo'] = $merlogo;
        $data['mercate'] = $mercate;
        $data['merchant'] = $merchant;
        $data['speak'] = $speak;
		return $this->render('index',$data);
	}

	//热搜
    public function actionHot_word()
    {
        $request = \Yii::$app->request;
        $hotWords = Hot_word::find()->where(['show_status'=>0,'word_type'=>$request->post('type')])->orderBy('hot_length DESC')->limit(5)->asArray()->all();
        echo json_encode($hotWords);
    }

	//食物搜索
	public function actionS_food()
	{
        $this->layout = false;
        $data = \Yii::$app->request->post();
        if ($data['cate_id']=='' && $data['d_id']=='') {
            $where = ['is_delete'=>0];
        }else if ($data['cate_id']=='') {
            $where = ['is_delete'=>0,'dis_id'=>$data['d_id']];
        }else if ($data['d_id']=='') {
            $where = ['is_delete'=>0,'food_cate'=>$data['cate_id']];
        }else{
            $where = ['is_delete'=>0,'dis_id'=>$data['d_id'],'food_cate'=>$data['cate_id']];
        }

        $food = Food::find()->select(['food_id','food_mername','food_name','food_image','food_price','is_discount','discount_price','is_new'])->where($where)->orderBy('food_saled DESC')->limit(3)->asArray()->all();
//        SELECT food_id,food_mername,food_name,food_image,food_price,is_discount,discount_price,is_new FROM yfc_food as f join yfc_merchant as m ON f.food_mer = m.mer_id join yfc_district as d on m.dis_id=d.d_id JOIN yfc_food_category as fc ON f.food_cate=fc.cate_id WHERE f.food_cate=1 and d.d_id=3

        return $this->render('get_foods',['food'=>$food]);
	}

	//店铺搜索
	public function actionS_shop()
	{
        $this->layout = false;
        $data = \Yii::$app->request->post();
        if ($data['cate_id']=='' && $data['d_id']=='') {
            $where = ['mer_status'=>0];
        }else if ($data['cate_id']=='') {
            $where = ['mer_status'=>0,'dis_id'=>$data['d_id']];
        }else if ($data['d_id']=='') {
            $where = ['mer_status'=>0,'info_mer_cate'=>$data['cate_id']];
        }else{
            $where = ['mer_status'=>0,'dis_id'=>$data['d_id'],'info_mer_cate'=>$data['cate_id']];
        }

        $merchant = Merchant::find()->select(['mer_id','mer_name','mer_address','mer_phone'])->joinwith('merinfo')->where($where)->limit(3)->asArray()->all();
		return $this->render('get_merchant',['merchant'=>$merchant]);
	}

    //获取餐馆类型或者菜品类型
    public function actionGet_cate()
    {
        $this->layout = false;
        $type=\Yii::$app->request->post();
        if ($type['type']==1) {
            //菜品分类
            $foodcate = FoodCategory::find()->asArray()->all();
            return $this->render('get_cate',['type'=>1,'foodcate'=>$foodcate]);
        }else{ 
            //餐馆分类
            $mercate = MerCategory::find()->asArray()->all();
            return $this->render('get_cate',['type'=>2,'mercate'=>$mercate]);
        }
	}

	//

}