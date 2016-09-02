<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_parameter".
 *
 * @property string $id
 * @property string $type_id
 * @property string $param_val
 * @property string $description
 * @property string $seq_id
 *
 * @property ActBuyDiscount[] $actBuyDiscounts
 * @property ActBuyGivingDetail[] $actBuyGivingDetails
 * @property ActExchangeProduct[] $actExchangeProducts
 * @property Activity[] $activities
 * @property Activity[] $activities0
 * @property DeliveryType[] $deliveryTypes
 * @property DeliveryTypeTpl[] $deliveryTypeTpls
 * @property OutStockSheet[] $outStockSheets
 * @property PayType[] $payTypes
 * @property PayTypeTpl[] $payTypeTpls
 * @property PayTypeTpl[] $payTypeTpls0
 * @property PickUpPoint[] $pickUpPoints
 * @property Product[] $products
 * @property Product[] $products0
 * @property Product[] $products1
 * @property Product[] $products2
 * @property Product[] $products3
 * @property ProductComment[] $productComments
 * @property ProductComment[] $productComments0
 * @property ProductGallery[] $productGalleries
 * @property ProductTypeProp[] $productTypeProps
 * @property ProductTypeProp[] $productTypeProps0
 * @property ProductTypeProp[] $productTypeProps1
 * @property ProductTypeProp[] $productTypeProps2
 * @property RefundSheet[] $refundSheets
 * @property RefundSheetApply[] $refundSheetApplies
 * @property ReturnApply[] $returnApplies
 * @property ReturnSheet[] $returnSheets
 * @property ShoppingCart[] $shoppingCarts
 * @property ShoppingCart[] $shoppingCarts0
 * @property SoSheet[] $soSheets
 * @property SoSheet[] $soSheets0
 * @property SoSheet[] $soSheets1
 * @property SoSheet[] $soSheets2
 * @property SysAppRelease[] $sysAppReleases
 * @property SysFeedback[] $sysFeedbacks
 * @property SysModule[] $sysModules
 * @property SysModule[] $sysModules0
 * @property SysNotify[] $sysNotifies
 * @property SysParameterType $type
 * @property SysRelativeModule[] $sysRelativeModules
 * @property SysUser[] $sysUsers
 * @property SysUser[] $sysUsers0
 * @property SysVerifyCode[] $sysVerifyCodes
 * @property SysVerifyCode[] $sysVerifyCodes0
 * @property Vip[] $vips
 * @property Vip[] $vips0
 * @property Vip[] $vips1
 * @property Vip[] $vips2
 * @property VipAddress[] $vipAddresses
 * @property VipBlog[] $vipBlogs
 * @property VipBlog[] $vipBlogs0
 * @property VipBlogCmt[] $vipBlogCmts
 * @property VipCaseTypeProp[] $vipCaseTypeProps
 * @property VipCaseTypeProp[] $vipCaseTypeProps0
 * @property VipCaseTypeProp[] $vipCaseTypeProps1
 * @property VipCouponType[] $vipCouponTypes
 * @property VipOrgCase[] $vipOrgCases
 * @property VipOrgCase[] $vipOrgCases0
 * @property VipOrgCase[] $vipOrgCases1
 * @property VipOrgNotice[] $vipOrgNotices
 * @property VipOrgNotice[] $vipOrgNotices0
 * @property VipOrgNotice[] $vipOrgNotices1
 * @property VipOrganization[] $vipOrganizations
 */
class SysParameter extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_parameter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'param_val'], 'required'],
            [['id', 'type_id', 'seq_id'], 'integer'],
            [['param_val'], 'string', 'max' => 60],
            [['description'], 'string', 'max' => 200],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameterType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'type_id' => Yii::t('app', '所属参数类型编号'),
            'param_val' => Yii::t('app', '参数值'),
            'description' => Yii::t('app', '描述'),
            'seq_id' => Yii::t('app', '序号，用来显示的时候排序用'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActBuyDiscounts()
    {
        return $this->hasMany(ActBuyDiscount::className(), ['is_double' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActBuyGivingDetails()
    {
        return $this->hasMany(ActBuyGivingDetail::className(), ['is_double_give' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActExchangeProducts()
    {
        return $this->hasMany(ActExchangeProduct::className(), ['is_exchange' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivities()
    {
        return $this->hasMany(Activity::className(), ['activity_scope' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivities0()
    {
        return $this->hasMany(Activity::className(), ['activity_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveryTypes()
    {
        return $this->hasMany(DeliveryType::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveryTypeTpls()
    {
        return $this->hasMany(DeliveryTypeTpl::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutStockSheets()
    {
        return $this->hasMany(OutStockSheet::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayTypes()
    {
        return $this->hasMany(PayType::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayTypeTpls()
    {
        return $this->hasMany(PayTypeTpl::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayTypeTpls0()
    {
        return $this->hasMany(PayTypeTpl::className(), ['is_cod' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPickUpPoints()
    {
        return $this->hasMany(PickUpPoint::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['audit_status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts0()
    {
        return $this->hasMany(Product::className(), ['can_return_flag' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts1()
    {
        return $this->hasMany(Product::className(), ['is_free_shipping' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts2()
    {
        return $this->hasMany(Product::className(), ['is_on_sale' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts3()
    {
        return $this->hasMany(Product::className(), ['is_hot' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductComments()
    {
        return $this->hasMany(ProductComment::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductComments0()
    {
        return $this->hasMany(ProductComment::className(), ['cmt_rank_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductGalleries()
    {
        return $this->hasMany(ProductGallery::className(), ['primary_flag' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTypeProps()
    {
        return $this->hasMany(ProductTypeProp::className(), ['input_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTypeProps0()
    {
        return $this->hasMany(ProductTypeProp::className(), ['multi_select' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTypeProps1()
    {
        return $this->hasMany(ProductTypeProp::className(), ['is_required' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTypeProps2()
    {
        return $this->hasMany(ProductTypeProp::className(), ['is_sale_prop' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundSheets()
    {
        return $this->hasMany(RefundSheet::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundSheetApplies()
    {
        return $this->hasMany(RefundSheetApply::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReturnApplies()
    {
        return $this->hasMany(ReturnApply::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReturnSheets()
    {
        return $this->hasMany(ReturnSheet::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShoppingCarts()
    {
        return $this->hasMany(ShoppingCart::className(), ['is_gift' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShoppingCarts0()
    {
        return $this->hasMany(ShoppingCart::className(), ['is_checked' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheets()
    {
        return $this->hasMany(SoSheet::className(), ['delivery_status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheets0()
    {
        return $this->hasMany(SoSheet::className(), ['invoice_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheets1()
    {
        return $this->hasMany(SoSheet::className(), ['order_status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheets2()
    {
        return $this->hasMany(SoSheet::className(), ['pay_status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysAppReleases()
    {
        return $this->hasMany(SysAppRelease::className(), ['force_upgrade' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysFeedbacks()
    {
        return $this->hasMany(SysFeedback::className(), ['feedback_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysModules()
    {
        return $this->hasMany(SysModule::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysModules0()
    {
        return $this->hasMany(SysModule::className(), ['menu_flag' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysNotifies()
    {
        return $this->hasMany(SysNotify::className(), ['notify_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(SysParameterType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysRelativeModules()
    {
        return $this->hasMany(SysRelativeModule::className(), ['is_show' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysUsers()
    {
        return $this->hasMany(SysUser::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysUsers0()
    {
        return $this->hasMany(SysUser::className(), ['is_admin' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysVerifyCodes()
    {
        return $this->hasMany(SysVerifyCode::className(), ['verify_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysVerifyCodes0()
    {
        return $this->hasMany(SysVerifyCode::className(), ['usage_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVips()
    {
        return $this->hasMany(Vip::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVips0()
    {
        return $this->hasMany(Vip::className(), ['email_verify_flag' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVips1()
    {
        return $this->hasMany(Vip::className(), ['merchant_flag' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVips2()
    {
        return $this->hasMany(Vip::className(), ['mobile_verify_flag' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipAddresses()
    {
        return $this->hasMany(VipAddress::className(), ['default_flag' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipBlogs()
    {
        return $this->hasMany(VipBlog::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipBlogs0()
    {
        return $this->hasMany(VipBlog::className(), ['blog_flag' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipBlogCmts()
    {
        return $this->hasMany(VipBlogCmt::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipCaseTypeProps()
    {
        return $this->hasMany(VipCaseTypeProp::className(), ['is_required' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipCaseTypeProps0()
    {
        return $this->hasMany(VipCaseTypeProp::className(), ['input_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipCaseTypeProps1()
    {
        return $this->hasMany(VipCaseTypeProp::className(), ['multi_select' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipCouponTypes()
    {
        return $this->hasMany(VipCouponType::className(), ['send_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipOrgCases()
    {
        return $this->hasMany(VipOrgCase::className(), ['case_flag' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipOrgCases0()
    {
        return $this->hasMany(VipOrgCase::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipOrgCases1()
    {
        return $this->hasMany(VipOrgCase::className(), ['audit_status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipOrgNotices()
    {
        return $this->hasMany(VipOrgNotice::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipOrgNotices0()
    {
        return $this->hasMany(VipOrgNotice::className(), ['send_extend' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipOrgNotices1()
    {
        return $this->hasMany(VipOrgNotice::className(), ['notice_flag' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipOrganizations()
    {
        return $this->hasMany(VipOrganization::className(), ['status' => 'id']);
    }
}
