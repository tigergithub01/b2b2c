<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_article_type".
 *
 * @property string $id
 * @property string $name
 * @property string $parent_id
 * @property string $is_show
 * @property integer $seq_id
 *
 * @property SysArticle[] $sysArticles
 * @property SysArticleType $parent
 * @property SysArticleType[] $sysArticleTypes
 */
class SysArticleType extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_article_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'is_show'], 'required'],
            [['parent_id', 'is_show', 'seq_id'], 'integer'],
            [['name'], 'string', 'max' => 60],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysArticleType::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'name' => Yii::t('app', '文章分类名称'),
            'parent_id' => Yii::t('app', '父编号'),
            'is_show' => Yii::t('app', '是否显示'),
            'seq_id' => Yii::t('app', '序号'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysArticles()
    {
        return $this->hasMany(SysArticle::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(SysArticleType::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysArticleTypes()
    {
        return $this->hasMany(SysArticleType::className(), ['parent_id' => 'id']);
    }
}
