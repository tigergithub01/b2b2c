<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_module".
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $parent_id
 * @property string $url
 * @property string $controller
 * @property string $menu_flag
 *
 * @property SysModule $parent
 * @property SysModule[] $sysModules
 * @property SysParameter $menuFlag
 * @property SysOperationLog[] $sysOperationLogs
 * @property SysRoleRights[] $sysRoleRights
 */
class SysModule extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_module';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'menu_flag'], 'required'],
            [['parent_id', 'menu_flag'], 'integer'],
            [['code', 'controller'], 'string', 'max' => 30],
            [['name'], 'string', 'max' => 60],
            [['url'], 'string', 'max' => 200],
            [['code'], 'unique'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysModule::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['menu_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['menu_flag' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'code' => Yii::t('app', '模块唯一编码'),
            'name' => Yii::t('app', '模块名称'),
            'parent_id' => Yii::t('app', '关联上级模块主键编号'),
            'url' => Yii::t('app', '模块URL地址'),
            'controller' => Yii::t('app', '模块对应的控制器编号'),
            'menu_flag' => Yii::t('app', '是否菜单项'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(SysModule::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysModules()
    {
        return $this->hasMany(SysModule::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuFlag()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'menu_flag']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysOperationLogs()
    {
        return $this->hasMany(SysOperationLog::className(), ['module_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysRoleRights()
    {
        return $this->hasMany(SysRoleRights::className(), ['module_id' => 'id']);
    }
}
