<?php

namespace app\models\b2b2c;

use Yii;
use app\common\utils\CommonUtils;

/**
 * This is the model class for table "t_sheet_type".
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $prefix
 * @property string $date_format
 * @property string $sep
 * @property string $seq_length
 * @property string $cur_seq
 *
 * @property SoSheet[] $soSheets
 */
class SheetType extends \app\models\b2b2c\BasicModel
{
	const so = 1; //普通订单
	const qu = 2; //报价单
	const ra = 3; //退款申请单
	const rd = 4; //退款单
	const ta = 5; //退货申请单
	const tt = 6; //退货单
	const ot = 7; //发货单
	
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sheet_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'code', 'name', 'prefix', 'date_format', 'seq_length', 'cur_seq'], 'required'],
            [['id', 'seq_length', 'cur_seq'], 'integer'],
            [['code', 'prefix', 'sep'], 'string', 'max' => 10],
            [['name'], 'string', 'max' => 60],
            [['date_format'], 'string', 'max' => 20],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键编号'),
            'code' => Yii::t('app', '单据唯一编码'),
            'name' => Yii::t('app', '单据名称'),
            'prefix' => Yii::t('app', '单据前缀'),
            'date_format' => Yii::t('app', '日期格式(YmdHis)'),
            'sep' => Yii::t('app', '分隔符(Null、’-’)'),
            'seq_length' => Yii::t('app', '序列长度'),
            'cur_seq' => Yii::t('app', '当前序列号'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSoSheets()
    {
        return $this->hasMany(SoSheet::className(), ['sheet_type_id' => 'id']);
    }
    
    /**
     * 获取单据编号
     * @param unknown $sheetTypeId
     * @return string
     */
    public static function getCode($sheetTypeId , $save = false) {
    	//generate code
    	$sheetType = self::findOne ( $sheetTypeId );
//     	$df = date ( $sheetType ['date_format'], time () );
    	$df = date ( "YmdHis", time () );
//     	$seq = sprintf ( '%0' . $sheetType ['seq_length'] . 's', $sheetType ['cur_seq'] );
    	$seq = "";
    	$code = $sheetType ['prefix'] . $sheetType ['sep'] . $df . $sheetType ['sep'] . $seq . CommonUtils::random(5, 1);
    
    	//increment cur_seq field
//     	$sheetType->cur_seq = ($sheetType->cur_seq + 1);
    	if($save){
    		$sheetType->save();
    	}
    	return $code;
    
    }
}
