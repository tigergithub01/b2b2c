<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_out_stock_sheet_detail".
 *
 * @property string $id
 * @property string $out_stock_id
 * @property string $product_id
 * @property integer $order_quantity
 * @property integer $out_quantity
 *
 * @property OutStockSheet $outStock
 * @property Product $product
 */
class OutStockSheetDetail extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_out_stock_sheet_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['out_stock_id', 'product_id'], 'required'],
            [['out_stock_id', 'product_id', 'order_quantity', 'out_quantity'], 'integer'],
            [['out_stock_id'], 'exist', 'skipOnError' => true, 'targetClass' => OutStockSheet::className(), 'targetAttribute' => ['out_stock_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'out_stock_id' => Yii::t('app', '关联发货单编号'),
            'product_id' => Yii::t('app', '关联产品编号'),
            'order_quantity' => Yii::t('app', '订单数量'),
            'out_quantity' => Yii::t('app', '本次发货数量'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutStock()
    {
        return $this->hasOne(OutStockSheet::className(), ['id' => 'out_stock_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
