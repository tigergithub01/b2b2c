<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_role_user".
 *
 * @property string $id
 * @property string $role_id
 * @property string $user_id
 *
 * @property SysUser $user
 * @property SysRole $role
 */
class SysRoleUser extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_role_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'user_id'], 'required'],
            [['role_id', 'user_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysRole::className(), 'targetAttribute' => ['role_id' => 'id']],
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
            'user_id' => Yii::t('app', '用户编号'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(SysUser::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(SysRole::className(), ['id' => 'role_id']);
    }
}
