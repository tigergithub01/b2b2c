<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_so_sheet".
 *
 * @property string $id
 * @property string $sheet_type_id
 * @property string $code
 * @property string $vip_id
 * @property string $order_amt
 * @property integer $order_quantity
 * @property string $goods_amt
 * @property string $deliver_fee
 * @property string $order_date
 * @property string $delivery_date
 * @property string $delivery_type
 * @property string $pay_type_id
 * @property string $pay_date
 * @property string $delivery_no
 * @property string $pick_point_id
 * @property string $paid_amt
 * @property string $integral
 * @property string $integral_money
 * @property string $coupon
 * @property string $discount
 * @property string $return_amt
 * @property string $return_date
 * @property string $memo
 * @property string $message
 * @property string $order_status
 * @property string $delivery_status
 * @property string $pay_status
 * @property string $consignee
 * @property string $country_id
 * @property string $province_id
 * @property string $city_id
 * @property string $district_id
 * @property string $mobile
 * @property string $detail_address
 * @property string $invoice_type
 * @property string $invoice_header
 * @property string $service_date
 * @property string $budget_amount
 * @property string $related_service
 * @property string $service_style
 *
 * @property OutStockSheet[] $outStockSheets
 * @property RefundSheet[] $refundSheets
 * @property RefundSheetApply[] $refundSheetApplies
 * @property ReturnApply[] $returnApplies
 * @property ReturnSheet[] $returnSheets
 * @property Vip $vip
 * @property SysRegion $city
 * @property SysRegion $country
 * @property SysParameter $deliveryStatus
 * @property SysRegion $district
 * @property SysParameter $invoiceType
 * @property SysParameter $orderStatus
 * @property SysParameter $payStatus
 * @property SysRegion $province
 * @property DeliveryType $deliveryType
 * @property PayType $payType
 * @property PickUpPoint $pickPoint
 * @property SheetType $sheetType
 * @property SoSheetCoupon[] $soSheetCoupons
 * @property SoSheetDetail[] $soSheetDetails
 * @property SoSheetPayInfo[] $soSheetPayInfos
 * @property VipCoupon[] $vipCoupons
 * @property VipCouponLog[] $vipCouponLogs
 */
class SoSheet extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_so_sheet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sheet_type_id', 'code', 'vip_id', 'order_amt', 'order_quantity', 'goods_amt', 'deliver_fee', 'order_date', 'delivery_type', 'integral', 'integral_money', 'coupon', 'discount', 'order_status', 'delivery_status', 'pay_status', 'consignee', 'country_id', 'province_id', 'city_id', 'district_id', 'mobile', 'detail_address'], 'required'],
            [['sheet_type_id', 'vip_id', 'order_quantity', 'delivery_type', 'pay_type_id', 'pick_point_id', 'integral', 'order_status', 'delivery_status', 'pay_status', 'country_id', 'province_id', 'city_id', 'district_id', 'invoice_type'], 'integer'],
            [['order_amt', 'goods_amt', 'deliver_fee', 'paid_amt', 'integral_money', 'coupon', 'discount', 'return_amt', 'budget_amount'], 'number'],
            [['order_date', 'delivery_date', 'pay_date', 'return_date', 'service_date'], 'safe'],
            [['code', 'consignee'], 'string', 'max' => 30],
            [['delivery_no', 'invoice_header', 'related_service', 'service_style'], 'string', 'max' => 60],
            [['memo'], 'string', 'max' => 400],
            [['message'], 'string', 'max' => 300],
            [['mobile'], 'string', 'max' => 20],
            [['detail_address'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysRegion::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysRegion::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['delivery_status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['delivery_status' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysRegion::className(), 'targetAttribute' => ['district_id' => 'id']],
            [['invoice_type'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['invoice_type' => 'id']],
            [['order_status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['order_status' => 'id']],
            [['pay_status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['pay_status' => 'id']],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysRegion::className(), 'targetAttribute' => ['province_id' => 'id']],
            [['delivery_type'], 'exist', 'skipOnError' => true, 'targetClass' => DeliveryType::className(), 'targetAttribute' => ['delivery_type' => 'id']],
            [['pay_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PayType::className(), 'targetAttribute' => ['pay_type_id' => 'id']],
            [['pick_point_id'], 'exist', 'skipOnError' => true, 'targetClass' => PickUpPoint::className(), 'targetAttribute' => ['pick_point_id' => 'id']],
            [['sheet_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => SheetType::className(), 'targetAttribute' => ['sheet_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'sheet_type_id' => Yii::t('app', '单据类型（普通订单，定制订单）'),
            'code' => Yii::t('app', '订单编号(so-年月日-顺序号，根据单据设置进行生成)'),
            'vip_id' => Yii::t('app', '会员编号'),
            'order_amt' => Yii::t('app', '订单待支付费用'),
            'order_quantity' => Yii::t('app', '产品数量（所有商品数量汇总）'),
            'goods_amt' => Yii::t('app', '商品总金额'),
            'deliver_fee' => Yii::t('app', '运费'),
            'order_date' => Yii::t('app', '订单提交日期'),
            'delivery_date' => Yii::t('app', '发货日期'),
            'delivery_type' => Yii::t('app', '配送方式'),
            'pay_type_id' => Yii::t('app', '支付方式'),
            'pay_date' => Yii::t('app', '付款日期'),
            'delivery_no' => Yii::t('app', '快递单号'),
            'pick_point_id' => Yii::t('app', '自提点'),
            'paid_amt' => Yii::t('app', '已付款金额'),
            'integral' => Yii::t('app', '消耗积分'),
            'integral_money' => Yii::t('app', '积分折合金额'),
            'coupon' => Yii::t('app', '优惠券消耗金额'),
            'discount' => Yii::t('app', '折扣费用'),
            'return_amt' => Yii::t('app', '退款金额'),
            'return_date' => Yii::t('app', '退款日期'),
            'memo' => Yii::t('app', '备注'),
            'message' => Yii::t('app', '买家留言'),
            'order_status' => Yii::t('app', '订单状态（普通订单：待付款，待接单，待服务，[客户付尾款，商户确认服务完成]交易完成，待评价[交易完成可评价])  定制订单：待确定，待付款，待接单，待服务，[客户付尾款，商户确认服务完成]交易完成，待评价[交易完成可评价]）'),
            'delivery_status' => Yii::t('app', '配送状态'),
            'pay_status' => Yii::t('app', '支付状态'),
            'consignee' => Yii::t('app', '收货人'),
            'country_id' => Yii::t('app', '国家'),
            'province_id' => Yii::t('app', '省份'),
            'city_id' => Yii::t('app', '城市'),
            'district_id' => Yii::t('app', '区域街道'),
            'mobile' => Yii::t('app', '联系手机号码'),
            'detail_address' => Yii::t('app', '详细地址'),
            'invoice_type' => Yii::t('app', '发票类型（电子发票，纸质发票)'),
            'invoice_header' => Yii::t('app', '发票抬头名称'),
            'service_date' => Yii::t('app', '服务时间(婚礼)'),
            'budget_amount' => Yii::t('app', '婚礼预算'),
            'related_service' => Yii::t('app', '需要人员（多选）（婚礼策划师，摄影师，摄像师，化妆师，主持人）'),
            'service_style' => Yii::t('app', '婚礼样式（多选）（浪漫，简约）'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutStockSheets()
    {
        return $this->hasMany(OutStockSheet::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundSheets()
    {
        return $this->hasMany(RefundSheet::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundSheetApplies()
    {
        return $this->hasMany(RefundSheetApply::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReturnApplies()
    {
        return $this->hasMany(ReturnApply::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReturnSheets()
    {
        return $this->hasMany(ReturnSheet::className(), ['order_id' => 'id']);
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
    public function getCity()
    {
        return $this->hasOne(SysRegion::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(SysRegion::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveryStatus()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'delivery_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(SysRegion::className(), ['id' => 'district_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceType()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'invoice_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderStatus()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'order_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayStatus()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'pay_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(SysRegion::className(), ['id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveryType()
    {
        return $this->hasOne(DeliveryType::className(), ['id' => 'delivery_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayType()
    {
        return $this->hasOne(PayType::className(), ['id' => 'pay_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPickPoint()
    {
        return $this->hasOne(PickUpPoint::className(), ['id' => 'pick_point_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSheetType()
    {
        return $this->hasOne(SheetType::className(), ['id' => 'sheet_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheetCoupons()
    {
        return $this->hasMany(SoSheetCoupon::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheetDetails()
    {
        return $this->hasMany(SoSheetDetail::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheetPayInfos()
    {
        return $this->hasMany(SoSheetPayInfo::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipCoupons()
    {
        return $this->hasMany(VipCoupon::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipCouponLogs()
    {
        return $this->hasMany(VipCouponLog::className(), ['order_id' => 'id']);
    }
}