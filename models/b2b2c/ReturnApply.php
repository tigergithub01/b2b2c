<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_return_apply".
 *
 * @property string $id
 * @property string $sheet_type_id
 * @property string $apply_date
 * @property string $vip_id
 * @property string $order_id
 * @property string $reason
 * @property string $status
 * @property string $code
 *
 * @property SoSheet $order
 * @property Vip $vip
 * @property SysParameter $status0
 * @property ReturnApplyDetail[] $returnApplyDetails
 * @property ReturnSheet[] $returnSheets
 */
class ReturnApply extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_return_apply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sheet_type_id', 'apply_date', 'vip_id', 'order_id', 'reason', 'status', 'code'], 'required'],
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
            'sheet_type_id' => Yii::t('app', '退货申请单'),
            'apply_date' => Yii::t('app', '申请日期'),
            'vip_id' => Yii::t('app', '申请会员'),
            'order_id' => Yii::t('app', '关联订单编号'),
            'reason' => Yii::t('app', '退货申请原因'),
            'status' => Yii::t('app', '审核中，退货处理中(审核通过)，已退货，审核不通过，用户撤销'),
            'code' => Yii::t('app', '退货申请单编号'),
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
    public function getStatus0()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReturnApplyDetails()
    {
        return $this->hasMany(ReturnApplyDetail::className(), ['return_apply_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReturnSheets()
    {
        return $this->hasMany(ReturnSheet::className(), ['return_apply_id' => 'id']);
    }
}
