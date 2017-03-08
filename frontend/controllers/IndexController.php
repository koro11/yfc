<?php
namespace frontend\controllers;

use Yii;
use yii\web\Request; 
use DB;
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

use frontend\models\Merchant_info;
use frontend\models\Users;
use frontend\models\Message;
use frontend\models\Speak;
use frontend\custom_classes\Page;
use yii\web\Session;
use yii\web\Cookie;


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
    
    //商家首页
    public function actionShop_index()
    {
    	// 哪个商家
        $mer_id = 2; 
        
        //商家信息
        $merchant_info = new Merchant_info;
        $merchant = $merchant_info->find()
                        ->joinWith('merchant')
                        ->joinWith('mer_category')
                        ->where(['info_mer'=>$mer_id])
                        ->asArray()
                        ->one();
        //存入cookie,浏览历史
        $shop_desc = [
                     'info_mer'=>$merchant['info_mer'],
                     'info_mername'=>$merchant['merchant']['mer_name'],
                     'info_image'=>$merchant['info_image'],
                     'info_address'=>$merchant['merchant']['mer_address'],
                     ] ;
        // var_dump($shop_desc);die();
        $this->index_history($shop_desc);

        $cookies = Yii::$app->request->cookies;                      //注意此处是request
        $get_history = $cookies->get('shop_history', 'defaultName');//设置默认值
        $shop_history = unserialize($get_history);
        // var_dump($shop_history);die();
        // var_dump($merchant);die();
        // 商家菜谱
        $query = new \yii\db\Query; 
        $page = new Page;
        $foods_count = $query->from('yfc_food')->where(['food_mer'=>$mer_id])->count();
        $page->pageCount = $foods_count;
        $page->pageSize = 1;
        $pages = $page->getPage();
        // var_dump($pages);die;
        $foods = $query->select('food_id,food_name,food_image,food_price')->from('yfc_food')->where(['food_mer'=>$mer_id])->limit(1)->all();
         
        //商家留言
        $new_message = Message::get_new_message($mer_id);
         // var_dump($new_message);die();       
        //获取该商家的餐饮的评论，最新的三条
        $food_ids = Food::find()
                       ->select('food_id')
                       ->where(['food_mer'=>$mer_id])
                       ->asArray()
                       ->all();
        $ids = $this->deal_food_ids($food_ids,'food_id');   
        // var_dump($ids);die();
        $speak = new Speak;
        $comment = $speak->find()
                         ->joinWith('food')
                         ->joinWith('user_info')
                         ->select('yfc_speak.*,yfc_user_info.user_name,yfc_food.food_name,yfc_food.food_image')
                         ->where(['in','yfc_speak.food_id',$ids])
                         ->orderBy('yfc_speak.create_time DESC')          
                         // ->createCommand()->getRawSql();
                         ->asArray()
                         ->all();
        $comment_num = count($comment);
        $comment = array_slice($comment, 0,3);
        $comment = $this->deal_join_arr($comment,'food','user_info');       
        
        $collect_num = $query->from('yfc_collect')->where(['mer_id'=>$mer_id])->count();
        // var_dump($collect_num);die();
        $data = [
                 'shop_info'=>$merchant,
                 'shop_foods'=>$foods,
                 'shop_comment'=>$comment,
                 'shop_history'=>$shop_history,
                 'shop_comment_num'=>$comment_num,
                 'shop_collect_num'=>$collect_num,
                 'shop_message'=>$new_message,
                 'shop_foods_pages'=>$pages
                ];
        return $this->render('shop_index',$data);
          
    }

    //ajax获取分页数据
    public function actionGet_ajax(){
        
        $param = \Yii::$app->request->get();
        $p = $param['p'];
        $mer_id = $param['mid'];
        // var_dump($p);die();
        $page = new Page;    
        $query = new \yii\db\Query;
        $foods_count = $query->from('yfc_food')->where(['food_mer'=>$mer_id])->count();
        //获取数据总条数
        $page->pageCount = $foods_count;      
        $page->pageNow = $p;

        $limit = ($p-1)*$page->pageSize;//当前偏移量
        $foods = $query->select('food_id,food_name,food_image,food_price')->from('yfc_food')->where(['food_mer'=>$mer_id])->offset($limit)->limit(1)->all();
        // var_dump($foods);
        //获取数据集合
        $data['msg'] = $foods;
        $data['page'] = $page->getPage();

        echo json_encode($data);
    }
    
    //关于我们
	public function actionAboutus()
	{
		return $this->render('aboutus');
	}
    
    //检测是否登录
    public function actionCheck_login()
    {
        $session = \Yii::$app->session;
        $user_id = $session->get('user_id');
        // $user_id = 1;
        echo $user_id == '' ? 0 : $user_id;
    }

     //清除商家浏览记录
    public function actionClear_history()
    {
        $cookies = Yii::$app->response->cookies;
        $result = $cookies->remove('shop_history');
        // var_dump($result);     //为空
        echo $result ? 0 : 1;  //1删除成功
    }
    
    //检测用户名是否正确
    public function actionCheck_user_login()
    {
        $request = \Yii::$app->request;
        $data['user_phone'] = $request->get('username');
        $data['user_password'] = md5($request->get('userpass'));
        // var_dump($data);die();
        $result = Users::find()->select('user_id')->where($data)->asArray()->one();
        if ($result) {
            //存储session
            echo $result['user_id'];
        }
        else
        {
            //0表示密码错误
            echo 0;
        }
        
    }

    //检测用户名是否存在
    public function actionCheck_user_phone()
    {
        $user_phone = \Yii::$app->request->get('user_phone');
        // echo $user_phone;
        $result = Users::find()->where(['user_phone'=>$user_phone])->asArray()->one();
        echo $result ? 0 : 1;   //1表示不存在
    }

    //处理二维数组
    public function deal_food_ids($data,$prekey)
    {
        $arr = [];
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                  $arr[] = $value[$prekey];
                }
            }
        }
        return $arr;
    }

    public function deal_join_arr($data,$key1,$key2)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                unset($data[$key][$key1]);
                unset($data[$key][$key2]);
            }
        }
        return $data;
    }

    /**
     * 商品历史浏览记录
     * $data 商品记录信息
     */
    private function index_history($data)
    {
      $cookies = Yii::$app->request->cookies;      //取cookie
      $cookies_set = Yii::$app->response->cookies; //设置cookie
      if(!$data || !is_array($data))
      {
        return false;
      }

      //判断cookie类里面是否有浏览记录
      if($cookies->get('shop_history'))
      {
        $history = unserialize($cookies->get('shop_history'));
        array_unshift($history, $data); //在浏览记录顶部加入
        /* 去除重复记录 */
        $rows = array();
        foreach ($history as $v)
        {
          if(in_array($v, $rows))
          {
            continue;
          }
          $rows[] = $v;
        }
        /* 如果记录数量多余5则去除 */
        while (count($rows) > 3)
        {
          array_pop($rows); //弹出
        }
        
        $cookies_set->add(new \yii\web\Cookie([
                'name' => 'shop_history',
                'value' => serialize($rows),
                'expire'=>time()+3600
            ]));
        // setcookie('shop_history',serialize($rows),time()+3600*24*30,'/');
      }
      else
      {
        $history = serialize(array($data));
        $cookies_set->add(new \yii\web\Cookie([
                'name' => 'shop_history',
                'value' => $history,
                'expire'=>time()+3600
            ]));
        // setcookie('shop_history',$history,time()+3600*24*30,'/');
      }
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

    /**
     * 关于我们
     */
    public function actionAbout_us()
    {
        return $this->render('about_us');
	}


	/*添加用户经纬度*/
	public function actionAdd_coor()
	{
		$arr=Yii::$app->request->get();unset($arr['r']);
		$res=Yii::$app->db->createCommand("select * from yfc_user_coor where user_id=".$arr['user_id']."")->queryOne();
		if (empty($res)) 
		{
			$resa=Yii::$app->db->createCommand()->update("yfc_user_coor",$arr)->execute();
		}
		else
		{
			$resa=Yii::$app->db->createCommand()->update("yfc_user_coor",$arr,"user_id=:user_id",[":user_id"=>$arr['user_id']])->execute();
		}
		$resb=$resa ? 1  : 0;
		return $resb;
	}

	
}