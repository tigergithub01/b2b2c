<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_warehouse".
 *
 * @property string $id
 * @property string $name
 * @property string $organization_id
 *
 * @property ProductStock[] $productStocks
 * @property VipOrganization $organization
 * @property SysWarehouseRegion[] $sysWarehouseRegions
 */
class SysWarehouse extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_warehouse';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'organization_id'], 'required'],
            [['organization_id'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipOrganization::className(), 'targetAttribute' => ['organization_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'name' => Yii::t('app', '仓库名称'),
            'organization_id' => Yii::t('app', '所属机构'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductStocks()
    {
        return $this->hasMany(ProductStock::className(), ['warehouse_id' => 'id']);
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
    public function getSysWarehouseRegions()
    {
        return $this->hasMany(SysWarehouseRegion::className(), ['warehouse_id' => 'id']);
    }
}
