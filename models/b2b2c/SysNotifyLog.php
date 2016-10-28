<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_notify_log".
 *
 * @property string $id
 * @property string $notify_id
 * @property string $vip_id
 * @property string $create_date
 * @property string $read_date
 * @property string $expiration_time
 *
 * @property Vip $vip
 * @property SysNotify $notify
 */
class SysNotifyLog extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_notify_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notify_id', 'vip_id', 'create_date'], 'required'],
            [['notify_id', 'vip_id'], 'integer'],
            [['create_date', 'read_date', 'expiration_time'], 'safe'],
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
            'vip_id' => Yii::t('app', '通知会员编号'),
            'create_date' => Yii::t('app', '消息创建时间'),
            'read_date' => Yii::t('app', '消息阅读时间'),
            'expiration_time' => Yii::t('app', '消息过期时间'),
        	'notify.title' => Yii::t('app', '通知标题'),
        	'vip.vip_name' => Yii::t('app', '接收会员'),
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
