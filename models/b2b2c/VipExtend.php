<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_vip_extend".
 *
 * @property string $id
 * @property string $vip_id
 * @property string $real_name
 * @property string $id_card_no
 * @property string $id_card_img_url
 * @property string $id_card_thumb_url
 * @property string $id_card_img_original
 * @property string $id_back_img_url
 * @property string $id_back_thumb_url
 * @property string $id_back_img_original
 * @property string $bl_img_url
 * @property string $bl_thumb_url
 * @property string $bl_img_original
 * @property string $bank_account
 * @property string $bank_name
 * @property string $bank_number
 * @property string $bank_addr
 * @property string $audit_status
 * @property string $audit_user_id
 * @property string $audit_date
 * @property string $audit_memo
 * @property string $create_date
 * @property string $update_date
 *
 * @property Vip $vip
 * @property SysParameter $auditStatus
 * @property SysUser $auditUser
 */
class VipExtend extends \app\models\b2b2c\BasicModel
{
	//身份证正面照
	public $imageFileIdCard;
	
	//身份证背面照
	public $imageFileIdCardBack;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_vip_extend';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vip_id', 'audit_status', 'create_date', 'update_date'], 'required'],
            [['vip_id', 'audit_status', 'audit_user_id'], 'integer'],
            [['audit_date', 'create_date', 'update_date'], 'safe'],
            [['real_name', 'bank_name', 'bank_number'], 'string', 'max' => 50],
            [['id_card_no', 'bank_account'], 'string', 'max' => 30],
            [['id_card_img_url', 'id_card_thumb_url', 'id_card_img_original', 'id_back_img_url', 'id_back_thumb_url', 'id_back_img_original', 'bl_img_url', 'bl_thumb_url', 'bl_img_original', 'bank_addr'], 'string', 'max' => 255],
            [['audit_memo'], 'string', 'max' => 200],
            [['vip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vip::className(), 'targetAttribute' => ['vip_id' => 'id']],
            [['audit_status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['audit_status' => 'id']],
            [['audit_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysUser::className(), 'targetAttribute' => ['audit_user_id' => 'id']],
        	[['imageFileIdCard', 'imageFileIdCardBack'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg','maxSize'=>5*1024*1024, 'checkExtensionByMimeType' => false,'mimeTypes'=>'image/jpeg, image/png','maxFiles' => 1],
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
            'real_name' => Yii::t('app', '真实姓名'),
            'id_card_no' => Yii::t('app', '身份证号码'),
            'id_card_img_url' => Yii::t('app', /* '身份证正面照-图片（放大后查看）' */'身份证正面照'),
            'id_card_thumb_url' => Yii::t('app', '身份证正面照-缩略图'),
            'id_card_img_original' => Yii::t('app', '身份证正面照-原图'),
            'id_back_img_url' => Yii::t('app', /* '身份证背面照-图片（放大后查看）' */'身份证背面照'),
            'id_back_thumb_url' => Yii::t('app', '身份证背面照-缩略图'),
            'id_back_img_original' => Yii::t('app', '身份证背面照-原图'),
            'bl_img_url' => Yii::t('app', '公司营业执照-图片（放大后查看）'),
            'bl_thumb_url' => Yii::t('app', '公司营业执照-缩略图'),
            'bl_img_original' => Yii::t('app', '公司营业执照-原图'),
            'bank_account' => Yii::t('app', '银行账户（真实姓名）'),
            'bank_name' => Yii::t('app', '开户银行'),
            'bank_number' => Yii::t('app', '银行卡号'),
            'bank_addr' => Yii::t('app', '开户支行（如，招商银行深圳分行科技园支行）'),
            'audit_status' => Yii::t('app', '审核状态：未审核，审核不通过，已审核'),
            'audit_user_id' => Yii::t('app', '审核人'),
            'audit_date' => Yii::t('app', '审核日期'),
            'audit_memo' => Yii::t('app', '审核意见（不通过时必须填写）'),
            'create_date' => Yii::t('app', '创建时间'),
            'update_date' => Yii::t('app', '更新时间'),
        	'imageFileIdCard' => Yii::t('app', '身份证正面照'),
        	'imageFileIdCardBack' => Yii::t('app', '身份证背面照'),
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
    public function getAuditStatus()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'audit_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuditUser()
    {
        return $this->hasOne(SysUser::className(), ['id' => 'audit_user_id']);
    }
}
