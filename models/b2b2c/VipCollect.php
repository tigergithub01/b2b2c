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
 *
 * @property Vip $vip
 * @property Activity $package
 * @property VipCase $case
 * @property Product $product
 */
class VipCollect extends \app\models\b2b2c\BasicModel
{
	/* 产品名称（查询用） */
	public $product_name;
	
	/* 会员编号（查询用） */
	public $vip_no;
	
	/* 套餐名称 （查询用） */
	public $package_name;
	
	/* 案例名称 （查询用） */
	public $case_name;
    
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
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'package_name';
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'case_name';
    	return $scenarios;
    	// 		return parent::scenarios();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vip_id', 'collect_date'], 'required'],
            [['vip_id', 'product_id', 'package_id', 'case_id', 'blog_id'], 'integer'],
            [['collect_date'], 'safe'],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['package_id' => 'id']],
            [['case_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipCase::className(), 'targetAttribute' => ['case_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
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
        	'vip.vip_id' => Yii::t('app', '会员编号'),
        	'product.name' => Yii::t('app', '关联产品'),
        	'package.name' => Yii::t('app', '关联套餐'),
        	'case.name' => Yii::t('app', '关联案例'),
        	'vip_no' => Yii::t('app', '会员编号'),
        	'product_name' => Yii::t('app', '关联产品'),
        	'package_name' => Yii::t('app', '关联套餐'),
        	'case_name' => Yii::t('app', '关联案例'),
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
