<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_return_sheet_detail".
 *
 * @property string $id
 * @property string $return_id
 * @property string $product_id
 * @property integer $out_quantity
 * @property integer $return_quantity
 *
 * @property ReturnSheet $return
 * @property Product $product
 */
class ReturnSheetDetail extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_return_sheet_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['return_id', 'product_id'], 'required'],
            [['return_id', 'product_id', 'out_quantity', 'return_quantity'], 'integer'],
            [['return_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReturnSheet::className(), 'targetAttribute' => ['return_id' => 'id']],
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
            'return_id' => Yii::t('app', '关联退货单编号'),
            'product_id' => Yii::t('app', '关联产品编号'),
            'out_quantity' => Yii::t('app', '发货数量'),
            'return_quantity' => Yii::t('app', '本次退货数量'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReturn()
    {
        return $this->hasOne(ReturnSheet::className(), ['id' => 'return_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
