<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_pick_up_point".
 *
 * @property string $id
 * @property string $vip_id
 * @property string $name
 * @property string $address
 * @property string $status
 *
 * @property Vip $vip
 * @property SysParameter $status0
 * @property PickUpPointRegion[] $pickUpPointRegions
 * @property SoSheet[] $soSheets
 */
class PickUpPoint extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_pick_up_point';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vip_id', 'name', 'address', 'status'], 'required'],
            [['vip_id', 'status'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 100],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'vip_id' => Yii::t('app', '关联商户编号'),
            'name' => Yii::t('app', '自提点名称'),
            'address' => Yii::t('app', '自提点地址'),
            'status' => Yii::t('app', '是否启用：1、是；0、否；'),
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
    public function getStatus0()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPickUpPointRegions()
    {
        return $this->hasMany(PickUpPointRegion::className(), ['point_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheets()
    {
        return $this->hasMany(SoSheet::className(), ['pick_point_id' => 'id']);
    }
}
