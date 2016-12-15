<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_upload_file".
 *
 * @property string $id
 * @property string $vip_id
 * @property string $user_id
 * @property string $file_path
 * @property string $create_date
 * @property string $session_id
 */
class SysUploadFile extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_upload_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vip_id', 'user_id'], 'integer'],
            [['file_path', 'create_date'], 'required'],
            [['create_date'], 'safe'],
            [['file_path', 'session_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'vip_id' => Yii::t('app', '关联会员编号'),
            'user_id' => Yii::t('app', '关联用户编号'),
            'file_path' => Yii::t('app', '文件地址'),
            'create_date' => Yii::t('app', '创建日期'),
            'session_id' => Yii::t('app', '会话编号'),
        ];
    }
}
