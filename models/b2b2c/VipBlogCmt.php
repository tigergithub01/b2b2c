<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_blog_cmt".
 *
 * @property string $id
 * @property string $content
 * @property string $blog_id
 * @property string $reply_date
 * @property string $vip_id
 * @property string $status
 * @property string $parent_id
 *
 * @property VipBlogCmt $parent
 * @property VipBlogCmt[] $vipBlogCmts
 * @property VipBlog $blog
 * @property Vip $vip
 * @property SysParameter $status0
 * @property VipBlogLikes[] $vipBlogLikes
 */
class VipBlogCmt extends \app\models\b2b2c\BasicModel
{
	/* 回帖标识（用来区分直接回帖与评论回复） */
	public $blog_reply_flag;
    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_blog_cmt';
    }
    
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
    	// bypass scenarios() implementation in the parent class
    	$scenarios = parent::scenarios();
    	$scenarios[self::SCENARIO_DEFAULT][]  = 'blog_reply_flag';
    	return $scenarios;
    	// 		return parent::scenarios();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'blog_id', 'reply_date', 'vip_id', 'status'], 'required'],
            [['blog_id', 'vip_id', 'status', 'parent_id'], 'integer'],
            [['reply_date'], 'safe'],
            [['content'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipBlogCmt::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['blog_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipBlog::className(), 'targetAttribute' => ['blog_id' => 'id']],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'content' => Yii::t('app', '回复内容'),
            'blog_id' => Yii::t('app', '关联帖子编号'),
            'reply_date' => Yii::t('app', '回复日期'),
            'vip_id' => Yii::t('app', '关联会员编号'),
            'status' => Yii::t('app', /* '是否显示?1:是：0:否' */'是否显示'),
            'parent_id' => Yii::t('app', '上级评论'),
        	'blog.name' => Yii::t('app', '帖子标题'),
        	'vip.vip_name' => Yii::t('app', '回帖人'),
        	'status0.param_val' => Yii::t('app', '是否显示'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(VipBlogCmt::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipBlogCmts()
    {
        return $this->hasMany(VipBlogCmt::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlog()
    {
        return $this->hasOne(VipBlog::className(), ['id' => 'blog_id']);
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
    public function getStatus0()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipBlogLikes()
    {
        return $this->hasMany(VipBlogLikes::className(), ['blog_cmt_id' => 'id']);
    }
}
