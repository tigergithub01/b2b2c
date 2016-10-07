<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_config".
 *
 * @property string $id
 * @property string $code
 * @property string $value
 * @property string $description
 *
 * @property SysConfigDetail[] $sysConfigDetails
 */
class SysConfig extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'value'], 'required'],
            [['code'], 'string', 'max' => 30],
            [['value'], 'string', 'max' => 60],
            [['description'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'code' => Yii::t('app', '唯一编码'),
            'value' => Yii::t('app', '值'),
            'description' => Yii::t('app', '描述'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysConfigDetails()
    {
        return $this->hasMany(SysConfigDetail::className(), ['config_id' => 'id']);
    }
    
    /**
     * 
     * @param unknown $code
     */
    public static function getConfigVal($code){
    	return $this->find()->select(['value'])->where(['code'=>$this->code])->scalar();
    }
}
