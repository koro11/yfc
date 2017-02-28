<?php
namespace frontend\controllers;

use yii\web\Request; 
use yii\data\Pagination;
use yii\web\Session;
use DB;
use Yii;
use  frontend\models\Food;
use  frontend\models\Collect;
use  frontend\models\Merchant;
use  frontend\models\User_info;
use  frontend\models\Orders;
use  frontend\models\User_ticket;
use  frontend\models\Tickets;
use yii\web\Controller;
use yii\web\UploadedFile;
class UserController extends Controller
{

    public $enableCsrfValidation= false;

    //用户中心首页
    public function actionUser_index()
    {
        //相当于获取用户id 
        $session=Yii::$app->session;
        $user_id=$session->get('user_id');   

        //实例化模型层并且查询用户信息（积分在用户信息表中）  
        $info= new User_info;
        $user= $info->find()->joinWith('users')->where(['yfc_user_info.user_id'=>$user_id])->asArray()->one();

        //查询优惠券信息
        $user['ticket']= count(Yii::$app->db->createCommand('select * from yfc_user_ticket where user_id='.$user_id.'')->queryAll());
        
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
        //相当于获取用户id 
        $session=Yii::$app->session;
        $user_id=$session->get('user_id'); 

        //查询优惠券信息，判断过期时间 
        $ticket= new User_ticket;
        $user= $ticket->find()->with('tickets')->where(['yfc_user_ticket.user_id'=>$user_id])->asArray()->All();
        return $this->render('user_coupon',['user'=>$user]);
    }



    /*删除优惠券*/
    public function actionDel_tic()
    {
        $cun_id=Yii::$app->request->get('cun_id');
        $res=Yii::$app->db->createCommand()->delete("yfc_user_ticket","cun_id=:cun_id",[':cun_id'=>$cun_id])->execute();
        $resa= $res ? 1 : 0;
        return $resa;
    }








    //用户收获地址
    public function actionUser_address()
    {
        $session=Yii::$app->session;
        $user_id=$session->get('user_id'); 
        $arr=Yii::$app->db->createCommand("select * from yfc_consignee where user_id=".$user_id."")->queryAll();
        return $this->render('user_address',['arr'=>$arr]);
    }



    //用户删除地址
    public function actionDel_address()
    {
        $cons_id=Yii::$app->request->get("cons_id");
        $res=Yii::$app->db->createCommand()->delete("yfc_consignee","cons_id=:cons_id",[':cons_id'=>$cons_id])->execute();
        $resa=$res ? 1 : 0 ;
        return $resa;
    }










    //用户账户管理
    public function actionUser_account()
    {
        $session=Yii::$app->session;
        $user_id=$session->get('user_id'); 
        
        /*两边联查查询用户信息*/
        $info= new User_info;
        $user= $info->find()->joinWith('users')->where(['yfc_user_info.user_id'=>$user_id])->asArray()->one();
        return $this->render('user_account',['user'=>$user]);
    }


    //修改用户数据
    public function actionUp_account()
    {
        $arr=Yii::$app->request->post();
        $users['user_password']=$arr['user_password'];unset($arr['user_password']);
        $users['user_phone']=$arr['user_phone'];unset($arr['user_phone']);
        $upload=new UploadedFile(); //实例化上传类
        $name=$upload->getInstanceByName('myfile'); //获取文件原名称
        $img=$_FILES['myfile']; //获取上传文件参数
        $upload->tempName=$img['tmp_name']; //设置上传的文件的临时名称
        $img_path='upload/user_img/'.$name; //设置上传文件的路径名称(这里的数据进行入库)
        $res=$upload->saveAs($img_path); //保存文件
        $arr['user_image']=$img_path;
        $resa=Yii::$app->db->createCommand()->update('yfc_users',$users,'user_id=:user_id',[':user_id'=>$arr['user_id']])->execute();
        $resb=Yii::$app->db->createCommand()->update('yfc_user_info',$arr,'user_id=:user_id',[':user_id'=>$arr['user_id']])->execute();
        if ($resb) 
        {
            echo "<script>alert('修改成功')</script>";
           return $this->redirect('?r=user/user_account',301); 
        }
        else
        {
           return $this->redirect('?r=user/user_account',301);
        }
    }






    //用户收藏
    public function actionUser_collect()
    {
        $session=Yii::$app->session;
        $user_id=$session->get('user_id'); 

        /*查询用户关注的所有商家*/
        $collect=new Collect;
        $arr= $collect->find()->with('merchant')->where(['yfc_collect.user_id'=>$user_id])->asArray()->All();
        return $this->render('user_collect',['arr'=>$arr]);
    }



    //删除收藏
    public function actionDel_collect()
    {
        $collect_id=Yii::$app->request->get('collect_id');
        $res=Yii::$app->db->createCommand()->delete("yfc_collect","collect_id=:collect_id",[":collect_id"=>$collect_id])->execute();
        $resa= $res ? 1  :  0;
        return $resa;
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


    //添加地址
    public function actionAddress_add()
    {
        $arr=Yii::$app->request->get();unset($arr['r']);
        $session=Yii::$app->session;
        $arr['user_id']=$session->get('user_id'); 
        $res=Yii::$app->db->createCommand()->insert('yfc_consignee',$arr)->execute();
        $resa= $res ? 1 : 0;
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
        $arr['create_time']=time();
        /*插入评论*/
        $res=Yii::$app->db->createCommand()->insert('yfc_speak',$arr)->execute();
        /*获取刚插入ID*/
        $order_speak=Yii::$app->db->getLastInsertId();
        /*菜品评论+1*/
        $res=Food::updateAllCounters(['food_comment_num' => 1],['food_id'=>$arr['food_id']]);
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
        $session=Yii::$app->session;
        $user_id=$session->get('user_id'); 
        $user=Yii::$app->db->createCommand("select * from yfc_user_info where user_id=".$user_id."")->queryOne();
        $name=$user['user_name'];
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
