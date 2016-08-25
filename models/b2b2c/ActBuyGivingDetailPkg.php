<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_act_buy_giving_detail_pkg".
 *
 * @property string $id
 * @property string $buy_giving_detail_id
 * @property integer $giving_number
 * @property string $giving_product_id
 *
 * @property Product $givingProduct
 * @property ActBuyGivingDetail $buyGivingDetail
 */
class ActBuyGivingDetailPkg extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_act_buy_giving_detail_pkg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['buy_giving_detail_id', 'giving_number', 'giving_product_id'], 'required'],
            [['buy_giving_detail_id', 'giving_number', 'giving_product_id'], 'integer'],
            [['giving_product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['giving_product_id' => 'id']],
            [['buy_giving_detail_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActBuyGivingDetail::className(), 'targetAttribute' => ['buy_giving_detail_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'buy_giving_detail_id' => Yii::t('app', '关联买增商品信息'),
            'giving_number' => Yii::t('app', '赠送数量'),
            'giving_product_id' => Yii::t('app', '赠送商品编号'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGivingProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'giving_product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuyGivingDetail()
    {
        return $this->hasOne(ActBuyGivingDetail::className(), ['id' => 'buy_giving_detail_id']);
    }
}
