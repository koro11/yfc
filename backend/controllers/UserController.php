<?php
namespace backend\controllers;

use yii;
use yii\web\Controller;
use yii\db\Query;
/**
 * User controller
 */
class UserController extends  CommonController
{
	public $layout = false;
    public $enableCsrfValidation = false;
    /**
     *入驻店面管理
     */
    public function actionShop()
    {
        //查询商家的一些基本字段
        $db = new Query();
        $merchant = $db->select('mer_id,mer_name,mer_status,mer_address,mer_phone,mer_register_time')->from('yfc_merchant')->all();

        //根据商家ID 查询商家的一些扩展信息 加扩展字段塞到$merchant中
        foreach ($merchant as $key => $value) {
            $info_mer = $value['mer_id'];
            $mer_info = $db->select('info_specialty,info_desc')->from('yfc_merchant_info')->where(['info_mer'=>$info_mer])->one();
            $merchant[$key]['mer_register_time'] = date('Y-m-d',$merchant[$key]['mer_register_time']);
            $merchant[$key]['info_specialty'] = $mer_info['info_specialty'];
            $merchant[$key]['info_desc'] = $mer_info['info_desc'];    
        }

    	return $this->render('shop',['merchant'=>$merchant]);
    }

    /**
     *入驻店面运营状态管理
     */
    public function actionShop_status()
    {
        $request = Yii::$app->request;
        $mer_id = $request->post('mer_id');
        $is_show = $request->post('is_show');

        if($is_show == 0){
            //运营改为歇业
            $db = \Yii::$app->db->createCommand();
            $res = $db->update('yfc_merchant',['mer_status'=>1],['mer_id'=>$mer_id])->execute();
            if($res){
                //修改状态之后  查看新的状态
                $db = new \yii\db\Query;
                $mer_status = $db->select('*')->from('yfc_merchant')->where(['mer_id'=>$mer_id])->one();
            }
        }else{
            //歇业改为运营
            $db = \Yii::$app->db->createCommand();
            $res = $db->update('yfc_merchant',['mer_status'=>0],['mer_id'=>$mer_id])->execute();
            if($res){
                //修改状态之后  查看新的状态
                $db = new \yii\db\Query;
                $mer_status = $db->select('*')->from('yfc_merchant')->where(['mer_id'=>$mer_id])->one();
            }
        }
        echo json_encode($mer_status);
    }

    /**
     *删除停业店铺
     */
    public function actionShop_del()
    {
        $request = Yii::$app->request;
        $mer_id = $request->post('mer_id');
        $query = new Query();
        $mer_status = $query->select('mer_status')->from('yfc_merchant')->where(['mer_id'=>$mer_id])->one();
        if($mer_status['mer_status']  == 1){
            $db = \Yii::$app->db->createCommand();
            $db->delete('yfc_merchant',['mer_id'=>$mer_id])->execute();
            $db->delete('yfc_merchant_info',['info_mer'=>$mer_id])->execute();
            return "yes";
        }else{
            return "no";
        }
    }


    /**
     *个人用户管理
     */
    public function actionPerson()
    {
        //查询用户的一些基本信息
        $db = new Query();
        $user = $db->select('user_id,user_status,user_phone,register_time')->from('yfc_users')->all();

        //根据用户ID 查询用户的用户名 加用户名字段塞到$user中
        foreach ($user as $key => $value) {
            $user_id = $value['user_id'];
            $user_info = $db->select('user_name')->from('yfc_user_info')->where(['user_id'=>$user_id])->one();
            $user[$key]['register_time'] = date('Y-m-d',$user[$key]['register_time']);
            $user[$key]['user_name'] = $user_info['user_name'];   
        }

    	return $this->render('person',['user'=>$user]);
    }

    /**
     *注册用户状态管理
     */
    public function actionUser_status()
    {
        $request = Yii::$app->request;
        $user_id = $request->post('user_id');
        $is_show = $request->post('is_show');

        if($is_show == 0){
            //正常改为锁定
            $db = \Yii::$app->db->createCommand();
            $res = $db->update('yfc_users',['user_status'=>1],['user_id'=>$user_id])->execute();
            if($res){
                //修改状态之后  查看新的状态
                $db = new \yii\db\Query;
                $user_status = $db->select('*')->from('yfc_users')->where(['user_id'=>$user_id])->one();
            }
        }else{
            //锁定改为正常
            $db = \Yii::$app->db->createCommand();
            $res = $db->update('yfc_users',['user_status'=>0],['user_id'=>$user_id])->execute();
            if($res){
                //修改状态之后  查看新的状态
                $db = new \yii\db\Query;
                $user_status = $db->select('*')->from('yfc_users')->where(['user_id'=>$user_id])->one();
            }
        }
        echo json_encode($user_status);
    }

    /**
     *删除锁定用户
     */
    public function actionUser_del()
    {
        $request = Yii::$app->request;
        $user_id = $request->post('user_id');
        $query = new Query();
        $user_status = $query->select('user_status')->from('yfc_users')->where(['user_id'=>$user_id])->one();
        if($user_status['user_status']  == 1){
            $db = \Yii::$app->db->createCommand();
            $db->delete('yfc_users',['user_id'=>$user_id])->execute();
            $db->delete('yfc_user_info',['user_id'=>$user_id])->execute();
            return "yes";
        }else{
            return "no";
        }
    }
}