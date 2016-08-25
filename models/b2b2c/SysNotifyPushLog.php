<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_notify_push_log".
 *
 * @property string $id
 * @property string $notify_id
 * @property string $vip_id
 * @property string $title
 * @property string $content
 * @property string $push_date
 * @property string $read_date
 *
 * @property Vip $vip
 * @property SysNotify $notify
 */
class SysNotifyPushLog extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_notify_push_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notify_id', 'vip_id', 'title', 'push_date'], 'required'],
            [['notify_id', 'vip_id'], 'integer'],
            [['push_date', 'read_date'], 'safe'],
            [['title'], 'string', 'max' => 60],
            [['content'], 'string', 'max' => 500],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['notify_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysNotify::className(), 'targetAttribute' => ['notify_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'notify_id' => Yii::t('app', '关联通知编号'),
            'vip_id' => Yii::t('app', '推送会员编号'),
            'title' => Yii::t('app', '推送标题'),
            'content' => Yii::t('app', '推送内容,手机客户端推送内容一般不会太多'),
            'push_date' => Yii::t('app', '推送时间'),
            'read_date' => Yii::t('app', '阅读时间'),
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
    public function getNotify()
    {
        return $this->hasOne(SysNotify::className(), ['id' => 'notify_id']);
    }
}
