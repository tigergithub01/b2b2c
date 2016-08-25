<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_so_sheet_pay_info".
 *
 * @property string $id
 * @property string $order_id
 * @property string $pay_amt
 * @property string $pay_date
 *
 * @property SoSheet $order
 */
class SoSheetPayInfo extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_so_sheet_pay_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'pay_amt', 'pay_date'], 'required'],
            [['order_id'], 'integer'],
            [['pay_amt'], 'number'],
            [['pay_date'], 'safe'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => SoSheet::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'order_id' => Yii::t('app', '关联订单编号'),
            'pay_amt' => Yii::t('app', '付款金额'),
            'pay_date' => Yii::t('app', '付款日期'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(SoSheet::className(), ['id' => 'order_id']);
    }
}
