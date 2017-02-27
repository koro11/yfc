<?php 
namespace common\models;

use yii\base\Model;

class Upload extends Model
{
	public function files($files)
	{
		//判断文件大小
		if($files['size']>1024*1024*2) die('文件过大');
		//判断文件类型
		$arr=array('image/png','image/jpg','image/gif','image/jpeg');
		if(!in_array($files['type'],$arr)) die('文件类型不对');
		//判断文件上传错误信息
		switch($files['error'])
		{
			case 1 :
				echo "上传文件超过php.ini配置文件里设置文件大小";
				break;
			case 2 :
				echo "上传文件超过HTML表单设置文件大小";
				break;
			case 3 :
				echo "部分文件被上传";
				break;
			case 4 :
				echo "文件没被上传";
				break;
			case 6 :
				echo "临时文件没找到";
				break;
		}
		//定义要上传的文件路径
		$path='./uploads'.'/'.date('Y-m-d').'/';
		//判断路径是否存在
		if(!file_exists($path))
		{
			mkdir($path,0777,true);
		}
		//定义新的文件
		$pos=strrpos($files['name'],'.');
		$sub=substr($files['name'],$pos);
		$new_name=time().rand(10000,99999).$sub;
		//拼接路径
		$p=$path.$new_name;
		//移动上传文件
		if(move_uploaded_file($files['tmp_name'],$p))
		{
			return $p;
		}else
		{
			return false;
		}
	}
}

?>