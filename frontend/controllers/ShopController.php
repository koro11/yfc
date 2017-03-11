<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Merchant;
use frontend\models\Merchant_info;
use frontend\models\Food_category;
use frontend\models\Orders;
use frontend\models\Food;
use frontend\models\Message;
use frontend\controllers\CommonController;
use frontend\models\Tickets;
use yii\web\UploadedFile;
use yii\data\Pagination;
use frontend\custom_classes\Page;
use yii\web\Session;

/**
 * Yii2.0 ShopController
 * 商家管理控制器
 * @author Danny
 * @email  351518543@qq.com
 * @Time   2017-2-23
 */
class ShopController extends CommonController
{

    public $layout = '@app/views/layouts/center_nav.php';
    public $enableCsrfValidation = false;

    public function actionShop_intro()
    {
        // $mer_id['id'] = Yii::$app->session->get('mer_id');
        // echo $mer_id;die();
        return $this->render('shop_intro');
    }

    /**
     * @Shop_center
     * 商家中心首页
     * @access public
     */
    public function actionShop_center()
    {
        // 哪个商家
        $mer_id = Yii::$app->session->get('mer_id');
        // var_dump($mer_id);die();
        // $mer_id = 1;
        $arr = Merchant::find()->where(['mer_id' => $mer_id])->asArray()->one();
            # code...
            // var_dump($arr);die();
            if ($arr) {
                $arr['mer_last_login'] = date('Y-m-d H:i:s', $arr['mer_last_login']);
                //查询订单表里待未配送的，已配送的
                $unship        = Orders::find()->where(['merchant_id' => $mer_id, 'order_status' => 0, 'shipping_status' => 0])->asArray()->all();
                $shiped        = Orders::find()->where(['merchant_id' => $mer_id, 'order_status' => 0, 'shipping_status' => 2])->asArray()->all();
                $arr['unship'] = count($unship);
                $arr['shiped'] = count($shiped);
                // var_dump($arr);die;
                return $this->render('shop_center', ['merchant' => $arr]);
            }
        }
    }


    /**
     * @Shop_orders
     * 商家订单详情页
     * @access public
     */
    public function actionShop_orders()
    {
        // 哪个商家
        $mer_id = Yii::$app->session->get('mer_id');

        //查询商家订单
        $orders = Orders::find()
            ->where(['merchant_id' => $mer_id, 'order_status' => 0])
            ->orderBy('shipping_status');
        // var_dump($orders);die();
        $pages      = new Pagination([
            //'totalCount' => $countQuery->count(),
            'totalCount' => $orders->count(),
            'pageSize'   => 7   //每页显示条数
        ]);
        $order_data = $orders->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        // var_dump($order_data);die();
        return $this->render('shop_orders', ['orders' => $order_data, 'pages' => $pages]);
    }

    /**
     * @Shop_complete_info
     * 商家完善详情页
     * @access public
     */
    public function actionShop_complete_info()
    {
        // 哪个商家
        $mer_id = Yii::$app->session->get('mer_id');
        return $this->render('shop_complete_info', ['info_mer' => $mer_id]);
    }

    /**
     * @Shop_complete_act
     * 商家完善详情处理页
     * @access public
     */
    public function actionShop_complete_act()
    {
        $data = Yii::$app->request->post();

        $upload           = new UploadedFile();                      //实例化上传类
        $file             = $upload->getInstanceByName('info_image');  //获取文件原名称
        $name             = $file->name;
        $suffix           = substr($name, strrpos($name, '.'));
        $img              = $_FILES['info_image'];                    //获取上传文件参数
        $upload->tempName = $img['tmp_name'];              //设置上传的文件的临时名称
        $img_path         = 'upload/merchants/' . 'merchant' . $data['info_mer'] . '-' . time() . $suffix; //设置上传文件的路径名称(这里的数据进行入库)
        $arr              = $upload->saveAs($img_path);                 //保存文件

        $data['info_image']    = $img_path;
        $cate                  = Merchant::find()->select('info_mer_cate')->where(['mer_id' => $data['info_mer']])->asArray()->one();
        $data['info_mer_cate'] = $cate['info_mer_cate'];
        $result                = Merchant_info::updateAll($data, ['info_mer' => $data['info_mer']]);
        return $this->redirect(Url::to('/shop/shop_center'), 301);
    }

    //关于商家的信息
    public function actionShop_info()
    {
        return $this->render('shop_info');
    }

    /**
     * @Shop_addfood
     * 商家添加菜谱页
     * @access public
     */
    public function actionShop_addfood()
    {
        // 哪个商家
        $mer_id = Yii::$app->session->get('mer_id');
        //菜系分类
        $food_category = Food_category::find()->asArray()->all();

        //哪家商家在操作
        $merchant_info = Merchant::find()->where(['mer_id' => $mer_id])->asArray()->one();

        return $this->render('shop_addfood', ['food_category' => $food_category, 'merchant' => ['mer_id' => $mer_id, 'mer_name' => $merchant_info['mer_name']]]);
    }

    /**
     * @Shop_addfood_act
     * 商家完善详情处理页
     * @access public
     */
    public function actionShop_addfood_act()
    {
        $data = Yii::$app->request->post();

        $upload           = new UploadedFile();                     //实例化上传类
        $file             = $upload->getInstanceByName('food_image'); //获取文件原名称
        $name             = $file->name;
        $suffix           = substr($name, strrpos($name, '.'));
        $img              = $_FILES['food_image'];                   //获取上传文件参数
        $upload->tempName = $img['tmp_name'];             //设置上传的文件的临时名称
        $img_path         = 'upload/foods/' . 'food' . $data['food_mer'] . '-' . time() . $suffix; //设置上传文件的路径名称(这里的数据进行入库)
        $arr              = $upload->saveAs($img_path);                //保存文件

        $data['food_image'] = $img_path;
        // var_dump($data);die();

        $db     = \Yii::$app->db->createCommand();
        $result = $db->insert('yfc_food', $data)->execute();

        if ($result) {
            return $this->redirect(Url::to('/shop/shop_food_list'), 301);
        } else {
            return $this->redirect(Url::to('/shop/shop_food_list'), 301);
        }
    }

    /**
     * @Shop_foods
     * 商家详情页
     * @access public
     */
    public function actionShop_foods()
    {
        // 哪个商家
        $mer_id = Yii::$app->session->get('mer_id');
        // $mer_id = 1;
        //哪家商家在操作
        $foods = Food::find()
            ->joinWith('food_category')
            ->where(['food_mer' => $mer_id]);
        // var_dump($foods);die();

        $pages      = new Pagination([
            //'totalCount' => $countQuery->count(),
            'totalCount' => $foods->count(),
            'pageSize'   => 1   //每页显示条数
        ]);
        $foods_data = $foods->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        // var_dump($foods_data);die();
        return $this->render('shop_foods', ['foods' => $foods_data, 'pages' => $pages]);
    }

    /**
     * @Shop_messages
     * 商家留言回复
     * @access public
     */
    public function actionShop_messages()
    {
        // 哪个商家
        $mer_id = Yii::$app->session->get('mer_id');
        // $mer_id = 1;
        $page         = 1;
        $limit        = ($page - 1) * 3;
        $message_data = Message::get_new_message($mer_id, $limit);
        // 留言分页
        $query         = new \yii\db\Query;
        $page          = new Page;
        $message_count = $query->from('yfc_message')->where(['m_mer' => $mer_id, 'm_type' => 0])->count();
        // echo $message_count;die();
        $page->pageCount = $message_count;
        $page->pageSize  = 3;
        $pages           = $page->getPage();

        return $this->render('Shop_messages', ['shop_message' => $message_data, 'pages' => $pages]);
    }

    /**
     * @shop_message_back
     * 商家回复处理
     * @access public
     * @param  mixed integer boolean
     * @return mixed void
     */
    public function actionShop_message_back()
    {
        $data = Yii::$app->request->post();
        // var_dump($data);
        $data['m_message'] = htmlspecialchars($data['m_message']);
        $data['m_addtime'] = time();
        $data['m_type']    = 1;
        $db                = \Yii::$app->db->createCommand();
        $result            = $db->insert('yfc_message', $data)->execute();
        echo $result ? 1 : 0;
    }

    public function actionShop_page_back()
    {
        $p     = Yii::$app->request->get('p');
        $limit = ($p - 1) * 3;
        // $mer_id = Yii::$app->session->get('mer_id');
        $mer_id        = 1;
        $message_data  = Message::get_new_message($mer_id, $limit);
        $page          = new Page;
        $query         = new \yii\db\Query;
        $message_count = $query->from('yfc_message')->where(['m_mer' => $mer_id, 'm_type' => 0])->count();
        //获取数据总条数
        $page->pageCount = $message_count;
        $page->pageNow   = $p;
        $page->pageSize  = 3;

        // var_dump($foods);
        //获取数据集合
        $data['msg']  = $message_data;
        $data['page'] = $page->getPage();

        echo json_encode($data);
    }

    /**
     * @Shop_issue_tickets
     * 商家发行优惠券
     * @access public
     */
    public function actionShop_issue_tickets()
    {
        // 哪个商家
        $mer_id = Yii::$app->session->get('mer_id');
        //哪家商家在操作
        $merchant_info = Merchant::find()->where(['mer_id' => $mer_id])->asArray()->one();

        return $this->render('shop_issue_tickets', ['merchant' => ['mer_id' => $merchant_info['mer_id'], 'mer_name' => $merchant_info['mer_name']]]);
    }

    /**
     * @Shop_issue_act
     * 商家发行优惠券
     * @access public
     */
    public function actionShop_issue_act()
    {
        $data = Yii::$app->request->post();

        $data['tic_start'] = strtotime($data['tic_start']);
        $data['tic_end']   = strtotime($data['tic_end']);

        if ($data['tic_end'] > $data['tic_start'] && $data['tic_end'] > time()) {

            $db     = \Yii::$app->db->createCommand();
            $result = $db->insert('yfc_tickets', $data)->execute();

        }
        if ($result) {
            return $this->redirect(Url::to('/shop/shop_tickets'), 301);
        } else {
            return $this->redirect(Url::to('/shop/shop_issue_tickets'), 301);
        }
    }

    /**
     * @Shop_tickets
     * 商家优惠券页
     * @access public
     */
    public function actionShop_tickets()
    {
        // 哪个商家
        $mer_id = Yii::$app->session->get('mer_id');
        //改商家发行多少优惠券
        $tickets = Tickets::find()
            ->where(['tic_merchant' => $mer_id])
            ->asArray()
            ->all();
        // var_dump($tickets);die();
        return $this->render('shop_tickets', ['tickets' => $tickets]);
    }

}
