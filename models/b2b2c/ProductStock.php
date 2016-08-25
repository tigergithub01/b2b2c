<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_product_stock".
 *
 * @property string $id
 * @property string $warehouse_id
 * @property string $product_id
 * @property string $stock_quantity
 *
 * @property Product $product
 * @property SysWarehouse $warehouse
 */
class ProductStock extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_product_stock';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['warehouse_id', 'product_id', 'stock_quantity'], 'required'],
            [['warehouse_id', 'product_id'], 'integer'],
            [['stock_quantity'], 'number'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['warehouse_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysWarehouse::className(), 'targetAttribute' => ['warehouse_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'warehouse_id' => Yii::t('app', '关联仓库'),
            'product_id' => Yii::t('app', '关联产品编号'),
            'stock_quantity' => Yii::t('app', '仓库库存'),
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
    public function getWarehouse()
    {
        return $this->hasOne(SysWarehouse::className(), ['id' => 'warehouse_id']);
    }
}
