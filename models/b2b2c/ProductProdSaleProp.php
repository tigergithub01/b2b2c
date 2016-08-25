<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_product_prod_sale_prop".
 *
 * @property string $id
 * @property string $attr_group_id
 * @property string $prop_id
 *
 * @property ProductProp $prop
 * @property ProductProdSale $attrGroup
 */
class ProductProdSaleProp extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_product_prod_sale_prop';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attr_group_id', 'prop_id'], 'required'],
            [['attr_group_id', 'prop_id'], 'integer'],
            [['prop_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductProp::className(), 'targetAttribute' => ['prop_id' => 'id']],
            [['attr_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductProdSale::className(), 'targetAttribute' => ['attr_group_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'attr_group_id' => Yii::t('app', '销售属性产品编号'),
            'prop_id' => Yii::t('app', '商品属性编号'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProp()
    {
        return $this->hasOne(ProductProp::className(), ['id' => 'prop_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttrGroup()
    {
        return $this->hasOne(ProductProdSale::className(), ['id' => 'attr_group_id']);
    }
}
