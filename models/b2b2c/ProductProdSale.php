<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_product_prod_sale".
 *
 * @property string $id
 * @property string $product_id
 * @property string $sale_price
 * @property string $stock_quantity
 *
 * @property Product $product
 * @property ProductProdSaleProp[] $productProdSaleProps
 */
class ProductProdSale extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_product_prod_sale';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'sale_price', 'stock_quantity'], 'required'],
            [['product_id'], 'integer'],
            [['sale_price', 'stock_quantity'], 'number'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'product_id' => Yii::t('app', '商品编号'),
            'sale_price' => Yii::t('app', '批发价'),
            'stock_quantity' => Yii::t('app', '库存'),
        ];
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
    public function getProductProdSaleProps()
    {
        return $this->hasMany(ProductProdSaleProp::className(), ['attr_group_id' => 'id']);
    }
}
