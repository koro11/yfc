<?php
namespace frontend\controllers;


use frontend\models\Carts;
use frontend\models\Speak;
use yii\db\Query;
use yii\web\Controller;
use frontend\models\Food;
use frontend\functions\Page;
use yii\web\Cookie;

class MenuController extends Controller
{
    public function actionDetails()
    {
        $food_id       = intval(\Yii::$app->request->get('id'));
        $now           = intval(\Yii::$app->request->get('now'));
        $status        = \Yii::$app->request->get('status');
        $now           = $now ? $now : 1;//当前页
        $page          = new Page();
        $page->pageNow = $now;
        //评论model
        $comment = new Speak();
        //总条数
        $num = $comment->getCount($food_id);
        //分页码
        $commentPage = $this->actionGetpage($page, $num['food_comment_num']);
        if (!$status) {
            if (empty($food_id)) exit('缺少参数');
            $obj     = new Food();
            $details = $obj->getFooddetails($food_id);
            //            var_dump($details);die;
            if (empty($details)) exit('商品已下线,请重新选择');

            $content = $page->getComment($comment, $food_id, $now);
            $cookie  = \Yii::$app->response->cookies;
            $cookies = \Yii::$app->request->cookies;
            //浏览历史
            if ($cookies->has('history')) {
                $history = $cookies->get('history');

                $temp = explode(',', $history);
                //                var_dump($temp);die;
                if (count($temp) < 2) {
                    if (!in_array($food_id, $temp)) {
                        $history .= ',' . $food_id;
                        $cookie->add(new \yii\web\Cookie([
                            'name'  => 'history',
                            'value' => $history,
                        ]));
                    }
                } else {
                    if (!in_array($food_id, $temp)) {
                        $history = str_replace($temp[0] . ',', '', $history);
                        $history .= ',' . $food_id;
                        $cookie->add(new \yii\web\Cookie([
                            'name'  => 'history',
                            'value' => $history,
                        ]));

                    }
                }

            } else {
                $cookie->add(new \yii\web\Cookie([
                    'name'  => 'history',
                    'value' => $food_id,
                ]));
            }
            $list = array();

            if ($cookies->has('history')) {
                $list = $obj->getFoods($cookies->get('history'));
            }
            //            var_dump($list);die;
            return $this->render('details', ['details' => $details, 'page' => $commentPage['str'], 'content' => $content, 'count' => $commentPage['count'], 'list' => $list, 'num' => $num['food_comment_num']]);
        } else {
            $return = array(
                'status'  => 0,
                'msg'     => '失败',
                'content' => ''
            );
            if (empty($food_id)) {
                $retrun['msg'] = '缺少参数';
                exit(json_encode($return));
            }
            $db = new \Memcache();

            $db->connect('127.0.0.1', '11211');
            $res = $db->get($now . $food_id);
            if ($res) {
                $content = $res;
            } else {
                if (empty($now)) {
                    $retrun['msg'] = '缺少参数';
                    exit(json_encode($return));
                }
                $content['comment'] = $page->getComment($comment, $food_id, $now);

                $content['page'] = $commentPage['str'];

                $db->set($now . $food_id, $content, false, 60);
            }
            if (!$content) {
                exit(json_encode($return));
            }

            $return['status']  = 1;
            $return['msg']     = '成功';
            $return['content'] = $content;
            exit(json_encode($return));

        }
    }

    /**
     * 获取分页信息
     * @author Dx
     * @param intval $num
     * @return
     */
    public function actionGetpage($obj, $num)
    {
        $obj->pageCount = $num;
        $res['count']   = ceil($num / $obj->pageSize);
        $res['str']     = $obj->getPage($res['count']);
        return $res;
    }

    /**
     * 加入购物车
     * @author Dx
     * @param
     * @return
     */
    public function actionAddcart()
    {
        $return = array(
            'status' => 0,
            'msg'    => '无法加入购物车'
        );
        $id     = intval(\Yii::$app->request->get('id'));
        $num    = intval(\Yii::$app->request->get('num'));
        if (empty($id)) exit('无法加入购物车');
        $session = \Yii::$app->session;

        $db            = new Query();
        $res[]['food'] = $db->from('yfc_food')->where(['food_id' => $id])->one();

        $res[0]['buy_number'] = $num;

        if (!$session->has('user_id')) {

            if (isset($_COOKIE['cart'])) {
                $arr = unserialize($_COOKIE['cart']);

                foreach ($arr as $k => $v) {
                    if ($v['food']['food_id'] == $res[0]['food']['food_id']) {
                        $return['msg']    = '此商品已经存在购物车中';
                        $return['status'] = '-1';
                        exit(json_encode($return));
                    }
                }
                if (count($arr) == 2) {
                    unset($arr[0]);
                }

                $res = array_merge($arr, $res);
            }
            $data = setcookie('cart', serialize($res), time() + 86400, '/');

            if ($data) {
                $return['status'] = 1;
                $return['msg']    = '成功加入购物车';
            }

        } else {

            $obj  = new Carts();
            $db   = new  Query();
            $food = $db->from('yfc_carts')->where(['food_id' => $res[0]['food']['food_id'], 'user_id' => $session->get('user_id')])->one();

            if (!empty($food)) {
                $return['msg']    = '此商品已经存在购物车中';
                $return['status'] = '-1';
                exit(json_encode($return));
            }
            $param = array(
                'user_id'     => $session->get('user_id'),
                'buy_number'  => $res[0]['buy_number'],
                'food_id'     => $id,
                'food_market' => $res[0]['food']['is_discount'] ? $res[0]['food']['discount_price'] : $res[0]['food']['food_price'],
                'food_price'  => $res[0]['food']['food_price'],
            );

            $data = $obj->setCart($param);
            if ($data) {
                $return['status'] = 1;
                $return['msg']    = '购物车添加成功';
            }
        }

        exit(json_encode($return));
    }
}
