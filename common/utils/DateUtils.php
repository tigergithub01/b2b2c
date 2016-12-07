<?php
namespace app\common\utils;

use app\models\b2b2c\common\Constant;

class DateUtils{
	
	
	public static function formatDate($time=null){
		$time = (empty($time)?time():$time);
		return self::format($time, Constant::DATE_FORMAT);
	}
	
	public static function formatDatetime($time=null){
		$time = (empty($time)?time():$time);
		return self::format($time, Constant::DATE_TIME_FORMAT);
	}

	public static function formatTime($time=null){
		$time = (empty($time)?time():$time);
		return self::format($time, Constant::TIME_FORMAT);
	}
	
	/**
	 * 用date()函数格式化，便于保存到数据库中
	 * @param unknown $time
	 * @return string
	 */
	public static function format($time , $format){
		return date($format, $time);
	}	
	
	/**
	 * 用\Yii::$app->formatter 格式化输出：
	 * @param unknown $value
	 * @param unknown $format
	 * @return string
	 */
	public static function asDateTime($value, $format=null){
		$format = (empty($format)?("php:" . Constant::DATE_TIME_FORMAT):$format);
		return \Yii::$app->formatter->asDatetime($value, $format);
	}
	
	public static function asDate($value, $format=null){
		$format = (empty($format)?("php:" . Constant::DATE_FORMAT):$format);
		return \Yii::$app->formatter->asDate($value, $format);
	}
	
	public static function asTime($value, $format=null){
		$format = (empty($format)?("php:" . Constant::TIME_FORMAT):$format);
		return \Yii::$app->formatter->asTime($value, $format);
	}
	
	
	
	
	
	
	
}