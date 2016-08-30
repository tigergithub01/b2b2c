<?php

namespace app\modules\admin\components;

use yii\grid\GridView;

class AppGridView extends GridView{ 
	public $layout = '{items}<div class="text-right tooltip-demo"><div class="col-sm-12">{summary}</div><div class="col-sm-12">{pager}</div>';
}