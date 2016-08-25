<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_product_collect".
 *
 * @property string $id
 * @property string $vip_id
 * @property string $product_id
 * @property string $collect_date
 *
 * @property Vip $vip
 * @property Product $product
 */
class VipProductCollect extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_product_collect';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vip_id', 'product_id', 'collect_date'], 'required'],
            [['vip_id', 'product_id'], 'integer'],
            [['collect_date'], 'safe'],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'vip_id' => Yii::t('app', '会员编号'),
            'product_id' => Yii::t('app', '产品编号'),
            'collect_date' => Yii::t('app', '收藏时间'),
        ];
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
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
