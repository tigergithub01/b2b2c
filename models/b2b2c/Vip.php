<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip".
 *
 * @property string $id
 * @property string $vip_id
 * @property string $merchant_flag
 * @property string $vip_name
 * @property string $last_login_date
 * @property string $password
 * @property string $parent_id
 * @property string $mobile
 * @property string $mobile_verify_flag
 * @property string $email
 * @property string $email_verify_flag
 * @property string $status
 * @property string $register_date
 * @property string $rank_id
 *
 * @property ProductComment[] $productComments
 * @property RefundSheetApply[] $refundSheetApplies
 * @property ReturnApply[] $returnApplies
 * @property SheetLog[] $sheetLogs
 * @property ShoppingCart[] $shoppingCarts
 * @property SoSheet[] $soSheets
 * @property SysFeedback[] $sysFeedbacks
 * @property SysNotifyPushLog[] $sysNotifyPushLogs
 * @property SysParameter $status0
 * @property SysParameter $emailVerifyFlag
 * @property Vip $parent
 * @property Vip[] $vips
 * @property SysParameter $merchantFlag
 * @property SysParameter $mobileVerifyFlag
 * @property VipRank $rank
 * @property VipAddress[] $vipAddresses
 * @property VipBlog[] $vipBlogs
 * @property VipBlogCmt[] $vipBlogCmts
 * @property VipConcern[] $vipConcerns
 * @property VipConcern[] $vipConcerns0
 * @property VipCoupon[] $vipCoupons
 * @property VipOperationLog[] $vipOperationLogs
 * @property VipOrganization[] $vipOrganizations
 * @property VipProductCollect[] $vipProductCollects
 */
class Vip extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vip_id', 'merchant_flag', 'password', 'email_verify_flag', 'status', 'register_date'], 'required'],
            [['merchant_flag', 'parent_id', 'mobile_verify_flag', 'email_verify_flag', 'status', 'rank_id'], 'integer'],
            [['last_login_date', 'register_date'], 'safe'],
            [['vip_id', 'email'], 'string', 'max' => 30],
            [['vip_name', 'password'], 'string', 'max' => 50],
            [['mobile'], 'string', 'max' => 20],
            [['vip_id', 'merchant_flag'], 'unique', 'targetAttribute' => ['vip_id', 'merchant_flag'], 'message' => 'The combination of 会员登陆名 and 是否商户?1:是；0：否 has already been taken.'],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['email_verify_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['email_verify_flag' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['merchant_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['merchant_flag' => 'id']],
            [['mobile_verify_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['mobile_verify_flag' => 'id']],
            [['rank_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipRank::className(), 'targetAttribute' => ['rank_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'vip_id' => Yii::t('app', '会员登陆名'),
            'merchant_flag' => Yii::t('app', '是否商户?1:是；0：否'),
            'vip_name' => Yii::t('app', '姓名'),
            'last_login_date' => Yii::t('app', '最后一次登陆时间'),
            'password' => Yii::t('app', '密码'),
            'parent_id' => Yii::t('app', '上级会员编号'),
            'mobile' => Yii::t('app', '手机号码'),
            'mobile_verify_flag' => Yii::t('app', '手机号码是否已经验证'),
            'email' => Yii::t('app', '安全邮箱'),
            'email_verify_flag' => Yii::t('app', '安全邮箱是否已验证(1:是；0：否)'),
            'status' => Yii::t('app', '会员状态(1:正常、0:停用)'),
            'register_date' => Yii::t('app', '注册时间'),
            'rank_id' => Yii::t('app', '会员等级'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductComments()
    {
        return $this->hasMany(ProductComment::className(), ['vip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundSheetApplies()
    {
        return $this->hasMany(RefundSheetApply::className(), ['vip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReturnApplies()
    {
        return $this->hasMany(ReturnApply::className(), ['vip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSheetLogs()
    {
        return $this->hasMany(SheetLog::className(), ['vip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShoppingCarts()
    {
        return $this->hasMany(ShoppingCart::className(), ['vip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheets()
    {
        return $this->hasMany(SoSheet::className(), ['vip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysFeedbacks()
    {
        return $this->hasMany(SysFeedback::className(), ['vip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysNotifyPushLogs()
    {
        return $this->hasMany(SysNotifyPushLog::className(), ['vip_id' => 'id']);
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
    public function getEmailVerifyFlag()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'email_verify_flag']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Vip::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVips()
    {
        return $this->hasMany(Vip::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMerchantFlag()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'merchant_flag']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMobileVerifyFlag()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'mobile_verify_flag']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRank()
    {
        return $this->hasOne(VipRank::className(), ['id' => 'rank_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipAddresses()
    {
        return $this->hasMany(VipAddress::className(), ['vip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipBlogs()
    {
        return $this->hasMany(VipBlog::className(), ['vip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipBlogCmts()
    {
        return $this->hasMany(VipBlogCmt::className(), ['vip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipConcerns()
    {
        return $this->hasMany(VipConcern::className(), ['vip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipConcerns0()
    {
        return $this->hasMany(VipConcern::className(), ['ref_vip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipCoupons()
    {
        return $this->hasMany(VipCoupon::className(), ['vip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipOperationLogs()
    {
        return $this->hasMany(VipOperationLog::className(), ['vip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipOrganizations()
    {
        return $this->hasMany(VipOrganization::className(), ['vip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipProductCollects()
    {
        return $this->hasMany(VipProductCollect::className(), ['vip_id' => 'id']);
    }
}
