<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_so_sheet".
 *
 * @property string $id
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
 * @property string $quotation_id
 * @property string $cancel_date
 * @property string $cancel_reason
 *
 * @property OutStockSheet[] $outStockSheets
 * @property ProductComment[] $productComments
 * @property RefundSheet[] $refundSheets
 * @property RefundSheetApply[] $refundSheetApplies
 * @property ReturnApply[] $returnApplies
 * @property ReturnSheet[] $returnSheets
 * @property Quotation $quotation
 * @property Vip $vip
 * @property SysRegion $city
 * @property SysRegion $country
 * @property SysParameter $deliveryStatus
 * @property SysRegion $district
 * @property SysParameter $invoiceType
 * @property SysParameter $orderStatus
 * @property SysParameter $payStatus
 * @property SysRegion $province
 * @property DeliveryTypeTpl $deliveryType
 * @property PayType $payType
 * @property PickUpPoint $pickPoint
 * @property SoSheetCoupon[] $soSheetCoupons
 * @property SoSheetDetail[] $soSheetDetails
 * @property SoSheetPayInfo[] $soSheetPayInfos
 * @property SoSheetVip[] $soSheetVips
 * @property VipCoupon[] $vipCoupons
 * @property VipCouponLog[] $vipCouponLogs
 * 
 */
class SoSheet extends \app\models\b2b2c\BasicModel
{
	/* 订单状态： */
// 	const order_need_confirm = 5001; // 待确认（定制订单需要此状态，普通订单不需要）
	const order_need_pay = 5002; // 待付款
	const order_cancelled = 5003; // 已取消 （用户未付款时直接取消）
	const order_need_schedule = 5004; // 待接单
	const order_need_service = 5005; // 待服务
	const order_need_refund = 5006; // 待退款 (用户申请退款，待接单与待服务状态都可以申请退款)
	const order_closed = 5007; // 已关闭 (已经退款给用户，订单关闭) 
	const order_completed = 5008; // 交易完成(客户付尾款，商户确认服务完成)
// 	const order_need_commented = 5009; // 待评价 (交易完成可评价)
	
	/* 付款状态： */
	const pay_need_pay = 6001; // 未付款
	const pay_part_pay = 6002; // 部分支付
	const pay_completed = 6003; // 已付款 
	
	/* 会员编号（查询用） */
	public $vip_no;
	
	/* 起始日期 （查询用） */
	public $start_date;
	
	/* 结束日期 （查询用） */
	public $end_date;
	
	/* 订单编号 （查询用） */
	public $order_code;
	
	/* 服务类别（多选）用来接收数据 */
	public $related_services;
	
	/* 服务类别，用来显示数据 */
	public $related_service_names;
	
	/* 商户编号-查询用 */
	public $query_merchant_id;
	
	/* 订单状态（显示）  */
// 	public $order_status_name;
	
	
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
    public function scenarios()
    {
    	// bypass scenarios() implementation in the parent class
    	$scenarios = parent::scenarios();
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'vip_no';
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'start_date';
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'end_date';
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'order_code';
//     	$scenarios[self::SCENARIO_DEFAULT][]  = 'related_services';
//     	$scenarios[self::SCENARIO_DEFAULT][]  = 'order_status_name';
    	
    	return $scenarios;
    	// 		return parent::scenarios();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'vip_id', 'order_amt', 'order_quantity', 'goods_amt', 'deliver_fee', 'order_date', /* 'delivery_type', */ 'integral', 'integral_money', 'coupon', 'discount', 'order_status', /* 'delivery_status', */ 'pay_status', 'consignee', 'mobile'], 'required'],
            [['vip_id', 'order_quantity', 'delivery_type', 'pay_type_id', 'pick_point_id', 'integral', 'order_status', 'delivery_status', 'pay_status', 'country_id', 'province_id', 'city_id', 'district_id', 'invoice_type', 'quotation_id'], 'integer'],
            [['order_amt', 'goods_amt', 'deliver_fee', 'paid_amt', 'integral_money', 'coupon', 'discount', 'return_amt'], 'number'],
            [['order_date', 'delivery_date', 'pay_date', 'return_date', 'service_date', 'cancel_date'], 'safe'],
            [['code', 'consignee'], 'string', 'max' => 30],
            [['delivery_no', 'invoice_header'], 'string', 'max' => 60],
            [['memo'], 'string', 'max' => 400],
            [['mobile'], 'string', 'max' => 20],
        	[['detail_address', 'cancel_reason'], 'string', 'max' => 255],
            [['detail_address'], 'string', 'max' => 255],
            [['code'], 'unique'],
        	[['quotation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quotation::className(), 'targetAttribute' => ['quotation_id' => 'id']],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysRegion::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysRegion::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['delivery_status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['delivery_status' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysRegion::className(), 'targetAttribute' => ['district_id' => 'id']],
            [['invoice_type'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['invoice_type' => 'id']],
            [['order_status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['order_status' => 'id']],
            [['pay_status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['pay_status' => 'id']],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysRegion::className(), 'targetAttribute' => ['province_id' => 'id']],
            [['delivery_type'], 'exist', 'skipOnError' => true, 'targetClass' => DeliveryTypeTpl::className(), 'targetAttribute' => ['delivery_type' => 'id']],
            [['pay_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PayType::className(), 'targetAttribute' => ['pay_type_id' => 'id']],
            [['pick_point_id'], 'exist', 'skipOnError' => true, 'targetClass' => PickUpPoint::className(), 'targetAttribute' => ['pick_point_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'code' => Yii::t('app', '订单编号'/* '订单编号(so-年月日-顺序号，根据单据设置进行生成)' */),
            'vip_id' => Yii::t('app', '会员编号'),
            'order_amt' => Yii::t('app', '待支付金额'),
            'order_quantity' => Yii::t('app', '产品数量（所有商品数量汇总）'),
            'goods_amt' => Yii::t('app', '订单总金额'),
            'deliver_fee' => Yii::t('app', '运费'),
            'order_date' => Yii::t('app', '订单日期'),
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
            'memo' => Yii::t('app', '买家留言'),
            'order_status' => Yii::t('app', '订单状态'/* '订单状态（普通订单：待付款，已取消[用户未付款时直接取消]，待接单，待服务，待退款[用户申请退款，待接单与待服务状态都可以申请退款]，已关闭[已经退款给用户，订单关闭],[客户付尾款，商户确认服务完成]交易完成，待评价[交易完成可评价])   定制订单：待确定[用户提交购买申请]，待付款，已取消[用户未付款时直接取消]，待接单，待服务，待退款[用户申请退款，待接单与待服务状态都可以申请退款]，[客户付尾款，商户确认服务完成]交易完成，待评价[交易完成可评价]）' */),
            'delivery_status' => Yii::t('app', '配送状态'),
            'pay_status' => Yii::t('app', '支付状态'),
            'consignee' => Yii::t('app', /* '收货人' */'婚礼人'),
            'country_id' => Yii::t('app', '国家'),
            'province_id' => Yii::t('app', '省份'),
            'city_id' => Yii::t('app', '城市'),
            'district_id' => Yii::t('app', '区域街道'),
            'mobile' => Yii::t('app', '联系手机号码'),
            'detail_address' => Yii::t('app', '详细地址'),
            'invoice_type' => Yii::t('app', '发票类型（电子发票，纸质发票)'),
            'invoice_header' => Yii::t('app', '发票抬头名称'),
            'service_date' => Yii::t('app', /* '服务时间(婚礼)' */'婚礼服务时间'),
        	'quotation_id' => Yii::t('app', /* '关联报价单编号' */'订单咨询编号'),
        	'cancel_date' => Yii::t('app', '订单取消日期'),
        	'cancel_reason' => Yii::t('app', '订单取消原因'),
        	'vip.vip_id' =>  Yii::t('app', '会员编号'),
        	'vip.vip_name' =>  Yii::t('app', '会员名称'),
        	'quotation.code' => Yii::t('app', '订单咨询编号'),
        		'city.name' =>  Yii::t('app', '城市'),
        		'country.name' =>  Yii::t('app', '国家'),
        		'deliveryStatus.param_val' =>  Yii::t('app', '配送状态'),
        		'district.name' =>  Yii::t('app', '区域街道'),
        		'invoiceType.param_val' =>  Yii::t('app', '发票类型'),
        		'orderStatus.param_val' =>  Yii::t('app', '订单状态'),
        		'payStatus.param_val' =>  Yii::t('app', '支付状态'),
        		'province.name' =>  Yii::t('app', '省份'),
        		'deliveryType.name' =>  Yii::t('app', '配送方式'),
        		'payType.name' =>  Yii::t('app', '支付方式'),
        		'pickPoint.name' =>  Yii::t('app', '自提点'),
        		'vip_no' => Yii::t('app', '会员编号'),
        		'start_date' => Yii::t('app', '开始日期'),
        		'end_date' => Yii::t('app', '结束日期'),
        		'order_code' => Yii::t('app', '订单编号'),
        		
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
    public function getProductComments()
    {
    	return $this->hasMany(ProductComment::className(), ['order_id' => 'id']);
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
    public function getQuotation()
    {
    	return $this->hasOne(Quotation::className(), ['id' => 'quotation_id']);
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
        return $this->hasOne(DeliveryTypeTpl::className(), ['id' => 'delivery_type']);
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
    public function getSoSheetVips()
    {
    	return $this->hasMany(SoSheetVip::className(), ['order_id' => 'id']);
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
    
    public function getOrderStatusName(){
    	return "xxx";
    }
}
