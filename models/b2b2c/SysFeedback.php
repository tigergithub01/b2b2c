<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_feedback".
 *
 * @property string $id
 * @property string $vip_id
 * @property string $feedback_date
 * @property string $feedback_type
 * @property string $content
 *
 * @property SysParameter $feedbackType
 * @property Vip $vip
 */
class SysFeedback extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_feedback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vip_id', 'feedback_date', 'feedback_type', 'content'], 'required'],
            [['vip_id', 'feedback_type'], 'integer'],
            [['feedback_date'], 'safe'],
            [['content'], 'string', 'max' => 500],
            [['feedback_type'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['feedback_type' => 'id']],
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
            'vip_id' => Yii::t('app', '会员编号'),
            'feedback_date' => Yii::t('app', '反馈时间'),
            'feedback_type' => Yii::t('app', '反馈类型'),
            'content' => Yii::t('app', '反馈内容'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbackType()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'feedback_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVip()
    {
        return $this->hasOne(Vip::className(), ['id' => 'vip_id']);
    }
}
