<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AdminAsset;

$asset = AdminAsset::register($this);
$moduleName = $this->context->module->id;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Yii::t('easyii', 'Control Panel') ?> - <?= Html::encode($this->title) ?></title>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="<?= $asset->baseUrl ?>/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?= $asset->baseUrl ?>/favicon.ico" type="image/x-icon">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="admin-body">
    <div class="containerok">
        <div class="wrapper">
            <div class="header">
                <div class="logo">
                    <img src="<?= $asset->baseUrl ?>/img/logo_20.png">
                    NNNCMS
                </div>
                <div class="nav">
                    <a href="<?= Yii::$app->homeUrl ?>" class="pull-left"><i class="glyphicon glyphicon-home"></i> <?= Yii::t('easyii', 'Open site') ?></a>
                    <a href="<?= Url::to(['/admin/sign/out']) ?>" class="pull-right"><i class="glyphicon glyphicon-log-out"></i> <?= Yii::t('easyii', 'Logout') ?></a>
                </div>
            </div>
            <div class="main">
                <div class="box sidebar">
                    <a href="<?= Url::to(['/admin/novanews']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'novanews') ? 'active' :'' ?>">
                        <i class="glyphicon glyphicon-file"></i>
                        novanews
                    </a>

                    <a href="<?= Url::to(['/admin/slidemain']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'slidesmall') ? 'active' :'' ?>">
                        <i class="glyphicon glyphicon-file"></i>
                        Слайдер (верхний)
                    </a>
                    <a href="<?= Url::to(['/admin/tickers']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'tickers') ? 'active' :'' ?>">
                        <i class="glyphicon glyphicon-file"></i>
                        Бегущая строка
                    </a>
                    <a href="<?= Url::to(['/admin/slidesmall']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'slidesmall') ? 'active' :'' ?>">
                        <i class="glyphicon glyphicon-file"></i>
                        Слайдер (нижний)
                    </a>
                    <a href="<?= Url::to(['/admin/page?type=6']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'offshore') ? 'active' :'' ?>">
                        <i class="glyphicon glyphicon-file"></i>
                        <?= Yii::t('easyii', 'Offshore') ?>
                    </a>
                    <a href="<?= Url::to(['/admin/page?type=1']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'page') ? 'active' :'' ?>">
                        <i class="glyphicon glyphicon-file"></i>
                        <?= Yii::t('easyii', 'Page') ?>
                    </a>
                    <a href="<?= Url::to(['/admin/page?type=2']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'news') ? 'active' :'' ?>">
                        <i class="glyphicon glyphicon-file"></i>
                        <?= Yii::t('easyii', 'News') ?>
                    </a>
                    <a href="<?= Url::to(['/admin/page?type=3']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'news') ? 'active' :'' ?>">
                        <i class="glyphicon glyphicon-file"></i>
                        <?= Yii::t('easyii', 'Licenses') ?>
                    </a>
                    <a href="<?= Url::to(['/admin/page?type=4']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'news') ? 'active' :'' ?>">
                        <i class="glyphicon glyphicon-file"></i>
                        <?= Yii::t('easyii', 'Fonds') ?>
                    </a>
                    <a href="<?= Url::to(['/admin/page?type=7']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'news') ? 'active' :'' ?>">
                    <i class="glyphicon glyphicon-file"></i>
                    <?= Yii::t('easyii', 'Sale') ?>
                    </a>
                    <a href="<?= Url::to(['/admin/page?type=5']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'news') ? 'active' :'' ?>">
                        <i class="glyphicon glyphicon-file"></i>
                        <?= Yii::t('easyii', 'Processing') ?>
                    </a>
                    <?php foreach(Yii::$app->getModule('admin')->activeModules as $module) : ?>
                        <a href="<?= Url::to(["/admin/$module->name"]) ?>" class="menu-item <?= ($moduleName == $module->name ? 'active' : '') ?>">
                            <?php if($module->icon != '') : ?>
                                <i class="glyphicon glyphicon-<?= $module->icon ?>"></i>
                            <?php endif; ?>
                            <?= $module->title ?>!
                            <?php if($module->notice > 0) : ?>
                                <span class="badge"><?= $module->notice ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                    <a href="<?= Url::to(['/admin/settings']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'settings') ? 'active' :'' ?>">
                        <i class="glyphicon glyphicon-cog"></i>
                        <?= Yii::t('easyii', 'Settings') ?>
                    </a>
                    <?php if(IS_ROOT) : ?>
                        <a href="<?= Url::to(['/admin/modules']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'modules') ? 'active' :'' ?>">
                            <i class="glyphicon glyphicon-folder-close"></i>
                            <?= Yii::t('easyii', 'Modules') ?>
                        </a>
                        <a href="<?= Url::to(['/admin/admins']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'admins') ? 'active' :'' ?>">
                            <i class="glyphicon glyphicon-user"></i>
                            <?= Yii::t('easyii', 'Admins') ?>
                        </a>
                        <a href="<?= Url::to(['/admin/system']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'system') ? 'active' :'' ?>">
                            <i class="glyphicon glyphicon-hdd"></i>
                            <?= Yii::t('easyii', 'System') ?>
                        </a>
                        <a href="<?= Url::to(['/admin/logs']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'logs') ? 'active' :'' ?>">
                            <i class="glyphicon glyphicon-align-justify"></i>
                            <?= Yii::t('easyii', 'Logs') ?>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="box content">
                    <div class="page-title">
                        <?= $this->title ?>
                    </div>
                    <div class="container-fluid">
                        <?php foreach(Yii::$app->session->getAllFlashes() as $key => $message) : ?>
                            <div class="alert alert-<?= $key ?>"><?= $message ?></div>
                        <?php endforeach; ?>
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
