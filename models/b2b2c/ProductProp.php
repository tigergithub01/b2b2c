<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_product_prop".
 *
 * @property string $id
 * @property string $product_id
 * @property string $prop_id
 * @property string $prop_val
 * @property string $prop_input_val
 *
 * @property ProductProdSaleProp[] $productProdSaleProps
 * @property Product $product
 * @property ProductTypeProp $prop
 * @property ProductTypePropVal $propVal
 */
class ProductProp extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_product_prop';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'prop_id', 'prop_val'], 'required'],
            [['product_id', 'prop_id', 'prop_val'], 'integer'],
            [['prop_input_val'], 'string', 'max' => 50],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['prop_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductTypeProp::className(), 'targetAttribute' => ['prop_id' => 'id']],
            [['prop_val'], 'exist', 'skipOnError' => true, 'targetClass' => ProductTypePropVal::className(), 'targetAttribute' => ['prop_val' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'product_id' => Yii::t('app', '产品编号'),
            'prop_id' => Yii::t('app', '属性编号'),
            'prop_val' => Yii::t('app', '属性值'),
            'prop_input_val' => Yii::t('app', '属性输入值'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductProdSaleProps()
    {
        return $this->hasMany(ProductProdSaleProp::className(), ['prop_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProp()
    {
        return $this->hasOne(ProductTypeProp::className(), ['id' => 'prop_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropVal()
    {
        return $this->hasOne(ProductTypePropVal::className(), ['id' => 'prop_val']);
    }
}
