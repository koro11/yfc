<?php
namespace frontend\controllers;

use Yii;
//use yii\base\InvalidParamException;
//use yii\web\BadRequestHttpException;
use yii\web\Controller;
use frontend\models\Merchant_info;
use frontend\models\Food;
use frontend\models\Users;
use frontend\models\Message;
use frontend\models\Speak;
use frontend\custom_classes\Page;
//use yii\filters\VerbFilter;
//use yii\filters\AccessControl;
use yii\web\Session;
use yii\web\Cookie;

/**
 * Site controller
 */
class IndexController extends Controller
{	
	//首页
	public function actionIndex()
	{
		return $this->render('index');
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

}