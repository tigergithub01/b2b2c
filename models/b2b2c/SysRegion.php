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
 * @property SysParameter $regionType
 * @property SysRegion $parent
 * @property SysRegion[] $sysRegions
 * @property SysWarehouseRegion[] $sysWarehouseRegions
 * @property VipAddress[] $vipAddresses
 * @property VipAddress[] $vipAddresses0
 * @property VipAddress[] $vipAddresses1
 * @property VipAddress[] $vipAddresses2
 * @property VipOrganization[] $vipOrganizations
 * @property VipOrganization[] $vipOrganizations0
 * @property VipOrganization[] $vipOrganizations1
 */
class SysRegion extends \app\models\b2b2c\BasicModel
{
	/* 上级区域名称（查询用） */
	public $parent_name;
	
	//国家
	const region_type_country = 22001;
	
	//省份（直辖市）
	const region_type_province = 22002;
	
	//市
	const region_type_city = 22003;
	
	//区
	const region_type_district = 22004;
	
	//县（街道)
	const region_type_town = 22005;
	
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
    public function scenarios()
    {
    	// bypass scenarios() implementation in the parent class
    	$scenarios = parent::scenarios();
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'parent_name';
    	return $scenarios;
    	// 		return parent::scenarios();
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
            [['region_type'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['region_type' => 'id']],
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
            'name' => Yii::t('app', '区域名称'),
            'parent_id' => Yii::t('app', '上级区域'),
            'region_type' => Yii::t('app', '国家省市区类别'),
        	'parent.name' => Yii::t('app', '上级区域'),
        	'regionType.param_val' => Yii::t('app', '国家省市区类别'),
        	'parent_name' => Yii::t('app', '上级区域名称'),
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
    public function getRegionType()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'region_type']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipOrganizations()
    {
        return $this->hasMany(VipOrganization::className(), ['city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipOrganizations0()
    {
        return $this->hasMany(VipOrganization::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipOrganizations1()
    {
        return $this->hasMany(VipOrganization::className(), ['province_id' => 'id']);
    }
}
