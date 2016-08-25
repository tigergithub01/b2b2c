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
 *
 * @property SysParameter $notifyType
 * @property SysNotifyPushLog[] $sysNotifyPushLogs
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
            [['notify_type', 'title', 'issue_date'], 'required'],
            [['notify_type'], 'integer'],
            [['issue_date'], 'safe'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 60],
            [['notify_type'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['notify_type' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'notify_type' => Yii::t('app', '公告类型'),
            'title' => Yii::t('app', '消息标题'),
            'issue_date' => Yii::t('app', '消息发布日期'),
            'content' => Yii::t('app', '消息内容'),
        ];
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
    public function getSysNotifyPushLogs()
    {
        return $this->hasMany(SysNotifyPushLog::className(), ['notify_id' => 'id']);
    }
}
