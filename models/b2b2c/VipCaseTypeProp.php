<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_case_type_prop".
 *
 * @property string $id
 * @property string $case_type_id
 * @property string $prop_name
 * @property string $is_required
 * @property string $input_type
 * @property string $multi_select
 *
 * @property SysParameter $isRequired
 * @property SysParameter $inputType
 * @property SysParameter $multiSelect
 * @property VipCaseType $caseType
 * @property VipCaseTypePropVal[] $vipCaseTypePropVals
 */
class VipCaseTypeProp extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_case_type_prop';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['case_type_id', 'prop_name', 'is_required', 'multi_select'], 'required'],
            [['case_type_id', 'is_required', 'input_type', 'multi_select'], 'integer'],
            [['prop_name'], 'string', 'max' => 60],
            [['is_required'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['is_required' => 'id']],
            [['input_type'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['input_type' => 'id']],
            [['multi_select'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['multi_select' => 'id']],
            [['case_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipCaseType::className(), 'targetAttribute' => ['case_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'case_type_id' => Yii::t('app', '案例类别编号'),
            'prop_name' => Yii::t('app', '属性名称'),
            'is_required' => Yii::t('app', '是否必填项？1：是；0：否'),
            'input_type' => Yii::t('app', '录入类型：输入，从列表中选取，日期选择'),
            'multi_select' => Yii::t('app', '是否可以多选？1：是，0：否'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIsRequired()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'is_required']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputType()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'input_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMultiSelect()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'multi_select']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaseType()
    {
        return $this->hasOne(VipCaseType::className(), ['id' => 'case_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipCaseTypePropVals()
    {
        return $this->hasMany(VipCaseTypePropVal::className(), ['prop_id' => 'id']);
    }
}
