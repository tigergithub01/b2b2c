<?php

namespace app\models\b2b2c;

use Yii;
use app\common\utils\ImageUtils;

/**
 * This is the model class for table "t_sys_ad_info".
 *
 * @property string $id
 * @property string $img_url
 * @property string $thumb_url
 * @property string $img_original
 * @property string $sequence_id
 * @property string $redirect_url
 */
class SysAdInfo extends \app\models\b2b2c\BasicModel
{
	//上传文件
	public $imageFile;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_ad_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['img_url', 'thumb_url', 'img_original', 'sequence_id'], 'required'],
            [['sequence_id'], 'integer'],
            [['img_url', 'thumb_url', 'img_original'], 'string', 'max' => 255],
            [['redirect_url'], 'string', 'max' => 255],
        	[['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg','maxSize'=>5*1024*1024, 'checkExtensionByMimeType' => false,'mimeTypes'=>'image/jpeg, image/png',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'img_url' => Yii::t('app', '图片（放大后查看）'),
            'thumb_url' => Yii::t('app', '缩略图'),
            'img_original' => Yii::t('app', '原图'),
            'sequence_id' => Yii::t('app', '显示顺序'),
            'redirect_url' => Yii::t('app', '点击后跳转关联URL'),
        	'imageFile' => Yii::t('app', '广告图'),
        ];
    }
    
    public function upload()
    {
    	
    	//yii\web\UploadedFile
    	if(empty($this->imageFile)){
    		return false;
    	}
    	
    	$base_dir = 'uploads/ads';
    	$path = $base_dir . '/' . date('ym',time()) . '/';
//     	$webroot = Yii::getAlias("@webroot")  ;
    	
    	//创建文件夹
    	if(!is_dir($path)){
    		mkdir(iconv("UTF-8", "GBK", $path),0777,true);
    	}
    	
    	//重新命名广告图，命名规则ads_id_yyyymmdd_xxxx.ext
    	$img_original = $path . 'ads_' . $this->imageFile->baseName . '_' . date('ymdhis',time()) . '_' . rand(1000, 9999). '.' . $this->imageFile->extension;
    	$file_path = $img_original;
    	
    	//上传图片
    	$this->imageFile->saveAs(iconv("UTF-8","GBK",$file_path),false);
    	
    	//处理图片
    	$img_url = $path . 'ads_' . $this->imageFile->baseName . '_' . date('ymdhis',time()) . '_' . rand(1000, 9999). '_img' . '.' . $this->imageFile->extension;;
    	$thumb_url = $path . 'ads_'. $this->imageFile->baseName . '_' . date('ymdhis',time()) . '_' . rand(1000, 9999). '.' . $this->imageFile->extension;;
    	
    	//拷贝文件
    	copy(iconv("UTF-8","GBK",$file_path), iconv("UTF-8", "GBK",  $img_url));
    	copy(iconv("UTF-8","GBK",$file_path), iconv("UTF-8", "GBK",  $thumb_url));
    	$imageUtils = new ImageUtils();
    	if($thumbed_url = ($imageUtils->make_thumb($thumb_url,300,200))){
    		unlink(iconv("UTF-8", "GBK",  $thumb_url));
    	}
    	
    	//返回处理好的图片    
		var_dump($thumbed_url);
    	
    	return ['img_url'=> $img_url, 'thumb_url' => iconv("GBK", "UTF-8",  $thumbed_url), 'img_original' => $img_original ];
    	
    	
    	/* if ($this->validate()) {
    		foreach ($this->imageFiles as $file) {
    			$file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
    		}
    		return true;
    	} else {
    		return false;
    	} */
    }
    
}
