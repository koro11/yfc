<?php
namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * Yii2.0 Message
 * 商家留言模型
 * @author Danny
 * @email  351518543@qq.com
 * @Time   2017-2-23 
 */ 
class Message extends ActiveRecord
{
   
    //关联 User_info 表  
    public function getUser()
    {      
        // 第一个参数为要关联的子表模型类名称， 
        // 第二个参数指定通过子表的 info_mer 去关联主表的 mer_id 字段  
        return $this->hasOne(User_info::className(), ['user_id' => 'm_user']);  
    }  

    //关联 Merchant 表  
    public function getMer()
    {      
        // 第一个参数为要关联的子表模型类名称， 
        // 第二个参数指定通过子表的 info_mer 去关联主表的 mer_id 字段  
        return $this->hasOne(Merchant::className(), ['mer_id' => 'm_mer']);  
    }

    /**
     * @get_new_message
     * 获取某商家最新的三条留言和对应的商家回复
     * @access public
     */
    static public function get_new_message($mer_id = 1,$offset = 0)
     {
         
         $new_message = Message::find()
                               ->joinWith('user')  
                               ->where(['m_type'=>0,'m_mer'=>$mer_id])
                               ->orderBy('m_addtime DESC')
                               ->asArray()
                               ->all();
         $new_message = array_slice($new_message, $offset,3);
         // var_dump($new_message);die();   
         foreach ($new_message as $key => $value) {
          
         $new_message[$key]['user_name'] = $value['user']['user_name'];
        
         unset($new_message[$key]['user']);
        
         $new_message[$key]['m_addtime'] = date('Y-m-d H:i:s',$value['m_addtime']);
         $new_message[$key]['m_message'] = htmlspecialchars_decode($value['m_message']);
         
         //对应的商家回复
         $back = Message::find()                           
                        ->joinWith('mer')
                        ->where(['m_type'=>1,'m_pid'=>$value['m_id'],'m_mer'=>$mer_id])
                        ->asArray()
                        ->one();
         if ($back) 
         {
             $back['mer_name'] = $back['mer']['mer_name'];
             unset($back['mer']);
             $back['m_addtime'] = date('Y-m-d H:i:s',$back['m_addtime']);
             $back['m_message'] = htmlspecialchars_decode($back['m_message']);
             $new_message[$key]['back'] = $back;
          }
          else
          {
             $new_message[$key]['back'] = '';
          }
                         
          }
         return $new_message;
     }  
}