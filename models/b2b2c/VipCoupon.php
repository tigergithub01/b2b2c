<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_coupon".
 *
 * @property string $id
 * @property string $coupon_type_id
 * @property string $vip_id
 * @property string $coupon_sn
 * @property string $used_time
 * @property string $used_amount
 * @property string $order_id
 *
 * @property SoSheetCoupon[] $soSheetCoupons
 * @property Vip $vip
 * @property VipCouponType $couponType
 * @property SoSheet $order
 * @property VipCouponLog[] $vipCouponLogs
 */
class VipCoupon extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_coupon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['coupon_type_id', 'vip_id', 'coupon_sn', 'used_amount'], 'required'],
            [['coupon_type_id', 'vip_id', 'order_id'], 'integer'],
            [['used_time'], 'safe'],
            [['used_amount'], 'number'],
            [['coupon_sn'], 'string', 'max' => 20],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['coupon_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipCouponType::className(), 'targetAttribute' => ['coupon_type_id' => 'id']],
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
            'coupon_type_id' => Yii::t('app', '优惠券类型'),
            'vip_id' => Yii::t('app', '所属会员'),
            'coupon_sn' => Yii::t('app', '优惠券编号'),
            'used_time' => Yii::t('app', '使用时间'),
            'used_amount' => Yii::t('app', '已使用金额'),
            'order_id' => Yii::t('app', '关联订单编号'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheetCoupons()
    {
        return $this->hasMany(SoSheetCoupon::className(), ['coupon_id' => 'id']);
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
    public function getCouponType()
    {
        return $this->hasOne(VipCouponType::className(), ['id' => 'coupon_type_id']);
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
    public function getVipCouponLogs()
    {
        return $this->hasMany(VipCouponLog::className(), ['coupon_id' => 'id']);
    }
}
