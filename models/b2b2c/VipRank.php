<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_rank".
 *
 * @property string $id
 * @property string $name
 * @property integer $min_points
 * @property integer $max_points
 * @property string $discount
 *
 * @property ProductVipPrice[] $productVipPrices
 * @property Vip[] $vips
 */
class VipRank extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_rank';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'min_points', 'max_points'], 'required'],
            [['min_points', 'max_points'], 'integer'],
            [['discount'], 'number'],
            [['name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'name' => Yii::t('app', '会员等级名称'),
            'min_points' => Yii::t('app', '最少等级积分'),
            'max_points' => Yii::t('app', '最大等级积分'),
            'discount' => Yii::t('app', '折扣'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductVipPrices()
    {
        return $this->hasMany(ProductVipPrice::className(), ['vip_rank_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVips()
    {
        return $this->hasMany(Vip::className(), ['rank_id' => 'id']);
    }
}
