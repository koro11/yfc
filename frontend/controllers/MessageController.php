<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Message;

/**
 * Yii2.0 MessageController  
 * 商家留言控制器          
 * @author Danny    
 * @email  351518543@qq.com
 * @Time   2017-2-26 
 */
class MessageController extends Controller
{
	public $enableCsrfValidation = false;
    
    /**
     * @message_add
     * 用户留言
     * @access public
     */
     public function actionMessage_add()
     {
     	$data = Yii::$app->request->post();
     	$data['m_addtime'] = time();
     	$data['m_type'] = 0;
     	// var_dump($data);
     	$db = Yii::$app->db->createCommand();
        $result = $db->insert('yfc_message' , $data )->execute();
        // var_dump($result);
        $id = Yii::$app->db->getLastInsertID();
        $new_message =Message::get_new_message($data['m_mer']);
        if ($new_message) {
        	echo json_encode($new_message);
        }
        else
        {
        	echo 0;
        }
     }

 

}