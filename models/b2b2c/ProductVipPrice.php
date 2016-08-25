<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_product_vip_price".
 *
 * @property string $id
 * @property string $product_id
 * @property string $vip_rank_id
 * @property string $price
 *
 * @property VipRank $vipRank
 * @property Product $product
 */
class ProductVipPrice extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_product_vip_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'vip_rank_id', 'price'], 'required'],
            [['product_id', 'vip_rank_id'], 'integer'],
            [['price'], 'number'],
            [['vip_rank_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipRank::className(), 'targetAttribute' => ['vip_rank_id' => 'id']],
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
            'product_id' => Yii::t('app', '产品编号'),
            'vip_rank_id' => Yii::t('app', '会员等级'),
            'price' => Yii::t('app', '价格'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipRank()
    {
        return $this->hasOne(VipRank::className(), ['id' => 'vip_rank_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
