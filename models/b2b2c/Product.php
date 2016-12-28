<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_product".
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $type_id
 * @property string $brand_id
 * @property string $market_price
 * @property string $sale_price
 * @property string $deposit_amount
 * @property string $description
 * @property string $is_on_sale
 * @property string $is_hot
 * @property string $audit_status
 * @property string $audit_user_id
 * @property string $audit_date
 * @property string $stock_quantity
 * @property string $safety_quantity
 * @property string $can_return_flag
 * @property string $return_days
 * @property string $return_desc
 * @property string $cost_price
 * @property string $vip_id
 * @property string $keywords
 * @property string $is_free_shipping
 * @property integer $give_integral
 * @property integer $rank_integral
 * @property integer $integral
 * @property string $relative_module
 * @property integer $bonus
 * @property string $product_weight
 * @property string $product_weight_unit
 * @property string $product_group_id
 * @property string $img_url
 * @property string $thumb_url
 * @property string $img_original
 * @property string $service_flag
 *
 * @property ActBuyGivingDetail[] $actBuyGivingDetails
 * @property ActBuyGivingDetailPkg[] $actBuyGivingDetailPkgs
 * @property ActExchangeProduct[] $actExchangeProducts
 * @property ActPackageProduct[] $actPackageProducts
 * @property ActPackageProduct[] $actPackageProducts0
 * @property ActScope[] $actScopes
 * @property ActSpecialPrice[] $actSpecialPrices
 * @property OutStockSheetDetail[] $outStockSheetDetails
 * @property SysParameter $serviceFlag
 * @property Vip $vip
 * @property SysParameter $auditStatus
 * @property SysUser $auditUser
 * @property SysParameter $canReturnFlag
 * @property SysParameter $isFreeShipping
 * @property SysParameter $isOnSale
 * @property ProductBrand $brand
 * @property SysRelativeModule $relativeModule
 * @property SysParameter $isHot
 * @property ProductGroup $productGroup
 * @property ProductType $type
 * @property ProductComment[] $productComments
 * @property ProductGallery[] $productGalleries
 * @property ProductHomeAds[] $productHomeAds
 * @property ProductProdSale[] $productProdSales
 * @property ProductProp[] $productProps
 * @property ProductStock[] $productStocks
 * @property ProductVipPrice[] $productVipPrices
 * @property ReturnApplyDetail[] $returnApplyDetails
 * @property ReturnSheetDetail[] $returnSheetDetails
 * @property ShoppingCart[] $shoppingCarts
 * @property SoSheetDetail[] $soSheetDetails
 * @property VipCaseDetail[] $vipCaseDetails
 * @property VipCollect[] $vipCollects
 */
class Product extends \app\models\b2b2c\BasicModel
{
	/* 产品状态：正常销售 */
	const is_on_sale_yes = 2001;
	
	/* 产品状态：下架 */
	const is_on_sale_no = 2002;
	
	//场景
	const SCENARIO_MERCHANT_REG = 'merchant_reg';//商户信息完善
	
	//案例封面
	public $imageFile;
	
	//案例相册
	public $imageFiles;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type_id', 'market_price', 'sale_price', 'deposit_amount', 'is_on_sale', 'is_hot', 'audit_status', 'can_return_flag', 'vip_id', 'is_free_shipping', 'service_flag'], 'required'],
            [['type_id', 'brand_id', 'is_on_sale', 'is_hot', 'audit_status', 'audit_user_id', 'can_return_flag', 'return_days', 'vip_id', 'is_free_shipping', 'give_integral', 'rank_integral', 'integral', 'relative_module', 'bonus', 'product_weight_unit', 'product_group_id', 'service_flag'], 'integer'],
            [['market_price', 'sale_price', 'deposit_amount', 'stock_quantity', 'safety_quantity', 'cost_price', 'product_weight'], 'number'],
            [['description', 'return_desc'], 'string'],
            [['audit_date'], 'safe'],
            [['code'], 'string', 'max' => 30],
            [['name'], 'string', 'max' => 60],
            [['keywords'], 'string', 'max' => 100],
            [['img_url', 'thumb_url', 'img_original'], 'string', 'max' => 255],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
        	[['service_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['service_flag' => 'id']],
            [['audit_status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['audit_status' => 'id']],
            [['audit_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['audit_user_id' => 'id']],
            [['can_return_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['can_return_flag' => 'id']],
            [['is_free_shipping'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['is_free_shipping' => 'id']],
            [['is_on_sale'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['is_on_sale' => 'id']],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductBrand::className(), 'targetAttribute' => ['brand_id' => 'id']],
            [['relative_module'], 'exist', 'skipOnError' => true, 'targetClass' => SysRelativeModule::className(), 'targetAttribute' => ['relative_module' => 'id']],
            [['is_hot'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['is_hot' => 'id']],
            [['product_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductGroup::className(), 'targetAttribute' => ['product_group_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductType::className(), 'targetAttribute' => ['type_id' => 'id']],
        	[['market_price', 'sale_price', 'deposit_amount'], 'required','on' => [self::SCENARIO_MERCHANT_REG,]],
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
            'code' => Yii::t('app', '产品唯一编码'),
            'name' => Yii::t('app', '产品名称'),
            'type_id' => Yii::t('app', '产品分类'),
            'brand_id' => Yii::t('app', '品牌'),
            'market_price' => Yii::t('app', '市场价'),
            'sale_price' => Yii::t('app', '销售价'),
            'deposit_amount' => Yii::t('app', '定金金额'),
            'description' => Yii::t('app', '产品描述'),
            'is_on_sale' => Yii::t('app', '产品状态（1:正常销售、0:下架）'),
            'is_hot' => Yii::t('app', '是否热销商品？1：是；0：否'),
            'audit_status' => Yii::t('app', '审核状态：未审核，审核不通过，审核通过'),
            'audit_user_id' => Yii::t('app', '审核人'),
            'audit_date' => Yii::t('app', '审核时间'),
            'stock_quantity' => Yii::t('app', '库存数量'),
            'safety_quantity' => Yii::t('app', '安全库存'),
            'can_return_flag' => Yii::t('app', '是否能退货（1:可以、0:不可以）'),
            'return_days' => Yii::t('app', '可退货天数(可以退货时才设置此字段)'),
            'return_desc' => Yii::t('app', '退货规则描述'),
            'cost_price' => Yii::t('app', '成本价'),
            'vip_id' => Yii::t('app', '关联商户编号'),
            'keywords' => Yii::t('app', '商品关键字，供检索用'),
            'is_free_shipping' => Yii::t('app', '是否免运费商品'),
            'give_integral' => Yii::t('app', '赠送消费积分数'),
            'rank_integral' => Yii::t('app', '赠送等级积分数'),
            'integral' => Yii::t('app', '积分购买金额'),
            'relative_module' => Yii::t('app', '关联版式'),
            'bonus' => Yii::t('app', '红包购买金额'),
            'product_weight' => Yii::t('app', '商品重量'),
            'product_weight_unit' => Yii::t('app', '商品重量单位'),
            'product_group_id' => Yii::t('app', '产品分组编号'),
            'img_url' => Yii::t('app', '图片（放大后查看）(上传商品图片后自动加入商品相册）'),
            'thumb_url' => Yii::t('app', '缩略图'),
            'img_original' => Yii::t('app', '原图'),
        	'service_flag' => Yii::t('app', '是否个人服务？1：是；0：否（每个商户只有一个个人服务）'),
        	'brand.name' => Yii::t('app', '品牌'),
        	'type.name' => Yii::t('app', '产品分类'),
        	'vip.vip_id' => Yii::t('app', '关联商户编号'),
        	'vip.vip_name' => Yii::t('app', '关联商户'),
        	'isOnSale.param_val' => Yii::t('app', '产品状态'),
        	'isHot.param_val' => Yii::t('app', '是否热销商品'),
        	'auditStatus.param_val' => Yii::t('app', '审核状态'),
        	'canReturnFlag.param_val' => Yii::t('app', '是否能退货'),
        	'isFreeShipping.param_val' => Yii::t('app', '是否免运费'),
        	'imageFile' => Yii::t('app', '产品图片'),
        	'imageFiles' => Yii::t('app', '产品相册'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActBuyGivingDetails()
    {
        return $this->hasMany(ActBuyGivingDetail::className(), ['giving_product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActBuyGivingDetailPkgs()
    {
        return $this->hasMany(ActBuyGivingDetailPkg::className(), ['giving_product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActExchangeProducts()
    {
        return $this->hasMany(ActExchangeProduct::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActPackageProducts()
    {
        return $this->hasMany(ActPackageProduct::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActPackageProducts0()
    {
        return $this->hasMany(ActPackageProduct::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActScopes()
    {
        return $this->hasMany(ActScope::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActSpecialPrices()
    {
        return $this->hasMany(ActSpecialPrice::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutStockSheetDetails()
    {
        return $this->hasMany(OutStockSheetDetail::className(), ['product_id' => 'id']);
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
    public function getServiceFlag()
    {
    	return $this->hasOne(SysParameter::className(), ['id' => 'service_flag']);
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
    public function getCanReturnFlag()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'can_return_flag']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIsFreeShipping()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'is_free_shipping']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIsOnSale()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'is_on_sale']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(ProductBrand::className(), ['id' => 'brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelativeModule()
    {
        return $this->hasOne(SysRelativeModule::className(), ['id' => 'relative_module']);
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
    public function getProductGroup()
    {
        return $this->hasOne(ProductGroup::className(), ['id' => 'product_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ProductType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductComments()
    {
        return $this->hasMany(ProductComment::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductGalleries()
    {
        return $this->hasMany(ProductGallery::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductHomeAds()
    {
        return $this->hasMany(ProductHomeAds::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductProdSales()
    {
        return $this->hasMany(ProductProdSale::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductProps()
    {
        return $this->hasMany(ProductProp::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductStocks()
    {
        return $this->hasMany(ProductStock::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductVipPrices()
    {
        return $this->hasMany(ProductVipPrice::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReturnApplyDetails()
    {
        return $this->hasMany(ReturnApplyDetail::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReturnSheetDetails()
    {
        return $this->hasMany(ReturnSheetDetail::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShoppingCarts()
    {
        return $this->hasMany(ShoppingCart::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheetDetails()
    {
        return $this->hasMany(SoSheetDetail::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipCaseDetails()
    {
        return $this->hasMany(VipCaseDetail::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipCollects()
    {
        return $this->hasMany(VipCollect::className(), ['product_id' => 'id']);
    }
}
