<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_delivery_type".
 *
 * @property string $id
 * @property string $tpl_id
 * @property string $vip_id
 * @property string $description
 * @property string $status
 *
 * @property Vip $vip
 * @property DeliveryTypeTpl $tpl
 * @property SysParameter $status0
 * @property DeliveryTypeArea[] $deliveryTypeAreas
 */
class DeliveryType extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_delivery_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tpl_id', 'vip_id', 'status'], 'required'],
            [['tpl_id', 'vip_id', 'status'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['tpl_id'], 'exist', 'skipOnError' => true, 'targetClass' => DeliveryTypeTpl::className(), 'targetAttribute' => ['tpl_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'tpl_id' => Yii::t('app', '配送方式名称'),
            'vip_id' => Yii::t('app', '关联商户编号'),
            'description' => Yii::t('app', '描述'),
            'status' => Yii::t('app', '是否启用？(1:是；0:否)'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVip()
    {
        return $this->hasOne(Vip::className(), ['id' => 'vip_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTpl()
    {
        return $this->hasOne(DeliveryTypeTpl::className(), ['id' => 'tpl_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveryTypeAreas()
    {
        return $this->hasMany(DeliveryTypeArea::className(), ['delivery_id' => 'id']);
    }
}
