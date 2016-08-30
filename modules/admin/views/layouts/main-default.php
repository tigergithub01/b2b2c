<?php
use yii\helpers\Html;
use yii\helpers\Url;
use Yii\web\View;

/* @var $this \yii\web\View */
/* @var $content string */
/* layout of default controller with iframe */

$this->title = Yii::$app->name;

if (Yii::$app->controller->action->id === 'login') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }

//     dmstr\web\AdminLteAsset::register($this);
//     $this->skin='skin-blue-light';
    app\assets\admin\AdminAsset::register($this);
    
    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition skin-blue-light sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>
		
		<div class="content-wrapper" style="margin-left: auto;">
        	<iframe id="iframe_content" style='width:100%;border:0px;min-height: 1000px;' frameborder="0" src="<?= Url::to(['basic/product/index'])?>"></iframe>
        </div>

    </div>

    <?php $this->endBody() ?>
    
    <script type="text/javascript">
    	$(function () {
    		$('.treeview-menu a').click(function(){
    			//alert($(this).attr("href"));
    			$("#iframe_content").attr("src",$(this).attr("href"));
    			return false;
    		});
    	});
		
    </script>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>


