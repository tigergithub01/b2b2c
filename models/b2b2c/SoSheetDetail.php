<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_so_sheet_detail".
 *
 * @property string $id
 * @property string $order_id
 * @property string $product_id
 * @property integer $quantity
 * @property string $price
 * @property string $amount
 * @property string $package_id
 *
 * @property Product $product
 * @property SoSheet $order
 * @property Activity $package
 */
class SoSheetDetail extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_so_sheet_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'product_id', 'quantity', 'price', 'amount'], 'required'],
            [['id', 'order_id', 'product_id', 'quantity', 'package_id'], 'integer'],
            [['price', 'amount'], 'number'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => SoSheet::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['package_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'order_id' => Yii::t('app', '关联订单编号'),
            'product_id' => Yii::t('app', '关联产品编号'),
            'quantity' => Yii::t('app', '购买数量'),
            'price' => Yii::t('app', '单价'),
            'amount' => Yii::t('app', '金额'),
            'package_id' => Yii::t('app', '套餐编号'),
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
    public function getOrder()
    {
        return $this->hasOne(SoSheet::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(Activity::className(), ['id' => 'package_id']);
    }
}
