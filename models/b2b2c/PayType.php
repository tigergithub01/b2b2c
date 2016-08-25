<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_pay_type".
 *
 * @property string $id
 * @property string $tpl_id
 * @property string $name
 * @property string $description
 * @property string $status
 * @property string $organization_id
 * @property string $configure
 *
 * @property SysParameter $status0
 * @property VipOrganization $organization
 * @property PayTypeTpl $tpl
 * @property SoSheet[] $soSheets
 */
class PayType extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_pay_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tpl_id', 'name', 'status', 'organization_id', 'configure'], 'required'],
            [['tpl_id', 'status', 'organization_id'], 'integer'],
            [['configure'], 'string'],
            [['name'], 'string', 'max' => 60],
            [['description'], 'string', 'max' => 255],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipOrganization::className(), 'targetAttribute' => ['organization_id' => 'id']],
            [['tpl_id'], 'exist', 'skipOnError' => true, 'targetClass' => PayTypeTpl::className(), 'targetAttribute' => ['tpl_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'tpl_id' => Yii::t('app', '关联支付方式模板编号'),
            'name' => Yii::t('app', '支付方式名称'),
            'description' => Yii::t('app', '描述'),
            'status' => Yii::t('app', '状态（1:有效、0:停用）'),
            'organization_id' => Yii::t('app', '关联机构编号'),
            'configure' => Yii::t('app', '对应配置信息'),
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
    public function getOrganization()
    {
        return $this->hasOne(VipOrganization::className(), ['id' => 'organization_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTpl()
    {
        return $this->hasOne(PayTypeTpl::className(), ['id' => 'tpl_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheets()
    {
        return $this->hasMany(SoSheet::className(), ['pay_type_id' => 'id']);
    }
}
