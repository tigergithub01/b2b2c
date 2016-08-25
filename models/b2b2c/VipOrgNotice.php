<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_org_notice".
 *
 * @property string $id
 * @property string $organization_id
 * @property string $content
 * @property string $issue_date
 * @property string $issue_user_id
 * @property string $notice_flag
 * @property string $status
 *
 * @property SysParameter $status0
 * @property VipOrganization $organization
 * @property SysParameter $noticeFlag
 */
class VipOrgNotice extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_org_notice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_id', 'issue_user_id', 'notice_flag', 'status'], 'integer'],
            [['content', 'issue_date', 'notice_flag', 'status'], 'required'],
            [['content'], 'string'],
            [['issue_date'], 'safe'],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipOrganization::className(), 'targetAttribute' => ['organization_id' => 'id']],
            [['notice_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['notice_flag' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'organization_id' => Yii::t('app', '发布机构(店铺发布公告时使用此字段）'),
            'content' => Yii::t('app', '发布内容'),
            'issue_date' => Yii::t('app', '发布日期'),
            'issue_user_id' => Yii::t('app', '平台发布公告时使用此字段'),
            'notice_flag' => Yii::t('app', '店铺发公告，平台发公告'),
            'status' => Yii::t('app', '是否显示'),
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
    public function getOrganization()
    {
        return $this->hasOne(VipOrganization::className(), ['id' => 'organization_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoticeFlag()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'notice_flag']);
    }
}
