<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_act_exchange_product".
 *
 * @property string $id
 * @property string $product_id
 * @property integer $exchange_integral
 * @property string $is_exchange
 *
 * @property Product $product
 * @property SysParameter $isExchange
 */
class ActExchangeProduct extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_act_exchange_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'exchange_integral', 'is_exchange'], 'required'],
            [['product_id', 'exchange_integral', 'is_exchange'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['is_exchange'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['is_exchange' => 'id']],
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
            'exchange_integral' => Yii::t('app', '可使用积分数'),
            'is_exchange' => Yii::t('app', '是否可以兑换'),
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
    public function getIsExchange()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'is_exchange']);
    }
}
