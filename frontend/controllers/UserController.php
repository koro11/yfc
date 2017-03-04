<?php
namespace frontend\controllers;

use yii\web\Request; 
use yii\data\Pagination;
use yii\web\Session;
use DB;
use Yii;
use  frontend\models\User_info;
use  frontend\models\Orders;
use yii\web\Controller;
class UserController extends CommonController
{

    public $enableCsrfValidation= false;

    //用户中心首页
    public function actionUser_index()
    {
        //相当于获取用户id 
        $user_id=1;     

        //实例化模型层并且查询用户信息（积分在用户信息表中）  
        $info= new User_info;
        $user= $info->find()->joinWith('users')->where(['yfc_user_info.user_id'=>$user_id])->asArray()->one();

        //查询优惠券信息
        $user['ticket']= count(Yii::$app->db->createCommand('select * from yfc_user_ticket where user_id='.$user_id.'')->queryAll());
        // $sql="select pay_status,shipping_status,order_speak,count(*) from yfc_orders  where user_id=".$user_id." and order_status=0 group by pay_status,shipping_status,order_speak";
        // $arr=Yii::$app->db->createCommand($sql)->queryAll();
        // var_dump($arr);die;
        //分类查询待付款，待收货，待发货，待评价
        $pay='select * from yfc_orders where user_id='.$user_id.' and order_status=0  and pay_status=0';
        $ship='select * from yfc_orders where user_id='.$user_id.' and order_status=0  and shipping_status=0 and pay_status=1';
        $shipping='select * from yfc_orders where user_id='.$user_id.' and order_status=0  and shipping_status!=2 and pay_status=1';
        $speak="select * from yfc_orders where user_id=".$user_id." and order_status=0 and order_speak=0 and shipping_status=2 and pay_status=1";
        $order['pay']= count(Yii::$app->db->createCommand($pay)->queryAll());
        $order['ship']=count(Yii::$app->db->createCommand($ship)->queryAll());
        $order['shipping']=count(Yii::$app->db->createCommand($shipping)->queryAll());
        $order['speak']=count(Yii::$app->db->createCommand($speak)->queryAll());

        //指向试图
        return $this->render('user_index',['user'=>$user,'order'=>$order]);
    }









    
    //用户优惠券
    public function actionUser_coupon()
    {
        return $this->render('user_coupon');
    }












    //用户收获地址
    public function actionUser_address()
    {
        $user_id=1;//session获取用户id
        $arr=Yii::$app->db->createCommand("select * from yfc_consignee where user_id=".$user_id."")->queryAll();
        return $this->render('user_address',['arr'=>$arr]);
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
        /*接收订单id*/
        $order_id=Yii::$app->request->get('order_id');

        /*实例化模型层，两表联查 查询订单表和详细订单表*/
        $orders=new Orders;
        $arr=$orders->find()->joinWith('date')->where(['yfc_orders.order_id'=>$order_id])->asArray()->one();

        $arr['food']=Yii::$app->db->createCommand('select * from yfc_food where food_id='.$arr['date']['food_id'].'')->queryOne();
        $arr['adress']=Yii::$app->db->createCommand('select * from yfc_consignee where cons_id='.$arr['address_id'].'')->queryOne();     
        
        return $this->render('user_order',['arr'=>$arr]);
    }


    //修改地址
    public function actionUpdate_cons()
    {
        $arr=Yii::$app->request->get();unset($arr['r']);
        $res=Yii::$app->db->createCommand()
        ->update('yfc_consignee',$arr,"cons_id=:cons_id",[':cons_id'=>$arr['cons_id']])
        ->execute();
        $resa= $res ? 1 :0;
        return $resa;
    }




    /*订单评价页面*/
    public function actionOrder_speak()
    {
        /*接收订单id*/
        $order_id=Yii::$app->request->get('order_id');

        /*实例化模型层，两表联查 查询订单表和详细订单表*/
        $orders=new Orders;
        $arr=$orders->find()->joinWith('date')->where(['yfc_orders.order_id'=>$order_id])->asArray()->one();
        $arr['food']=Yii::$app->db->createCommand('select * from yfc_food where food_id='.$arr['date']['food_id'].'')->queryOne();
        $arr['order_id']=$order_id;

        return $this->render('order_speak',['arr'=>$arr]);
    }


    /*订单评价入库*/
    public function actionSpeak_save()
    {
        $arr=Yii::$app->request->post();
        $order_id=$arr['order_id'];unset($arr['order_id']);
        /*插入评论*/
        $res=Yii::$app->db->createCommand()->insert('yfc_speak',$arr)->execute();
        /*获取刚插入ID*/
        $order_speak=Yii::$app->db->getLastInsertId();
        /*修改订单状态*/
        $update=Yii::$app->db->createCommand()
        ->update('yfc_orders',['order_speak'=>$order_speak],"order_id=:order_id",[':order_id'=>$order_id])
        ->execute();
        if ($update) 
        {
           return $this->redirect('?r=user/user_orderlist',301); 
        }
        else
        {
           return $this->redirect('?r=user/user_orderlist&order_id='.$order_id.'',301);
        }
        
    }



    //订单列表
    public function actionUser_orderlist()
    {
        $name="李硕";//session读取用户名
        $user_id=1;//读取用户id
        $res=Yii::$app->request->get();
        /*var_dump($arr);die;*/
        $test=new Orders();   //实例化model模型
        $arr=$test->find();
        $pages = new Pagination([
            'totalCount' => $arr->where(['order_status'=>0,'user_id'=>$user_id])->count(),
            'pageSize'   => 10  //每页显示条数
        ]);
        if (count($res)<=3) 
        {
            $models = $arr->where(['order_status'=>0,'user_id'=>$user_id])->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        }
        else
        {
             $models = $arr->where(['order_status'=>0,'user_id'=>$user_id,$res['key']=>$res['value'],$res['k']=>$res['v']])    
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        }
        return $this->render('user_orderlist', [
            'models' => $models,
            'pages'  => $pages,
            'name'   => $name
        ]);
    }     
    






/*删除订单*/
public function actionDel_order()
{
    $order_id=Yii::$app->request->get('order_id');
    $res=Yii::$app->db->createCommand()->delete("yfc_orders","order_id=:order_id",[':order_id'=>$order_id])->execute();
    if ($res) 
    {
        return $this->redirect('?r=user/user_orderlist',301);
    }
}















}
