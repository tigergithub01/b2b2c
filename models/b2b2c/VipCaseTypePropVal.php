<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_case_type_prop_val".
 *
 * @property string $id
 * @property string $prop_id
 * @property string $prop_value
 *
 * @property VipCaseTypeProp $prop
 */
class VipCaseTypePropVal extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_case_type_prop_val';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'prop_id', 'prop_value'], 'required'],
            [['id', 'prop_id'], 'integer'],
            [['prop_value'], 'string', 'max' => 50],
            [['prop_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipCaseTypeProp::className(), 'targetAttribute' => ['prop_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'prop_id' => Yii::t('app', '对应属性编号'),
            'prop_value' => Yii::t('app', '对应属性值'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProp()
    {
        return $this->hasOne(VipCaseTypeProp::className(), ['id' => 'prop_id']);
    }
}
