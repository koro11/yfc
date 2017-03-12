<?php
namespace frontend\controllers;

use frontend\models\District;
use frontend\models\Food;
use frontend\models\MerCategory;
use frontend\models\MerchantInfo;
use frontend\models\Merchant;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Session;

class SearchController extends Controller
{
    //public $enableCsrfValidation = false;

    //搜索
    public function actionSearch()
    {
        $cache = Yii::$app->cache;
        $type  = Yii::$app->request->get('search_type');
        if (empty($type) || $type != 'food') {
            //搜索店铺
            $search = Yii::$app->request->get();

            unset($search['r']);

            $key = 'search' . json_encode($search);

            //判断缓存，查询
            $data = $cache->get($key);
            if ($data === false) {
                $data = $this->searchShop($search, $cache, $key);
            }

            //分类
            $cate = $cache->get('search_cate');
            if ($cate === false) {
                $cate = MerCategory::find()->asArray()->all();
                $cache->set('search_cate', $cate);
            }

            //地区
            $dis = $cache->get('search_dis');
            if ($dis === false) {
                $dis = District::find()->asArray()->all();
                $cache->set('search_dis', $dis);
            }

            // var_dump($data['shop']);die;
            return $this->render('shop', [
                'shop'  => $data['shop'],
                'pages' => $data['pages'],
                'cate'  => $cate,
                'dis'   => $dis,
            ]);
        } elseif ($type == 'food') {
            //搜索食物
            $search = Yii::$app->request->get();
            unset($search['r']);

            $key = 'search' . json_encode($search);

            $data = $cache->get($key);
            if ($data === false) {
                $data = $this->searchFood($search, $cache, $key);
            }

            if (isset($search['score']) && $search['score'] == 'score') {
                return $this->render('score', [
                    'food'  => $data['food'],
                    'pages' => $data['pages'],
                ]);
            } else {
                return $this->render('food', [
                    'food'  => $data['food'],
                    'pages' => $data['pages'],
                ]);
            }
        }
    }

    /**
     * 搜索餐厅
     * @param $search
     * @param $cache
     * @return mixed
     */
    public function searchShop($search, $cache, $key)
    {

        $keyword = isset($search['keyword']) ? $search['keyword'] : '';
        $cate_id = isset($search['cate']) ? $search['cate'] : '';
        $dis_id  = isset($search['dis']) ? $search['dis'] : '';
        $catipa  = isset($search['catipa']) ? $search['catipa'] : '-';
        $catipa  = explode('-', $catipa);
        $min     = isset($catipa[0]) ? $catipa[0] : '';
        $max     = isset($catipa[1]) ? $catipa[1] : '';
        $order   = isset($search['order']) ? str_replace('-', ' ', $search['order']) : '';

        if (isset($search['order']) && ($search['order'] == 'address-asc' || $search['order'] == 'address-desc')) {
            $ha            = substr($search['order'], 8);
            $session       = Yii::$app->session;
            $user_id       = $session->get('user_id');
            $arr           = Yii::$app->db->createCommand("select * from yfc_user_coor where user_id=" . $user_id . "")->queryOne();
            $shop          = Yii::$app->db->createCommand("select count(*) from yfc_merchant")->queryAll();
            $num           = $shop[0]["count(*)"];
            $data['pages'] = new Pagination(['totalCount' => $num, 'pageSize' => '2']);
            $shop          = Yii::$app->db->createCommand("select   * from(select info_mer_cate,mer_id,mer_name,mer_address,mer_lng,mer_lat,ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN((" . $arr['user_lat'] . " * PI() / 180 - mer_lat * PI() / 180) / 2),2)+ COS(" . $arr['user_lat'] . " * PI() / 180) * COS(mer_lat * PI() / 180) * POW(SIN((" . $arr['user_lng'] . " * PI() / 180-   mer_lng * PI() / 180) / 2),2)))* 1000) as juli from yfc_merchant)yfc_merchant   ORDER BY juli " . $ha . " limit " . $data['pages']->offset . ',' . $data['pages']->limit)->queryAll();
        } else {
            $shop = Merchant::find()
                ->select(['info_mer_cate', 'info_catipa', 'mer_id', 'mer_name', 'mer_address'])
                ->where(['mer_status' => '0'])
                ->andFilterWhere(['like', 'mer_name', $keyword])
                ->andFilterWhere(['=', 'info_mer_cate', $cate_id])
                ->andFilterWhere(['=', 'dis_id', $dis_id])
                ->andFilterWhere(['between', 'info_catipa', $min, $max]);
            $data['pages'] = new Pagination(['totalCount' => $shop->count(), 'pageSize' => '2']);
            $shop          = $shop->offset($data['pages']->offset)->limit($data['pages']->limit)->orderBy($order)->asArray()->all();
        }

        foreach ($shop as $k => $v) {
            $mer_info = $this->getMerInfo($v['mer_id']);
            //$shop[$k]['info_catipa'] = $mer_info['info_catipa'];
            $shop[$k]['info_image'] = $mer_info['info_image'];
            $cat_name               = $this->getCateName($v['info_mer_cate']);
            $shop[$k]['cat_name']   = $cat_name['cat_name'];
        }
        $data['shop'] = $shop;
        $cache->set($key, $data, 60);
        return $data;
    }

    /**
     * 搜索食物
     * @param $search
     * @param $cache
     * @return mixed
     */
    public function searchFood($search, $cache, $key)
    {
        $keyword = isset($search['keyword']) ? $search['keyword'] : '';
        $score   = isset($search['score']) ? 1 : '';
        $order   = isset($search['order']) ? str_replace('-', ' ', $search['order']) : '';

        $food = Food::find()
            ->select(['food_id', 'food_mer', 'food_name', 'food_price', 'food_mername', 'food_image', 'food_score'])
            ->where(['is_delete' => '0'])
            ->andFilterWhere(['like', 'food_name', $keyword])
            ->andFilterWhere(['=', 'is_score', $score]);

        $data['pages'] = new Pagination(['totalCount' => $food->count(), 'pageSize' => '12']);
        $food          = $food->offset($data['pages']->offset)->limit($data['pages']->limit)->orderBy($order)->asArray()->all();

        foreach ($food as $k => $v) {
            $mer = Merchant::find()->select(['mer_address', 'mer_status'])->where(['mer_id' => $v['food_mer']])->asArray()->one();
            if ($mer['mer_status'] == 0) {
                $food[$k]['mer_address'] = $mer['mer_address'];
            } else {
                unset($food[$k]);
            }
        }
        $data['food'] = $food;
        $cache->set($key, $data, 60);
        return $data;
    }

    /**
     * 获取商家图片
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getMerInfo($id)
    {
        return MerchantInfo::find()
            ->select(['info_image'])
            //->with('merCate')
            ->where(['info_mer' => $id])
            ->asArray()
            ->one();


    }


    /**
     * 获取分类名称
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getCateName($id)
    {
        return MerCategory::find()
            ->select(['cat_name'])
            ->where(['cat_id' => $id])
            ->asArray()
            ->one();
    }

    /**
     * 获取最热餐厅
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function hotShop()
    {
        $sum = Food::find()->select(['food_mer', 'sum(food_saled) saled'])->groupBy('food_mer')->asArray()->all();

        $ids = [];
        foreach ($sum as $v) {
            $ids[] = $v['food_mer'];
        }
        //var_dump($ids);die;

        $hot = Merchant::find()
            ->select(['mer_id', 'mer_name', 'info_catipa', 'mer_address'])
            ->where(['mer_status' => '0'])
            ->andWhere(['in', 'mer_id', $ids])
            ->limit(3)->asArray()->all();
        foreach ($hot as $k => $v) {
            $img                   = self::getMerInfo($v['mer_id']);
            $hot[$k]['info_image'] = $img['info_image'];
        }
        return $hot;
    }

    /**
     * 获取最热食物
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function hotFood()
    {
        return Food::find()
            ->select(['food_id', 'food_name', 'food_image', 'food_price', 'food_saled'])
            ->orderBy('food_saled desc')
            ->limit(5)
            ->asArray()
            ->all();
    }


    /**
     * 计算某个经纬度的周围某段距离的正方形的四个点
     *
     * @param
     *            radius 地球半径 平均6371km
     * @param
     *            lng float 经度
     * @param
     *            lat float 纬度
     * @param
     *            distance float 该点所在圆的半径，该圆与此正方形内切，默认值为1千米
     * @return array 正方形的四个点的经纬度坐标
     */
    public function returnSquarePoint($lng, $lat, $distance, $radius = 6371)
    {
        $dlng = 2 * asin(sin($distance / (2 * $radius)) / cos(deg2rad($lat)));
        $dlng = rad2deg($dlng);

        $dlat = $distance / $radius;
        $dlat = rad2deg($dlat);

        return array(
            'left-top'     => array(
                'lat' => $lat + $dlat,
                'lng' => $lng - $dlng
            ),
            'right-top'    => array(
                'lat' => $lat + $dlat,
                'lng' => $lng + $dlng
            ),
            'left-bottom'  => array(
                'lat' => $lat - $dlat,
                'lng' => $lng - $dlng
            ),
            'right-bottom' => array(
                'lat' => $lat - $dlat,
                'lng' => $lng + $dlng
            )
        );
    }


}
