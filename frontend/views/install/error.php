<?php
$asset = frontend\assets\EmptyAsset::register($this);

$this->title = Yii::t('easyii/install', 'Installation error');
?>
<div class="container">
    <div id="wrapper" class="col-md-6 col-md-offset-3 vertical-align-parent">
        <div class="vertical-align-child">
            <div class="panel">
                <div class="panel-heading text-center">
                    <?= Yii::t('easyii/install', 'Installation error') ?>
                </div>
                <div class="panel-body text-center">
                    <?= $error ?>
                </div>
            </div>
            <div class="text-center">
                <a class="logo" href="//easyiicms.com" target="_blank" title="ETR_CMS homepage">
                    <img src="<?= $asset->baseUrl ?>/img/logo_20.png">ETR_CMS
                </a>
            </div>
        </div>
    </div>
</div>
