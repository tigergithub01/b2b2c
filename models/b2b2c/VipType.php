<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_type".
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property integer $seq_id
 * @property string $merchant_flag
 *
 * @property Vip[] $vips
 * @property VipCaseType[] $vipCaseTypes
 * @property VipProductType[] $vipProductTypes
 * @property SysParameter $merchantFlag
 */
class VipType extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'merchant_flag'], 'required'],
            [['seq_id', 'merchant_flag'], 'integer'],
            [['code'], 'string', 'max' => 30],
            [['name'], 'string', 'max' => 60],
            [['description'], 'string', 'max' => 400],
            [['merchant_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['merchant_flag' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'code' => Yii::t('app', '编号'),
            'name' => Yii::t('app', '经营范围名称'),
            'description' => Yii::t('app', '描述'),
            'seq_id' => Yii::t('app', '排序'),
            'merchant_flag' => Yii::t('app', '商家分类与会员分类？1：商家；0：会员'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVips()
    {
        return $this->hasMany(Vip::className(), ['vip_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipCaseTypes()
    {
        return $this->hasMany(VipCaseType::className(), ['vip_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipProductTypes()
    {
        return $this->hasMany(VipProductType::className(), ['vip_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMerchantFlag()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'merchant_flag']);
    }
}
