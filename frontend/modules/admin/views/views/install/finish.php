<?php
use yii\helpers\Url;

$asset = \frontend\assets\EmptyAsset::register($this);;

$this->title = Yii::t('easyii/install', 'Installation completed');
?>
<div class="container">
    <div id="wrapper" class="col-md-6 col-md-offset-3 vertical-align-parent">
        <div class="vertical-align-child">
            <div class="panel">
                <div class="panel-heading text-center">
                    <?= Yii::t('easyii/install', 'Installation completed') ?>
                </div>
                <div class="panel-body text-center">
                    <a href="<?= Url::to(['/admin']) ?>">Go to control panel</a>
                </div>
            </div>
            <div class="text-center">
                <a class="logo" href="http://easyiicms.com" target="_blank" title="NNNCMS homepage">
                    <img src="<?= $asset->baseUrl ?>/img/logo_20.png">NNNCMS
                </a>
            </div>
        </div>
    </div>
</div>
