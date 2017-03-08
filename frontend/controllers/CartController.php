<?php
namespace frontend\controllers;

use frontend\models\Merchant;
use yii\web\Controller;
use frontend\models\Carts;
use frontend\models\Food;
use frontend\functions\Functions;
use yii\db\query;
class CartController extends Controller
{
//    public $enableCsrfValidation = false;
    /**
     * 购物车展示
     * @author Dx
     * @param  array  $cartMsg 购物车信息
     * @param  intval $sumPrice 总价格
     * @param  arraya $res
     * @return
     */
    public function actionCart()
    {
        $session = \Yii::$app->session;

        //用户登录cookie中购物信息入库
        if($session->has('user_id')){
            $db = new Carts();
            $userInfo = $session->get('user_id');
            $field = array('yfc_carts.cart_id','yfc_carts.food_id','food_mername','yfc_food.food_price','user_id','buy_number','food_mer','food_image');
            //用户未下订单的购物信息
            $cartMsg = $db::find()->select($field)->joinWith('food')->where(['user_id'=>$userInfo])->asArray()->all();
        }else{
            $cartMsg = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
        }

        $res = array();
        if(!empty($cartMsg)){
            foreach($cartMsg as $k=>$v){
                if($v['food']['is_discount']){
                    $v['food']['price'] = $v['food']['discount_price'];
                }else{
                    $v['food']['price'] = $v['food']['food_price'];
                }

                $res[$v['food']['food_mername'].','.$v['food_mer']][$k] = $v;
            }
        }

        return $this->render('cart',['res'=>$res]);
    }

    /**
     * cookie购物信息
     * @author Dx
     * @param array $cartMsg
     * @param string $name
     * @return array || boolean
     */
    public function actionCookiecart($name)
    {
        $cookies = \Yii::$app->request->cookies;
        //cookie中是否存在购物列表
        if(!$cookies->has($name)){
            return false;
        }
        $cartMsg = empty($cookies->get($name)) ? array() : unserialize($cookies->get($name));
        return $cartMsg;
    }

    /**
     * 删除购物车
     * @author Dx
     * @param string $cartId
     * @return json
     */
    public function actionDelcart()
    {
        $return =array(
            'status'=>1,
            'msg'=>'成功删除此项餐饮'
        );
        $cartId = intval(\Yii::$app->request->get('cartId'));
//        var_dump($cartId);die;
        if(empty($cartId)){
            $return['status'] = 0;
            $return['msg'] ='删除失败,请重试' ;
            exit(json_encode($return));
        }
        $obj = new Carts();
        $res = $obj->delCart($cartId);
        if(!$res){
            $return['status'] = 0;
            $return['msg'] = '删除失败,请重试';
        }
        exit(json_encode($return));
    }
    /**
     * 购物车结算
     * @author Dx
     * @param intval   $sellerId
     * @param resource $obj
     * @param array   $param
     * @param array   $seller
     * @return json
     */
    public  function actionSettlement()
    {
        $return  = array(
            'status'=>0,
            'msg'=>'',
        );
        $session = \Yii::$app->session;
        if(!$session->has('user_id')){
            $return['msg'] = '请先登录';
            exit(json_encode($return));
        }
        //餐饮
        $param= \Yii::$app->request->get('order');
        //商户ID
        $seller= \Yii::$app->request->get('store');
        if(empty($param) || empty($seller)){
            $return['msg'] = '无法结算';
            exit($return);
        }
        //商户判断
        $count = count($seller);
        $obj = new Merchant();
        $store = '';
        //查看所选餐饮的商家是否还在线
        for($i = 0;$i<$count;$i++){
            //商户ID
            $store .= empty($store)? $sellerId = $seller[$i]['store'] : ','.$sellerId = $seller[$i]['store'];
            if(empty($sellerId)){
                $return['msg'] = '参数格式不正确,请重试';
                exit(json_encode($return));
            }

            $res = $obj->checkOffline($sellerId);
            if(!$res){
                $return['msg'] = '商户已经不存在';
                exit(json_encode($return));
            }
            if($res['mer_status']=='1'){
                $return['msg'] = $res['mer_name'].'商户未营业,请明日再来';
                exit(json_encode($return));
            }
        }
        //餐饮
        sort($param);
        $cartId = '';
        $cartCount = count($param);
        for($i=0;$i<$cartCount;$i++){
            $cartId .= empty($cartId)? $param[$i]['cartId'] : ','.$param[$i]['cartId'];
        }
        //URL
        $cartId = urlencode($cartId);
        $store = urlencode($store);

        $url = APP_URL.'order/order';

        $return['content'] = $url.'?buycart='.substr($cartId,0,4).'&id='.substr($cartId,4,4).'&param='.substr($cartId,8).'&mer='.$store;
        $return['msg'] ='可以进行下单';
        $return['status'] = 1;
        exit(json_encode($return));
    }
    /**
     * 修改购物数量
     * @author Dx
     * @param
     * @return
     */
    public function actionSavenum()
    {
        $return = array(
            'status'=>0,
            'msg'=>'数量修改失败',
        );
        $id= intval(\Yii::$app->request->get('id'));
        $num = intval(\yii::$app->request->get('num'));
        $obj = new Carts();
        $res = $obj->savenum($id,$num);
        if(!$res){
            exit(json_encode($res));
        }
        $return['status'] = 1;
        $return['msg'] = '数量修改成功';
        exit(json_encode($return));
    }


}
