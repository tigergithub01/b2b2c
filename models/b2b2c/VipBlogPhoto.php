<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_blog_photo".
 *
 * @property string $id
 * @property string $blog_id
 * @property string $img_url
 * @property string $thumb_url
 * @property string $img_original
 *
 * @property VipBlog $blog
 */
class VipBlogPhoto extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_blog_photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blog_id', 'img_url', 'thumb_url', 'img_original'], 'required'],
            [['blog_id'], 'integer'],
            [['img_url', 'thumb_url', 'img_original'], 'string', 'max' => 255],
            [['blog_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipBlog::className(), 'targetAttribute' => ['blog_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'blog_id' => Yii::t('app', '关联博客编号'),
            'img_url' => Yii::t('app', '图片（放大后查看）'),
            'thumb_url' => Yii::t('app', '缩略图'),
            'img_original' => Yii::t('app', '原始图片'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlog()
    {
        return $this->hasOne(VipBlog::className(), ['id' => 'blog_id']);
    }
}
