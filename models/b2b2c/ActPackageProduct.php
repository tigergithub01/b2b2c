<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_act_package_product".
 *
 * @property string $id
 * @property string $act_id
 * @property string $product_id
 * @property string $sale_price
 * @property string $package_price
 * @property integer $quantity
 *
 * @property Product $product
 * @property Activity $act
 * @property Product $product0
 */
class ActPackageProduct extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_act_package_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['act_id', 'product_id', 'sale_price', 'package_price', 'quantity'], 'required'],
            [['act_id', 'product_id', 'quantity'], 'integer'],
            [['sale_price', 'package_price'], 'number'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['act_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['act_id' => 'id']],
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
            'act_id' => Yii::t('app', '关联活动编号'),
            'product_id' => Yii::t('app', '关联产品编号'),
            'sale_price' => Yii::t('app', '原价'),
            'package_price' => Yii::t('app', '套装价'),
            'quantity' => Yii::t('app', '数量'),
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
    public function getAct()
    {
        return $this->hasOne(Activity::className(), ['id' => 'act_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct0()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
