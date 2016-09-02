<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_blog_type".
 *
 * @property string $id
 * @property string $name
 * @property string $parent_id
 *
 * @property VipBlog[] $vipBlogs
 * @property VipBlogType $parent
 * @property VipBlogType[] $vipBlogTypes
 */
class VipBlogType extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_blog_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipBlogType::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'name' => Yii::t('app', '名字'),
            'parent_id' => Yii::t('app', '上级频道分类'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipBlogs()
    {
        return $this->hasMany(VipBlog::className(), ['blog_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(VipBlogType::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipBlogTypes()
    {
        return $this->hasMany(VipBlogType::className(), ['parent_id' => 'id']);
    }
}
