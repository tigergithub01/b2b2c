<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_product_type".
 *
 * @property string $id
 * @property string $name
 * @property string $parent_id
 * @property string $description
 *
 * @property ActScope[] $actScopes
 * @property Product[] $products
 * @property ProductType $parent
 * @property ProductType[] $productTypes
 * @property ProductTypeProp[] $productTypeProps
 */
class ProductType extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_product_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 60],
            [['description'], 'string', 'max' => 600],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductType::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'name' => Yii::t('app', '分类名称'),
            'parent_id' => Yii::t('app', '上级分类编号'),
            'description' => Yii::t('app', '分类描述'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActScopes()
    {
        return $this->hasMany(ActScope::className(), ['product_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ProductType::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTypes()
    {
        return $this->hasMany(ProductType::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTypeProps()
    {
        return $this->hasMany(ProductTypeProp::className(), ['product_type_id' => 'id']);
    }
}
