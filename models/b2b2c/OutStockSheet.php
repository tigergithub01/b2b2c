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
 * @property string $sheet_date
 * @property string $status
 * @property string $delivery_type
 * @property string $delivery_no
 * @property string $organization_id
 *
 * @property SysUser $user
 * @property DeliveryType $deliveryType
 * @property SoSheet $order
 * @property SysParameter $status0
 * @property VipOrganization $organization
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
            [['sheet_type_id', 'code', 'order_id', 'user_id', 'sheet_date', 'status', 'delivery_type', 'delivery_no', 'organization_id'], 'required'],
            [['sheet_type_id', 'order_id', 'user_id', 'status', 'delivery_type', 'organization_id'], 'integer'],
            [['sheet_date'], 'safe'],
            [['code'], 'string', 'max' => 30],
            [['delivery_no'], 'string', 'max' => 60],
            [['code'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['delivery_type'], 'exist', 'skipOnError' => true, 'targetClass' => DeliveryType::className(), 'targetAttribute' => ['delivery_type' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => SoSheet::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
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
            'code' => Yii::t('app', '发货单编号（根据规则自动生成）'),
            'order_id' => Yii::t('app', '关联订单编号'),
            'user_id' => Yii::t('app', '制单人'),
            'sheet_date' => Yii::t('app', '单据生成时间'),
            'status' => Yii::t('app', '发货单状态（配货中、已发货）'),
            'delivery_type' => Yii::t('app', '配送方式'),
            'delivery_no' => Yii::t('app', '快递单号'),
            'organization_id' => Yii::t('app', '关联机构编号'),
        ];
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
    public function getDeliveryType()
    {
        return $this->hasOne(DeliveryType::className(), ['id' => 'delivery_type']);
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
    public function getStatus0()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(VipOrganization::className(), ['id' => 'organization_id']);
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
