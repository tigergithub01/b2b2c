<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_shopping_cart".
 *
 * @property string $id
 * @property string $session_id
 * @property string $vip_id
 * @property string $product_id
 * @property string $package_id
 * @property integer $quantity
 * @property string $price
 * @property string $is_checked
 * @property string $create_date
 * @property string $update_date
 * @property string $is_gift
 * @property string $parent_id
 *
 * @property SysParameter $isGift
 * @property Activity $package
 * @property Vip $vip
 * @property ShoppingCart $parent
 * @property ShoppingCart[] $shoppingCarts
 * @property Product $product
 * @property SysParameter $isChecked
 */
class ShoppingCart extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_shopping_cart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['session_id', 'quantity', 'create_date', 'is_gift'], 'required'],
            [['vip_id', 'product_id', 'package_id', 'quantity', 'is_checked', 'is_gift', 'parent_id'], 'integer'],
            [['price'], 'number'],
            [['create_date', 'update_date'], 'safe'],
            [['session_id'], 'string', 'max' => 32],
            [['is_gift'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['is_gift' => 'id']],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['package_id' => 'id']],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShoppingCart::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['is_checked'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['is_checked' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'session_id' => Yii::t('app', '会话编号'),
            'vip_id' => Yii::t('app', '会员编号'),
            'product_id' => Yii::t('app', '关联产品编号'),
            'package_id' => Yii::t('app', '关联套餐编号'),
            'quantity' => Yii::t('app', '购买数量'),
            'price' => Yii::t('app', '单价'),
            'is_checked' => Yii::t('app', '是否选中'),
            'create_date' => Yii::t('app', '创建日期'),
            'update_date' => Yii::t('app', '修改日期'),
            'is_gift' => Yii::t('app', '是否赠品'),
            'parent_id' => Yii::t('app', '赠品对应的原品'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIsGift()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'is_gift']);
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
    public function getVip()
    {
        return $this->hasOne(Vip::className(), ['id' => 'vip_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ShoppingCart::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShoppingCarts()
    {
        return $this->hasMany(ShoppingCart::className(), ['parent_id' => 'id']);
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
    public function getIsChecked()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'is_checked']);
    }
}
