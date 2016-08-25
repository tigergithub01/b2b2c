<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_act_buy_discount".
 *
 * @property string $id
 * @property string $act_id
 * @property string $buy_amount
 * @property string $discount
 * @property string $is_double
 * @property string $max_discount
 *
 * @property Activity $act
 * @property SysParameter $isDouble
 */
class ActBuyDiscount extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_act_buy_discount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['act_id', 'buy_amount', 'discount', 'is_double', 'max_discount'], 'required'],
            [['act_id', 'is_double'], 'integer'],
            [['buy_amount', 'discount', 'max_discount'], 'number'],
            [['act_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['act_id' => 'id']],
            [['is_double'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['is_double' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'act_id' => Yii::t('app', '关联买赠主产品信息'),
            'buy_amount' => Yii::t('app', '购买金额'),
            'discount' => Yii::t('app', '折扣金额，折扣率'),
            'is_double' => Yii::t('app', '是否按倍数折扣'),
            'max_discount' => Yii::t('app', '最大折扣金额，折扣率'),
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
    public function getIsDouble()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'is_double']);
    }
}
