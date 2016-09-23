<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_pay_type".
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $rate
 * @property string $description
 * @property string $configure
 * @property string $status
 * @property string $is_cod
 *
 * @property SysParameter $status0
 * @property SysParameter $isCod
 * @property SoSheet[] $soSheets
 */
class PayType extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_pay_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'status', 'is_cod'], 'required'],
            [['rate'], 'number'],
            [['configure'], 'string'],
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
            'code' => Yii::t('app', '支付方式编码'),
            'name' => Yii::t('app', '支付方式名称'),
            'rate' => Yii::t('app', '费率'),
            'description' => Yii::t('app', '描述'),
            'configure' => Yii::t('app', '对应配置信息'),
            'status' => Yii::t('app', '状态'),
            'is_cod' => Yii::t('app', '是否货到付款'),
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
    public function getIsCod()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'is_cod']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheets()
    {
        return $this->hasMany(SoSheet::className(), ['pay_type_id' => 'id']);
    }
}
