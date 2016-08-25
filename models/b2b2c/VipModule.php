<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_module".
 *
 * @property string $id
 * @property string $name
 * @property string $op_controller
 * @property string $op_action
 *
 * @property VipOperationLog[] $vipOperationLogs
 */
class VipModule extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_module';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 60],
            [['op_controller'], 'string', 'max' => 30],
            [['op_action'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'name' => Yii::t('app', '模块名称'),
            'op_controller' => Yii::t('app', '对应控制器'),
            'op_action' => Yii::t('app', '对应方法'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipOperationLogs()
    {
        return $this->hasMany(VipOperationLog::className(), ['module_id' => 'id']);
    }
}
