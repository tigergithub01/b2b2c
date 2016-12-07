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
 * @property string $content
 * @property string $create_date
 * @property string $update_date
 * @property string $audit_user_id
 * @property string $audit_status
 * @property string $audit_date
 * @property string $audit_memo
 * @property string $status
 * @property string $name
 *
 * @property SysParameter $auditStatus
 * @property SysUser $auditUser
 * @property Vip $vip
 * @property SysParameter $status0
 * @property SysParameter $blogFlag
 * @property VipBlogType $blogType
 * @property VipBlogCmt[] $vipBlogCmts
 * @property VipBlogLikes[] $vipBlogLikes
 * @property VipBlogPhoto[] $vipBlogPhotos
 */
class VipBlog extends \app\models\b2b2c\BasicModel
{
	
	/* 商户、会员帖子标志 */
	const blog_flag_merchant = 16002; //商户博客
	const blog_flag_vip = 16001; //会员博客
	
	/* 会员编号（查询用） */
	public $vip_no;
	
	/* 会员名称（查询用） */
	public $vip_name;
	
	/* 起始日期 （查询用） */
	public $start_date;
	
	/* 结束日期 （查询用） */
	public $end_date;
	
	//帖子图片
	public $imageFiles;
	
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
    public function scenarios()
    {
    	// bypass scenarios() implementation in the parent class
    	$scenarios = parent::scenarios();
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'vip_no';
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'vip_name';
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'start_date';
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'end_date';
    	return $scenarios;
    	// 		return parent::scenarios();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blog_type', 'blog_flag', 'vip_id', 'audit_user_id', 'audit_status', 'status'], 'integer'],
            [['blog_flag', 'content', 'create_date', 'update_date', 'audit_status', 'status', 'name'], 'required'],
            [['content'], 'string'],
            [['create_date', 'update_date', 'audit_date'], 'safe'],
            [['audit_memo', 'name'], 'string', 'max' => 200],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
        	[['audit_status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['audit_status' => 'id']],
        	[['audit_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['audit_user_id' => 'id']],
        	[['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['blog_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['blog_flag' => 'id']],
            [['blog_type'], 'exist', 'skipOnError' => true, 'targetClass' => VipBlogType::className(), 'targetAttribute' => ['blog_type' => 'id']],
        	[['imageFiles'], 'file', 'skipOnEmpty' => true, /* 'extensions' => 'png, jpg', */'maxSize'=>5*1024*1024, 'checkExtensionByMimeType' => false,'mimeTypes'=>'image/jpeg, image/png','maxFiles' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
        	'name' => Yii::t('app', '帖子标题'),
            'blog_type' => Yii::t('app', '博客频道'),
            'blog_flag' => Yii::t('app', /* '博客分类(会员博客，商户博客)' */'博客分类'),
            'vip_id' => Yii::t('app', '关联会员编号'),
            'content' => Yii::t('app', '发布内容'),
            'create_date' => Yii::t('app', '发布时间'),
            'update_date' => Yii::t('app', '更新时间'),
            'audit_user_id' => Yii::t('app', '审核人'),
            'audit_status' => Yii::t('app', /* '审核状态（未审核，审核通过，审核不通过）' */'审核状态'),
            'audit_date' => Yii::t('app', '审核日期'),
            'audit_memo' => Yii::t('app', '审核意见（不通过时必须填写）'),
            'status' => Yii::t('app', '是否显示？1：是；0：否'),
        	'vip.vip_id' => Yii::t('app', '会员编号'),
        	'vip.vip_name' => Yii::t('app', '会员(商户)名称'),
        	'blogType.name' => Yii::t('app', '博客频道'),
        	'blogFlag.param_val' => Yii::t('app', /* '博客分类(会员博客，商户博客)' */'博客分类'),
        	'status0.param_val' => Yii::t('app', '是否显示'),
        	'auditStatus.param_val' => Yii::t('app', '审核状态'),
        	'auditUser.user_id' => Yii::t('app', '审核人'),
        	'vip_no' => Yii::t('app', '会员编号'),
        	'vip_name' => Yii::t('app', '会员(商户)名称'),
        	'start_date' => Yii::t('app', '日期'),
        	'end_date' => Yii::t('app', '结束日期'),
        	'imageFiles' => Yii::t('app', '帖子图片'),
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
    public function getVipBlogLikes()
    {
        return $this->hasMany(VipBlogLikes::className(), ['blog_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipBlogPhotos()
    {
        return $this->hasMany(VipBlogPhoto::className(), ['blog_id' => 'id']);
    }
}
