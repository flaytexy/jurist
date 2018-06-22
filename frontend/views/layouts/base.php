<?php
/* @var $this yii\web\View */
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
        <meta name="google-site-verification" content="p0JwcN9qcVgsUEaLl-fXCCGOx-A4JxOG0mQpVRzgRMA" />

        <?php $this->head() ?>
    </head>
    <body>
        <style>
            #privy-container {
                display: none;
            }
        </style>
        <?php if (YII_DEBUG): ?>
        <script type='text/javascript'>
            var _DEBUG_MODE = true;
        </script>
        <?php endif; ?>

        <?php $this->beginBody() ?>
        <?= $content ?>
        <?php $this->endBody() ?>

<?php if (!YII_DEBUG): ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-112429010-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-112429010-1');
        </script>

        <!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter47424991 = new Ya.Metrika2({ id:47424991, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks2"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/47424991" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
<?php endif; ?>

        <!-- My scripts loading -->
        <?/* if (YII_ENV_PROD) : */?>
        <?= ScriptsFooter::widget([]) ?>
       <!-- --><?/* endif */?>
    </body>
</html>
<?php $this->endPage() ?>