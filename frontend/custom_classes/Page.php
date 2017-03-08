<?php  
namespace frontend\custom_classes;

//自定义分页类
class Page {

	public $pageNow	= 1;	//当前页

	public $pageCount	= 100;//数据总条数
	public $pageSize	= 1;//每页显示条数



	//获取分页
	public function getPage(){
		
		$total = ceil($this->pageCount/$this->pageSize);//总页数

		//页码起始数
		$start = $this->pageNow - 3;
		$start = $start < 1 ? 1 : $start;

		//页码结束数
		$end = $start + 6;
		$end = $end > $total ? $total : $end;

		//生成页码数
		$str = '';//页码
		$str .= '<a href="javascript:page(1)"><span class="Prev"><i></i>首页</span></a>';
		for($i = $start; $i <= $end;$i++){
			if($this->pageNow == $i){
				$str .= '<span class="PNumber">'.$i.'</span> ';
			}else{
				$str .= '<a href="javascript:page('.$i.')" class="PNumber">'.$i.'</a> ';
			}
			
		}
		
		$str .= '<a href="javascript:page('.$total.')"><span class="Next">最后一页<i></i></span></a>';
		return $str;
	}
}


