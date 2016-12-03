<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_cart".
 *
 * @property string $id
 * @property string $vip_id
 * @property string $product_id
 * @property string $package_id
 * @property integer $quantity
 * @property string $price
 * @property string $checked
 *
 * @property Vip $vip
 * @property Activity $package
 * @property Product $product
 */
class VipCart extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_cart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vip_id', 'quantity', 'price', 'checked'], 'required'],
            [['vip_id', 'product_id', 'package_id', 'quantity', 'checked'], 'integer'],
            [['price'], 'number'],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['package_id' => 'id']],
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
            'vip_id' => Yii::t('app', '会员编号'),
            'product_id' => Yii::t('app', '关联产品编号'),
            'package_id' => Yii::t('app', '关联团体服务编号'),
            'quantity' => Yii::t('app', '数量'),
            'price' => Yii::t('app', '单价'),
            'checked' => Yii::t('app', '是否选中？1：是；0：否'),
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
    public function getPackage()
    {
        return $this->hasOne(Activity::className(), ['id' => 'package_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
