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
            [['id', 'name'], 'required'],
            [['id', 'parent_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'name' => Yii::t('app', 'Name'),
            'parent_id' => Yii::t('app', 'Parent ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipBlogs()
    {
        return $this->hasMany(VipBlog::className(), ['blog_type' => 'id']);
    }
}
