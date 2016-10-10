<?php

namespace app\models\b2b2c\common;

class JsonObj{
	//错误编码
	public $err_code;
	
	//状态
	public $status = true;
	
	//值
	public $value;
	
	//消息
	public $message;
	
	//验证错误消息
	public $attributeErrors;
	
	
	/**
	 * 自定义构造函数
	 * @param string $status
	 * @param string $value
	 * @param string $message
	 */
	public function __construct($status = true,$value = null,$message = null, $attributeErrors=[] ,$err_code = null){
		$this->status = $status;
		$this->value = $value;
		$this->message = $message;
		$this->attributeErrors = $attributeErrors;
		$this->err_code = $err_code;
	}
	
	
}