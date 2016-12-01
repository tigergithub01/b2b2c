<?php

namespace app\modules\vip\service\vip;

use app\models\b2b2c\Vip;
use app\models\b2b2c\VipCollect;
use yii\web\NotFoundHttpException;

class VipCollectService{
	
	/**
	 * 获取收藏信息
	 * @param unknown $vip_id
	 * @param unknown $collect_type
	 * @param unknown $ref_id
	 * @return NULL|\yii\db\ActiveRecord
	 */
	public function getVipCollect($vip_id, $collect_type, $ref_id){
		$model = null;
		if($collect_type==VipCollect::collect_case){
			$model = VipCollect::find()->where(['vip_id'=>$vip_id, 'case_id'=>$ref_id])->one();
			
		}else if ($collect_type==VipCollect::collect_vip){
			$model = VipCollect::find()->where(['vip_id'=>$vip_id, 'ref_vip_id'=>$ref_id])->one();
			
		}else if ($collect_type==VipCollect::collect_prod){
			$model = VipCollect::find()->where(['vip_id'=>$vip_id, 'product_id'=>$ref_id])->one();
			
		}else if ($collect_type==VipCollect::collect_act){
			$model = VipCollect::find()->where(['vip_id'=>$vip_id, 'package_id'=>$ref_id])->one();
			
		}else if ($collect_type==VipCollect::collect_blog){
			$model = VipCollect::find()->where(['vip_id'=>$vip_id, 'blog_id'=>$ref_id])->one();
		}
		
		return $model;
	}
	
	
	/**
	 * 获取收藏数量
	 * @param unknown $vip_id
	 * @param unknown $collect_type
	 * @param unknown $ref_id
	 * @return number|string
	 */
	public function getVipCollectCount($collect_type, $ref_id, $vip_id = null){
		$query = VipCollect::find()->where(['collect_type'=>$collect_type]);
		if($collect_type==VipCollect::collect_case){
			$query->andFilterWhere(['case_id'=>$ref_id]);
			
		}else if ($collect_type==VipCollect::collect_vip){
			$query->andFilterWhere(['ref_vip_id'=>$ref_id]);
			
		}else if ($collect_type==VipCollect::collect_prod){
			$query->andFilterWhere(['product_id'=>$ref_id]);
			
		}else if ($collect_type==VipCollect::collect_act){
			$query->andFilterWhere(['package_id'=>$ref_id]);
			
		}else if ($collect_type==VipCollect::collect_blog){
			$query->andFilterWhere(['blog_id'=>$ref_id]);
			
		}else{
			throw new NotFoundHttpException('收藏类型不存在！');
		}		
		$query->andFilterWhere(['vip_id'=>$vip_id]);
		return $query->count();
	}
	
	
	/**
	 * 获取收藏数量
	 * @param unknown $vip_id
	 * @param unknown $collect_type
	 * @param unknown $ref_id
	 * @return number|string
	 */
	public function saveVipCollect($model, $ref_id){
		if($model->collect_type==VipCollect::collect_case){
			$model->case_id = $ref_id;
			return $model->save(true,['vip_id','collect_type','collect_date','case_id']);
			
		}else if ($model->collect_type==VipCollect::collect_vip){
			$model->ref_vip_id = $ref_id;
			return $model->save(true,['vip_id','collect_type','collect_date','ref_vip_id']);
			
		}else if ($model->collect_type==VipCollect::collect_prod){
			$model->product_id = $ref_id;
			return $model->save(true,['vip_id','collect_type','collect_date','product_id']);
			
		}else if ($model->collect_type==VipCollect::collect_act){
			$model->package_id = $ref_id;
			return $model->save(true,['vip_id','collect_type','collect_date','package_id']);
			
		}else if ($model->collect_type==VipCollect::collect_blog){
			$model->blog_id = $ref_id;
			return $model->save(true,['vip_id','collect_type','collect_date','blog_id']);
			
		}else{
			throw new NotFoundHttpException('收藏类型不存在！');
		}
		return false;
	}
	
}