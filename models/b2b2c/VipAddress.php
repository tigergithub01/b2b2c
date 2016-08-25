<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_address".
 *
 * @property string $id
 * @property string $vip_id
 * @property string $consignee
 * @property string $phone_number
 * @property string $district_id
 * @property string $city_id
 * @property string $province_id
 * @property string $county_id
 * @property string $detail_address
 * @property string $default_flag
 *
 * @property SysRegion $province
 * @property Vip $vip
 * @property SysRegion $city
 * @property SysRegion $county
 * @property SysRegion $district
 * @property SysParameter $defaultFlag
 */
class VipAddress extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vip_id', 'consignee', 'phone_number', 'district_id', 'city_id', 'province_id', 'county_id', 'detail_address', 'default_flag'], 'required'],
            [['vip_id', 'district_id', 'city_id', 'province_id', 'county_id', 'default_flag'], 'integer'],
            [['consignee'], 'string', 'max' => 30],
            [['phone_number'], 'string', 'max' => 20],
            [['detail_address'], 'string', 'max' => 150],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysRegion::className(), 'targetAttribute' => ['province_id' => 'id']],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysRegion::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['county_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysRegion::className(), 'targetAttribute' => ['county_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysRegion::className(), 'targetAttribute' => ['district_id' => 'id']],
            [['default_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['default_flag' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'vip_id' => Yii::t('app', '会员编号'),
            'consignee' => Yii::t('app', '收货人姓名'),
            'phone_number' => Yii::t('app', '收货人手机号码'),
            'district_id' => Yii::t('app', '镇，区域编号'),
            'city_id' => Yii::t('app', '城市编号'),
            'province_id' => Yii::t('app', '收货省份'),
            'county_id' => Yii::t('app', '国家编号'),
            'detail_address' => Yii::t('app', '收货详细地址'),
            'default_flag' => Yii::t('app', '是否设置为默认收货地址(1：是；0：否)'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(SysRegion::className(), ['id' => 'province_id']);
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
    public function getCity()
    {
        return $this->hasOne(SysRegion::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCounty()
    {
        return $this->hasOne(SysRegion::className(), ['id' => 'county_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(SysRegion::className(), ['id' => 'district_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefaultFlag()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'default_flag']);
    }
}
