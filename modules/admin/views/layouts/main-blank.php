<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use app\modules\admin\Module;

/* @var $this \yii\web\View */
/* @var $content string */

// dmstr\web\AdminLteAsset::register($this);

app\assets\admin\AdminLoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Module::t('app','app_admin_name').'-'.Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition">

<?php $this->beginBody() ?>

    <?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
