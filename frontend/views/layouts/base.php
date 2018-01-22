<?php
/* @var $this yii\web\View */
/* @var $searchModel \frontend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use yii\helpers\Html;
$asset = \frontend\assets\AppAsset::register($this);

use \frontend\widgets\ScriptsFooter;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <!--<link  href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>-->
        <link rel="shortcut icon" href="<?= $asset->baseUrl ?>/favicon.ico" type="image/x-icon">
        <link rel="icon" href="<?= $asset->baseUrl ?>/favicon.ico" type="image/x-icon">

        <meta http-equiv="content-language" content="ru">
        <meta name="google-site-verification" content="heki76RWc6-gZB7LnqLlp8rGAjdhIMdErxKGACtbnCg" />
        <?php $this->head() ?>
    </head>
    <body>
        <?php if (YII_DEBUG): ?>
        <script type='text/javascript'>
            var _DEBUG_MODE = true;
        </script>
        <?php endif; ?>

        <?php $this->beginBody() ?>
        <?= $content ?>
        <?php $this->endBody() ?>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-112429010-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-112429010-1');
        </script>

        <!-- My scripts loading -->
        <?/* if (YII_ENV_PROD) : */?>
        <?= ScriptsFooter::widget([]) ?>
       <!-- --><?/* endif */?>
    </body>
</html>
<?php $this->endPage() ?>