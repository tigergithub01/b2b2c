<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_product_type_prop_val".
 *
 * @property string $id
 * @property string $prop_id
 * @property string $prop_value
 *
 * @property ProductProp[] $productProps
 * @property ProductTypeProp $prop
 */
class ProductTypePropVal extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_product_type_prop_val';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prop_id', 'prop_value'], 'required'],
            [['prop_id'], 'integer'],
            [['prop_value'], 'string', 'max' => 50],
            [['prop_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductTypeProp::className(), 'targetAttribute' => ['prop_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'prop_id' => Yii::t('app', '对应属性编号'),
            'prop_value' => Yii::t('app', '对应属性值'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductProps()
    {
        return $this->hasMany(ProductProp::className(), ['prop_val' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProp()
    {
        return $this->hasOne(ProductTypeProp::className(), ['id' => 'prop_id']);
    }
}
