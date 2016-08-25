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
 * @property string $organization_id
 *
 * @property SysParameter $status0
 * @property SoSheet $order
 * @property ReturnSheet $return
 * @property RefundSheetApply $refundApply
 * @property SysUser $user
 * @property VipOrganization $organization
 */
class RefundSheet extends \app\models\b2b2c\BasicModel
{
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
    public function rules()
    {
        return [
            [['sheet_type_id', 'code', 'order_id', 'user_id', 'sheet_date', 'status', 'organization_id'], 'required'],
            [['sheet_type_id', 'refund_apply_id', 'order_id', 'return_id', 'user_id', 'status', 'organization_id'], 'integer'],
            [['sheet_date'], 'safe'],
            [['need_return_amt', 'return_amt'], 'number'],
            [['code'], 'string', 'max' => 30],
            [['memo'], 'string', 'max' => 400],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => SoSheet::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['return_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReturnSheet::className(), 'targetAttribute' => ['return_id' => 'id']],
            [['refund_apply_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefundSheetApply::className(), 'targetAttribute' => ['refund_apply_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipOrganization::className(), 'targetAttribute' => ['organization_id' => 'id']],
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
            'code' => Yii::t('app', '退款单编号（根据单据规则自动生成）'),
            'order_id' => Yii::t('app', '关联订单编号'),
            'return_id' => Yii::t('app', '关联退货单编号'),
            'user_id' => Yii::t('app', '制单人'),
            'sheet_date' => Yii::t('app', '制单时间'),
            'need_return_amt' => Yii::t('app', '待退款金额'),
            'return_amt' => Yii::t('app', '实际退款金额'),
            'memo' => Yii::t('app', '备注'),
            'status' => Yii::t('app', '退款单状态（待退款、已退款）'),
            'organization_id' => Yii::t('app', '关联机构编号'),
        ];
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
    public function getOrganization()
    {
        return $this->hasOne(VipOrganization::className(), ['id' => 'organization_id']);
    }
}
