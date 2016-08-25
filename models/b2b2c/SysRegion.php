<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_region".
 *
 * @property string $id
 * @property string $name
 * @property string $parent_id
 * @property string $region_type
 *
 * @property DeliveryTypeAreaRegion[] $deliveryTypeAreaRegions
 * @property PickUpPointRegion[] $pickUpPointRegions
 * @property SoSheet[] $soSheets
 * @property SoSheet[] $soSheets0
 * @property SoSheet[] $soSheets1
 * @property SoSheet[] $soSheets2
 * @property SysRegion $parent
 * @property SysRegion[] $sysRegions
 * @property SysWarehouseRegion[] $sysWarehouseRegions
 * @property VipAddress[] $vipAddresses
 * @property VipAddress[] $vipAddresses0
 * @property VipAddress[] $vipAddresses1
 * @property VipAddress[] $vipAddresses2
 */
class SysRegion extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'region_type'], 'required'],
            [['parent_id', 'region_type'], 'integer'],
            [['name'], 'string', 'max' => 60],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysRegion::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'name' => Yii::t('app', '省份名称'),
            'parent_id' => Yii::t('app', '上级区域编号'),
            'region_type' => Yii::t('app', '国家省市区类别'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveryTypeAreaRegions()
    {
        return $this->hasMany(DeliveryTypeAreaRegion::className(), ['region_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPickUpPointRegions()
    {
        return $this->hasMany(PickUpPointRegion::className(), ['region_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheets()
    {
        return $this->hasMany(SoSheet::className(), ['city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheets0()
    {
        return $this->hasMany(SoSheet::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheets1()
    {
        return $this->hasMany(SoSheet::className(), ['district_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheets2()
    {
        return $this->hasMany(SoSheet::className(), ['province_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(SysRegion::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysRegions()
    {
        return $this->hasMany(SysRegion::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysWarehouseRegions()
    {
        return $this->hasMany(SysWarehouseRegion::className(), ['region_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipAddresses()
    {
        return $this->hasMany(VipAddress::className(), ['province_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipAddresses0()
    {
        return $this->hasMany(VipAddress::className(), ['city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipAddresses1()
    {
        return $this->hasMany(VipAddress::className(), ['county_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipAddresses2()
    {
        return $this->hasMany(VipAddress::className(), ['district_id' => 'id']);
    }
}
