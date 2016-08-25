<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_act_buy_giving_detail".
 *
 * @property string $id
 * @property string $act_id
 * @property string $buy_amount
 * @property integer $giving_number
 * @property string $is_double_give
 * @property string $giving_product_id
 * @property integer $max_give_number
 *
 * @property Product $givingProduct
 * @property SysParameter $isDoubleGive
 * @property Activity $act
 * @property ActBuyGivingDetailPkg[] $actBuyGivingDetailPkgs
 */
class ActBuyGivingDetail extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_act_buy_giving_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['act_id', 'buy_amount', 'giving_number', 'is_double_give', 'giving_product_id', 'max_give_number'], 'required'],
            [['act_id', 'giving_number', 'is_double_give', 'giving_product_id', 'max_give_number'], 'integer'],
            [['buy_amount'], 'number'],
            [['giving_product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['giving_product_id' => 'id']],
            [['is_double_give'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['is_double_give' => 'id']],
            [['act_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['act_id' => 'id']],
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
            'buy_amount' => Yii::t('app', '购买数量,购满金额'),
            'giving_number' => Yii::t('app', '赠送数量'),
            'is_double_give' => Yii::t('app', '是否按倍数赠送如买二赠一，买四赠二'),
            'giving_product_id' => Yii::t('app', '赠送商品编号'),
            'max_give_number' => Yii::t('app', '最大赠送数量'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGivingProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'giving_product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIsDoubleGive()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'is_double_give']);
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
    public function getActBuyGivingDetailPkgs()
    {
        return $this->hasMany(ActBuyGivingDetailPkg::className(), ['buy_giving_detail_id' => 'id']);
    }
}
