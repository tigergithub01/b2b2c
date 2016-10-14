<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_notify".
 *
 * @property string $id
 * @property string $notify_type
 * @property string $title
 * @property string $issue_date
 * @property string $content
 * @property string $vip_id
 * @property string $issue_user_id
 * @property string $send_extend
 * @property string $status
 * @property string $is_sent
 * @property string $sent_time
 *
 * @property SysParameter $isSent
 * @property SysParameter $sendExtend
 * @property SysUser $issueUser
 * @property SysParameter $status0
 * @property SysParameter $notifyType
 * @property Vip $vip
 * @property SysNotifyLog[] $sysNotifyLogs
 */
class SysNotify extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_notify';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notify_type', 'vip_id', 'issue_user_id', 'send_extend', 'status', 'is_sent'], 'integer'],
            [['title', 'issue_date', 'send_extend', 'status', 'is_sent'], 'required'],
            [['issue_date', 'sent_time'], 'safe'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 60],
            [['is_sent'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['is_sent' => 'id']],
            [['send_extend'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['send_extend' => 'id']],
            [['issue_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['issue_user_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['notify_type'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['notify_type' => 'id']],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'notify_type' => Yii::t('app', '公告类型：店铺公告，平台公告'),
            'title' => Yii::t('app', '标题'),
            'issue_date' => Yii::t('app', '发布日期'),
            'content' => Yii::t('app', '内容'),
            'vip_id' => Yii::t('app', '关联商户编号(联商户布公告时使用此字段)'),
            'issue_user_id' => Yii::t('app', '发布人（发布公告时使用此字段）'),
            'send_extend' => Yii::t('app', '发送范围[全部（商户+会员)-待定,商户,会员]'),
            'status' => Yii::t('app', '是否有效（1：是，0：否）'),
            'is_sent' => Yii::t('app', '是否已发送（1：是，0：否）'),
            'sent_time' => Yii::t('app', '发送时间'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIsSent()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'is_sent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSendExtend()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'send_extend']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssueUser()
    {
        return $this->hasOne(SysUser::className(), ['id' => 'issue_user_id']);
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
    public function getNotifyType()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'notify_type']);
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
    public function getSysNotifyLogs()
    {
        return $this->hasMany(SysNotifyLog::className(), ['notify_id' => 'id']);
    }
}
