<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_delivery_type".
 *
 * @property string $id
 * @property string $tpl_id
 * @property string $organization_id
 * @property string $description
 * @property string $status
 *
 * @property SysParameter $status0
 * @property DeliveryTypeTpl $tpl
 * @property VipOrganization $organization
 * @property DeliveryTypeArea[] $deliveryTypeAreas
 * @property OutStockSheet[] $outStockSheets
 * @property SoSheet[] $soSheets
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
            [['tpl_id', 'organization_id', 'status'], 'required'],
            [['tpl_id', 'organization_id', 'status'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['tpl_id'], 'exist', 'skipOnError' => true, 'targetClass' => DeliveryTypeTpl::className(), 'targetAttribute' => ['tpl_id' => 'id']],
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
            'tpl_id' => Yii::t('app', '配送方式名称'),
            'organization_id' => Yii::t('app', '机构编号'),
            'description' => Yii::t('app', '描述'),
            'status' => Yii::t('app', '是否启用？(1:是；0:否)'),
        ];
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
    public function getTpl()
    {
        return $this->hasOne(DeliveryTypeTpl::className(), ['id' => 'tpl_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(VipOrganization::className(), ['id' => 'organization_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveryTypeAreas()
    {
        return $this->hasMany(DeliveryTypeArea::className(), ['delivery_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutStockSheets()
    {
        return $this->hasMany(OutStockSheet::className(), ['delivery_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheets()
    {
        return $this->hasMany(SoSheet::className(), ['delivery_type' => 'id']);
    }
}
