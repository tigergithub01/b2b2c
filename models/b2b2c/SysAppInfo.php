<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_app_info".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $release_id
 *
 * @property SysAppRelease $release
 * @property SysAppRelease[] $sysAppReleases
 */
class SysAppInfo extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_app_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['release_id'], 'integer'],
            [['name'], 'string', 'max' => 60],
            [['description'], 'string', 'max' => 400],
            [['release_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysAppRelease::className(), 'targetAttribute' => ['release_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'name' => Yii::t('app', '产品名称（ios版本，android版本）'),
            'description' => Yii::t('app', '产品描述'),
            'release_id' => Yii::t('app', '关联最新发布编号'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelease()
    {
        return $this->hasOne(SysAppRelease::className(), ['id' => 'release_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysAppReleases()
    {
        return $this->hasMany(SysAppRelease::className(), ['app_info_id' => 'id']);
    }
}
