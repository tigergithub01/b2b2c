<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_product_comment_photo".
 *
 * @property string $id
 * @property string $comment_id
 * @property string $img_url
 * @property string $thumb_url
 * @property string $img_original
 *
 * @property ProductComment $comment
 */
class ProductCommentPhoto extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_product_comment_photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment_id', 'img_url', 'thumb_url', 'img_original'], 'required'],
            [['comment_id'], 'integer'],
            [['img_url', 'thumb_url', 'img_original'], 'string', 'max' => 255],
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
            'comment_id' => Yii::t('app', '关联评价编号'),
            'img_url' => Yii::t('app', '图片（放大后查看）'),
            'thumb_url' => Yii::t('app', '缩略图'),
            'img_original' => Yii::t('app', '原始图片'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComment()
    {
        return $this->hasOne(ProductComment::className(), ['id' => 'comment_id']);
    }
}
