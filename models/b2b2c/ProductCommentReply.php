<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_product_comment_reply".
 *
 * @property string $id
 * @property string $content
 * @property string $comment_id
 * @property string $reply_date
 * @property string $user_id
 *
 * @property SysUser $user
 * @property ProductComment $comment
 */
class ProductCommentReply extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_product_comment_reply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'comment_id', 'reply_date', 'user_id'], 'required'],
            [['comment_id', 'user_id'], 'integer'],
            [['reply_date'], 'safe'],
            [['content'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['comment_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductComment::className(), 'targetAttribute' => ['comment_id' => 'id']],
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
            'comment_id' => Yii::t('app', '关联评价编号'),
            'reply_date' => Yii::t('app', '回复日期'),
            'user_id' => Yii::t('app', '关联用户编号'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(SysUser::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComment()
    {
        return $this->hasOne(ProductComment::className(), ['id' => 'comment_id']);
    }
}
