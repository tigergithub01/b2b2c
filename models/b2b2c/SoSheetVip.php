<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_so_sheet_vip".
 *
 * @property string $id
 * @property string $order_id
 * @property string $vip_id
 *
 * @property Vip $vip
 * @property SoSheet $order
 */
class SoSheetVip extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_so_sheet_vip';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'vip_id'], 'required'],
            [['order_id', 'vip_id'], 'integer'],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => SoSheet::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'order_id' => Yii::t('app', '关联订单编号'),
            'vip_id' => Yii::t('app', '关联商户编号'),
        ];
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
    public function getOrder()
    {
        return $this->hasOne(SoSheet::className(), ['id' => 'order_id']);
    }
}
