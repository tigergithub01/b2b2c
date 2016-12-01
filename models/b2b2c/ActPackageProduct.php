<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_act_package_product".
 *
 * @property string $id
 * @property string $act_id
 * @property string $product_id
 * @property string $package_price
 * @property integer $quantity
 *
 * @property Activity $act
 * @property Product $product
 */
class ActPackageProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_act_package_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['act_id', 'product_id', 'package_price', 'quantity'], 'required'],
            [['act_id', 'product_id', 'quantity'], 'integer'],
            [['package_price'], 'number'],
            [['act_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['act_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'act_id' => Yii::t('app', /* '关联活动编号' */'关联团体服务'),
            'product_id' => Yii::t('app', /* '关联产品编号' */'关联个人服务'),
            'package_price' => Yii::t('app', /* '套装价' */'团体价'),
            'quantity' => Yii::t('app', '数量'),
        	'act.name' => Yii::t('app', /* '关联活动编号' */'关联团体服务'),
        	'product.name' => Yii::t('app', /* '关联产品编号' */'关联个人服务'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAct()
    {
        return $this->hasOne(Activity::className(), ['id' => 'act_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
