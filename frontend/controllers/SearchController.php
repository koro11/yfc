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

class SearchController extends Controller
{
//    public $enableCsrfValidation = false;

    //搜索
    public function actionSearch()
    {
        $type = Yii::$app->request->get('search_type');
        if ($type == 'shop') {
            //搜索店铺
            $search = Yii::$app->request->get();

            $cate_id = isset($search['cate']) ? $search['cate'] : '';
            $dis_id  = isset($search['dis']) ? $search['dis'] : '';
            $catipa  = isset($search['catipa']) ? $search['catipa'] : '-';
            $catipa  = explode('-', $catipa);
            $min     = isset($catipa[0]) ? $catipa[0] : '';
            $max     = isset($catipa[1]) ? $catipa[1] : '';
            $order   = isset($search['order']) ? str_replace('-',' ',$search['order']) : '';
//            var_dump($catipa);

            $shop = Merchant::find()
                ->select(['info_mer_cate', 'info_catipa', 'mer_id', 'mer_name', 'mer_address'])
                ->where(['mer_status' => '0'])
                ->andFilterWhere(['like', 'mer_name', $search['keyword']])
                ->andFilterWhere(['=', 'info_mer_cate', $cate_id])
                ->andFilterWhere(['=', 'dis_id', $dis_id])
                ->andFilterWhere(['between', 'info_catipa', $min, $max]);

            $pages = new Pagination(['totalCount' => $shop->count(), 'pageSize' => '2']);
//            var_dump($shop);die;
            $shop  = $shop->offset($pages->offset)->limit($pages->limit)->orderBy($order)->asArray()->all();
//var_dump($shop);die;
            foreach ($shop as $k => $v) {
                $mer_info = $this->getMerInfo($v['mer_id']);
//                $shop[$k]['info_catipa'] = $mer_info['info_catipa'];
                $shop[$k]['info_image'] = $mer_info['info_image'];
                $cat_name               = $this->getCateName($v['info_mer_cate']);
                $shop[$k]['cat_name']   = $cat_name['cat_name'];
            }
//            var_dump($shop);
            //分类
            $cate = MerCategory::find()->asArray()->all();
            //地区
            $dis = District::find()->asArray()->all();
//            var_dump($dis);
            return $this->render('shop', [
                'shop'  => $shop,
                'pages' => $pages,
                'cate'  => $cate,
                'dis'   => $dis,
            ]);
        } elseif ($type == 'food') {
            //搜索食物
            $search = Yii::$app->request->get();

            $order   = isset($search['order']) ? str_replace('-',' ',$search['order']) : '';

            $food = Food::find()
                ->select(['food_id','food_mer','food_name','food_price','food_mername','food_image'])
                ->where(['is_delete' => '0'])
                ->andFilterWhere(['like', 'food_name', $search['keyword']]);

            $pages = new Pagination(['totalCount' => $food->count(), 'pageSize' => '8']);
            $food  = $food->offset($pages->offset)->limit($pages->limit)->orderBy($order)->asArray()->all();
//var_dump($food);die;
            foreach ($food as $k => $v) {
                $mer = Merchant::find()->select(['mer_address','mer_status'])->where(['mer_id'=>$v['food_mer']])->asArray()->one();
                if($mer['mer_status'] == 0){
                    $food[$k]['mer_address'] = $mer['mer_address'];
                }else{
                    unset($food[$k]);
                }
            }
//            var_dump($food);
            return $this->render('food',[
                'food' => $food,
                'pages' => $pages,
            ]);
        }
    }



    /**
     * 获取商家图片
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getMerInfo($id)
    {
        return MerchantInfo::find()
            ->select(['info_image'])
//                    ->with('merCate')
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

}
