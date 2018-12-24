<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\FrontendAsset;
use frontend\models\Setting;

//$asset = FrontendAsset::register($this);
$position = Setting::get('toolbar_position') === 'bottom' ? 'bottom' : 'top';
$this->registerCss('body {padding-'.$position.': 50px;}');
?>

<nav id="easyii-navbar" class="navbar navbar-inverse navbar-fixed-<?= $position ?>">
    <div class="container">
        <ul class="nav navbar-nav navbar-left">
            <li><a href="<?= Url::to(['/admin']) ?>"><span class="glyphicon glyphicon-arrow-left"></span> <?= Yii::t('easyii', 'Control Panel') ?></a></li>
        </ul>
<!--        <p class="navbar-text"><i class="glyphicon glyphicon-pencil"></i> <a href="--><?php //Url::to(['/admin/system/live-edit']) ?><!--">Cливка</a></p>-->
<!--        --><?//= Html::checkbox('', LIVE_EDIT, ['data-link' => Url::to(['/admin/system/live-edit'])]) ?>
<!--        <p class="navbar-text"><i class="glyphicon glyphicon-pencil"></i> sadasdasd</p>-->
        <ul class="nav navbar-nav navbar-right">
            <li><a href="<?= Url::to(['/admin/sign/out']) ?>"><span class="glyphicon glyphicon-log-out"></span> <?= Yii::t('easyii', 'Logout') ?></a></li>
        </ul>
    </div>
</nav>