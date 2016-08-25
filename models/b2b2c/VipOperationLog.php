<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_operation_log".
 *
 * @property string $id
 * @property string $vip_id
 * @property string $module_id
 * @property string $op_date
 * @property string $op_ip_addr
 * @property string $op_browser_type
 * @property string $op_phone_model
 * @property string $op_url
 * @property string $op_desc
 * @property string $op_os_type
 * @property string $op_method
 * @property string $op_app_ver
 * @property string $op_app_type_id
 * @property string $op_module
 * @property string $op_controller
 * @property string $op_action
 * @property string $op_view
 *
 * @property VipModule $module
 * @property Vip $vip
 */
class VipOperationLog extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_operation_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vip_id', 'module_id', 'op_app_type_id'], 'integer'],
            [['op_date'], 'required'],
            [['op_date'], 'safe'],
            [['op_desc'], 'string'],
            [['op_ip_addr', 'op_module', 'op_controller'], 'string', 'max' => 30],
            [['op_browser_type'], 'string', 'max' => 300],
            [['op_phone_model'], 'string', 'max' => 60],
            [['op_url'], 'string', 'max' => 1000],
            [['op_os_type'], 'string', 'max' => 100],
            [['op_method', 'op_app_ver', 'op_action'], 'string', 'max' => 20],
            [['op_view'], 'string', 'max' => 50],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipModule::className(), 'targetAttribute' => ['module_id' => 'id']],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'vip_id' => Yii::t('app', '会员编号'),
            'module_id' => Yii::t('app', '模块编号'),
            'op_date' => Yii::t('app', '操作日期'),
            'op_ip_addr' => Yii::t('app', '操作IP地址'),
            'op_browser_type' => Yii::t('app', '浏览器类型'),
            'op_phone_model' => Yii::t('app', '手机型号'),
            'op_url' => Yii::t('app', '操作对应完整URL'),
            'op_desc' => Yii::t('app', '操作描述'),
            'op_os_type' => Yii::t('app', '操作系统'),
            'op_method' => Yii::t('app', '数据提交方式（POST,GET）'),
            'op_app_ver' => Yii::t('app', 'app版本号'),
            'op_app_type_id' => Yii::t('app', 'app类型：1:andorid 2:ios'),
            'op_module' => Yii::t('app', 'Yii模块'),
            'op_controller' => Yii::t('app', 'Yii控制器'),
            'op_action' => Yii::t('app', '操作对应的action'),
            'op_view' => Yii::t('app', 'Yii视图'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(VipModule::className(), ['id' => 'module_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVip()
    {
        return $this->hasOne(Vip::className(), ['id' => 'vip_id']);
    }
}
