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
        if($session->has('user_info')){
            $db = new Carts();
            $userInfo = $session->get('user_info');
            $field = array('yfc_carts.cart_id','yfc_carts.food_id','food_mername','yfc_food.food_price','user_id','buy_number','food_mer','food_image');
            //用户未下订单的购物信息
            $cartMsg = $db::find()->select($field)->joinWith('food')->where(['user_id'=>$userInfo['user_id']])->asArray()->all();
        }else{
            $cartMsg = $this->actionCookiecart('cart');
        }

        $res = array();
        $sumPrice = '';//商品总价格
        if(!empty($cartMsg)){
            foreach($cartMsg as $k=>$v){
                if($v['food']['is_discount']){
                    $v['food']['price'] = $v['food']['discount_price'];
                    $sumPrice = $sumPrice+($v['buy_number']*$v['food']['discount_price']);
                }else{
                    $v['food']['price'] = $v['food']['food_price'];
                    $sumPrice = $sumPrice+($v['buy_number']*$v['food']['food_price']);
                }

                $res[$v['food_mername']][$k] = $v;
            }
        }
        return $this->render('cart',['res'=>$res,'sumPrice'=>$sumPrice]);
    }

    /**
     * 清除cookie
     * @author Dx
     * @param  string $name
     * @return bool
     */
    public function actionRemovecookie($name)
    {
        if(empty($name))return false;
        $res = \Yii::$app->response->cookies->remove($name);
        if(!empty($res)){
            return false;
        }
        return true;
    }

    public function actionCookie()
    {
        $session = \Yii::$app->session;
        $session->set('user_info',array('user_id'=>1));
//        $cookie = \Yii::$app->response->cookies;
//
//        $a = array(array(
//            'user_id'=>2,
//            'food_id'=>4,
//            'food_market'=>5,
//            'food_price'=>66,
//            'buy_number'=>90,
//        ));
//        $b = $cookie->add(new \yii\web\Cookie([
//            'name' => 'cart',
//            'value' => serialize($a),
//        ]));
//        var_dump($b);
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
     *购物信息入库
     * @author Dx
     * @param array $cartMsg
     * @param string $userId
     * @return boolean
     */
    public function actionAddshopping($userId,$cartMsg)
    {
        if(empty($cartMsg)||empty($userId))return false;
        //cookie购物信息入库
        $class = new Functions();
        $sql = $class->adds('yfc_carts',$cartMsg);
        $addCart = \Yii::$app->db->createCommand($sql)->execute();
        //清除cookie购物信息
        if(!$addCart)exit('购物信息入库失败,请重试');
        $del = $this->actionRemovecookie('cart');
        if(!$del)exit('cookie清除异常');
        return true;
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
     * @return json
     */
    public  function actionSettlement()
    {
        $return  = array(
            'status'=>0,
            'msg'=>'',
        );
        $param= \Yii::$app->request->get('order');

        $count = count($param);
        $obj = new Merchant();
        $cartId = '';
        //查看所选餐饮的商家是否还在线
        for($i = 0;$i<$count;$i++){
            $sellerId = $param[$i]['sellerId'];
            if(empty($sellerId)){
                $return['msg'] = '参数格式不正确,请重试';
                exit(json_encode($return));
            }

            $res = $obj->checkOffline($sellerId);
            if(!$res){
                $return['msg'] = '商家已经下线,请重新选餐';
                exit(json_encode($return));
            }
            if(!$res['mer_status']){
                $return['msg'] = $res['mer_name'].'商户已经下线,请明日再来';
                exit(json_encode($return));
            }
            $cartId .= empty($cartId)? $param[$i]['cartId'] : ','.$param[$i]['cartId'];
        }
        $return['content'] = urlencode($cartId);
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
