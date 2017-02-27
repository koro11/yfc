<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
/**
 * Hotword controller
 */
class HotwordController extends CommonController
{
	public $layout = false;
	public $enableCsrfValidation = false;
    /**
     *热门店铺 
     */
    public function actionHotshop()
    {
    	$db = new \yii\db\Query;
		$hot_shop = $db->select('*')->from('yfc_hot_word')->orderBy('hot_length desc')->offset(0)->limit(7)->where(['word_type'=>0])->all();
    	return $this->render('hotshop',['hot_shop'=>$hot_shop]);
    }

    /**
     *热门店铺删除 
     */
    public function actionDel_hotshop()
    {
    	$request = Yii::$app->request;
    	$word_id = $request->post('word_id');
    	$db = \Yii::$app->db->createCommand();
        $result = $db->delete('yfc_hot_word',['word_id'=>$word_id])->execute();
        if ($result) {
            return "ok";
        }else{
            return "no";
        }
    }

    /**
     *热门店铺显示状态 
     */
    public function actionHotshop_status()
    {
    	$request = Yii::$app->request;
        $word_id = $request->post('word_id');
        $is_show = $request->post('is_show');

        if($is_show == 0){
            //显示改为隐藏
            $db = \Yii::$app->db->createCommand();
            $res = $db->update('yfc_hot_word',['show_status'=>1],['word_id'=>$word_id])->execute();
            if($res){
                //修改状态之后  查看新的状态
                $db = new \yii\db\Query;
                $hotshop_status = $db->select('*')->from('yfc_hot_word')->where(['word_id'=>$word_id])->one();
            }
        }else{
            //隐藏改为显示
            $db = \Yii::$app->db->createCommand();
            $res = $db->update('yfc_hot_word',['show_status'=>0],['word_id'=>$word_id])->execute();
            if($res){
                //修改状态之后  查看新的状态
                $db = new \yii\db\Query;
                $hotshop_status = $db->select('*')->from('yfc_hot_word')->where(['word_id'=>$word_id])->one();
            }
        }
        echo json_encode($hotshop_status);
    }

    /**
     *热门菜 
     */
    public function actionHotfood()
    {
    	$db = new \yii\db\Query;
		$hot_food = $db->select('*')->from('yfc_hot_word')->orderBy('hot_length desc')->offset(0)->limit(7)->where(['word_type'=>1])->all();
    	return $this->render('hotfood',['hot_food'=>$hot_food]);
    }

    /**
     *热门菜删除 
     */
    public function actionDel_hotfood()
    {
    	$request = Yii::$app->request;
    	$word_id = $request->post('word_id');
    	$db = \Yii::$app->db->createCommand();
        $result = $db->delete('yfc_hot_word',['word_id'=>$word_id])->execute();
        if ($result) {
            return "ok";
        }else{
            return "no";
        }
    }

    /**
     *热门菜显示状态 
     */
    public function actionHotfood_status()
    {
    	$request = Yii::$app->request;
        $word_id = $request->post('word_id');
        $is_show = $request->post('is_show');

        if($is_show == 0){
            //显示改为隐藏
            $db = \Yii::$app->db->createCommand();
            $res = $db->update('yfc_hot_word',['show_status'=>1],['word_id'=>$word_id])->execute();
            if($res){
                //修改状态之后  查看新的状态
                $db = new \yii\db\Query;
                $hotshop_status = $db->select('*')->from('yfc_hot_word')->where(['word_id'=>$word_id])->one();
            }
        }else{
            //隐藏改为显示
            $db = \Yii::$app->db->createCommand();
            $res = $db->update('yfc_hot_word',['show_status'=>0],['word_id'=>$word_id])->execute();
            if($res){
                //修改状态之后  查看新的状态
                $db = new \yii\db\Query;
                $hotshop_status = $db->select('*')->from('yfc_hot_word')->where(['word_id'=>$word_id])->one();
            }
        }
        echo json_encode($hotshop_status);
    }
}