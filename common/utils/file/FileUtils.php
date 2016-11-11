<?php
namespace app\common\utils\file;

use app\common\utils\CommonUtils;

class FileUtils{
	
	/**
	 * 文件上传  
	 * @param unknown $uploadFile
	 * @param unknown $uploadPath
	 * @param string $uploadType
	 * @param string $filename
	 * @return boolean|string
	 */
	function uploadFile($uploadFile, $uploadPath, $uploadType='item', $filename = ''){
		//yii\web\UploadedFile
		if(empty($uploadFile)){
			return false;
		}
		 
		$base_dir = $uploadPath;
		$path = $base_dir . '/' . date('Ym',time()) . '/';
		//     	$webroot = Yii::getAlias("@webroot")  ;
		 
		//创建文件夹
		if(!is_dir($path)){
			mkdir(iconv("UTF-8", "GBK", $path),0777,true);
		}
		
		//主文件名
		if(empty($filename)){
			$filename = $uploadFile->baseName;
		}
		 
		//重新命名，命名规则ads_id_yyyymmdd_xxxx.ext
		$file_path = $path . $uploadType . '_' . $filename . '_' . date('ymdhis',time()) . '_' . CommonUtils::random(4, 1). '.' . $uploadFile->extension;
		 
		//上传文件
		$uploadFile->saveAs(iconv("UTF-8","GBK",$file_path),false);
		 
		 
		//返回处理好的文件
		return $file_path;
	}
	
	
	/**
	 * renameFile
	 * @param unknown $uploadFile
	 * @param string $filename
	 * @param string $uploadType
	 * @param string $image_type
	 * @return string|boolean
	 */
	function renameFile($uploadFile , $filename = '', $uploadType='item', $image_type = ''){
		$file_info = pathinfo($uploadFile);
		if(empty($filename)){
			$filename = $file_info['filename'];
		}
		$newname =  $file_info['dirname'] . '/' . $uploadType . '_' . $filename . '_' . date('ymdhis',time()) . '_' . CommonUtils::random(4, 1). ($image_type?('_' . $image_type):'') . '.' . $file_info['extension'];
		if(rename(iconv("UTF-8","GBK",$uploadFile), iconv("UTF-8","GBK",$newname))){
			return $newname;
		}else{
			return false;
		}
	}
	
}