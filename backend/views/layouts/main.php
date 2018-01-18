<?php
use backend\assets\AppAsset;
AppAsset::register($this);
?>
<?php $this->beginContent('@backend/views/layouts/layout.php'); ?>

<div class="texture"></div>
<div class="theme_btn">
    <label>
        <input type="checkbox"/>
    </label>
</div>

<section class="header">
    <div class="logo_mob"><img src="/img/intro/logo.png"/></div>
    <ul class="nav">
        <li><a href="/">home</a>
            <div class="bottom_line"></div>
            <div class="bottom_point"></div>
        </li>
        <li class="active"><a href="/about">about</a>
            <div class="bottom_line"></div>
            <div class="bottom_point"></div>
        </li>
        <li><a href="/news">news</a>
            <div class="bottom_line"></div>
            <div class="bottom_point"></div>
        </li>
        <li><a href="/photo">photo</a>
            <div class="bottom_line"></div>
            <div class="bottom_point"></div>
        </li>
        <li><a href="/video">video</a>
            <div class="bottom_line"></div>
            <div class="bottom_point"></div>
        </li>
        <li><a href="/press">press</a>
            <div class="bottom_line"></div>
            <div class="bottom_point"></div>
        </li>
        <li><a href="/contacts">contacts</a>
            <div class="bottom_line"></div>
            <div class="bottom_point"></div>
        </li>
    </ul>
    <div class="social">
        <a class="social_icons" href="<?= Yii::$app->settings->get('twitter') ?>"></a>
        <a class="social_icons" href="<?= Yii::$app->settings->get('facebook') ?>"></a>
        <a class="social_icons" href="<?= Yii::$app->settings->get('telegram') ?>"></a>
    </div>
    <button class="hamburger hamburger--collapse" type="button"><span class="hamburger-box"><span
                class="hamburger-inner"></span></span></button>
</section>

<?= $content ?>

<?php $this->endContent(); ?>
