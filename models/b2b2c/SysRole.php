<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_role".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 *
 * @property SysRoleRights[] $sysRoleRights
 * @property SysRoleUser[] $sysRoleUsers
 */
class SysRole extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 60],
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
            'name' => Yii::t('app', '角色名称'),
            'description' => Yii::t('app', '描述'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysRoleRights()
    {
        return $this->hasMany(SysRoleRights::className(), ['role_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysRoleUsers()
    {
        return $this->hasMany(SysRoleUser::className(), ['role_id' => 'id']);
    }
}
