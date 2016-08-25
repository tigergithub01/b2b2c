<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_warehouse_region".
 *
 * @property string $id
 * @property string $warehouse_id
 * @property string $region_id
 *
 * @property SysWarehouse $warehouse
 * @property SysRegion $region
 */
class SysWarehouseRegion extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_warehouse_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['warehouse_id', 'region_id'], 'required'],
            [['warehouse_id', 'region_id'], 'integer'],
            [['warehouse_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysWarehouse::className(), 'targetAttribute' => ['warehouse_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysRegion::className(), 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'warehouse_id' => Yii::t('app', '关联仓库编号'),
            'region_id' => Yii::t('app', '关联所辖区域'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouse()
    {
        return $this->hasOne(SysWarehouse::className(), ['id' => 'warehouse_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(SysRegion::className(), ['id' => 'region_id']);
    }
}
