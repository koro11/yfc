<?php
namespace backend\controllers;

use yii;
use yii\web\Controller;
use common\models\Upload;
use yii\data\Pagination;
use backend\models\Shuffing;
/**
 * Shuffing controller
 */
class ShuffingController extends CommonController
{
	public $layout = false;
    public $enableCsrfValidation = false;
    /**
     *轮播图添加 
     */
    public function actionShuffing_add()
    {
        if (Yii::$app->request->isPost) {
            $upload = new Upload();
            $img = $upload->files($_FILES['file']);
            $db = \Yii::$app->db->createCommand();
            $db->insert('yfc_shuffing',['path'=>$img])->execute();
            return $this->redirect('?r=shuffing/shuffing_list');
        }else{
            return $this->render('Shuffing_add');
        }
    }

    /**
     *轮播图列表展示
     */
    public function actionShuffing_list()
    {
        $shuffing = new Shuffing();   //实例化model模型
        $arr = $shuffing->find();
        $pages = new Pagination([
            'totalCount' => $arr->count(),
            'pageSize'   => 2   //每页显示条数
        ]);
        $shuffing_img = $arr->orderBy('sort asc')->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('Shuffing_list', [
            'shuffing_img' => $shuffing_img,
            'pages'  => $pages
        ]);
    }

    /**
     *轮播图删除
     */
    public function actionDel_shuffing()
    {
        $request = Yii::$app->request;
        $pic_id = $request->post('pic_id');
        $db = \Yii::$app->db->createCommand();
        $result = $db->delete('yfc_shuffing',['pic_id'=>$pic_id])->execute();
        if ($result) {
            return "ok";
        }else{
            return "no";
        }
    }

    /**
     *轮播图显示状态修改
     */
    public function actionShuffing_status()
    {
        $request = Yii::$app->request;
        $pic_id = $request->post('pic_id');
        $is_show = $request->post('is_show');

        if($is_show == 0){
            //显示改为隐藏
            $db = \Yii::$app->db->createCommand();
            $res = $db->update('yfc_shuffing',['is_show'=>1],['pic_id'=>$pic_id])->execute();
            if($res){
                //修改状态之后  查看新的状态
                $db = new \yii\db\Query;
                $shuffing_status = $db->select('*')->from('yfc_shuffing')->where(['pic_id'=>$pic_id])->one();
            }
        }else{
            //隐藏改为显示
            $db = \Yii::$app->db->createCommand();
            $res = $db->update('yfc_shuffing',['is_show'=>0],['pic_id'=>$pic_id])->execute();
            if($res){
                //修改状态之后  查看新的状态
                $db = new \yii\db\Query;
                $shuffing_status = $db->select('*')->from('yfc_shuffing')->where(['pic_id'=>$pic_id])->one();
            }
        }
        echo json_encode($shuffing_status);
    }

    /**
     *轮播图排序修改
     */
    public function actionShuffing_sort()
    {
        $request = Yii::$app->request;
        $sort = $request->post('sort');
        $pic_id = $request->post('pic_id');

        //根据ID修改轮播图排列顺序
        $db = \Yii::$app->db->createCommand();
        $db->update('yfc_shuffing',['sort'=>$sort],['pic_id'=>$pic_id])->execute();

        //修改之后查看 返回新的sort
        $db = new \yii\db\Query;
        $shuffing_sort = $db->select('sort')->from('yfc_shuffing')->where(['pic_id'=>$pic_id])->one();
        echo json_encode($shuffing_sort);
    }
}