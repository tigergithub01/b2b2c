<?php

namespace app\models\b2b2c;

use Yii;

/**
 * This is the model class for table "t_sys_parameter_type".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 *
 * @property SysParameter[] $sysParameters
 */
class SysParameterType extends \app\models\b2b2c\BasicModel
{
    
	/* 是否标志位  */
	const YES_NO = 1;
	
	/* 角色类型 */
	const ROLE_TYPE = 23;
	
	/* 省市区类别  */
	const REGION_TYPE = 22;
	
	/* 产品状态  */
	const PRODUCT_STATUS = 2; 
	
	/* 审核状态  */
	const AUDIT_STATUS = 3;
	
	/* 会员状态  */
	const VIP_STATUS = 15;
	
	/* 会员性别  */
	const VIP_SEX = 23;
	
	/* 评价等级  */
	const CMT_RANK = 12;
	
	/* 案例类别  */
	const CASE_FLAG = 19;
	
	/* 帖子类别  */
	const BLOG_FLAG = 16;
	
	/* 订单类型 */
	const ORDER_TYPE = 4;
	
	/* 订单状态 */
	const ORDER_STATUS = 5;
	
	/* 付款状态 */
	const PAY_STATUS = 6;
	
	/* 配送状态 */
	const SHIPPING_STATUS = 7;
	
	/* 发票类型 */
	const INVOICE_TYPE = 8;
	
	/* 退货申请单状态 */
	const RETURN_APPLY_STATUS = 9;
	
	/* 退货单状态 */
	const RETURN_STATUS = 10;
	
	/* 发货单状态 */
	const OUT_STOCK_STATUS = 11;
	
	/* 退款申请单状态 */
	const REFUND_APPLY_STATUS = 24;
	
	/* 退款单状态 */
	const REFUND_STATUS = 25;
	
	/* 婚礼类型 */
	const SERVICE_STYLE = 26;
	
	/* 婚礼人服务 */
	const RELATED_SERVICE = 27;
	
	/* 公告类型 */
	const NOTIFY_TYPE = 20;
	
	/* 公告发送范围 */
	const NOTIFY_EXTEND = 21;
	
	/* 会员收藏类型 */
	const VIP_COLLECT_TYPE = 28;
	
	/* 报价单状态 */
	const QUOTATION_STATUS = 29;
	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sys_parameter_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 60],
            [['description'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'name' => Yii::t('app', '类型名称'),
            'description' => Yii::t('app', '描述'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysParameters()
    {
        return $this->hasMany(SysParameter::className(), ['type_id' => 'id']);
    }
    
    /**
     * 
     * @param unknown $id
     */
    public static function getSysParametersById($id){
    	return SysParameter::find()->where(['type_id'=>$id])->orderBy("seq_id")->all();
    }
}
