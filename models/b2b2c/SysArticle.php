<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_article".
 *
 * @property string $id
 * @property string $type_id
 * @property string $title
 * @property string $code
 * @property string $issue_date
 * @property string $content
 * @property string $issue_user_id
 * @property string $is_show
 *
 * @property SysUser $issueUser
 * @property SysParameter $isShow
 * @property SysArticleType $type
 */
class SysArticle extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'issue_user_id', 'is_show'], 'integer'],
            [['title', 'issue_date', 'is_show'], 'required'],
            [['issue_date'], 'safe'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 60],
            [['code'], 'string', 'max' => 30],
            [['issue_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['issue_user_id' => 'id']],
            [['is_show'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['is_show' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysArticleType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'type_id' => Yii::t('app', '文章分类（以后再建表）'),
            'title' => Yii::t('app', '标题'),
            'code' => Yii::t('app', '特殊标识（比如注册协议可以增加一个特殊标识register_agreement）'),
            'issue_date' => Yii::t('app', '发布日期'),
            'content' => Yii::t('app', '内容'),
            'issue_user_id' => Yii::t('app', '发布人'),
            'is_show' => Yii::t('app', '是否显示（1：是，0：否）'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssueUser()
    {
        return $this->hasOne(SysUser::className(), ['id' => 'issue_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIsShow()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'is_show']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(SysArticleType::className(), ['id' => 'type_id']);
    }
}
