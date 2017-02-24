<?php
namespace frontend\controllers;

use frontend\models\District;
use frontend\models\MerCategory;
use frontend\models\MerchantInfo;
use frontend\models\Merchant;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;

class SearchController extends Controller
{
//    public $enableCsrfValidation = false;

    //搜索页面
    public function actionSearch()
    {
        $type = Yii::$app->request->get('search_type');
        if($type == 'shop'){
            $search = Yii::$app->request->get();

            $cate_id = isset($search['cate']) ? $search['cate'] : '';
            $dis_id = isset($search['dis']) ? $search['dis'] : '';
            $catipa = isset($search['catipa']) ? $search['catipa'] : '';
            $catipa = explode('-',$catipa);
            var_dump($catipa);

            $shop = Merchant::find()
                ->select(['info_mer_cate','info_catipa','mer_id','mer_name','mer_address'])
                ->where(['mer_status'=>'0'])
                ->andFilterWhere(['like','mer_name',$search['keyword']])
                ->andFilterWhere(['=','info_mer_cate',$cate_id])
                ->andFilterWhere(['=','dis_id',$dis_id]);

            $pages = new Pagination(['totalCount' =>$shop->count(),'pageSize'=>'2']);
            $shop = $shop->offset($pages->offset)->limit($pages->limit)->asArray()->all();

            foreach($shop as $k=>$v){
                $mer_info = $this->getMerInfo($v['mer_id']);
//                $shop[$k]['info_catipa'] = $mer_info['info_catipa'];
                $shop[$k]['info_image'] = $mer_info['info_image'];
                $cat_name = $this->getCateName($v['info_mer_cate']);
                $shop[$k]['cat_name'] = $cat_name['cat_name'];
            }
//            var_dump($shop);
            //分类
            $cate = MerCategory::find()->asArray()->all();
            //地区
            $dis = District::find()->asArray()->all();
//            var_dump($dis);
            return $this->render('shop',[
                'shop'=>$shop,
                'pages' =>$pages,
                'cate' =>$cate,
                'dis' =>$dis,
            ]);
        }elseif($type == 'food'){
            $search = Yii::$app->request->get();
            //
            return $this->render('food');
        }
    }


    public function getMerInfo($id)
    {
        return MerchantInfo::find()
            ->select(['info_image'])
//                    ->with('merCate')
            ->where(['info_mer'=>$id])
            ->asArray()
            ->one();
    }


    public function getCateName($id)
    {
        return MerCategory::find()
            ->select(['cat_name'])
            ->where(['cat_id'=>$id])
            ->asArray()
            ->one();
    }
    
}
