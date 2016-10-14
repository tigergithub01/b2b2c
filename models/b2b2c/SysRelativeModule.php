<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_relative_module".
 *
 * @property string $id
 * @property string $name
 * @property string $is_show
 * @property string $footer_content
 * @property string $header_content
 * @property string $vip_id
 *
 * @property Product[] $products
 * @property SysParameter $isShow
 * @property Vip $vip
 */
class SysRelativeModule extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_relative_module';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'is_show', 'vip_id'], 'required'],
            [['is_show', 'vip_id'], 'integer'],
            [['footer_content', 'header_content'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['is_show'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['is_show' => 'id']],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'name' => Yii::t('app', '版式名称'),
            'is_show' => Yii::t('app', '是否显示'),
            'footer_content' => Yii::t('app', '底部内容'),
            'header_content' => Yii::t('app', '底部内容'),
            'vip_id' => Yii::t('app', '关联商户编号'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['relative_module' => 'id']);
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
    public function getVip()
    {
        return $this->hasOne(Vip::className(), ['id' => 'vip_id']);
    }
}
