<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_delivery_type_area".
 *
 * @property string $id
 * @property string $name
 * @property string $delivery_id
 * @property string $configure
 *
 * @property DeliveryType $delivery
 * @property DeliveryTypeAreaRegion[] $deliveryTypeAreaRegions
 */
class DeliveryTypeArea extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_delivery_type_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'delivery_id', 'configure'], 'required'],
            [['delivery_id'], 'integer'],
            [['configure'], 'string'],
            [['name'], 'string', 'max' => 30],
            [['delivery_id'], 'exist', 'skipOnError' => true, 'targetClass' => DeliveryType::className(), 'targetAttribute' => ['delivery_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'name' => Yii::t('app', '配送区域名称'),
            'delivery_id' => Yii::t('app', '关联配送方式'),
            'configure' => Yii::t('app', '对应的计费规则'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDelivery()
    {
        return $this->hasOne(DeliveryType::className(), ['id' => 'delivery_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveryTypeAreaRegions()
    {
        return $this->hasMany(DeliveryTypeAreaRegion::className(), ['delivery_area_id' => 'id']);
    }
}
