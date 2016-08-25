<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_ad_info".
 *
 * @property string $id
 * @property string $organization_id
 * @property string $ad_type
 * @property string $image_url
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
            [['organization_id', 'ad_type', 'sequence_id'], 'integer'],
            [['ad_type', 'image_url', 'sequence_id'], 'required'],
            [['image_url', 'redirect_url'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'organization_id' => Yii::t('app', '关联机构编号'),
            'ad_type' => Yii::t('app', '平台广告图（商家广告图）'),
            'image_url' => Yii::t('app', '图片地址'),
            'sequence_id' => Yii::t('app', '显示顺序'),
            'redirect_url' => Yii::t('app', '点击后跳转关联URL'),
        ];
    }
}
