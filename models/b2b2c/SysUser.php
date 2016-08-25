<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_user".
 *
 * @property string $id
 * @property string $user_id
 * @property string $user_name
 * @property string $password
 * @property string $is_admin
 * @property string $status
 * @property string $last_login_date
 *
 * @property OutStockSheet[] $outStockSheets
 * @property Product[] $products
 * @property ProductCommentReply[] $productCommentReplies
 * @property RefundSheet[] $refundSheets
 * @property ReturnSheet[] $returnSheets
 * @property SheetLog[] $sheetLogs
 * @property SysAppRelease[] $sysAppReleases
 * @property SysOperationLog[] $sysOperationLogs
 * @property SysRoleUser[] $sysRoleUsers
 * @property SysParameter $status0
 * @property SysParameter $isAdmin
 * @property VipOrgCase[] $vipOrgCases
 */
class SysUser extends \app\models\b2b2c\BasicModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'password', 'is_admin', 'status'], 'required'],
            [['is_admin', 'status'], 'integer'],
            [['last_login_date'], 'safe'],
            [['user_id'], 'string', 'max' => 20],
            [['user_name'], 'string', 'max' => 60],
            [['password'], 'string', 'max' => 50],
            [['user_id'], 'unique'],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['status' => 'id']],
            [['is_admin'], 'exist', 'skipOnError' => true, 'targetClass' => SysParameter::className(), 'targetAttribute' => ['is_admin' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'user_id' => Yii::t('app', '用户名(登陆名）'),
            'user_name' => Yii::t('app', '姓名'),
            'password' => Yii::t('app', '密码'),
            'is_admin' => Yii::t('app', '是否管理员'),
            'status' => Yii::t('app', '是否有效？1：是；0：否'),
            'last_login_date' => Yii::t('app', '最后一次登陆时间'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutStockSheets()
    {
        return $this->hasMany(OutStockSheet::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['audit_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCommentReplies()
    {
        return $this->hasMany(ProductCommentReply::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundSheets()
    {
        return $this->hasMany(RefundSheet::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReturnSheets()
    {
        return $this->hasMany(ReturnSheet::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSheetLogs()
    {
        return $this->hasMany(SheetLog::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysAppReleases()
    {
        return $this->hasMany(SysAppRelease::className(), ['issue_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysOperationLogs()
    {
        return $this->hasMany(SysOperationLog::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysRoleUsers()
    {
        return $this->hasMany(SysRoleUser::className(), ['user_id' => 'id']);
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
    public function getIsAdmin()
    {
        return $this->hasOne(SysParameter::className(), ['id' => 'is_admin']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVipOrgCases()
    {
        return $this->hasMany(VipOrgCase::className(), ['audit_user_id' => 'id']);
    }
}
