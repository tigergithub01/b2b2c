<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_ad_info".
 *
 * @property string $id
 * @property string $img_url
 * @property string $thumb_url
 * @property string $img_original
 * @property string $sequence_id
 * @property string $redirect_url
 * @property string $description
 * @property integer $width
 * @property integer $height
 */
class SysAdInfo extends \app\models\b2b2c\BasicModel
{
	//上传文件
	public $imageFile;
	const SCENARIO_CREATE = 'create';//创建
	const SCENARIO_UPDATE = 'update';//更新
	
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
            [['img_url', 'thumb_url', 'img_original', 'sequence_id', 'width', 'height'], 'required'],
            [['sequence_id', 'width', 'height'], 'integer'],
            [['img_url', 'thumb_url', 'img_original', 'redirect_url', 'description'], 'string', 'max' => 255],
        	[['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg','maxSize'=>5*1024*1024, 'checkExtensionByMimeType' => false,'mimeTypes'=>'image/jpeg, image/png','maxFiles' => 1, 'on' => [self::SCENARIO_CREATE]],
        	[['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg','maxSize'=>5*1024*1024, 'checkExtensionByMimeType' => false,'mimeTypes'=>'image/jpeg, image/png','maxFiles' => 1, 'on' => [self::SCENARIO_UPDATE]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'img_url' => Yii::t('app', /* '图片（放大后查看）' */'图片'),
            'thumb_url' => Yii::t('app', '缩略图'),
            'img_original' => Yii::t('app', '原图'),
            'sequence_id' => Yii::t('app', '显示顺序'),
            'redirect_url' => Yii::t('app', '点击后跳转关联URL'),
            'description' => Yii::t('app', '描述'),
            'width' => Yii::t('app', '宽度'),
            'height' => Yii::t('app', '高度'),
        	'imageFile' => Yii::t('app', '广告图'),
        ];
    }
}
