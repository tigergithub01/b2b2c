<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_activity".
 *
 * @property string $id
 * @property string $name
 * @property string $activity_type
 * @property string $activity_scope
 * @property string $start_time
 * @property string $end_date
 * @property string $description
 * @property string $market_price
 * @property string $package_price
 * @property string $deposit_amount
 * @property integer $buy_limit_num
 * @property string $vip_id
 * @property string $img_url
 * @property string $thumb_url
 * @property string $img_original
 * @property string $audit_status
 * @property string $audit_user_id
 * @property string $audit_date
 *
 * @property ActBuyDiscount[] $actBuyDiscounts
 * @property ActBuyGivingDetail[] $actBuyGivingDetails
 * @property ActPackageProduct[] $actPackageProducts
 * @property ActScope[] $actScopes
 * @property ActSpecialPrice[] $actSpecialPrices
 * @property ActivityType $activityType
 * @property Vip $vip
 * @property SysParameter $auditStatus
 * @property SysUser $auditUser
 * @property SysParameter $activityScope
 * @property ProductComment[] $productComments
 * @property ShoppingCart[] $shoppingCarts
 * @property SoSheetDetail[] $soSheetDetails
 * @property VipCollect[] $vipCollects
 */
class Activity extends \app\models\b2b2c\BasicModel
{
	/* 商户编号（查询用） */
	public $vip_no;
	
	//封面
	public $imageFile;
	
	/* 活动类型 */
	const act_package = 1; //优惠套装，团体服务
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_activity';
    }
    
    public function scenarios()
    {
    	// bypass scenarios() implementation in the parent class
    	$scenarios = parent::scenarios();
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'vip_no';
    	return $scenarios;
    	// 		return parent::scenarios();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'activity_type', 'start_time', 'end_date', 'vip_id', 'audit_status'], 'required'],
            [['activity_type', 'activity_scope', 'buy_limit_num', 'vip_id', 'audit_status', 'audit_user_id'], 'integer'],
            [['start_time', 'end_date', 'audit_date'], 'safe'],
            [['package_price', 'deposit_amount', 'market_price'], 'number'],
            [['name'], 'string', 'max' => 30],
            [['description', 'img_url', 'thumb_url', 'img_original'], 'string', 'max' => 255],
            [['activity_type'], 'exist', 'skipOnError' => true, 'targetClass' => ActivityType::className(), 'targetAttribute' => ['activity_type' => 'id']],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['audit_status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['audit_status' => 'id']],
            [['audit_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['audit_user_id' => 'id']],
            [['activity_scope'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['activity_scope' => 'id']],
        	[['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg','maxSize'=>5*1024*1024, 'checkExtensionByMimeType' => false,'mimeTypes'=>'image/jpeg, image/png','maxFiles' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'name' => Yii::t('app', /* '买赠活动名称' */'团队名称'),
            'activity_type' => Yii::t('app', '活动类型（特价促销，优惠套装，产品满几件赠几件，满金额赠送产品、折扣、满金额减金额）'),
            'activity_scope' => Yii::t('app', '是否全场参与活动'),
            'start_time' => Yii::t('app', '开始时间'),
            'end_date' => Yii::t('app', '结束时间'),
            'description' => Yii::t('app', /* '活动描述' */'描述'),
        	'market_price' => Yii::t('app', /* '套装价' */'市场价'),
            'package_price' => Yii::t('app', /* '套装价' */'销售价'),
            'deposit_amount' => Yii::t('app', '最少定金金额'),
            'buy_limit_num' => Yii::t('app', '限购数量'),
            'vip_id' => Yii::t('app', '关联商户编号'),
            'img_url' => Yii::t('app', /* '图片（放大后查看）(上传商品图片后自动加入商品相册）' */'团体封面'),
            'thumb_url' => Yii::t('app', '缩略图'),
            'img_original' => Yii::t('app', '原图'),
            'audit_status' => Yii::t('app', /* '审核状态：未审核，审核不通过，已审核' */'审核状态'),
            'audit_user_id' => Yii::t('app', '审核人'),
            'audit_date' => Yii::t('app', '审核日期'),
        	'activityType.name' => '活动类型',
        	'vip.vip_id' => '商家编号',
        	'vip.vip_name' => '商家名称',
        	'auditStatus.param_val' => '审核状态',
        	'auditUser.user_id' => '审核人',
        	'actScopes.param_val' => '是否全场参与活动',
        	'vip_no' => Yii::t('app', '商户编号'),
        	'imageFile' => Yii::t('app', '团体封面'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActBuyDiscounts()
    {
        return $this->hasMany(ActBuyDiscount::className(), ['act_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActBuyGivingDetails()
    {
        return $this->hasMany(ActBuyGivingDetail::className(), ['act_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActPackageProducts()
    {
        return $this->hasMany(ActPackageProduct::className(), ['act_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActScopes()
    {
        return $this->hasMany(ActScope::className(), ['act_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActSpecialPrices()
    {
        return $this->hasMany(ActSpecialPrice::className(), ['act_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityType()
    {
        return $this->hasOne(ActivityType::className(), ['id' => 'activity_type']);
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
    public function getActivityScope()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'activity_scope']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductComments()
    {
    	return $this->hasMany(ProductComment::className(), ['package_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShoppingCarts()
    {
        return $this->hasMany(ShoppingCart::className(), ['package_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheetDetails()
    {
        return $this->hasMany(SoSheetDetail::className(), ['package_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipCollects()
    {
        return $this->hasMany(VipCollect::className(), ['package_id' => 'id']);
    }
}
