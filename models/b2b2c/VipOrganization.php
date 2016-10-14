<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_organization".
 *
 * @property string $id
 * @property string $name
 * @property string $status
 * @property string $logo_img_url
 * @property string $logo_thumb_url
 * @property string $logo_img_original
 * @property string $cover_img_url
 * @property string $cover_thumb_url
 * @property string $cover_img_original
 * @property string $vip_id
 * @property string $description
 * @property string $country_id
 * @property string $province_id
 * @property string $city_id
 * @property string $audit_status
 * @property string $audit_user_id
 * @property string $audit_date
 * @property string $audit_memo
 * @property string $create_date
 * @property string $update_date
 *
 * @property VipOrgGallery[] $vipOrgGalleries
 * @property SysUser $auditUser
 * @property SysRegion $city
 * @property SysRegion $country
 * @property SysRegion $province
 * @property Vip $vip
 * @property SysParameter $status0
 * @property SysParameter $auditStatus
 */
class VipOrganization extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_organization';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'vip_id', 'audit_status', 'create_date', 'update_date'], 'required'],
            [['status', 'vip_id', 'country_id', 'province_id', 'city_id', 'audit_status', 'audit_user_id'], 'integer'],
            [['audit_date', 'create_date', 'update_date'], 'safe'],
            [['name'], 'string', 'max' => 30],
            [['logo_img_url', 'logo_thumb_url', 'logo_img_original', 'cover_img_url', 'cover_thumb_url', 'cover_img_original'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 500],
            [['audit_memo'], 'string', 'max' => 200],
            [['audit_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['audit_user_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysRegion::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysRegion::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysRegion::className(), 'targetAttribute' => ['province_id' => 'id']],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
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
            'id' => Yii::t('app', '主键'),
            'name' => Yii::t('app', '门店（店铺、机构）名称'),
            'status' => Yii::t('app', '状态（1：有效；0：无效）'),
            'logo_img_url' => Yii::t('app', '图片（放大后查看）（logo）'),
            'logo_thumb_url' => Yii::t('app', '缩略图（logo）'),
            'logo_img_original' => Yii::t('app', '原始图片（logo）'),
            'cover_img_url' => Yii::t('app', '图片（放大后查看）(封面)'),
            'cover_thumb_url' => Yii::t('app', '缩略图(封面)'),
            'cover_img_original' => Yii::t('app', '原图(封面)'),
            'vip_id' => Yii::t('app', '所属会员'),
            'description' => Yii::t('app', '店铺简介'),
            'country_id' => Yii::t('app', '关联国家编号'),
            'province_id' => Yii::t('app', '关联省份编号'),
            'city_id' => Yii::t('app', '关联城市编号'),
            'audit_status' => Yii::t('app', '审核状态：未审核，审核不通过，已审核'),
            'audit_user_id' => Yii::t('app', '审核人'),
            'audit_date' => Yii::t('app', '审核日期'),
            'audit_memo' => Yii::t('app', '审核意见（不通过时必须填写）'),
            'create_date' => Yii::t('app', '创建时间'),
            'update_date' => Yii::t('app', '更新时间'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipOrgGalleries()
    {
        return $this->hasMany(VipOrgGallery::className(), ['organization_id' => 'id']);
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
    public function getCity()
    {
        return $this->hasOne(SysRegion::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(SysRegion::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(SysRegion::className(), ['id' => 'province_id']);
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
    public function getAuditStatus()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'audit_status']);
    }
}
