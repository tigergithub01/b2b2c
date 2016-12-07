<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_collect".
 *
 * @property string $id
 * @property string $vip_id
 * @property string $product_id
 * @property string $package_id
 * @property string $case_id
 * @property string $blog_id
 * @property string $collect_date
 * @property string $collect_type
 * @property string $ref_vip_id
 *
 * @property SysParameter $collectType
 * @property Vip $refVip
 * @property Activity $package
 * @property VipCase $case
 * @property Product $product
 * @property Vip $vip
 */
class VipCollect extends \app\models\b2b2c\BasicModel
{
	/* 产品名称（查询用） */
	public $product_name;
	
	/* 会员编号（查询用） */
	public $vip_no;
	
	/* 会员名称（查询用） */
	public $vip_name;
	
	
	/* 套餐名称 （查询用） */
	public $package_name;
	
	/* 案例名称 （查询用） */
	public $case_name;
	
	/* 商户名称 （查询用） */
	public $ref_vip_name;
	
	
	/* 收藏类型 */
	const collect_case = 28001; //案例
	const collect_vip = 28002; //商家
	const collect_prod = 28003; //产品
	const collect_act = 28004; //团体服务
	const collect_blog = 28005; //话题
	
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_collect';
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
    	// bypass scenarios() implementation in the parent class
    	$scenarios = parent::scenarios();
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'product_name';
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'vip_no';
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'vip_name';
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'package_name';
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'case_name';
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'ref_vip_name';
    	return $scenarios;
    	// 		return parent::scenarios();
    }

    /**
     * @inheritdoc
     */
    public function rules() 
    {
    	return [
    			[['vip_id', 'collect_date', 'collect_type'], 'required'],
    			[['vip_id', 'product_id', 'package_id', 'case_id', 'blog_id', 'collect_type', 'ref_vip_id'], 'integer'],
    			[['collect_date'], 'safe'],
    			[['collect_type'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['collect_type' => 'id']],
    			[['ref_vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['ref_vip_id' => 'id']],
    			[['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['package_id' => 'id']],
    			[['case_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipCase::className(), 'targetAttribute' => ['case_id' => 'id']],
    			[['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
    			[['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
    	];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'vip_id' => Yii::t('app', '会员编号'),
            'product_id' => Yii::t('app', '关联产品'),
            'package_id' => Yii::t('app', '关联套餐'),
            'case_id' => Yii::t('app', '关联案例'),
            'blog_id' => Yii::t('app', '关联话题'),
            'collect_date' => Yii::t('app', '收藏时间'),
            'collect_type' => Yii::t('app', '收藏类型'/* '收藏类型（话题，商家，产品，团体服务，案例）' */),
            'ref_vip_id' => Yii::t('app', '关注商家'),
        		
        	'vip.vip_id' => Yii::t('app', '会员编号'),
        	'vip.vip_name' => Yii::t('app', '会员名称'),
        	'product.name' => Yii::t('app', '关联产品'),
        	'package.name' => Yii::t('app', '关联团体服务'),
        	'case.name' => Yii::t('app', '关联案例'),
        	'refVip.vip_name' => Yii::t('app', '关注商家'),
        	'collectType.param_val' => Yii::t('app', '收藏类型'),
        		
        	'vip_no' => Yii::t('app', '会员编号'),
        	'vip_name' => Yii::t('app', '会员名称'),
        	'product_name' => Yii::t('app', '关联产品'),
        	'package_name' => Yii::t('app', '关联团体服务'),
        	'case_name' => Yii::t('app', '关联案例'),
        	'ref_vip_name' => Yii::t('app', '关联商户'),
        ];
    }

    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollectType()
    {
    	return $this->hasOne(SysParameter::className(), ['id' => 'collect_type']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefVip()
    {
    	return $this->hasOne(Vip::className(), ['id' => 'ref_vip_id']);
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
    public function getPackage()
    {
        return $this->hasOne(Activity::className(), ['id' => 'package_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCase()
    {
        return $this->hasOne(VipCase::className(), ['id' => 'case_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
