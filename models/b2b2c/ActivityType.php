<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_activity_type".
 *
 * @property string $id
 * @property string $name
 *
 * @property Activity[] $activities
 */
class ActivityType extends \app\models\b2b2c\BasicModel
{
	const activity_type_package = 1; //优惠套装
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_activity_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'name' => Yii::t('app', '活动类别名称'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivities()
    {
        return $this->hasMany(Activity::className(), ['activity_type' => 'id']);
    }
}
