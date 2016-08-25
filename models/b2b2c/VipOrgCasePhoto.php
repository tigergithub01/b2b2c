<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_org_case_photo".
 *
 * @property string $id
 * @property string $case_id
 * @property string $img_url
 * @property string $thumb_url
 * @property string $img_original
 *
 * @property VipOrgCase $case
 */
class VipOrgCasePhoto extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_org_case_photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['case_id', 'img_url', 'thumb_url', 'img_original'], 'required'],
            [['case_id'], 'integer'],
            [['img_url', 'thumb_url', 'img_original'], 'string', 'max' => 255],
            [['case_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipOrgCase::className(), 'targetAttribute' => ['case_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'case_id' => Yii::t('app', '关联案例编号'),
            'img_url' => Yii::t('app', '图片（放大后查看）'),
            'thumb_url' => Yii::t('app', '缩略图'),
            'img_original' => Yii::t('app', '原始图片'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCase()
    {
        return $this->hasOne(VipOrgCase::className(), ['id' => 'case_id']);
    }
}
