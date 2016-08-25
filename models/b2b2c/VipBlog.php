<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_blog".
 *
 * @property string $id
 * @property string $blog_type
 * @property string $blog_flag
 * @property string $vip_id
 * @property string $organization_id
 * @property string $content
 * @property string $create_date
 * @property string $update_date
 * @property string $audit_user_id
 * @property string $audit_status
 * @property string $audit_date
 * @property string $status
 *
 * @property Vip $vip
 * @property SysParameter $status0
 * @property SysParameter $blogFlag
 * @property VipOrganization $organization
 * @property VipBlogType $blogType
 * @property VipBlogCmt[] $vipBlogCmts
 * @property VipBlogPhoto[] $vipBlogPhotos
 */
class VipBlog extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_blog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blog_type', 'blog_flag', 'vip_id', 'organization_id', 'audit_user_id', 'audit_status', 'status'], 'integer'],
            [['blog_flag', 'content', 'create_date', 'update_date', 'audit_status', 'status'], 'required'],
            [['content'], 'string'],
            [['create_date', 'update_date', 'audit_date'], 'safe'],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['blog_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['blog_flag' => 'id']],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipOrganization::className(), 'targetAttribute' => ['organization_id' => 'id']],
            [['blog_type'], 'exist', 'skipOnError' => true, 'targetClass' => VipBlogType::className(), 'targetAttribute' => ['blog_type' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'blog_type' => Yii::t('app', '博客频道'),
            'blog_flag' => Yii::t('app', '博客分类：会员博客，商户博客'),
            'vip_id' => Yii::t('app', '关联用户编号(普通博客填写此字段)'),
            'organization_id' => Yii::t('app', '店铺动态（店铺博客填写此字段）'),
            'content' => Yii::t('app', '发布内容'),
            'create_date' => Yii::t('app', '发布时间'),
            'update_date' => Yii::t('app', '更新时间'),
            'audit_user_id' => Yii::t('app', '审核人'),
            'audit_status' => Yii::t('app', '审核状态（未审核，审核通过，审核不通过）'),
            'audit_date' => Yii::t('app', '审核日期'),
            'status' => Yii::t('app', '是否显示？1：是；0：否'),
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
    public function getStatus0()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogFlag()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'blog_flag']);
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
    public function getBlogType()
    {
        return $this->hasOne(VipBlogType::className(), ['id' => 'blog_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipBlogCmts()
    {
        return $this->hasMany(VipBlogCmt::className(), ['blog_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipBlogPhotos()
    {
        return $this->hasMany(VipBlogPhoto::className(), ['blog_id' => 'id']);
    }
}
