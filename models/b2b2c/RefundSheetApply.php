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
 *
 * @property RefundSheet[] $refundSheets
 * @property SysParameter $status0
 * @property SoSheet $order
 * @property Vip $vip
 */
class RefundSheetApply extends \app\models\b2b2c\BasicModel
{
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
    public function rules()
    {
        return [
            [['sheet_type_id', 'order_id', 'reason'], 'required'],
            [['sheet_type_id', 'vip_id', 'order_id', 'status'], 'integer'],
            [['reason'], 'string', 'max' => 255],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => SoSheet::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
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
            'status' => Yii::t('app', '退款申请状态（审核中，退款处理中[审核通过]，已退款，审核不通过，已撤销）'),
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
    public function getVip()
    {
        return $this->hasOne(Vip::className(), ['id' => 'vip_id']);
    }
}
