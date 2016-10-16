<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_delivery_type_tpl".
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $print_tpl
 * @property string $description
 * @property string $status
 *
 * @property DeliveryType[] $deliveryTypes
 * @property SysParameter $status0
 * @property OutStockSheet[] $outStockSheets
 * @property SoSheet[] $soSheets
 */
class DeliveryTypeTpl extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_delivery_type_tpl';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'status'], 'required'],
            [['print_tpl'], 'string'],
            [['status'], 'integer'],
            [['code'], 'string', 'max' => 30],
            [['name'], 'string', 'max' => 60],
            [['description'], 'string', 'max' => 255],
            [['code'], 'unique'],
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
            'code' => Yii::t('app', '配送方式唯一编码'),
            'name' => Yii::t('app', '配送方式名称'),
            'print_tpl' => Yii::t('app', '打印模板'),
            'description' => Yii::t('app', '描述'),
            'status' => Yii::t('app', '是否有效(1:是；0:否)'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveryTypes()
    {
        return $this->hasMany(DeliveryType::className(), ['tpl_id' => 'id']);
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
