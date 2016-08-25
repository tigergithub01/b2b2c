<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_config_detail".
 *
 * @property string $id
 * @property string $config_id
 * @property string $value
 * @property string $description
 *
 * @property SysConfig $config
 */
class SysConfigDetail extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_config_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['config_id', 'value'], 'required'],
            [['config_id'], 'integer'],
            [['value'], 'string', 'max' => 60],
            [['description'], 'string', 'max' => 200],
            [['config_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysConfig::className(), 'targetAttribute' => ['config_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'config_id' => Yii::t('app', '关联配置编号'),
            'value' => Yii::t('app', '值'),
            'description' => Yii::t('app', '描述'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfig()
    {
        return $this->hasOne(SysConfig::className(), ['id' => 'config_id']);
    }
}
