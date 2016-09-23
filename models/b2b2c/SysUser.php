<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_user".
 *
 * @property string $id
 * @property string $user_id
 * @property string $user_name
 * @property string $password
 * @property string $is_admin
 * @property string $status
 * @property string $last_login_date
 *
 * @property OutStockSheet[] $outStockSheets
 * @property Product[] $products
 * @property ProductCommentReply[] $productCommentReplies
 * @property RefundSheet[] $refundSheets
 * @property ReturnSheet[] $returnSheets
 * @property SheetLog[] $sheetLogs
 * @property SysAppRelease[] $sysAppReleases
 * @property SysAuditLog[] $sysAuditLogs
 * @property SysOperationLog[] $sysOperationLogs
 * @property SysRoleUser[] $sysRoleUsers
 * @property SysParameter $status0
 * @property SysParameter $isAdmin
 * @property Vip[] $vips
 * @property VipExtend[] $vipExtends
 * @property VipOrgCase[] $vipOrgCases
 * @property VipOrganization[] $vipOrganizations
 */
class SysUser extends \app\models\b2b2c\BasicModel
{
	//记住密码（登陆)
	public $remember_me = true;
	
	//图形验证码
	public $verify_code;
	
	//确认密码
	public $confirm_pwd;
	
	//新密码(登陆后修改密码）
	public $new_pwd;
		
	const SCENARIO_LOGIN = 'login';//登陆
	const SCENARIO_REGISTER = 'register';
	const SCENARIO_AUTO_LOGIN = 'auto_login';//自动登陆
	const SCENARIO_CHANGE_PWD = 'change_pwd'; //登陆后修改密码
	
	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios[self::SCENARIO_LOGIN] = ['user_id', 'password','remember_me','verify_code'];
		$scenarios[self::SCENARIO_AUTO_LOGIN] = ['user_id', 'password'];
		$scenarios[self::SCENARIO_CHANGE_PWD] = ['password', 'confirm_pwd', 'new_pwd'];
		
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
        return 't_sys_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//         	[['user_id', 'password', 'is_admin', 'status'], 'required', 'on' => [self::SCENARIO_LOGIN,parent::SCENARIO_DEFAULT]],
            [['user_id', 'password', 'is_admin', 'status'], 'required'],
            [['is_admin', 'status'], 'integer'],
            [['last_login_date'], 'safe'],
            [['user_id'], 'string', 'max' => 20],
            [['user_name'], 'string', 'max' => 60],
            [['password'], 'string', 'max' => 50],
            [['user_id'], 'unique','on' => [self::SCENARIO_DEFAULT]],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['is_admin'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['is_admin' => 'id']],
        	['verify_code', 'captcha','on' => [self::SCENARIO_LOGIN]],
        	[['new_pwd','confirm_pwd'], 'required','on' => [self::SCENARIO_CHANGE_PWD]],
        	[['confirm_pwd'], 'compare','compareAttribute'=>'new_pwd','message'=>'两次密码输入不一致','on' => [self::SCENARIO_CHANGE_PWD]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'user_id' => Yii::t('app', '用户名'),//用户名(登陆名）
            'user_name' => Yii::t('app', '姓名'),
            'password' => Yii::t('app', '密码'),
            'is_admin' => Yii::t('app', '是否管理员'),
            'status' => Yii::t('app', '是否有效'),
            'last_login_date' => Yii::t('app', '最后一次登陆时间'),
        	'verify_code' => Yii::t('app', '验证码'),
        	'new_pwd' => Yii::t('app', '新密码'),
        	'confirm_pwd' => Yii::t('app', '确认密码'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutStockSheets()
    {
        return $this->hasMany(OutStockSheet::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['audit_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCommentReplies()
    {
        return $this->hasMany(ProductCommentReply::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundSheets()
    {
        return $this->hasMany(RefundSheet::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReturnSheets()
    {
        return $this->hasMany(ReturnSheet::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSheetLogs()
    {
        return $this->hasMany(SheetLog::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysAppReleases()
    {
        return $this->hasMany(SysAppRelease::className(), ['issue_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysAuditLogs()
    {
        return $this->hasMany(SysAuditLog::className(), ['audit_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysOperationLogs()
    {
        return $this->hasMany(SysOperationLog::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysRoleUsers()
    {
        return $this->hasMany(SysRoleUser::className(), ['user_id' => 'id']);
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
    public function getIsAdmin()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'is_admin']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVips()
    {
        return $this->hasMany(Vip::className(), ['audit_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipExtends()
    {
        return $this->hasMany(VipExtend::className(), ['audit_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipOrgCases()
    {
        return $this->hasMany(VipOrgCase::className(), ['audit_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipOrganizations()
    {
        return $this->hasMany(VipOrganization::className(), ['audit_user_id' => 'id']);
    }
    
    public function login(){
    	//判断用户名是否存在
    	$_user = $this->find()->where(['user_id'=>$this->user_id])->one();
    	if(empty($_user)){
    		$this->addError("user_id",Yii::t('app', '用户名不存在'));
    		return false;
    	}
    	
    	//判断用户是否有效
    	if($_user->status==SysParameter::param_no){
    		$this->addError("user_id",Yii::t('app', '用户未激活'));
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
     * 初始化插入一个系统管理员
     */
    public function insertSystemUser(){
    	//     	$model = new SysUser();
    	// 		'user_id', 'password', 'is_admin', 'status'
    	$_usr = SysUser::find()->where('user_id=:p_user_id',['p_user_id'=>'admin'])->one();
    	if(empty($_usr)){
    		$this->user_id='admin';
    		$this->password=md5("admin123");
    		$this->is_admin =1;
    		$this->status = 1;
    		$this->validate();
    		$success = $this->save();
    		Yii::info("insertSystemUsr $success");
    	}
    }
    
}
