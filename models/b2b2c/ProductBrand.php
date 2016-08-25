<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_product_brand".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $brand_logo
 *
 * @property ActScope[] $actScopes
 * @property Product[] $products
 */
class ProductBrand extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_product_brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 30],
            [['description', 'brand_logo'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'name' => Yii::t('app', '品牌名称'),
            'description' => Yii::t('app', '品牌描述'),
            'brand_logo' => Yii::t('app', '品牌logo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActScopes()
    {
        return $this->hasMany(ActScope::className(), ['brand_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['brand_id' => 'id']);
    }
}
