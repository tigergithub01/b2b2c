<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_pick_up_point_region".
 *
 * @property string $id
 * @property string $point_id
 * @property string $region_id
 *
 * @property SysRegion $region
 * @property PickUpPoint $point
 */
class PickUpPointRegion extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_pick_up_point_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['point_id', 'region_id'], 'required'],
            [['point_id', 'region_id'], 'integer'],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysRegion::className(), 'targetAttribute' => ['region_id' => 'id']],
            [['point_id'], 'exist', 'skipOnError' => true, 'targetClass' => PickUpPoint::className(), 'targetAttribute' => ['point_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'point_id' => Yii::t('app', '自提点编号'),
            'region_id' => Yii::t('app', '区域编号'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(SysRegion::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPoint()
    {
        return $this->hasOne(PickUpPoint::className(), ['id' => 'point_id']);
    }
}
