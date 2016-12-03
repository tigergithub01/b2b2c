<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_quotation_detail".
 *
 * @property string $id
 * @property string $quotation_id
 * @property string $product_id
 * @property integer $quantity
 * @property string $price
 * @property string $amount
 *
 * @property Product $product
 * @property Quotation $quotation
 */
class QuotationDetail extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_quotation_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quotation_id', 'product_id', 'quantity', 'price'], 'integer'],
            [['quotation_id', 'product_id', 'quantity', 'price'], 'required'],
            [['price', 'amount'], 'number'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['quotation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quotation::className(), 'targetAttribute' => ['quotation_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'quotation_id' => Yii::t('app', '关联报价单编号'),
            'product_id' => Yii::t('app', '关联产品编号'),
            'quantity' => Yii::t('app', '购买数量'),
            'price' => Yii::t('app', '单价'),
            'amount' => Yii::t('app', '金额'),
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
    public function getQuotation()
    {
        return $this->hasOne(Quotation::className(), ['id' => 'quotation_id']);
    }
}
