<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_product_gallery".
 *
 * @property string $id
 * @property string $product_id
 * @property string $img_url
 * @property string $thumb_url
 * @property string $img_original
 * @property string $primary_flag
 *
 * @property Product $product
 * @property SysParameter $primaryFlag
 */
class ProductGallery extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_product_gallery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'img_url', 'thumb_url', 'img_original'], 'required'],
            [['product_id', 'primary_flag'], 'integer'],
            [['img_url', 'thumb_url', 'img_original'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['primary_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['primary_flag' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'product_id' => Yii::t('app', '关联产品编号'),
            'img_url' => Yii::t('app', '图片（放大后查看）'),
            'thumb_url' => Yii::t('app', '缩略图'),
            'img_original' => Yii::t('app', '原图'),
            'primary_flag' => Yii::t('app', '是否设置为主图(1：是；0：否),不需要此字段'),
        ];
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
    public function getPrimaryFlag()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'primary_flag']);
    }
}
