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
 * @property string $audit_status
 * @property string $audit_user_id
 * @property string $audit_date
 * @property string $audit_memo
 * @property string $vip_type_id
 * @property string $sex
 * @property string $nick_name
 * @property string $wedding_date
 * @property string $birthday
 * @property string $img_url
 * @property string $thumb_url
 * @property string $img_original
 *
 * @property ProductComment[] $productComments
 * @property RefundSheetApply[] $refundSheetApplies
 * @property ReturnApply[] $returnApplies
 * @property SheetLog[] $sheetLogs
 * @property ShoppingCart[] $shoppingCarts
 * @property SoSheet[] $soSheets
 * @property SysFeedback[] $sysFeedbacks
 * @property SysNotifyLog[] $sysNotifyLogs
 * @property SysParameter $status0
 * @property SysParameter $auditStatus
 * @property SysUser $auditUser
 * @property SysParameter $emailVerifyFlag
 * @property Vip $parent
 * @property Vip[] $vips
 * @property SysParameter $merchantFlag
 * @property VipType $vipType
 * @property SysParameter $mobileVerifyFlag
 * @property VipRank $rank
 * @property VipAddress[] $vipAddresses
 * @property VipBlog[] $vipBlogs
 * @property VipBlogCmt[] $vipBlogCmts
 * @property VipBlogLikes[] $vipBlogLikes
 * @property VipCollect[] $vipCollects
 * @property VipConcern[] $vipConcerns
 * @property VipConcern[] $vipConcerns0
 * @property VipCoupon[] $vipCoupons
 * @property VipExtend[] $vipExtends
 * @property VipOperationLog[] $vipOperationLogs
 * @property VipOrganization[] $vipOrganizations
 * @property VipProductType[] $vipProductTypes
 */
class Vip extends \app\models\b2b2c\BasicModel
{
	//记住密码（登陆)
	public $remember_me = true;
	
	//验证码
	public $verify_code;
	
	//注册同意协议
	public $agreement = true;
	
	//确认密码
	public $confirm_pwd;
	
	//短信验证码
	public $sms_code;
	
	//新密码(登陆后修改密码）
	public $new_pwd;
	
	/* 会员 */
	const SCENARIO_REGISTER = 'register';//注册
	const SCENARIO_LOGIN = 'login';//登陆
	const SCENARIO_AUTO_LOGIN = 'auto_login';//自动登陆
	const SCENARIO_FORGOT_PWD = 'forgot_pwd';//忘记密码
	const SCENARIO_CHANGE_PWD = 'change_pwd'; //登陆后修改密码
	
	/* 商户平台  */
	/* const SCENARIO_MERCHANT_LOGIN = 'merchant_login';
	const SCENARIO_MERCHANT_REGISTER = 'merchant_register';
	const SCENARIO_MERCHANT_AUTO_LOGIN = 'merchant_auto_login'; */
	
	
	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios[self::SCENARIO_REGISTER] = ['vip_id', 'password','agreement','verify_code','confirm_pwd','sms_code','vip_type_id'];
		$scenarios[self::SCENARIO_LOGIN] = ['vip_id', 'password','remember_me','verify_code'];
		$scenarios[self::SCENARIO_FORGOT_PWD] = ['vip_id', 'password','verify_code','confirm_pwd','sms_code',];
		$scenarios[self::SCENARIO_AUTO_LOGIN] = ['vip_id', 'password'];
		$scenarios[self::SCENARIO_CHANGE_PWD] = ['password', 'new_pwd','confirm_pwd'];
		return $scenarios;
	
		/* return [
		 self::SCENARIO_LOGIN => ['username', 'password'],
		 self::SCENARIO_REGISTER => ['username', 'email', 'password'],
		]; */
	}
	
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
            [['vip_id', 'merchant_flag', 'password', 'email_verify_flag', 'status', 'register_date', 'audit_status'], 'required'],
            [['vip_id'],'match','pattern'=>'/^1[0-9]{10}$/','message'=>'{attribute}格式不正确'],
            [['merchant_flag', 'parent_id', 'mobile_verify_flag', 'email_verify_flag', 'status', 'rank_id', 'audit_status', 'audit_user_id', 'vip_type_id', 'sex'], 'integer'],
            [['last_login_date', 'register_date', 'audit_date', 'wedding_date', 'birthday'], 'safe'],
            [['vip_id', 'email'], 'string', 'max' => 30],
            [['vip_name', 'password', 'nick_name'], 'string', 'max' => 50],
            [['mobile'], 'string', 'max' => 20],
            [['audit_memo'], 'string', 'max' => 200],
            [['img_url', 'thumb_url', 'img_original'], 'string', 'max' => 255],
            [['vip_id', 'merchant_flag'], 'unique', 'targetAttribute' => ['vip_id', 'merchant_flag'], 'message' => /* 'The combination of 会员登陆名 and 是否商户?1:是；0：否 has already been taken.' */'该手机号码已经注册'],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['audit_status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['audit_status' => 'id']],
            [['audit_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['audit_user_id' => 'id']],
            [['email_verify_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['email_verify_flag' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['merchant_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['merchant_flag' => 'id']],
            [['vip_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipType::className(), 'targetAttribute' => ['vip_type_id' => 'id']],
            [['mobile_verify_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['mobile_verify_flag' => 'id']],
            [['rank_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipRank::className(), 'targetAttribute' => ['rank_id' => 'id']],
        	['verify_code', 'captcha','on' => [self::SCENARIO_LOGIN,self::SCENARIO_REGISTER,self::SCENARIO_FORGOT_PWD]],
        	[['confirm_pwd'], 'required','on' => [self::SCENARIO_REGISTER,self::SCENARIO_FORGOT_PWD,self::SCENARIO_CHANGE_PWD]],
        	[['sms_code'], 'required','on' => [self::SCENARIO_REGISTER,self::SCENARIO_FORGOT_PWD]],
        	[['password','confirm_pwd','new_pwd'], 'string','min'=>6, 'max' => 16,'message'=>'{attribute}位数为6至16位','on' => [self::SCENARIO_REGISTER,self::SCENARIO_FORGOT_PWD,self::SCENARIO_CHANGE_PWD]],
        	[['confirm_pwd'], 'compare','compareAttribute'=>'password','message'=>'两次密码输入不一致','on' => [self::SCENARIO_REGISTER,self::SCENARIO_FORGOT_PWD]],
//         	[['agreement'],'boolean','on' => [self::SCENARIO_REGISTER]],
			[['new_pwd'], 'required','on' => [self::SCENARIO_CHANGE_PWD]],
        	[['confirm_pwd'], 'compare','compareAttribute'=>'new_pwd','message'=>'两次密码输入不一致','on' => [self::SCENARIO_CHANGE_PWD]],
        	[['vip_type_id'], 'required','on' => [self::SCENARIO_REGISTER]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'vip_id' => Yii::t('app', /*'会员登陆名'*/'手机号码'),
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
            'audit_status' => Yii::t('app', '审核状态(商户字段)：未审核，审核不通过，已审核'),
            'audit_user_id' => Yii::t('app', '审核人'),
            'audit_date' => Yii::t('app', '审核日期'),
            'audit_memo' => Yii::t('app', '审核意见（不通过时必须填写）'),
            'vip_type_id' => Yii::t('app', /*'会员类型（婚礼人类型：策划师，主持人，摄影师，化妆师，摄像师）'*/'婚礼人类型'),
            'sex' => Yii::t('app', '性别'),
            'nick_name' => Yii::t('app', '会员昵称'),
            'wedding_date' => Yii::t('app', '婚期'),
            'birthday' => Yii::t('app', '生日'),
            'img_url' => Yii::t('app', '用户图像-图片（放大后查看）'),
            'thumb_url' => Yii::t('app', '用户图像-缩略图'),
            'img_original' => Yii::t('app', '用户图像-原图'),
            'verify_code' => Yii::t('app', '验证码'),
            'confirm_pwd' => Yii::t('app', '确认密码'),
            'sms_code' => Yii::t('app', '短信验证码'),
            'new_pwd' => Yii::t('app', '新密码'),
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
    public function getSysNotifyLogs()
    {
        return $this->hasMany(SysNotifyLog::className(), ['vip_id' => 'id']);
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
    public function getAuditUser()
    {
        return $this->hasOne(SysUser::className(), ['id' => 'audit_user_id']);
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
    public function getVipType()
    {
        return $this->hasOne(VipType::className(), ['id' => 'vip_type_id']);
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
    public function getVipBlogLikes()
    {
        return $this->hasMany(VipBlogLikes::className(), ['vip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipCollects()
    {
        return $this->hasMany(VipCollect::className(), ['vip_id' => 'id']);
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
    public function getVipExtends()
    {
        return $this->hasMany(VipExtend::className(), ['vip_id' => 'id']);
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
    public function getVipProductTypes()
    {
        return $this->hasMany(VipProductType::className(), ['vip_id' => 'id']);
    }
}
