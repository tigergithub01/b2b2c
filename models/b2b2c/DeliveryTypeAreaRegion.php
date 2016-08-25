<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_delivery_type_area_region".
 *
 * @property string $id
 * @property string $delivery_area_id
 * @property string $region_id
 *
 * @property SysRegion $region
 * @property DeliveryTypeArea $deliveryArea
 */
class DeliveryTypeAreaRegion extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_delivery_type_area_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delivery_area_id', 'region_id'], 'required'],
            [['delivery_area_id', 'region_id'], 'integer'],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysRegion::className(), 'targetAttribute' => ['region_id' => 'id']],
            [['delivery_area_id'], 'exist', 'skipOnError' => true, 'targetClass' => DeliveryTypeArea::className(), 'targetAttribute' => ['delivery_area_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'delivery_area_id' => Yii::t('app', '关联配送方式区域'),
            'region_id' => Yii::t('app', '对应区域'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(SysRegion::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveryArea()
    {
        return $this->hasOne(DeliveryTypeArea::className(), ['id' => 'delivery_area_id']);
    }
}
