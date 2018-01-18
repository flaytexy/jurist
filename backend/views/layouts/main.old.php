<?php

use yii\widgets\Breadcrumbs;
use backend\assets\AppAsset;
use yii\helpers\Url;
use \backend\modules\menu\models\MenuItem;
use common\components\LanguageRequest;
use backend\modules\park\models\City;
use backend\modules\park\models\Brand;
use backend\modules\currency\models\Currency;

$language_request = new LanguageRequest;

AppAsset::register($this);

/* @var $this \yii\web\View */
/* @var $content string */

$header_cities = City::getHeaderCities();
$footer_cities = City::getFooterCities();

?>
<?php $this->beginContent('@backend/views/layouts/layout.php'); ?>

<section class="header<?= $language_request->getLanguageUrl() !== '/' ? ' not_main' : '' ?>">
    <div class="header__content container">
        <div class="header__content__left"><a href="<?= Url::to(['/main/default/index']) ?>"><img src="/img/header/logo.png"/></a>
            <?php
                $menu_items = MenuItem::find()
                ->where([
                    'menu_id' => 2,
                    'parent_id' => 0,
                ])
                ->joinWith('translation')
                ->with('translatedChildren')
                ->asArray()
                ->all();
            ?>
            <?php if ($menu_items) { ?>
                <ul>
                    <?php foreach ($menu_items as $menu_item) { ?>
                        <li<?= $menu_item['translatedChildren'] ? ' class="park_auto"' : '' ?>>
                            <a href="<?= $menu_item['translation']['link']; ?>"><?= $menu_item['translation']['title']; ?></a>
                            <?php if ($menu_item['translatedChildren']) { ?>
                                <ul class="park_auto_dropdown">
                                    <?php foreach ($menu_item['translatedChildren'] as $menu_child) { ?>
                                        <li>
                                            <a href="<?= $menu_child['translation']['link']; ?>"><?= $menu_child['translation']['title']; ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
        <div class="header__content__right">
            <div class="header__content__right__currency">
                <p><?= Currency::getCurrent()['title']; ?></p><img src="/img/header/more.png"/>
                <ul class="currency_dropdown" data-url="<?= Url::to(['/main/ajax/set-currency']); ?>">
                    <?php foreach (Currency::getAll() as $currency) { ?>
                        <li><a href="javascript:void(0);" data-currency="<?= $currency['iso']; ?>"><?= $currency['title']; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="header__content__hamburger">
            <button class="hamburger hamburger--collapse" type="button"><span class="hamburger-box"><span class="hamburger-inner"></span></span></button>
        </div>
        <?php if ($language_request->getLanguageUrl() == '/' && $header_cities) { ?>
        <?php
        $first_header_city = reset($header_cities);
        $first_header_city['phones'] = unserialize($first_header_city['phones']);
        $first_header_city['phone'] = reset($first_header_city['phones']);
        ?>
        <div class="header__content__right_bottom">
            <div class="header__content__right_bottom__tel">
                <a href="tel:<?= $first_header_city['phone']; ?>"><?= $first_header_city['phone']; ?></a>
            </div>
            <div class="header__content__right_bottom__city">
                <p>
                    <span class="header__content__right_bottom__city_name"><?= $first_header_city['title']; ?></span>
                    <img src="/img/header/more.png"/>
                </p>
                <div class="city_dropdown">
                    <p>Выберите город</p>
                    <ul>
                        <?php foreach ($header_cities as $header_city) { ?>
                            <?php
                            $header_city['phones'] = unserialize($header_city['phones']);
                            $header_city['phone'] = reset($header_city['phones']);
                            ?>
                            <li><a href="#" data-phone="<?= $header_city['phone']; ?>"><?= $header_city['title']; ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</section>

    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <?= $content ?>

<section class="footer">
    <div class="footer__content container">
        <div class="footer__content__left">
            <div class="footer__content__left__logo"><img src="/img/header/logo.png"/></div>
            <div class="footer__content__left__call">
                <div class="footer__content__left__call__cities">
                    <ul>
                        <?php foreach ($footer_cities as $index => $city) { ?>
                            <li<?= $index === 0 ? ' class="active_city"' : '' ?>><?= $city['title']; ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="footer__content__left__call__numbers">
                    <?php foreach ($footer_cities as $index => $city) { ?>
                        <?php $city['phones'] = unserialize($city['phones']); ?>
                        <div class="footer__content__left__call__numbers__item<?= $index === 0 ? ' active_number' : '' ?>">
                            <?php foreach ($city['phones'] as $phone) { ?>
                                <a href="tel:<?= $phone; ?>"><?= $phone; ?></a>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="footer__content__left__social">
                <a href="https://www.facebook.com/blscarrental" target="_blank"></a><a href="https://www.instagram.com/blscarrental/" target="_blank"></a><a href="https://www.youtube.com/channel/UCZzZDAz2PesrsOjaJv2vapQ" target="_blank"></a>
            </div>
            <div class="footer__content__left__bls">
                <p>© 2007 - <?= date('Y'); ?> <?= Yii::$app->name; ?> All rights reserved</p>
            </div>
        </div>
        <div class="footer__content__right">
            <ul>
                <?php foreach (MenuItem::getHierarchical(3, 0, Yii::$app->language) as $menu_item) { ?>
                    <li<?= $menu_item['children'] ? ' class="has_child"' : '' ?>>
                        <a href="<?= $menu_item['link']; ?>"><?= $menu_item['title']; ?></a>
                        <?php if ($menu_item['children']) { ?>
                            <ul>
                                <?php foreach ($menu_item['children'] as $menu_child) { ?>
                                    <li>
                                        <a href="<?= $menu_child['link']; ?>"><?= $menu_child['title']; ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
            <ul class="submenu">
                <?php foreach (MenuItem::getHierarchical(4, 0, Yii::$app->language) as $menu_item) { ?>
                    <li<?= $menu_item['children'] ? ' class="has_child"' : '' ?>>
                        <?php if ($menu_item['children']) { ?>
                            <ul>
                                <?php foreach ($menu_item['children'] as $menu_child) { ?>
                                    <li>
                                        <a href="<?= $menu_child['link']; ?>"><?= $menu_child['title']; ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
                <li class="has_child">
                    <ul>
                        <?php foreach (Brand::getMenuItems() as $menu_child) { ?>
                            <li>
                                <a href="<?= Url::to(['/park/default/brand', 'brand' => $menu_child['id']]); ?>"><?= $menu_child['title']; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <?php foreach (MenuItem::getHierarchical(5, 0, Yii::$app->language) as $menu_item) { ?>
                    <li<?= $menu_item['children'] ? ' class="has_child"' : '' ?>>
                        <?php if ($menu_item['children']) { ?>
                            <ul>
                                <?php foreach ($menu_item['children'] as $menu_child) { ?>
                                    <li>
                                        <a href="<?= $menu_child['link']; ?>"><?= $menu_child['title']; ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</section>

<?php $this->endContent(); ?>
