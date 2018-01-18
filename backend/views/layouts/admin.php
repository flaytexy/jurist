<?php

/**
 * @var \yii\web\View $this
 * @var string $content
 */

use yii\helpers\Url;
use yii\helpers\Html;
use backend\assets\AdminAsset;

AdminAsset::register($this);

?>

<?php $this->beginContent('@backend/views/layouts/layout.php'); ?>

    <div class="main-wrapper">
        <div class="app header-fixed sidebar-fixed" id="app">
            <header class="header">

                <div class="header-block header-block-collapse hidden-lg-up">
                    <button class="collapse-btn" id="sidebar-collapse-btn">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>

                <div class="header-block header-block-nav">
                    <ul class="nav-profile">
                        <li>
                            <?= Html::a('<i class="fa fa-power-off"></i>&nbsp;&nbsp;Выход', ['/admin/user/user/logout'], ['data-method' => 'post']) ?>
                        </li>
                    </ul>
                </div>
            </header>

            <aside class="sidebar">
                <div class="sidebar-container">

                    <div class="sidebar-header">
                        <div class="brand">
                           <img src="/img/intro/logo.png"/>
                        </div>
                    </div>

                    <nav class="menu">
                        <ul class="nav metismenu" id="sidebar-menu">

<!--                            <li<?/*= Yii::$app->controller->module->id === 'menu' ? ' class="active"' : '' */?>>
                                <a href="<?/*= Url::to(['/admin/menu/default/index']); */?>">
                                    <i class="fa fa-sitemap"></i>
                                    Меню
                                </a>
                            </li>

                            <li<?/*= Yii::$app->controller->module->id === 'currency' ? ' class="active"' : '' */?>>
                                <a href="<?/*= Url::to(['/admin/currency/default/index']); */?>">
                                    <i class="fa fa-money"></i>
                                    Валюты
                                </a>
                            </li>-->

<!--                            <li<?/*= Yii::$app->controller->module->id === 'page' ? ' class="active open"' : '' */?>>
                                <a href="">
                                    <i class="fa fa-file-text-o"></i>
                                    Контент
                                    <i class="fa arrow"></i>
                                </a>
                                <ul class="sidebar-nav collapse out">
                                    <li<?/*= Yii::$app->controller->module->id === 'page' && Yii::$app->controller->id === 'default' ? ' class="active"' : '' */?>>
                                        <a href="<?/*= Url::to(['/admin/page/default/index']); */?>">Страницы</a>
                                    </li>
                                    <li<?/*= Yii::$app->controller->module->id === 'page' && Yii::$app->controller->id === 'slider' ? ' class="active"' : '' */?>>
                                        <a href="<?/*= Url::to(['/admin/page/slider/index']); */?>">Слайды</a>
                                    </li>
                                    <li<?/*= Yii::$app->controller->module->id === 'page' && Yii::$app->controller->id === 'service' ? ' class="active"' : '' */?>>
                                        <a href="<?/*= Url::to(['/admin/page/service/index']); */?>">Услуги</a>
                                    </li>
                                    <li<?/*= Yii::$app->controller->module->id === 'page' && Yii::$app->controller->id === 'useful' ? ' class="active"' : '' */?>>
                                        <a href="<?/*= Url::to(['/admin/page/useful/index']); */?>">Полезно знать</a>
                                    </li>
                                    <li<?/*= Yii::$app->controller->module->id === 'page' && Yii::$app->controller->id === 'review' ? ' class="active"' : '' */?>>
                                        <a href="<?/*= Url::to(['/admin/page/review/index']); */?>">Отзывы</a>
                                    </li>
                                </ul>
                            </li>-->

                            <li<?= Yii::$app->controller->module->id === 'page' ? ' class="active"' : '' ?>>
                                <a href="<?= Url::to(['/admin/page/default/index']); ?>">
                                    <i class="fa fa-files-o"></i>
                                    <!--Страницы--> О нас
                                </a>
                            </li>

                            <li<?= Yii::$app->controller->module->id === 'news' ? ' class="active"' : '' ?>>
                                <a href="<?= Url::to(['/admin/news/default/index']); ?>">
                                    <i class="fa fa-newspaper-o"></i>
                                    Новости
                                </a>
                            </li>

                            <li<?= Yii::$app->controller->module->id === 'press' ? ' class="active"' : '' ?>>
                                <a href="<?= Url::to(['/admin/press/default/index']); ?>">
                                    <i class="fa fa-bullhorn"></i>
                                    Преса
                                </a>
                            </li>

                            <li<?= Yii::$app->controller->module->id === 'album' ? ' class="active"' : '' ?>>
                                <a href="<?= Url::to(['/admin/album/default/index']); ?>">
                                    <i class="fa fa-picture-o"></i>
                                    Альбомы
                                </a>
                            </li>

                            <li<?= Yii::$app->controller->module->id === 'video' ? ' class="active"' : '' ?>>
                                <a href="<?= Url::to(['/admin/video/default/index']); ?>">
                                    <i class="fa fa-file-video-o"></i>
                                    Видео
                                </a>
                            </li>
                            
                            <li<?= Yii::$app->controller->module->id === 'attachment' ? ' class="active"' : '' ?>>
                                <a href="<?= Url::to(['/admin/attachment/default/index']); ?>">
                                    <i class="fa fa-picture-o"></i>
                                    Медиафайлы
                                </a>
                            </li>



<!--                            <li<?/*= Yii::$app->controller->module->id === 'park' && Yii::$app->controller->id !== 'car' ? ' class="active open"' : '' */?>>
                                <a href="">
                                    <i class="fa fa-tachometer"></i>
                                    Парк авто
                                    <i class="fa arrow"></i>
                                </a>
                                <ul class="sidebar-nav collapse out">
                                    <li<?/*= Yii::$app->controller->module->id === 'park' && Yii::$app->controller->id === 'city' ? ' class="active"' : '' */?>>
                                        <a href="<?/*= Url::to(['/admin/park/city/index']); */?>">Города</a>
                                    </li>
                                    <li<?/*= Yii::$app->controller->module->id === 'park' && Yii::$app->controller->id === 'place' ? ' class="active"' : '' */?>>
                                        <a href="<?/*= Url::to(['/admin/park/place/index']); */?>">Местоположения</a>
                                    </li>
                                    <li<?/*= Yii::$app->controller->module->id === 'park' && (Yii::$app->controller->id === 'brand' || Yii::$app->controller->id === 'model') ? ' class="active"' : '' */?>>
                                        <a href="<?/*= Url::to(['/admin/park/brand/index']); */?>">Марки</a>
                                    </li>
                                    <li<?/*= Yii::$app->controller->module->id === 'park' && Yii::$app->controller->id === 'category' ? ' class="active"' : '' */?>>
                                        <a href="<?/*= Url::to(['/admin/park/category/index']); */?>">Классы</a>
                                    </li>
                                    <li<?/*= Yii::$app->controller->module->id === 'park' && (Yii::$app->controller->id === 'attribute' || Yii::$app->controller->id === 'attribute-value') ? ' class="active"' : '' */?>>
                                        <a href="<?/*= Url::to(['/admin/park/attribute/index']); */?>">Характеристики</a>
                                    </li>
                                    <li<?/*= Yii::$app->controller->module->id === 'park' && Yii::$app->controller->id === 'service' ? ' class="active"' : '' */?>>
                                        <a href="<?/*= Url::to(['/admin/park/service/index']); */?>">Дополнительные услуги</a>
                                    </li>
                                    <li<?/*= Yii::$app->controller->module->id === 'park' && Yii::$app->controller->id === 'sticker' ? ' class="active"' : '' */?>>
                                        <a href="<?/*= Url::to(['/admin/park/sticker/index']); */?>">Стикеры</a>
                                    </li>
                                    <li<?/*= Yii::$app->controller->module->id === 'park' && Yii::$app->controller->id === 'review' ? ' class="active"' : '' */?>>
                                        <a href="<?/*= Url::to(['/admin/park/review/index']); */?>">Отзывы</a>
                                    </li>
                                </ul>
                            </li>-->

<!--                            <li<?/*= Yii::$app->controller->module->id === 'park' && Yii::$app->controller->id === 'car' ? ' class="active open"' : '' */?>>
                                <a href="<?/*= Url::to(['/admin/park/car/index']); */?>">
                                    <i class="fa fa-truck"></i>
                                    Автомобили
                                </a>
                            </li>-->

                            <li<?= Yii::$app->controller->module->id === 'settinger' ? ' class="active open"' : '' ?>>
                                <a href="<?= Url::to(['/admin/settinger/default/index']); ?>">
                                    <i class="fa fa-cog"></i>
                                    Настройки
                                </a>
                            </li>

                            <li<?= Yii::$app->controller->module->id === 'seo' ? ' class="active open"' : '' ?>>
                                <a href="<?= Url::to(['/admin/seo/default/index']); ?>">
                                    <i class="fa fa-search"></i>
                                    SEO
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <footer class="sidebar-footer">
                    <ul class="nav metismenu" id="settings-menu">
                        <li>
                            <a href="<?= Url::to(['/main/cache/flush']); ?>">
                                <i class="fa fa-cog"></i> Очистить кэш
                            </a>
                        </li>
                    </ul>
                </footer>
            </aside>

            <div class="sidebar-overlay" id="sidebar-overlay"></div>

            <article class="content">

                <?php if ($flash_message = Yii::$app->session->getFlash('flash-admin-message-error')) { ?>
                    <div class="card card-block card-flash card-flash-error">
                        <?= $flash_message; ?>
                    </div>
                <?php } ?>

                <?php if ($flash_message = Yii::$app->session->getFlash('flash-admin-message-success')) { ?>
                    <div class="card card-block card-flash card-flash-success">
                        <?= $flash_message; ?>
                    </div>
                <?php } ?>

                <?= $content; ?>
            </article>

        </div>
    </div>

<?php $this->endContent(); ?>