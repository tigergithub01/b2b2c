<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_org_case_detail".
 *
 * @property string $id
 * @property string $case_id
 * @property string $product_id
 *
 * @property Product $product
 * @property VipOrgCase $case
 */
class VipOrgCaseDetail extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_org_case_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['case_id', 'product_id'], 'required'],
            [['case_id', 'product_id'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['case_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipOrgCase::className(), 'targetAttribute' => ['case_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'case_id' => Yii::t('app', '关联案例编号'),
            'product_id' => Yii::t('app', '产品编号'),
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
    public function getCase()
    {
        return $this->hasOne(VipOrgCase::className(), ['id' => 'case_id']);
    }
}
