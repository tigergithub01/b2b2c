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
 * @property string $package_price
 * @property string $deposit_amount
 * @property integer $buy_limit_num
 * @property string $vip_id
 * @property string $img_url
 * @property string $thumb_url
 * @property string $img_original
 *
 * @property ActBuyDiscount[] $actBuyDiscounts
 * @property ActBuyGivingDetail[] $actBuyGivingDetails
 * @property ActPackageProduct[] $actPackageProducts
 * @property ActScope[] $actScopes
 * @property ActSpecialPrice[] $actSpecialPrices
 * @property Vip $vip
 * @property SysParameter $activityScope
 * @property SysParameter $activityType
 * @property ShoppingCart[] $shoppingCarts
 * @property SoSheetDetail[] $soSheetDetails
 * @property VipCollect[] $vipCollects
 */
class Activity extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'activity_type', 'start_time', 'end_date', 'vip_id'], 'required'],
            [['activity_type', 'activity_scope', 'buy_limit_num', 'vip_id'], 'integer'],
            [['start_time', 'end_date'], 'safe'],
            [['package_price', 'deposit_amount'], 'number'],
            [['name'], 'string', 'max' => 30],
            [['description', 'img_url', 'thumb_url', 'img_original'], 'string', 'max' => 255],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['activity_scope'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['activity_scope' => 'id']],
            [['activity_type'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['activity_type' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'name' => Yii::t('app', '买赠活动名称'),
            'activity_type' => Yii::t('app', '活动类型（特价促销，优惠套装，产品满几件赠几件，满金额赠送产品、折扣、满金额减金额）'),
            'activity_scope' => Yii::t('app', '是否全场参与活动'),
            'start_time' => Yii::t('app', '开始时间'),
            'end_date' => Yii::t('app', '结束时间'),
            'description' => Yii::t('app', '活动描述'),
            'package_price' => Yii::t('app', '套装价'),
            'deposit_amount' => Yii::t('app', '最少定金金额'),
            'buy_limit_num' => Yii::t('app', '限购数量'),
            'vip_id' => Yii::t('app', '关联商户编号'),
            'img_url' => Yii::t('app', '图片（放大后查看）(上传商品图片后自动加入商品相册）'),
            'thumb_url' => Yii::t('app', '缩略图'),
            'img_original' => Yii::t('app', '原图'),
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
    public function getVip()
    {
        return $this->hasOne(Vip::className(), ['id' => 'vip_id']);
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
    public function getActivityType()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'activity_type']);
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
