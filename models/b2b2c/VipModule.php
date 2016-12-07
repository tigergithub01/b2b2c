<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_module".
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $parent_id
 * @property string $url
 * @property string $module
 * @property string $controller
 * @property string $action
 * @property string $menu_flag
 * @property string $status
 * @property string $merchant_flag
 *
 * @property SysParameter $status0
 * @property SysParameter $menuFlag
 * @property SysParameter $merchantFlag
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
            [['code', 'name', 'controller', 'action', 'menu_flag', 'status', 'merchant_flag'], 'required'],
            [['parent_id', 'menu_flag', 'status', 'merchant_flag'], 'integer'],
            [['code', 'module', 'action'], 'string', 'max' => 30],
        	[['controller'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 60],
            [['url'], 'string', 'max' => 200],
            [['code'], 'unique'],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['menu_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['menu_flag' => 'id']],
            [['merchant_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['merchant_flag' => 'id']],
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
            'module' => Yii::t('app', '对应模块'),
            'controller' => Yii::t('app', '模块对应的控制器编号'),
            'action' => Yii::t('app', '对应操作'),
            'menu_flag' => Yii::t('app', '是否菜单项'),
            'status' => Yii::t('app', '是否有效？1：是；0：否'),
            'merchant_flag' => Yii::t('app', '是否商户操作模块（1：商户；0：会员）'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'status']);
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
    public function getMerchantFlag()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'merchant_flag']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipOperationLogs()
    {
        return $this->hasMany(VipOperationLog::className(), ['module_id' => 'id']);
    }
}
