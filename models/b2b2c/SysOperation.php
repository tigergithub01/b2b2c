<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_operation".
 *
 * @property string $id
 * @property string $code
 * @property string $name
 */
class SysOperation extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_operation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code'], 'string', 'max' => 30],
            [['name'], 'string', 'max' => 60],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', '操作唯一编码'),
            'name' => Yii::t('app', '操作名称'),
        ];
    }
}
