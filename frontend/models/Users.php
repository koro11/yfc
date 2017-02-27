<?php
namespace frontend\models;

use yii\db\ActiveRecord;
use yii\captcha\Captcha;
class Users extends ActiveRecord
{
	public $verifyCode;
	
}
?>