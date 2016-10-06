<?php
namespace app\common\utils;

class ImageUtils{
	
	/**
	 * 创建图片的缩略图
	 *
	 * @access  public
	 * @param   string      $img    原始图片的路径
	 * @param   int         $thumb_width  缩略图宽度
	 * @param   int         $thumb_height 缩略图高度
	 * @param   strint      $path         指定生成图片的目录名
	 * @return  mix         如果成功返回缩略图的路径，失败则返回false
	 * 
	 * 算法有问题
	 */
	function make_thumb($img, $thumb_width = 0, $thumb_height = 0, $path = '')
	{
		
		//获取文件名和扩展名
		$img = iconv("UTF-8", "GBK", $img);
		$path_info = pathinfo($img);
		$filename = /* dirname($img) .  */$path_info['dirname'] . '/' .$path_info['filename']. '_thumb' . '.' . $path_info['extension'];
		 
		/* 检查缩略图宽度和高度是否合法 */
		if ($thumb_width == 0 && $thumb_height == 0)
		{
			copy($img, iconv("UTF-8", "GBK",  $filename));
			return $filename;
		}
	
		/* 检查原始文件是否存在及获得原始文件的信息 */
// 		list($width, $height, $type, $attr) = getimagesize($img);
// 		$type = image_type_to_extension($type,false);
// var_dump($img);exit;
		$org_info = getimagesize($img);
		$org_info_image_type = image_type_to_extension($org_info[2],false);
		if (!$org_info)
		{
			return false;
		}
	
		
// 		$img_org = $this->img_resource($img, $org_info[2]);
		$fun = "imagecreatefrom" . $org_info_image_type;
		$img_org = $fun($img);
		
		/* 原始图片以及缩略图的尺寸比例 */
		$scale_org      = $org_info[0] / $org_info[1];
		/* 处理只有缩略图宽和高有一个为0的情况，这时背景和缩略图一样大 */
		if ($thumb_width == 0)
		{
			$thumb_width = $thumb_height * $scale_org;
		}
		if ($thumb_height == 0)
		{
			$thumb_height = $thumb_width / $scale_org;
		}
	
		/* 创建缩略图的标志符 */
		$img_thumb  = imagecreatetruecolor($thumb_width, $thumb_height);
// 		$img_thumb = imagecreate($thumb_width, $thumb_height);
// 		imagesavealpha($img_thumb,true);
// 		imagealphablending($img_thumb,false);
		//处理背景色
		$color=imagecolorallocate($img_thumb,255,255,255);
		imagecolortransparent($img_thumb,$color);
		imagefill($img_thumb,0,0,$color);
		imagefilledrectangle($img_thumb, 0, 0, $thumb_width, $thumb_height, $color);
// 		

		
		if ($org_info[0] / $thumb_width > $org_info[1] / $thumb_height)
		{
			$lessen_width  = $thumb_width;
			$lessen_height  = $thumb_width / $scale_org;
		}
		else
		{
			/* 原始图片比较高，则以高度为准 */
			$lessen_width  = $thumb_height * $scale_org;
			$lessen_height = $thumb_height;
		}
	
		$dst_x = ($thumb_width  - $lessen_width)  / 2;
		$dst_y = ($thumb_height - $lessen_height) / 2;
	
		/* 将原始图片进行缩放处理 */
		imagecopyresampled($img_thumb, $img_org, $dst_x, $dst_y, 0, 0, $lessen_width, $lessen_height,  $org_info[0], $org_info[1]);
		 
		
		$funcs = "image" . $org_info_image_type;
		$funcs($img_thumb, $filename);
		
		/* 生成文件 */
		/* if (function_exists('imagejpeg'))
		{
			$filename .= '.jpg';
			imagejpeg($img_thumb,  $filename);
		}
		elseif (function_exists('imagegif'))
		{
			$filename .= '.gif';
			imagegif($img_thumb,  $filename);
		}
		elseif (function_exists('imagepng'))
		{
			$filename .= '.png';
			imagepng($img_thumb,  $filename);
		}
		else
		{
			return false;
		} */
	
		imagedestroy($img_thumb);
		imagedestroy($img_org);
		
		//确认文件是否生成
		if (file_exists($filename))
		{
			return $filename;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 根据来源文件的文件类型创建一个图像操作的标识符
	 *
	 * @access  public
	 * @param   string      $img_file   图片文件的路径
	 * @param   string      $mime_type  图片文件的文件类型
	 * @return  resource    如果成功则返回图像操作标志符，反之则返回错误代码
	 */
	function img_resource($img_file, $mime_type)
	{
		switch ($mime_type)
		{
			case 1:
			case 'image/gif':
				$res = imagecreatefromgif($img_file);
				break;
	
			case 2:
			case 'image/pjpeg':
			case 'image/jpeg':
				$res = imagecreatefromjpeg($img_file);
				break;
	
			case 3:
			case 'image/x-png':
			case 'image/png':
				$res = imagecreatefrompng($img_file);
				break;
	
			default:
				return false;
		}
	
		return $res;
	}	

	/**
	 * 文件上传  
	 * @param unknown $imageFile (yii\web\UploadedFile)
	 * @param unknown $uploadPath
	 * @param string $uploadType (ads, etc)
	 * @return boolean|multitype:string
	 */
	function uploadImage($imageFile, $uploadPath, $uploadType='item', $filename = ''){
		//yii\web\UploadedFile
		if(empty($imageFile)){
			return false;
		}
		 
		$base_dir = $uploadPath;
		$path = $base_dir . '/' . date('ym',time()) . '/';
		//     	$webroot = Yii::getAlias("@webroot")  ;
		 
		//创建文件夹
		if(!is_dir($path)){
			mkdir(iconv("UTF-8", "GBK", $path),0777,true);
		}
		
		//主文件名
		if(empty($filename)){
			$filename = $imageFile->baseName;
		}
		 
		//重新命名广告图，命名规则ads_id_yyyymmdd_xxxx.ext
		$img_original = $path . $uploadType . '_' . $filename . '_' . date('ymdhis',time()) . '_' . rand(1000, 9999). '.' . $imageFile->extension;
		$file_path = $img_original;
		 
		//上传图片
		$imageFile->saveAs(iconv("UTF-8","GBK",$file_path),false);
		 
		//处理图片
		$img_url = $path . $uploadType . '_' . $filename . '_' . date('ymdhis',time()) . '_' . rand(1000, 9999). '_img' . '.' . $imageFile->extension;;
		$thumb_url = $path . $uploadType . '_'. $filename . '_' . date('ymdhis',time()) . '_' . rand(1000, 9999). '.' . $imageFile->extension;;
		 
		//拷贝文件
		copy(iconv("UTF-8","GBK",$file_path), iconv("UTF-8", "GBK",  $img_url));
		copy(iconv("UTF-8","GBK",$file_path), iconv("UTF-8", "GBK",  $thumb_url));
		$imageUtils = new ImageUtils();
		if($thumbed_url = ($imageUtils->make_thumb($thumb_url,300,200))){
			unlink(iconv("UTF-8", "GBK",  $thumb_url));
		}
		 
		//返回处理好的图片
		return ['img_url'=> $img_url, 'thumb_url' => iconv("GBK", "UTF-8",  $thumbed_url), 'img_original' => $img_original ];
	}
	
	
	/**
	 * 
	 * @param unknown $imageFile
	 * @param string $filename
	 * @param string $uploadType(ads etc)
	 * @param string $image_type(thumb,img,'')
	 */
	function renameImage($imageFile , $filename = '', $uploadType='item', $image_type = ''){
		$file_info = pathinfo($imageFile);
		if(empty($filename)){
			$filename = $file_info['filename'];
		}
		$newname =  $file_info['dirname'] . '/' . $uploadType . '_' . $filename . '_' . date('ymdhis',time()) . '_' . rand(1000, 9999). ($image_type?('_' . $image_type):'') . '.' . $file_info['extension'];
		if(rename($imageFile, $newname)){
			return $newname;
		}else{
			return false;
		}
	}
	
}