<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_out_stock_sheet".
 *
 * @property string $id
 * @property string $sheet_type_id
 * @property string $code
 * @property string $order_id
 * @property string $user_id
 * @property string $vip_id
 * @property string $sheet_date
 * @property string $status
 * @property string $delivery_type
 * @property string $delivery_no
 *
 * @property DeliveryTypeTpl $deliveryType
 * @property SoSheet $order
 * @property Vip $vip
 * @property SysParameter $status0
 * @property SysUser $user
 * @property OutStockSheetDetail[] $outStockSheetDetails
 * @property ReturnSheet[] $returnSheets
 */
class OutStockSheet extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_out_stock_sheet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sheet_type_id', 'code', 'order_id', 'user_id', 'vip_id', 'sheet_date', 'status', 'delivery_type', 'delivery_no'], 'required'],
            [['sheet_type_id', 'order_id', 'user_id', 'vip_id', 'status', 'delivery_type'], 'integer'],
            [['sheet_date'], 'safe'],
            [['code'], 'string', 'max' => 30],
            [['delivery_no'], 'string', 'max' => 60],
            [['code'], 'unique'],
            [['delivery_type'], 'exist', 'skipOnError' => true, 'targetClass' => DeliveryTypeTpl::className(), 'targetAttribute' => ['delivery_type' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => SoSheet::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'code' => Yii::t('app', '发货单编号（根据规则自动生成）'),
            'order_id' => Yii::t('app', '关联订单编号'),
            'user_id' => Yii::t('app', '制单人'),
            'vip_id' => Yii::t('app', '关联商户编号'),
            'sheet_date' => Yii::t('app', '单据生成时间'),
            'status' => Yii::t('app', '发货单状态（未发货、已发货）'),
            'delivery_type' => Yii::t('app', '配送方式'),
            'delivery_no' => Yii::t('app', '快递单号'),
        ];
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
    public function getUser()
    {
        return $this->hasOne(SysUser::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutStockSheetDetails()
    {
        return $this->hasMany(OutStockSheetDetail::className(), ['out_stock_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReturnSheets()
    {
        return $this->hasMany(ReturnSheet::className(), ['out_id' => 'id']);
    }
}
