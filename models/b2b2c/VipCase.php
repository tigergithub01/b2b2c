<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_case".
 *
 * @property string $id
 * @property string $name
 * @property string $type_id
 * @property string $vip_id
 * @property string $content
 * @property string $create_date
 * @property string $update_date
 * @property string $status
 * @property string $audit_status
 * @property string $audit_user_id
 * @property string $audit_date
 * @property string $audit_memo
 * @property string $cover_img_url
 * @property string $cover_thumb_url
 * @property string $cover_img_original
 * @property string $is_hot
 * @property string $case_flag
 * @property string $market_price
 * @property string $sale_price
 * @property string $service_date
 * @property string $address
 *
 * @property SoSheet[] $soSheets
 * @property SysParameter $isHot
 * @property SysUser $auditUser
 * @property VipCaseType $type
 * @property SysParameter $caseFlag
 * @property SysParameter $status0
 * @property SysParameter $auditStatus
 * @property Vip $vip
 * @property VipCaseDetail[] $vipCaseDetails
 * @property VipCasePhoto[] $vipCasePhotos
 * @property VipCollect[] $vipCollects
 */
class VipCase extends \app\models\b2b2c\BasicModel
{
    
	/* 商户编号（查询用） */
	public $vip_no;
	
	/* 商户名称（查询用） */
	public $vip_name;
	
	//案例封面
	public $imageFile;
	
	//案例相册
	public $imageFiles;
	
	//案例相册图片地址
	public $imageUrls;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_case';
    }
    
    public function scenarios()
    {
    	// bypass scenarios() implementation in the parent class
    	$scenarios = parent::scenarios();
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'vip_no';
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'vip_name';
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'imageUrls';
    	return $scenarios;
    	// 		return parent::scenarios();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type_id', 'vip_id', 'content', 'create_date', 'update_date', 'status', 'audit_status', 'is_hot', 'sale_price', 'address', 'service_date'], 'required'],
            [['type_id', 'vip_id', 'status', 'audit_status', 'audit_user_id', 'is_hot', 'case_flag'], 'integer'],
            [['content'], 'string'],
            [['create_date', 'update_date', 'audit_date', 'service_date'], 'safe'],
            [['market_price', 'sale_price'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['audit_memo'], 'string', 'max' => 200],
            [['cover_img_url', 'cover_thumb_url', 'cover_img_original','address'], 'string', 'max' => 255],
        	[['is_hot'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['is_hot' => 'id']],
            [['audit_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['audit_user_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipCaseType::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['case_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['case_flag' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['audit_status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['audit_status' => 'id']],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
        	[['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg','maxSize'=>5*1024*1024, 'checkExtensionByMimeType' => false,'mimeTypes'=>'image/jpeg, image/png','maxFiles' => 1],
        	[['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg','maxSize'=>5*1024*1024, 'checkExtensionByMimeType' => false,'mimeTypes'=>'image/jpeg, image/png','maxFiles' => 10],
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
            'vip_id' => Yii::t('app', '关联商户编号'),
            'content' => Yii::t('app', /* '发布内容' */'案例简介'),
            'create_date' => Yii::t('app', '发布时间'),
            'update_date' => Yii::t('app', '更新时间'),
            'status' => Yii::t('app', /* '是否显示？1：是；0：否' */'是否显示'),
            'audit_status' => Yii::t('app', /* '审核状态：未审核，审核不通过，已审核' */'审核状态'),
            'audit_user_id' => Yii::t('app', '审核人'),
            'audit_date' => Yii::t('app', '审核日期'),
            'audit_memo' => Yii::t('app', '审核意见'),
            'cover_img_url' => Yii::t('app', /* '图片（放大后查看）(封面)' */'案例封面'),
            'cover_thumb_url' => Yii::t('app', '缩略图(封面)'),
            'cover_img_original' => Yii::t('app', '原图(封面)'),
            'is_hot' => Yii::t('app', /* '是否经典案例（经典案例显示在首页）' */'是否经典案例'),
            'case_flag' => Yii::t('app', '案例类别(个人案例，团体案例)'/* '案例类别？个人案例，团体案例（团体案例可以通过订单来生成，也可以手动创建）' */),
            'market_price' => Yii::t('app', '市场价'),
            'sale_price' => Yii::t('app', '销售价'),
        	'service_date' => Yii::t('app', '婚礼时间'),
        	'address' => Yii::t('app', '地址'),
        	'auditUser.user_id' => Yii::t('app', '审核人'),
        	'auditStatus.param_val' => Yii::t('app', '审核状态'),
        	'type.name' => Yii::t('app', '案例类型'),
        	'caseFlag.param_val' => Yii::t('app', '案例类别'),
        	'status0.param_val' => Yii::t('app', '是否已删除'),
        	'isHot.param_val' => Yii::t('app', '是否经典案例'),
        	'vip.vip_id' => Yii::t('app', '商户编号'),
        	'vip.vip_name' => Yii::t('app', '商户名称'),
        	'vip_no' => Yii::t('app', '商户编号'),
        	'vip_name' => Yii::t('app', '商户名称'),
        	'imageFile' => Yii::t('app', '案例封面'),
        	'imageFiles' => Yii::t('app', '案例相册'),	
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheets()
    {
        return $this->hasMany(SoSheet::className(), ['related_case_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIsHot()
    {
    	return $this->hasOne(SysParameter::className(), ['id' => 'is_hot']);
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
    public function getCaseFlag()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'case_flag']);
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
    public function getVip()
    {
        return $this->hasOne(Vip::className(), ['id' => 'vip_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipCaseDetails()
    {
        return $this->hasMany(VipCaseDetail::className(), ['case_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipCasePhotos()
    {
        return $this->hasMany(VipCasePhoto::className(), ['case_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipCollects()
    {
        return $this->hasMany(VipCollect::className(), ['case_id' => 'id']);
    }
}
