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
<style>
    .containerok .navbar {
        padding: 0.1rem 1rem !important;
    }
    .containerok .navbar > .navbar-brand {
        padding-top: 0 !important;  padding-bottom: 0 !important;
    }
</style>
<?php $this->beginBody() ?>
<div id="admin-body">
    <div class="containerok">
        <div class="wrapper">
            <div class="header">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark d-lg-none d-xl-none">
                    <a class="navbar-brand" href="#">Menu</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarsExample03">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                            </li>

                            <?php foreach(Yii::$app->getModule('admin')->activeModules as $module) : ?>
                                <li class="nav-item"><a href="<?= Url::to(["/admin/$module->name"]) ?>" class="menu-item <?= ($moduleName == $module->name ? 'active' : '') ?>">
                                        <?php if($module->icon != '') : ?>
                                            <i class="glyphicon glyphicon-<?= $module->icon ?>"></i>
                                        <?php endif; ?>
                                        <?= $module->title ?>!
                                        <?php if($module->notice > 0) : ?>
                                            <span class="badge"><?= $module->notice ?></span>
                                        <?php endif; ?>
                                    </a>   </li>
                            <?php endforeach; ?>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="https://example.com" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                                <div class="dropdown-menu" aria-labelledby="dropdown03">

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
                            </li>
                        </ul>
                        <form class="form-inline my-2 my-md-0">
                            <input class="form-control" type="text" placeholder="Search">
                        </form>
                    </div>
                </nav>
            </div>
            <div class="main">
                <div class="box sidebar">
                    <a href="<?= Url::to(['/admin/novanews']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'novanews') ? 'active' :'' ?>">
                        <i class="glyphicon glyphicon-file"></i>
                        Статьи (Новое)
                    </a>

                    <a href="<?= Url::to(['/admin/novabanks']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'novabanks') ? 'active' :'' ?>">
                        <i class="glyphicon glyphicon-file"></i>
                        Банки (Новое)
                    </a>

                    <a href="<?= Url::to(['/admin/novaoffers']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'novaoffers') ? 'active' :'' ?>">
                        <i class="glyphicon glyphicon-file"></i>
                        Компании (Новое)
                    </a>
                    <a href="<?= Url::to(['/admin/licenses']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'licenses') ? 'active' :'' ?>">
                        <i class="glyphicon glyphicon-file"></i>
                        Лицензии
                    </a>
                    <a href="<?= Url::to(['/admin/sale']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'sale') ? 'active' :'' ?>">
                        <i class="glyphicon glyphicon-file"></i>
                        Предложения
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
                    <a href="<?= Url::to(['/admin/default/flush']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'novanews') ? 'active' :'' ?>">
                        <i class="glyphicon glyphicon-file"></i>
                        Сброс кеша
                    </a>
                    <!--
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
                    -->
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
