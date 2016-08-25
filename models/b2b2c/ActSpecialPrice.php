<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_act_special_price".
 *
 * @property string $id
 * @property string $act_id
 * @property string $product_id
 * @property string $sale_price
 * @property string $special_price
 * @property integer $buy_limit_num
 *
 * @property Activity $act
 * @property Product $product
 */
class ActSpecialPrice extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_act_special_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['act_id', 'product_id', 'sale_price', 'special_price', 'buy_limit_num'], 'required'],
            [['act_id', 'product_id', 'buy_limit_num'], 'integer'],
            [['sale_price', 'special_price'], 'number'],
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
            'special_price' => Yii::t('app', '特价'),
            'buy_limit_num' => Yii::t('app', '限购数量'),
        ];
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
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
