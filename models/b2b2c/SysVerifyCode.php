<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_verify_code".
 *
 * @property string $id
 * @property string $verify_type
 * @property string $sent_time
 * @property string $expiration_time
 * @property string $verify_code
 * @property string $content
 * @property string $verify_number
 * @property string $usage_type
 *
 * @property SysParameter $verifyType
 * @property SysParameter $usageType
 */
class SysVerifyCode extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_verify_code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['verify_type', 'sent_time', 'verify_code', 'verify_number'], 'required'],
            [['verify_type', 'usage_type'], 'integer'],
            [['sent_time', 'expiration_time'], 'safe'],
            [['verify_code'], 'string', 'max' => 10],
            [['content'], 'string', 'max' => 200],
            [['verify_number'], 'string', 'max' => 15],
            [['verify_type'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['verify_type' => 'id']],
            [['usage_type'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['usage_type' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'verify_type' => Yii::t('app', '0、手机号码验证；1、邮箱验证'),
            'sent_time' => Yii::t('app', '发送时间'),
            'expiration_time' => Yii::t('app', '过期时间'),
            'verify_code' => Yii::t('app', '验证码'),
            'content' => Yii::t('app', '手机短信内容'),
            'verify_number' => Yii::t('app', '手机号码,邮箱'),
            'usage_type' => Yii::t('app', '验证码用途类型（注册、找回密码）'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVerifyType()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'verify_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsageType()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'usage_type']);
    }
}
