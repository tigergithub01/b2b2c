<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_operation_log".
 *
 * @property string $id
 * @property string $user_id
 * @property string $module_id
 * @property string $operation_id
 * @property string $op_date
 * @property string $op_ip_addr
 * @property string $op_browser_type
 * @property string $op_url
 * @property string $op_desc
 *
 * @property SysUser $user
 * @property SysModule $module
 * @property SysOperation $operation
 */
class SysOperationLog extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_operation_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'module_id', 'operation_id', 'op_date'], 'required'],
            [['user_id', 'module_id', 'operation_id'], 'integer'],
            [['op_date'], 'safe'],
            [['op_desc'], 'string'],
            [['op_ip_addr'], 'string', 'max' => 30],
            [['op_browser_type'], 'string', 'max' => 60],
            [['op_url'], 'string', 'max' => 400],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'id' => Yii::t('app', '主键'),
            'user_id' => Yii::t('app', '关联用户编号'),
            'module_id' => Yii::t('app', '关联模块编号'),
            'operation_id' => Yii::t('app', 'Operation ID'),
            'op_date' => Yii::t('app', '操作日期'),
            'op_ip_addr' => Yii::t('app', '操作IP地址'),
            'op_browser_type' => Yii::t('app', '浏览器类型'),
            'op_url' => Yii::t('app', '操作对应完整URL'),
            'op_desc' => Yii::t('app', '操作描述'),
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
