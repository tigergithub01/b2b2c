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
 */
class SysAdInfo extends \app\models\b2b2c\BasicModel
{
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
        ];
    }
}
