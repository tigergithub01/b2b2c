<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sheet_log".
 *
 * @property string $id
 * @property string $sheet_type_id
 * @property string $ref_sheet_id
 * @property string $ref_sheet_code
 * @property string $user_id
 * @property string $vip_id
 * @property string $action_type_id
 * @property string $action_date
 * @property string $description
 *
 * @property Vip $vip
 * @property SysParameter $actionType
 * @property SheetType $sheetType
 * @property SysUser $user
 */
class SheetLog extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sheet_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sheet_type_id', 'ref_sheet_id', 'action_date'], 'required'],
            [['sheet_type_id', 'ref_sheet_id', 'user_id', 'vip_id', 'action_type_id'], 'integer'],
            [['action_date'], 'safe'],
            [['ref_sheet_code'], 'string', 'max' => 30],
            [['description'], 'string', 'max' => 200],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['action_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['action_type_id' => 'id']],
            [['sheet_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => SheetType::className(), 'targetAttribute' => ['sheet_type_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'sheet_type_id' => Yii::t('app', '单据类型'),
            'ref_sheet_id' => Yii::t('app', '关联单据编号'),
            'ref_sheet_code' => Yii::t('app', '单据编号'),
            'user_id' => Yii::t('app', '关联操作用户编号'),
            'vip_id' => Yii::t('app', '关联操作会员编号'),
            'action_type_id' => Yii::t('app', '操作类型'),
            'action_date' => Yii::t('app', '操作时间'),
            'description' => Yii::t('app', '操作描述'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVip()
    {
        return $this->hasOne(Vip::className(), ['id' => 'vip_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActionType()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'action_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSheetType()
    {
        return $this->hasOne(SheetType::className(), ['id' => 'sheet_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(SysUser::className(), ['id' => 'user_id']);
    }
}
