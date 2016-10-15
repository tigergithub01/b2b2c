<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_blog_likes".
 *
 * @property string $id
 * @property string $vip_id
 * @property string $blog_id
 * @property string $blog_cmt_id
 * @property string $create_date
 *
 * @property VipBlog $blog
 * @property VipBlogCmt $blogCmt
 * @property Vip $vip
 */
class VipBlogLikes extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_blog_likes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vip_id', 'create_date'], 'required'],
            [['vip_id', 'blog_id', 'blog_cmt_id'], 'integer'],
            [['create_date'], 'safe'],
            [['blog_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipBlog::className(), 'targetAttribute' => ['blog_id' => 'id']],
            [['blog_cmt_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipBlogCmt::className(), 'targetAttribute' => ['blog_cmt_id' => 'id']],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'vip_id' => Yii::t('app', '点赞会员'),
            'blog_id' => Yii::t('app', '关联博客'),
            'blog_cmt_id' => Yii::t('app', '关联博客评论'),
            'create_date' => Yii::t('app', '点赞日期'),
        ];
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
    public function getBlogCmt()
    {
        return $this->hasOne(VipBlogCmt::className(), ['id' => 'blog_cmt_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVip()
    {
        return $this->hasOne(Vip::className(), ['id' => 'vip_id']);
    }
}
