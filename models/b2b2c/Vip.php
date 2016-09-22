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
 * @property SysParameter $auditStatus
 * @property SysUser $auditUser
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
	
	/* 会员 */
	const SCENARIO_REGISTER = 'register';//注册
	const SCENARIO_LOGIN = 'login';//登陆
	const SCENARIO_AUTO_LOGIN = 'auto_login';//自动登陆
	const SCENARIO_FORGOT_PWD = 'forgot_pwd';//忘记密码
	const SCENARIO_CHANG_PWD = 'change_pwd'; //登陆后修改密码
	
	/* 商户平台  */
	/* const SCENARIO_MERCHANT_LOGIN = 'merchant_login';
	const SCENARIO_MERCHANT_REGISTER = 'merchant_register';
	const SCENARIO_MERCHANT_AUTO_LOGIN = 'merchant_auto_login'; */
	
	
	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios[self::SCENARIO_REGISTER] = ['vip_id', 'password','agreement','verify_code','confirm_pwd','sms_code',];
		$scenarios[self::SCENARIO_LOGIN] = ['vip_id', 'password','remember_me','verify_code'];
		$scenarios[self::SCENARIO_FORGOT_PWD] = ['vip_id', 'password','verify_code','confirm_pwd','sms_code',];
		$scenarios[self::SCENARIO_AUTO_LOGIN] = ['vip_id', 'password'];
		// 		$scenarios[self::SCENARIO_REGISTER] = ['username', 'email', 'password'];
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
        	[['merchant_flag', 'parent_id', 'mobile_verify_flag', 'email_verify_flag', 'status', 'rank_id', 'audit_status', 'audit_user_id'], 'integer'],
            [['last_login_date', 'register_date', 'audit_date'], 'safe'],
            [['vip_id', 'email'], 'string', 'max' => 30],
            [['vip_name', 'password'], 'string', 'max' => 50],
            [['mobile'], 'string', 'max' => 20],
            [['audit_memo'], 'string', 'max' => 200],
            [['vip_id', 'merchant_flag'], 'unique', 'targetAttribute' => ['vip_id', 'merchant_flag'], 'message' => /* 'The combination of 会员登陆名 and 是否商户?1:是；0：否 has already been taken.' */'该手机号码已经注册'],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['audit_status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['audit_status' => 'id']],
            [['audit_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['audit_user_id' => 'id']],
            [['email_verify_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['email_verify_flag' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['merchant_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['merchant_flag' => 'id']],
            [['mobile_verify_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['mobile_verify_flag' => 'id']],
            [['rank_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipRank::className(), 'targetAttribute' => ['rank_id' => 'id']],
        	['verify_code', 'captcha','on' => [self::SCENARIO_LOGIN,self::SCENARIO_REGISTER,self::SCENARIO_FORGOT_PWD]],
        	[['confirm_pwd'], 'required','on' => [self::SCENARIO_REGISTER,self::SCENARIO_FORGOT_PWD]],
        	[['sms_code'], 'required','on' => [self::SCENARIO_REGISTER,self::SCENARIO_FORGOT_PWD]],
        	[['password','confirm_pwd'], 'string','min'=>6, 'max' => 16,'message'=>'{attribute}位数为6至16位','on' => [self::SCENARIO_REGISTER,self::SCENARIO_FORGOT_PWD]],
        	[['confirm_pwd'], 'compare','compareAttribute'=>'password','message'=>'两次密码输入不一致','on' => [self::SCENARIO_REGISTER,self::SCENARIO_FORGOT_PWD]],
//         	[['agreement'],'boolean','on' => [self::SCENARIO_REGISTER]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'vip_id' => Yii::t('app', '手机号码'),
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
        	'verify_code' => Yii::t('app', '验证码'),
        	'confirm_pwd' => Yii::t('app', '确认密码'),
        	'sms_code' => Yii::t('app', '短信验证码'),
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
    
    /**
     * 会员登陆
     */
    public function vipLogin(){
    	return null;
    }
    
    
    /**
     * 会员注册
     */
    public function vipRegister(){
    	 
    }
    
    /**
     * 商户登陆
     */
    public function merchantLogin(){
    	//判断用户名是否存在
    	$_user = $this->find()->where(['vip_id'=>$this->vip_id])->andWhere("merchant_flag=:merchant_flag",['merchant_flag'=>SysParameter::YES_FLAG])->one();
    	if(empty($_user)){
    		$this->addError("vip_id",Yii::t('app', '用户名不存在'));
    		return false;
    	}
    
    	//判断密码
    	if(!strcmp($this->password, $_user->password)==0){
    		$this->addError("password",Yii::t('app', '密码不正确'));
    		return false;
    	}
    
    	//更新最后一次登录时间
    	$_user->last_login_date = date("Y-m-d H:i:s");
    	$_user->update(true,['last_login_date']);
    
    	return $_user;
    }
    
    /**
     * 商户注册
     */
    public function merchantRegister(){
    	//判断用户名是否被注册
    	$_user = $this->find()->where(['vip_id'=>$this->vip_id])->andWhere("merchant_flag=:merchant_flag",['merchant_flag'=>SysParameter::YES_FLAG])->one();
    	if($_user){
    		$this->addError("vip_id",Yii::t('app', '用户名已经存在'));
    		return false;
    	}
    	 
    	//插入用户与店铺信息
    	$transaction = static::getDb()->beginTransaction();
    	try {
    		//插入新用户
    		$this->insert();
    
    		//     		$identityId = static::getDb()->getLastInsertID();
    		//     		$identityId = $this->getPrimaryKey();
    		$identityId = $this->id;
    
    		//插入店铺信息
    		$vipOrg = new VipOrganization();
    		$customer->id = 200;
    		$customer->save();
    		$transaction->commit();
    
    
    
    
    	} catch(\Exception $e) {
    		$transaction->rollBack();
    		throw $e;
    	}    	 
    }
    
}
