<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_warehouse".
 *
 * @property string $id
 * @property string $name
 * @property string $vip_id
 *
 * @property ProductStock[] $productStocks
 * @property Vip $vip
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
            [['name', 'vip_id'], 'required'],
            [['vip_id'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
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
            'vip_id' => Yii::t('app', '关联商户编号'),
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
    public function getVip()
    {
        return $this->hasOne(Vip::className(), ['id' => 'vip_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysWarehouseRegions()
    {
        return $this->hasMany(SysWarehouseRegion::className(), ['warehouse_id' => 'id']);
    }
}
