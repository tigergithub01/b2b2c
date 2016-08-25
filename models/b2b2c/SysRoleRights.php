<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_role_rights".
 *
 * @property string $id
 * @property string $role_id
 * @property string $module_id
 * @property string $operation_id
 *
 * @property SysRole $role
 * @property SysModule $module
 * @property SysOperation $operation
 */
class SysRoleRights extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_role_rights';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'module_id', 'operation_id'], 'required'],
            [['role_id', 'module_id', 'operation_id'], 'integer'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysRole::className(), 'targetAttribute' => ['role_id' => 'id']],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysModule::className(), 'targetAttribute' => ['module_id' => 'id']],
            [['operation_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysOperation::className(), 'targetAttribute' => ['operation_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'role_id' => Yii::t('app', '关联角色编号'),
            'module_id' => Yii::t('app', '关联模块编号'),
            'operation_id' => Yii::t('app', '关联操作编号'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(SysRole::className(), ['id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(SysModule::className(), ['id' => 'module_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperation()
    {
        return $this->hasOne(SysOperation::className(), ['id' => 'operation_id']);
    }
}
