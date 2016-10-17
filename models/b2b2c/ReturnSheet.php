<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_return_sheet".
 *
 * @property string $id
 * @property string $sheet_type_id
 * @property string $return_apply_id
 * @property string $code
 * @property string $order_id
 * @property string $out_id
 * @property string $user_id
 * @property string $sheet_date
 * @property string $return_amt
 * @property string $memo
 * @property string $status
 * @property string $vip_id
 * @property string $merchant_id
 *
 * @property RefundSheet[] $refundSheets
 * @property Vip $merchant
 * @property ReturnApply $returnApply
 * @property OutStockSheet $out
 * @property SysUser $user
 * @property Vip $vip
 * @property SysParameter $status0
 * @property SoSheet $order
 * @property ReturnSheetDetail[] $returnSheetDetails
 */
class ReturnSheet extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_return_sheet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sheet_type_id', 'code', 'order_id', 'out_id', 'user_id', 'sheet_date', 'status', 'vip_id', 'merchant_id'], 'required'],
            [['sheet_type_id', 'return_apply_id', 'order_id', 'out_id', 'user_id', 'status', 'vip_id', 'merchant_id'], 'integer'],
            [['sheet_date'], 'safe'],
            [['return_amt'], 'number'],
            [['code'], 'string', 'max' => 30],
            [['memo'], 'string', 'max' => 400],
            [['merchant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['merchant_id' => 'id']],
            [['return_apply_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReturnApply::className(), 'targetAttribute' => ['return_apply_id' => 'id']],
            [['out_id'], 'exist', 'skipOnError' => true, 'targetClass' => OutStockSheet::className(), 'targetAttribute' => ['out_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => SoSheet::className(), 'targetAttribute' => ['order_id' => 'id']],
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
            'return_apply_id' => Yii::t('app', '退货申请单号'),
            'code' => Yii::t('app', '退货单编号（根据单据规则自动生成）'),
            'order_id' => Yii::t('app', '关联订单编号'),
            'out_id' => Yii::t('app', '关联发货单编号'),
            'user_id' => Yii::t('app', '制单人'),
            'sheet_date' => Yii::t('app', '制单时间'),
            'return_amt' => Yii::t('app', '本次退货金额'),
            'memo' => Yii::t('app', '备注'),
            'status' => Yii::t('app', '退货单状态（待退货、已完成）'),
            'vip_id' => Yii::t('app', '会员编号'),
            'merchant_id' => Yii::t('app', '关联商户编号'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundSheets()
    {
        return $this->hasMany(RefundSheet::className(), ['return_id' => 'id']);
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
    public function getReturnApply()
    {
        return $this->hasOne(ReturnApply::className(), ['id' => 'return_apply_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOut()
    {
        return $this->hasOne(OutStockSheet::className(), ['id' => 'out_id']);
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
    public function getReturnSheetDetails()
    {
        return $this->hasMany(ReturnSheetDetail::className(), ['return_id' => 'id']);
    }
}
