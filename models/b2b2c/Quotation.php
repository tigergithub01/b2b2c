<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_quotation".
 *
 * @property string $id
 * @property string $code
 * @property string $vip_id
 * @property string $order_amt
 * @property string $deposit_amount
 * @property string $create_date
 * @property string $update_date
 * @property string $memo
 * @property string $status
 * @property string $consignee
 * @property string $mobile
 * @property string $service_date
 * @property string $budget_amount
 * @property string $related_service
 * @property string $service_style
 * @property string $merchant_id
 * @property string $order_id
 *
 * @property SoSheet $order
 * @property Vip $vip
 * @property Vip $merchant
 * @property SysParameter $status0
 * @property SysParameter $serviceStyle
 * @property QuotationDetail[] $quotationDetails
 */
class Quotation extends \app\models\b2b2c\BasicModel
{
	/* 会员名称，查询用 */
	public $vip_name;
	
	/* 服务类别（多选）用来接收数据 */
	public $related_services;
	
	/* 服务类别，用来显示数据 */
	public $related_service_names;	
	
	/* 报价单状态： */
	const stat_need_reply = 29001; // 待回复（用户提交咨询，商户待回复）
	const stat_replied = 29002; // 已回复（商户已回复）
	const stat_effective = 29003; // 已执行（用户已生成订单)
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_quotation';
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {
    	if($this->related_services) {
    		$this->related_service = implode(',',$this->related_services);
    	}
    	return parent::beforeSave($insert);
    }
    
    /**
     * @inheritdoc
     */
    public function afterFind() {
    	$this->related_services = explode(',',$this->related_service);
    	parent::afterFind();
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
    	// bypass scenarios() implementation in the parent class
    	$scenarios = parent::scenarios();
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'related_services';
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'vip_name';
    	return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'vip_id', 'create_date', 'update_date', 'status', 'consignee', 'mobile', 'service_date', 'merchant_id'], 'required'],
            [['vip_id', 'status', 'merchant_id', 'order_id'], 'integer'],
            [['order_amt', 'deposit_amount', 'budget_amount'], 'number'],
            [['create_date', 'update_date', 'service_date'], 'safe'],
            [['code', 'consignee'], 'string', 'max' => 30],
            [['memo'], 'string', 'max' => 400],
            [['mobile'], 'string', 'max' => 20],
            [['related_service', 'service_style'], 'string', 'max' => 60],
            [['code'], 'unique'],
        	[['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => SoSheet::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['merchant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['merchant_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'code' => Yii::t('app', '咨询编号'),
            'vip_id' => Yii::t('app', '会员编号'),
            'order_amt' => Yii::t('app', '报价金额'),
            'deposit_amount' => Yii::t('app', '定金金额'),
            'create_date' => Yii::t('app', '提交日期'),
            'update_date' => Yii::t('app', '修改日期'),
            'memo' => Yii::t('app', '备注'),
            'status' => Yii::t('app', /* '咨询状态：待回复（用户提交咨询，商户待回复），已回复（商户已回复），已完成（用户已生成订单)' */'咨询状态'),
            'consignee' => Yii::t('app', '联系人'),
            'mobile' => Yii::t('app', '联系手机号码'),
            'service_date' => Yii::t('app', '服务时间'),
            'budget_amount' => Yii::t('app', '婚礼预算'),
            'related_service' => Yii::t('app', /* '需要人员（多选）（婚礼策划师，摄影师，摄像师，化妆师，主持人）' */'需要人员'),
            'service_style' => Yii::t('app', /* '婚礼类型（单选）（室内，室外）' */'婚礼类型'),
            'merchant_id' => Yii::t('app', '关联商户编号'),
        	'order_id' => Yii::t('app', '订单编号'),
        	'related_services' => Yii::t('app', /* '需要人员（多选）（婚礼策划师，摄影师，摄像师，化妆师，主持人）' */'需要人员'),
        	'related_service_names' => Yii::t('app', /* '需要人员（多选）（婚礼策划师，摄影师，摄像师，化妆师，主持人）' */'需要人员'),
        	'serviceStyle.param_val' =>  Yii::t('app', '婚礼类型'),
        		'vip.vip_name' =>  Yii::t('app', '会员名称'),
        		'status0.param_val' =>  Yii::t('app', '状态'),
        		'serviceStyle.param_val' =>  Yii::t('app', '婚礼类型'),
        		'merchant.vip_name' =>  Yii::t('app', '商户名称'),
        		'vip_name' =>  Yii::t('app', '会员名称'),
        		'order.code' =>  Yii::t('app', '订单编号'),
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
    public function getVip()
    {
        return $this->hasOne(Vip::className(), ['id' => 'vip_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMerchant()
    {
        return $this->hasOne(Vip::className(), ['id' => 'merchant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotationDetails()
    {
        return $this->hasMany(QuotationDetail::className(), ['quotation_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceStyle()
    {
    	return $this->hasOne(SysParameter::className(), ['id' => 'service_style']);
    }
}
