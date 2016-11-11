<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_app_release".
 *
 * @property string $id
 * @property string $name
 * @property string $ver_no
 * @property string $upgrade_desc
 * @property string $force_upgrade
 * @property string $issue_date
 * @property string $issue_user_id
 * @property string $app_path
 * @property string $app_info_id
 *
 * @property SysParameter $forceUpgrade
 * @property SysAppInfo $appInfo
 * @property SysUser $issueUser
 */
class SysAppRelease extends \app\models\b2b2c\BasicModel
{
	//上传文件
	public $uploadFile;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_app_release';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'ver_no', 'force_upgrade', 'app_info_id'], 'required'],
            [['ver_no', 'force_upgrade', 'issue_user_id', 'app_info_id'], 'integer'],
            [['issue_date'], 'safe'],
            [['name'], 'string', 'max' => 60],
            [['upgrade_desc'], 'string', 'max' => 600],
            [['app_path'], 'string', 'max' => 200],
            [['force_upgrade'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['force_upgrade' => 'id']],
            [['app_info_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysAppInfo::className(), 'targetAttribute' => ['app_info_id' => 'id']],
            [['issue_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['issue_user_id' => 'id']],
        	[['uploadFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'apk, ipa','maxSize'=>50*1024*1024, 'checkExtensionByMimeType' => false, 'maxFiles' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'name' => Yii::t('app', '版本名称(1.1.1，字符串型)'),
            'ver_no' => Yii::t('app', '版本编号(数字型)'),
            'upgrade_desc' => Yii::t('app', '版本升级描述'),
            'force_upgrade' => Yii::t('app', '是否必须升级'),
            'issue_date' => Yii::t('app', '发布日期'),
            'issue_user_id' => Yii::t('app', '发布人'),
            'app_path' => Yii::t('app', '应用下载地址'),
            'app_info_id' => Yii::t('app', '产品名称（andorid版 ；ios版）'),
        	'forceUpgrade.param_val' => Yii::t('app', '是否必须升级'),
        	'issueUser.user_id' => Yii::t('app', '发布人'),
        	'uploadFile' => Yii::t('app', '文件'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForceUpgrade()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'force_upgrade']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppInfo()
    {
        return $this->hasOne(SysAppInfo::className(), ['id' => 'app_info_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssueUser()
    {
        return $this->hasOne(SysUser::className(), ['id' => 'issue_user_id']);
    }
}
