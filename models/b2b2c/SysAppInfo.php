<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_app_info".
 *
 * @property string $id
 * @property string $name
 * @property string $code
 * @property string $description
 *
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
            [['name'], 'string', 'max' => 60],
            [['code'], 'string', 'max' => 20],
            [['description'], 'string', 'max' => 400],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'name' => Yii::t('app', '产品名称（andorid版、ios版）'),
            'code' => Yii::t('app', 'app编码，便于根据code查找'),
            'description' => Yii::t('app', '产品描述'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysAppReleases()
    {
        return $this->hasMany(SysAppRelease::className(), ['app_info_id' => 'id']);
    }
}
