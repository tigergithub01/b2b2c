<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_product_comment".
 *
 * @property string $id
 * @property string $product_id
 * @property string $vip_id
 * @property string $cmt_rank_id
 * @property string $content
 * @property string $comment_date
 * @property string $ip_addr
 * @property string $status
 * @property string $parent_id
 * @property string $order_id
 * @property string $package_id
 *
 *
 * @property SoSheet $order
 * @property Activity $package
 * @property SysParameter $status0
 * @property SysParameter $cmtRank
 * @property ProductComment $parent
 * @property ProductComment[] $productComments
 * @property Vip $vip
 * @property Product $product
 * @property ProductCommentPhoto[] $productCommentPhotos
 * @property ProductCommentReply[] $productCommentReplies
 */
class ProductComment extends \app\models\b2b2c\BasicModel
{
	/* 产品名称（查询用） */
	public $product_name;
	
	/* 会员名（查询用） */
	public $vip_no;
	
	/* 会员名（查询用） */
	public $vip_name;
	
	/* 团体服务名（查询用） */
	public $package_name;
	
	/* 商户主键（查询用） */
	public $merchant_id;
	
	/* 评价等级： */
	const cmt_1_star = 12001; // 差评-1星
	const cmt_2_star = 12002; // 中评-2星
	const cmt_3_star = 12003; // 中评-3星
	const cmt_4_star = 12004; // 好评-4星
	const cmt_5_star = 12005; // 好评-5星
	
	//图片
	public $imageFiles;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_product_comment';
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
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'merchant_id';
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'vip_name';
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'package_name';
    	return $scenarios;
    	// 		return parent::scenarios();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'vip_id', 'cmt_rank_id', 'status', 'parent_id', 'order_id', 'package_id'], 'integer'],
            [['vip_id', 'content', 'comment_date', 'ip_addr', 'status'], 'required'],
            [['comment_date'], 'safe'],
            [['content'], 'string', 'max' => 300],
            [['ip_addr'], 'string', 'max' => 15],
        	[['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => SoSheet::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['cmt_rank_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['cmt_rank_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductComment::className(), 'targetAttribute' => ['parent_id' => 'id']],
        	[['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['package_id' => 'id']],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        	[['imageFiles'], 'file', 'skipOnEmpty' => true, /* 'extensions' => 'png, jpg', */'maxSize'=>5*1024*1024, 'checkExtensionByMimeType' => false,'mimeTypes'=>'image/jpeg, image/png','maxFiles' => 10],//客户端上传的文件扩展名很特殊，去掉扩展名验证
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'product_id' => Yii::t('app', /* '关联产品编号（评价商品时写此字段)' */'个人服务'),
            'vip_id' => Yii::t('app', '会员编号'),
            'cmt_rank_id' => Yii::t('app', '评价等级'/* '评价等级（好评、中评、差评）(也可以是星级1：差；2，3：中，4，5：好）' */),
            'content' => Yii::t('app', '评价内容'),
            'comment_date' => Yii::t('app', '评价时间'),
            'ip_addr' => Yii::t('app', '评价IP地址'),
            'status' => Yii::t('app', '是否显示？1：是；0：否'),
            'parent_id' => Yii::t('app', '上级评价'),
        	'order_id' => Yii::t('app', '关联订单编号'),
        	'package_id' => Yii::t('app', '团体服务编号'),
        	'status0.param_val' => '是否显示',
        	'cmtRank.param_val' => '评价等级',
        	'vip.vip_id' => '会员',
        	'vip.vip_name' => '会员名称',
        	'product.name' => '商户名称',
        	'package.name' => '团体服务名称',
        	'package_name' => '团体服务名称',
        	'product_name'  => /* '产品名称' */'商户名称',
        	'vip_no'  => '会员编号',
        	'vip_name' => '会员名',
        	'imageFiles' => Yii::t('app', '评论图片'),
        	'order.code' => '订单编号',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
    	return $this->hasOne(SoSheet::className(), ['id' => 'order_id']);
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
    public function getCmtRank()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'cmt_rank_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ProductComment::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductComments()
    {
        return $this->hasMany(ProductComment::className(), ['parent_id' => 'id']);
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
    public function getVip()
    {
        return $this->hasOne(Vip::className(), ['id' => 'vip_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCommentPhotos()
    {
        return $this->hasMany(ProductCommentPhoto::className(), ['comment_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCommentReplies()
    {
        return $this->hasMany(ProductCommentReply::className(), ['comment_id' => 'id']);
    }
}
