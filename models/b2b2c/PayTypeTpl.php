<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_pay_type_tpl".
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $rate
 * @property string $description
 * @property string $status
 * @property string $is_cod
 *
 * @property PayType[] $payTypes
 * @property SysParameter $status0
 * @property SysParameter $isCod
 */
class PayTypeTpl extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_pay_type_tpl';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'status', 'is_cod'], 'required'],
            [['rate'], 'number'],
            [['status', 'is_cod'], 'integer'],
            [['code'], 'string', 'max' => 30],
            [['name'], 'string', 'max' => 60],
            [['description'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['is_cod'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['is_cod' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'code' => Yii::t('app', '支付方式唯一编码'),
            'name' => Yii::t('app', '支付方式名称'),
            'rate' => Yii::t('app', '费率'),
            'description' => Yii::t('app', '描述'),
            'status' => Yii::t('app', '状态（1:有效、0:停用）'),
            'is_cod' => Yii::t('app', '是否货到付款（1:是、0:否）'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayTypes()
    {
        return $this->hasMany(PayType::className(), ['tpl_id' => 'id']);
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
    public function getIsCod()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'is_cod']);
    }
}
