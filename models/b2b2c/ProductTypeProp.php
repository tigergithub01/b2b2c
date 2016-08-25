<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_product_type_prop".
 *
 * @property string $id
 * @property string $product_type_id
 * @property string $prop_name
 * @property string $is_sale_prop
 * @property string $is_required
 * @property string $input_type
 * @property string $multi_select
 *
 * @property ProductProp[] $productProps
 * @property ProductType $productType
 * @property SysParameter $inputType
 * @property SysParameter $multiSelect
 * @property SysParameter $isRequired
 * @property SysParameter $isSaleProp
 * @property ProductTypePropVal[] $productTypePropVals
 */
class ProductTypeProp extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_product_type_prop';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_type_id', 'prop_name', 'is_sale_prop', 'is_required', 'input_type', 'multi_select'], 'required'],
            [['product_type_id', 'is_sale_prop', 'is_required', 'input_type', 'multi_select'], 'integer'],
            [['prop_name'], 'string', 'max' => 60],
            [['product_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductType::className(), 'targetAttribute' => ['product_type_id' => 'id']],
            [['input_type'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['input_type' => 'id']],
            [['multi_select'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['multi_select' => 'id']],
            [['is_required'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['is_required' => 'id']],
            [['is_sale_prop'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['is_sale_prop' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'product_type_id' => Yii::t('app', '关联产品类别编号'),
            'prop_name' => Yii::t('app', '属性名称'),
            'is_sale_prop' => Yii::t('app', '是否销售属性?1:是；0：否'),
            'is_required' => Yii::t('app', '是否必填项？1：是；0：否'),
            'input_type' => Yii::t('app', '录入类型：输入，从列表中选取'),
            'multi_select' => Yii::t('app', '是否可以多选？1：是，0：否'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductProps()
    {
        return $this->hasMany(ProductProp::className(), ['prop_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductType()
    {
        return $this->hasOne(ProductType::className(), ['id' => 'product_type_id']);
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
    public function getIsRequired()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'is_required']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIsSaleProp()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'is_sale_prop']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTypePropVals()
    {
        return $this->hasMany(ProductTypePropVal::className(), ['prop_id' => 'id']);
    }
}
