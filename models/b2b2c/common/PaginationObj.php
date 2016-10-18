<?php

namespace app\models\b2b2c\common;

/**
 * 分页对象
 * @author Tiger-guo
 *
 */
class PaginationObj{
	/* 返回数据 */
	public $dataList;
	
	//数据总行数
	public $totalCount;
	
	function __construct($dataList = null, $totalCount = 1){
		$this->dataList = $dataList;
		$this->totalCount = $totalCount;
	}
	
}