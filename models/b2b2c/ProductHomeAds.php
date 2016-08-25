<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_product_home_ads".
 *
 * @property string $id
 * @property string $product_id
 * @property string $sequence_id
 *
 * @property Product $product
 */
class ProductHomeAds extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_product_home_ads';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'sequence_id'], 'required'],
            [['product_id', 'sequence_id'], 'integer'],
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
            'product_id' => Yii::t('app', '关联产品编号'),
            'sequence_id' => Yii::t('app', '序号'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
