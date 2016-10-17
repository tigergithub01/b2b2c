<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_refund_sheet".
 *
 * @property string $id
 * @property string $sheet_type_id
 * @property string $refund_apply_id
 * @property string $code
 * @property string $order_id
 * @property string $return_id
 * @property string $user_id
 * @property string $sheet_date
 * @property string $need_return_amt
 * @property string $return_amt
 * @property string $memo
 * @property string $status
 * @property string $vip_id
 * @property string $merchant_id
 *
 * @property Vip $merchant
 * @property SoSheet $order
 * @property ReturnSheet $return
 * @property RefundSheetApply $refundApply
 * @property SysUser $user
 * @property SysParameter $status0
 * @property Vip $vip
 */
class RefundSheet extends \app\models\b2b2c\BasicModel
{
	/* 会员编号（查询用） */
	public $vip_no;
	
	/* 起始日期 （查询用） */
	public $start_date;
	
	/* 结束日期 （查询用） */
	public $end_date;
	
	/* 订单编号 （查询用） */
	public $order_code;
	
	/* 退款申请单编号 （查询用） */
	public $refund_apply_code;
	
	/* 退货申请单编号 （查询用） */
	public $return_code;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_refund_sheet';
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
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'refund_apply_code';
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'return_code';
    	return $scenarios;
    	// 		return parent::scenarios();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sheet_type_id', 'code', 'order_id', 'user_id', 'sheet_date', 'status', 'vip_id', 'merchant_id'], 'required'],
            [['sheet_type_id', 'refund_apply_id', 'order_id', 'return_id', 'user_id', 'status', 'vip_id', 'merchant_id'], 'integer'],
            [['sheet_date'], 'safe'],
            [['need_return_amt', 'return_amt'], 'number'],
            [['code'], 'string', 'max' => 30],
            [['memo'], 'string', 'max' => 400],
            [['merchant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['merchant_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => SoSheet::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['return_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReturnSheet::className(), 'targetAttribute' => ['return_id' => 'id']],
            [['refund_apply_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefundSheetApply::className(), 'targetAttribute' => ['refund_apply_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'sheet_type_id' => Yii::t('app', '单据类型'),
            'refund_apply_id' => Yii::t('app', '关联退款申请编号'),
            'code' => Yii::t('app', /* '退款单编号（根据单据规则自动生成）' */'退款单编号'),
            'order_id' => Yii::t('app', '关联订单编号'),
            'return_id' => Yii::t('app', '关联退货单编号'),
            'user_id' => Yii::t('app', '制单人'),
            'sheet_date' => Yii::t('app', '制单时间'),
            'need_return_amt' => Yii::t('app', '待退款金额'),
            'return_amt' => Yii::t('app', '实际退款金额'),
            'memo' => Yii::t('app', '备注'),
            'status' => Yii::t('app', '退款单状态（待退款、已退款）'),
            'vip_id' => Yii::t('app', '会员编号'),
            'merchant_id' => Yii::t('app', '关联商户编号'),
        	'merchant.vip_id' => Yii::t('app', '会员编号'),
        	'order.code' => Yii::t('app', '关联订单编号'),
        	'return.code' => Yii::t('app', '关联退货单编号'),
        	'refundApply.code' => Yii::t('app', '关联退款申请编号'),
        	'user.user_id' => Yii::t('app', '制单人'),
        	'status0.param_val' => Yii::t('app', /* '退款单状态（待退款、已退款）' */'退款单状态'),
        	'vip.vip_id' => Yii::t('app', '会员编号'),
        ];
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
    public function getOrder()
    {
        return $this->hasOne(SoSheet::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReturn()
    {
        return $this->hasOne(ReturnSheet::className(), ['id' => 'return_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundApply()
    {
        return $this->hasOne(RefundSheetApply::className(), ['id' => 'refund_apply_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(SysUser::className(), ['id' => 'user_id']);
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
    public function getVip()
    {
        return $this->hasOne(Vip::className(), ['id' => 'vip_id']);
    }
}
