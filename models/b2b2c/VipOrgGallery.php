<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_org_gallery".
 *
 * @property string $id
 * @property string $organization_id
 * @property string $img_url
 * @property string $thumb_url
 * @property string $img_original
 *
 * @property VipOrganization $organization
 */
class VipOrgGallery extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_org_gallery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_id', 'img_url', 'thumb_url', 'img_original'], 'required'],
            [['organization_id'], 'integer'],
            [['img_url', 'thumb_url', 'img_original'], 'string', 'max' => 255],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipOrganization::className(), 'targetAttribute' => ['organization_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'organization_id' => Yii::t('app', '关联产品编号'),
            'img_url' => Yii::t('app', '图片（放大后查看）'),
            'thumb_url' => Yii::t('app', '缩略图'),
            'img_original' => Yii::t('app', '原图'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(VipOrganization::className(), ['id' => 'organization_id']);
    }
}
