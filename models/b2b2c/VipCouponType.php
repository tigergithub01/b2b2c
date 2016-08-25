<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_coupon_type".
 *
 * @property string $id
 * @property string $name
 * @property string $type_money
 * @property string $send_type
 * @property string $min_amount
 * @property string $max_amount
 * @property string $send_start_date
 * @property string $send_end_date
 * @property string $use_start_date
 * @property string $use_end_date
 * @property string $organization_id
 *
 * @property VipCoupon[] $vipCoupons
 * @property SysParameter $sendType
 * @property VipOrganization $organization
 */
class VipCouponType extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_coupon_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'organization_id'], 'required'],
            [['type_money', 'min_amount', 'max_amount'], 'number'],
            [['send_type', 'organization_id'], 'integer'],
            [['send_start_date', 'send_end_date', 'use_start_date', 'use_end_date'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['send_type'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['send_type' => 'id']],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipOrganization::className(), 'targetAttribute' => ['organization_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'name' => Yii::t('app', '优惠券名称'),
            'type_money' => Yii::t('app', '优惠券金额'),
            'send_type' => Yii::t('app', '优惠券发送方式（按用户发放，按商品发放，按订单金额发放，线下发放的红包，注册送红包）'),
            'min_amount' => Yii::t('app', '最小订单金额（只有商品总金额达到这个数的订单才能使用这种优惠券）'),
            'max_amount' => Yii::t('app', '订单下限（只要订单金额达到该数值，就会发放红包给用户） - 针对按订单发放'),
            'send_start_date' => Yii::t('app', '发放起始日期(只有当前时间介于起始日期和截止日期之间时，此类型的红包才可以发放) - 只针对按商品发放,按订单金额发放,注册送红包'),
            'send_end_date' => Yii::t('app', '发放结束日期'),
            'use_start_date' => Yii::t('app', '使用起始日期（只有当前时间介于起始日期和截止日期之间时，此类型的红包才可以使用）'),
            'use_end_date' => Yii::t('app', '使用结束日期'),
            'organization_id' => Yii::t('app', '关联机构编号'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipCoupons()
    {
        return $this->hasMany(VipCoupon::className(), ['coupon_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSendType()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'send_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(VipOrganization::className(), ['id' => 'organization_id']);
    }
}
