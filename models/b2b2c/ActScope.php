<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_act_scope".
 *
 * @property string $id
 * @property string $act_id
 * @property string $brand_id
 * @property string $product_id
 * @property string $product_type_id
 *
 * @property ProductType $productType
 * @property Activity $act
 * @property ProductBrand $brand
 * @property Product $product
 */
class ActScope extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_act_scope';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['act_id'], 'required'],
            [['act_id', 'brand_id', 'product_id', 'product_type_id'], 'integer'],
            [['product_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductType::className(), 'targetAttribute' => ['product_type_id' => 'id']],
            [['act_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['act_id' => 'id']],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductBrand::className(), 'targetAttribute' => ['brand_id' => 'id']],
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
            'brand_id' => Yii::t('app', '关联品牌编号'),
            'product_id' => Yii::t('app', '关联产品编号'),
            'product_type_id' => Yii::t('app', '关联产品分类编号'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductType()
    {
        return $this->hasOne(ProductType::className(), ['id' => 'product_type_id']);
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
    public function getBrand()
    {
        return $this->hasOne(ProductBrand::className(), ['id' => 'brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
