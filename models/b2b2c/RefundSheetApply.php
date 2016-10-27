<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_refund_sheet_apply".
 *
 * @property string $id
 * @property string $sheet_type_id
 * @property string $vip_id
 * @property string $order_id
 * @property string $reason
 * @property string $status
 * @property string $apply_date
 * @property string $code
 *
 * @property RefundSheet[] $refundSheets
 * @property SoSheet $order
 * @property Vip $vip
 * @property SysParameter $status0
 */
class RefundSheetApply extends \app\models\b2b2c\BasicModel
{
	/* 退款申请单状态： */
	const status_need_confirm = 24001; //待审核
	const status_approved = 24002; // 退款处理中(审核通过)
	const status_refund = 24003; // 已退款
	const status_rejected = 24004; // 审核不通过
	const status_cancelled = 24005; // 用户已撤销
	
	/* 会员编号（查询用） */
	public $vip_no;
	
	/* 起始日期 （查询用） */
	public $start_date;
	
	/* 结束日期 （查询用） */
	public $end_date;
	
	/* 订单编号 （查询用） */
	public $order_code;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_refund_sheet_apply';
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
    	return $scenarios;
    	// 		return parent::scenarios();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sheet_type_id', 'order_id', 'reason', 'apply_date', 'code', 'vip_id'], 'required'],
            [['sheet_type_id', 'vip_id', 'order_id', 'status'], 'integer'],
            [['apply_date'], 'safe'],
            [['reason'], 'string', 'max' => 255],
        	[['code'], 'string', 'max' => 30],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => SoSheet::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'sheet_type_id' => Yii::t('app', '单据类型（退款申请单）'),
            'vip_id' => Yii::t('app', '关联会员编号'),
            'order_id' => Yii::t('app', '订单编号'),
            'reason' => Yii::t('app', '申请退款原因'),
            'status' => Yii::t('app', /* '退款申请状态（审核中，退款处理中[审核通过]，已退款，审核不通过，已撤销）' */'退款申请状态'),
            'apply_date' => Yii::t('app', '申请日期'),
        	'code' => Yii::t('app', '退款申请单编号'),
        	'vip.vip_name' => Yii::t('app', '会员名称'),
        	'order.code' => Yii::t('app', '订单编号'),
        	'status0.param_val' => Yii::t('app', /* '退款申请状态（审核中，退款处理中[审核通过]，已退款，审核不通过，已撤销）' */'退款申请状态'),
        		'vip_no' => Yii::t('app', '会员手机号码'),
        		'start_date' => Yii::t('app', '开始日期'),
        		'end_date' => Yii::t('app', '结束日期'),
        		'order_code' => Yii::t('app', '订单编号'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundSheets()
    {
        return $this->hasMany(RefundSheet::className(), ['refund_apply_id' => 'id']);
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
    public function getStatus0()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'status']);
    }
}
