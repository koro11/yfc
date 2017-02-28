<?php
namespace frontend\functions;
use yii\db\query;
//分页类
class Page {

    public $pageNow	= 1;	//当前页
    public $pageCount;//数据总条数
    public $pageSize = 3;//每页显示条数

    //获取分页
    public function getPage($count){

        $total = ceil($this->pageCount/$this->pageSize);//总页数

        //页码起始数
        $start = $this->pageNow - 3;
        $start = $start < 1 ? 1 : $start;

        //页码结束数
        $end = $start + 6;
        $end = $end > $total ? $total : $end;

        //生成页码数
        $str = '<a href="javascript:;"><span class="Prev" page="1"><i></i>首页</span></a>';//页码
        for($i = $start; $i <= $end;$i++){
            if($this->pageNow == $i){
                $str .= '<a href="javascript:;"><span class=" pick">'.$i.'</span></a>';
            }else{
                $str .= '<a href="javascript:;"><span class="PNumber">'.$i.'</span></a>';
            }

        }
        $str .= '<a href="javascript:;"><span class="Next" page='.$count.'>最后一页<i></i></span>
</a>';

        return $str;
    }
    /**
     * 评论数据
     * @author Dx
     * @param  intval $food_id
     * @param  intval $now
     * @return
     */
    public function getComment($obj,$food_id,$now)
    {
        //分页数据
        $content= $obj->getComment($food_id,$now,$this->pageSize);
       if(!$content)return false;
        foreach($content as $k=>$v){
            $content[$k]['create_time'] = date('y-m-d H:i:s',$v['create_time']);
            $username = (new query)->select('user_name')->from('yfc_user_info')->where(['user_id'=>$v['speak_user']])->one();
            $content[$k]['user_name'] = $username['user_name'];
        }
        return $content;

    }
}

