<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_concern".
 *
 * @property string $id
 * @property string $vip_id
 * @property string $ref_vip_id
 * @property string $concern_date
 *
 * @property Vip $vip
 * @property Vip $refVip
 */
class VipConcern extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_concern';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vip_id', 'ref_vip_id', 'concern_date'], 'required'],
            [['vip_id', 'ref_vip_id'], 'integer'],
            [['concern_date'], 'safe'],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['ref_vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['ref_vip_id' => 'id']],
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
            'ref_vip_id' => Yii::t('app', '关注会员编号'),
            'concern_date' => Yii::t('app', '关注时间'),
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
    public function getRefVip()
    {
        return $this->hasOne(Vip::className(), ['id' => 'ref_vip_id']);
    }
}
