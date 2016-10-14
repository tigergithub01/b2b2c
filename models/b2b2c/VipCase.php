<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_case".
 *
 * @property string $id
 * @property string $name
 * @property string $type_id
 * @property string $vip_id
 * @property string $content
 * @property string $create_date
 * @property string $update_date
 * @property string $status
 * @property string $audit_status
 * @property string $audit_user_id
 * @property string $audit_date
 * @property string $audit_memo
 * @property string $cover_img_url
 * @property string $cover_thumb_url
 * @property string $cover_img_original
 * @property string $is_hot
 * @property string $case_flag
 * @property string $market_price
 * @property string $sale_price
 *
 * @property SoSheet[] $soSheets
 * @property SysUser $auditUser
 * @property VipCaseType $type
 * @property SysParameter $caseFlag
 * @property SysParameter $status0
 * @property SysParameter $auditStatus
 * @property Vip $vip
 * @property VipCaseDetail[] $vipCaseDetails
 * @property VipCasePhoto[] $vipCasePhotos
 * @property VipCollect[] $vipCollects
 */
class VipCase extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_case';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type_id', 'vip_id', 'content', 'create_date', 'update_date', 'status', 'audit_status', 'cover_img_url', 'cover_thumb_url', 'cover_img_original', 'is_hot', 'case_flag'], 'required'],
            [['type_id', 'vip_id', 'status', 'audit_status', 'audit_user_id', 'is_hot', 'case_flag'], 'integer'],
            [['content'], 'string'],
            [['create_date', 'update_date', 'audit_date'], 'safe'],
            [['market_price', 'sale_price'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['audit_memo'], 'string', 'max' => 200],
            [['cover_img_url', 'cover_thumb_url', 'cover_img_original'], 'string', 'max' => 255],
            [['audit_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['audit_user_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => VipCaseType::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['case_flag'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['case_flag' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['audit_status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['audit_status' => 'id']],
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
            'name' => Yii::t('app', '案例名称'),
            'type_id' => Yii::t('app', '案例类型'),
            'vip_id' => Yii::t('app', '关联商户编号'),
            'content' => Yii::t('app', '发布内容'),
            'create_date' => Yii::t('app', '发布时间'),
            'update_date' => Yii::t('app', '更新时间'),
            'status' => Yii::t('app', '是否显示？1：是；0：否'),
            'audit_status' => Yii::t('app', '审核状态：未审核，审核不通过，已审核'),
            'audit_user_id' => Yii::t('app', '审核人'),
            'audit_date' => Yii::t('app', '审核日期'),
            'audit_memo' => Yii::t('app', '审核意见（不通过时必须填写）'),
            'cover_img_url' => Yii::t('app', '图片（放大后查看）(封面)'),
            'cover_thumb_url' => Yii::t('app', '缩略图(封面)'),
            'cover_img_original' => Yii::t('app', '原图(封面)'),
            'is_hot' => Yii::t('app', '是否经典案例（经典案例显示在首页）'),
            'case_flag' => Yii::t('app', '案例类别？个人案例，团体案例（团体案例可以通过订单来生成，也可以手动创建）'),
            'market_price' => Yii::t('app', '市场价'),
            'sale_price' => Yii::t('app', '销售价'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheets()
    {
        return $this->hasMany(SoSheet::className(), ['related_case_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuditUser()
    {
        return $this->hasOne(SysUser::className(), ['id' => 'audit_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(VipCaseType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaseFlag()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'case_flag']);
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
    public function getAuditStatus()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'audit_status']);
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
    public function getVipCaseDetails()
    {
        return $this->hasMany(VipCaseDetail::className(), ['case_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipCasePhotos()
    {
        return $this->hasMany(VipCasePhoto::className(), ['case_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipCollects()
    {
        return $this->hasMany(VipCollect::className(), ['case_id' => 'id']);
    }
}
