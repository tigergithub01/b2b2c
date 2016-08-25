<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_coupon_log".
 *
 * @property string $id
 * @property string $coupon_id
 * @property string $order_id
 * @property string $used_amount
 * @property string $use_time
 * @property string $use_desc
 *
 * @property SoSheet $order
 * @property VipCoupon $coupon
 */
class VipCouponLog extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_coupon_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['coupon_id', 'order_id', 'used_amount', 'use_time', 'use_desc'], 'required'],
            [['coupon_id', 'order_id'], 'integer'],
            [['used_amount'], 'number'],
            [['use_time'], 'safe'],
            [['use_desc'], 'string', 'max' => 255],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => SoSheet::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['coupon_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipCoupon::className(), 'targetAttribute' => ['coupon_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'coupon_id' => Yii::t('app', '关联优惠券编号'),
            'order_id' => Yii::t('app', '使用订单'),
            'used_amount' => Yii::t('app', '使用金额，退还金额'),
            'use_time' => Yii::t('app', '发生时间'),
            'use_desc' => Yii::t('app', '发生描述'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(SoSheet::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoupon()
    {
        return $this->hasOne(VipCoupon::className(), ['id' => 'coupon_id']);
    }
}
