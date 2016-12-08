<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_audit_log".
 *
 * @property string $id
 * @property string $ref_id
 * @property string $audit_type
 * @property string $audit_operate
 * @property string $audit_user_id
 * @property string $audit_date
 * @property string $audit_memo
 *
 * @property SysUser $auditUser
 * @property SysParameter $auditOperate
 * @property SysParameter $auditType
 */
class SysAuditLog extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_audit_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ref_id', 'audit_type', 'audit_operate', 'audit_user_id', 'audit_date'], 'required'],
            [['ref_id', 'audit_type', 'audit_operate', 'audit_user_id'], 'integer'],
            [['audit_date'], 'safe'],
            [['audit_memo'], 'string', 'max' => 200],
            [['audit_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['audit_user_id' => 'id']],
            [['audit_operate'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['audit_operate' => 'id']],
            [['audit_type'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['audit_type' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'ref_id' => Yii::t('app', '关联编号'),
            'audit_type' => Yii::t('app', '审批类型：会员信息审核，博客审核，案例审核，商户基础信息，商户店铺（经营信息）'),
            'audit_operate' => Yii::t('app', '审核动作：审核通过，审核不通过'),
            'audit_user_id' => Yii::t('app', '审核人'),
            'audit_date' => Yii::t('app', '审核日期'),
            'audit_memo' => Yii::t('app', '审核意见'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuditUser()
    {
        return $this->hasOne(SysUser::className(), ['id' => 'audit_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuditOperate()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'audit_operate']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuditType()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'audit_type']);
    }
}
