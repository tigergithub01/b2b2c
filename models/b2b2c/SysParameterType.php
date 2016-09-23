<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_parameter_type".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 *
 * @property SysParameter[] $sysParameters
 */
class SysParameterType extends \app\models\b2b2c\BasicModel
{
    
	const YES_NO = 1;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_parameter_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 60],
            [['description'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'name' => Yii::t('app', '类型名称'),
            'description' => Yii::t('app', '描述'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysParameters()
    {
        return $this->hasMany(SysParameter::className(), ['type_id' => 'id']);
    }
    
    /**
     * 
     * @param unknown $id
     */
    public static function getSysParametersById($id){
    	return SysParameter::find()->where(['type_id'=>$id])->orderBy("seq_id")->all();
    }
}
