<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_org_case".
 *
 * @property string $id
 * @property string $name
 * @property string $type_id
 * @property string $organization_id
 * @property string $content
 * @property string $create_date
 * @property string $update_date
 * @property string $status
 * @property string $audit_status
 * @property string $audit_user_id
 * @property string $audit_date
 * @property string $cover_img_url
 * @property string $cover_thumb_url
 * @property string $cover_img_original
 *
 * @property SysUser $auditUser
 * @property VipCaseType $type
 * @property VipOrganization $organization
 * @property SysParameter $status0
 * @property SysParameter $auditStatus
 * @property VipOrgCasePhoto[] $vipOrgCasePhotos
 */
class VipOrgCase extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_org_case';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'content', 'create_date', 'update_date', 'status', 'audit_status', 'cover_img_url', 'cover_thumb_url', 'cover_img_original'], 'required'],
            [['type_id', 'organization_id', 'status', 'audit_status', 'audit_user_id'], 'integer'],
            [['content'], 'string'],
            [['create_date', 'update_date', 'audit_date'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['cover_img_url', 'cover_thumb_url', 'cover_img_original'], 'string', 'max' => 255],
            [['audit_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['audit_user_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipCaseType::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipOrganization::className(), 'targetAttribute' => ['organization_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['audit_status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['audit_status' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'name' => Yii::t('app', '案例名称'),
            'type_id' => Yii::t('app', '案例类型'),
            'organization_id' => Yii::t('app', '关联店铺（机构）编号'),
            'content' => Yii::t('app', '发布内容'),
            'create_date' => Yii::t('app', '发布时间'),
            'update_date' => Yii::t('app', '更新时间'),
            'status' => Yii::t('app', '是否显示？1：是；0：否'),
            'audit_status' => Yii::t('app', '审核状态：未审核，审核不通过，已审核'),
            'audit_user_id' => Yii::t('app', '审核人'),
            'audit_date' => Yii::t('app', '审核日期'),
            'cover_img_url' => Yii::t('app', '图片（放大后查看）(封面)'),
            'cover_thumb_url' => Yii::t('app', '缩略图(封面)'),
            'cover_img_original' => Yii::t('app', '原图(封面)'),
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
    public function getType()
    {
        return $this->hasOne(VipCaseType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(VipOrganization::className(), ['id' => 'organization_id']);
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
    public function getAuditStatus()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'audit_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipOrgCasePhotos()
    {
        return $this->hasMany(VipOrgCasePhoto::className(), ['case_id' => 'id']);
    }
}
