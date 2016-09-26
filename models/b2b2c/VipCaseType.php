<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_case_type".
 *
 * @property string $id
 * @property string $name
 *
 * @property VipCase[] $vipCases
 * @property VipCaseTypeProp[] $vipCaseTypeProps
 */
class VipCaseType extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_case_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'name' => Yii::t('app', '案例类型名称'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipCases()
    {
        return $this->hasMany(VipCase::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipCaseTypeProps()
    {
        return $this->hasMany(VipCaseTypeProp::className(), ['case_type_id' => 'id']);
    }
}
