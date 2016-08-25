<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_so_sheet_coupon".
 *
 * @property string $id
 * @property string $order_id
 * @property string $coupon_id
 *
 * @property VipCoupon $coupon
 * @property SoSheet $order
 */
class SoSheetCoupon extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_so_sheet_coupon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'coupon_id'], 'required'],
            [['order_id', 'coupon_id'], 'integer'],
            [['coupon_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipCoupon::className(), 'targetAttribute' => ['coupon_id' => 'id']],
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
            'order_id' => Yii::t('app', '订单编号'),
            'coupon_id' => Yii::t('app', '红包编号'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoupon()
    {
        return $this->hasOne(VipCoupon::className(), ['id' => 'coupon_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(SoSheet::className(), ['id' => 'order_id']);
    }
}
