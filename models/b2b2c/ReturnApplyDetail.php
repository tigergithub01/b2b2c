<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_return_apply_detail".
 *
 * @property string $id
 * @property string $return_apply_id
 * @property string $product_id
 * @property integer $quantity
 *
 * @property ReturnApply $returnApply
 * @property Product $product
 */
class ReturnApplyDetail extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_return_apply_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['return_apply_id', 'product_id', 'quantity'], 'required'],
            [['return_apply_id', 'product_id', 'quantity'], 'integer'],
            [['return_apply_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReturnApply::className(), 'targetAttribute' => ['return_apply_id' => 'id']],
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
            'return_apply_id' => Yii::t('app', '退换货申请编号'),
            'product_id' => Yii::t('app', '退换货产品编号'),
            'quantity' => Yii::t('app', '申请退换货数量'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReturnApply()
    {
        return $this->hasOne(ReturnApply::className(), ['id' => 'return_apply_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
