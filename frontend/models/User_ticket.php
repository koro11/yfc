<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class User_ticket extends ActiveRecord
{
    public function getTickets(){
        return $this->hasOne(Tickets::className(),['tic_id'=>'tic_id']);
    }

    /**
     * 获取商户优惠券
     * @author Dx
     * @param intval $uid
     * @param string $merId
     * @return array|bool|\yii\db\ActiveRecord[]
     */
    public function getTicket($uid,$merId,$price=0)
    {
        if(empty($uid)||empty($merId))exit('缺少参数');
        $res = $this->find()->joinWith('tickets')->where('user_id = ('.$uid.') and tic_end > ('.time().') and tic_merchant in ('.$merId.') and tic_cost < ('.$price.')')->asArray()->all();
        if(!$res)return false;
        return $res;
    }

    /**
     * 获取全场优惠券
     * @author Dx
     * @param intval $uid
     * @param intval $sum
     * @return array|bool|\yii\db\ActiveRecord[]
     */
    public function getFullcourt($uid,$sum)
    {
        if(empty($uid))exit('缺少参数');
        $res = $this->find()->joinWith('tickets')->where('user_id = ('.$uid.') and tic_end > ('.time().') and tic_cost < ('.$sum.')')->andWhere(['=','tic_status','1'])->asArray()->all();
        if(!$res)return false;
        return $res;
    }
    /**
     * 查看优惠卷是否还在有效期
     * @author Dx
     * @param
     * @return
     */
    public function getCoupon($uid,$tic_id)
    {
        if(empty($uid))return false;
        $res = $this->find()->joinWith('tickets')->where(['=','tic_status','1'])->andWhere('user_id = ('.$uid.') and tic_end > ('.time().') and yfc_tickets.tic_id = ('.$tic_id.')')->asArray()->one();

        if(!$res)return false;
        return $res;
    }
    /**
     * 查看商户优惠券是否有效
     * @author Dx
     * @param
     * @return
     */
    public function getStore($uid,$tic_id,$mer_id)
    {
        if(empty($uid) || empty($tic_id) || empty($mer_id))return false;

        $res = $this->find()->joinWith('tickets')->where('user_id = ('.$uid.') and tic_end > ('.time().')and yfc_tickets.tic_id = ('.$tic_id.') and tic_merchant = ('.$mer_id.')')->asArray()->one();
        if(!$res)return false;
        return $res;
    }
    /**
     * 删除优惠券
     * @author Dx
     * @param
     * @return
     */
    public function delStore($id)
    {
        if(empty($id))return false;
        $res = $this->deleteAll('tic_id in ('.$id.')');
        if($res){
            return true;
        }else{
            return false;
        }
    }

}
?>