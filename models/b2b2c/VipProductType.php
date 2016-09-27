<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_product_type".
 *
 * @property string $id
 * @property string $product_type_id
 * @property string $vip_type_id
 * @property string $vip_id
 *
 * @property Vip $vip
 * @property VipType $vipType
 * @property ProductType $productType
 */
class VipProductType extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_product_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_type_id', 'vip_type_id'], 'required'],
            [['product_type_id', 'vip_type_id', 'vip_id'], 'integer'],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['vip_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipType::className(), 'targetAttribute' => ['vip_type_id' => 'id']],
            [['product_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductType::className(), 'targetAttribute' => ['product_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'product_type_id' => Yii::t('app', '关联产品分类'),
            'vip_type_id' => Yii::t('app', '关联商家类别'),
            'vip_id' => Yii::t('app', '关联会员编号（用于会员直接关联商品分类，待用）'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVip()
    {
        return $this->hasOne(Vip::className(), ['id' => 'vip_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipType()
    {
        return $this->hasOne(VipType::className(), ['id' => 'vip_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductType()
    {
        return $this->hasOne(ProductType::className(), ['id' => 'product_type_id']);
    }
}
