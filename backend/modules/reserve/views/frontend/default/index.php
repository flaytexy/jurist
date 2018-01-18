<?php

use backend\modules\reserve\widgets\Reserve;
use yii\helpers\Url;
use backend\modules\currency\models\Currency;
use backend\modules\attachment\models\Attachment;

?>

<section class="reserve_1 container">
    <ul class="reserve_1__steps">
        <li class="active_step"><?= Yii::t('app', 'Результаты поиска') ?></li>
        <li><?= Yii::t('app', 'Дополнения') ?></li>
        <li><?= Yii::t('app', 'Водитель') ?></li>
        <li><?= Yii::t('app', 'Оплата') ?></li>
        <li><?= Yii::t('app', 'Подтверждение') ?></li>
    </ul>
    <div class="reserve_1__main">
        <div class="intro__content__left">
            <div class="intro__content__left__title">
                <p><?= Yii::t('app', 'Позвольте найти для Вас идеальный автомобиль!') ?></p>
            </div>

            <?= Reserve::widget(); ?>

            <div class="reserve_1__main__filters">
                <div class="reserve_1__main__filters__title">
                    <p>выбраные фильры:</p>
                    <div class="chose_filters">
                        <div class="chose_filters__item">
                            <p>Name</p>
                            <div class="img"></div>
                        </div>
                    </div>
                </div>
                <ul class="reserve_1__main__filters__items">
                    <li>
                        <div class="head_filter">
                            <p>Спецификация авто</p><img src="/img/info/more.png"/>
                        </div>
                        <ul class="filter_dropdown">
                            <li>
                                <label>
                                    <input type="checkbox"/>NameNameName
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox"/>NameNameName
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox"/>NameNameName
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox"/>NameNameName
                                </label>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <div class="head_filter">
                            <p>Спецификация авто</p><img src="/img/info/more.png"/>
                        </div>
                        <ul class="filter_dropdown">
                            <li>
                                <label>
                                    <input type="checkbox"/>NameNameName
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox"/>NameNameName
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox"/>NameNameName
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox"/>NameNameName
                                </label>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <div class="head_filter">
                            <p>Спецификация авто</p><img src="/img/info/more.png"/>
                        </div>
                        <ul class="filter_dropdown">
                            <li>
                                <label>
                                    <input type="checkbox"/>NameNameName
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox"/>NameNameName
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox"/>NameNameName
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox"/>NameNameName
                                </label>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="reserve_1__main__right">
            <?php if ($categories) { ?>
                <div class="reserve_1__main__right__items">
                    <?php foreach ($categories as $category) { ?>
                        <?php
                        $active_categories = Yii::$app->request->get('category', []);

                        $category_active = in_array($category['id'], $active_categories);
                        if ($category_active) {
                            unset($active_categories[array_search($category['id'], $active_categories)]);
                            $category_href = Url::to(['/reserve/default/index', 'category' => $active_categories] + Yii::$app->request->get());
                        } else {
                            $category_href = Url::to(['/reserve/default/index', 'category' => array_merge($active_categories, [$category['id']])] + Yii::$app->request->get());
                        }
                        ?>
                        <a href="<?= $category_href; ?>">
                            <div class="reserve_1__main__right__items__item<?= $category_active ? ' active_item' : ''; ?>">
                                <div class="reserve_1__main__right__items__item__img"><img src="<?= Attachment::getImage($category['thumbnail'], [140, 100]); ?>" srcset="<?= Attachment::getImage($category['thumbnail'], [280, 200]); ?> 2x" /></div>
                                <div class="reserve_1__main__right__items__item__head">
                                    <p><?= $category['translation']['title']; ?></p>
                                    <p>
                                        <?= Yii::t('app', 'от'); ?> <?= Currency::format($category['minimumPrice']['minimum']); ?>
                                    </p>
                                </div>
                                <div class="status_img"></div>
                            </div>
                        </a>
                    <?php } ?>
                    <?php for($i = 0; $i < 5; $i++) { ?>
                        <span class="reserve_1__main__right__items__item indent-clear"></span>
                    <?php } ?>
                    <div class="news_page__more">
                        <a href="<?= Url::to(['/reserve/default/index', 'category' => null] + Yii::$app->request->get()); ?>">
                            <?= Yii::t('app', 'Смотреть все классы'); ?>
                            <div class="news_page__more__overlay"></div>
                        </a>
                    </div>
                </div>
            <?php } ?>
            <div class="reserve_1__main__right__list">
                <?php foreach ($models as $model) { ?>
                    <div class="reserve_1__main__right__list__card">
                        <div class="reserve_1__main__right__list__card__img"><img src="<?= Attachment::getImage($model['thumbnail'], [165, 140]); ?>" srcset="<?= Attachment::getImage($model['thumbnail'], [330, 280]); ?> 2x"/>
                            <?php if ($model['translatedSticker']) { ?>
                                <?php
                                $this->registerCss(".sticker-" . $model['translatedSticker']['id'] . " {color:" . $model['translatedSticker']['color'] . "!important;background:" . $model['translatedSticker']['background'] . "!important;border-color:" . $model['translatedSticker']['border'] . "!important;}");
                                ?>
                                <div class="label active sticker-<?= $model['translatedSticker']['id']; ?>">
                                    <p><?= $model['translatedSticker']['translation']['title']; ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card_wrapper_main">
                            <div class="reserve_1__main__right__list__card__head">
                                <div class="reserve_1__main__right__list__card__head__left">
                                    <div class="card_wrapper">
                                        <p>
                                            <?= $model['translatedBrand']['translation']['title']; ?>
                                            <?= $model['translatedModel']['translation']['title']; ?>
                                            <?= $model['translation']['title']; ?>
                                        </p>
                                        <p><?= $model['translatedCategory']['translation']['title']; ?> <span><?= $model['acriss']; ?></span></p>
                                    </div>
                                </div>
                                <div class="reserve_1__main__right__list__card__head__right"><a href="<?= Url::to(['/reserve/default/additions', 'car' => $model['id']]); ?>"><?= Yii::t('app', 'Бронировать'); ?></a></div>
                            </div>
                            <div class="reserve_1__main__right__list__card__main">
                                <div class="reserve_1__main__right__list__card__main__item small">
                                    <i class="icon-seat"></i>
                                    <div class="card_wrapper">
                                        <p><?= Yii::t('app', 'Мест') ?><br><?= $model['attr_seat'] ?: 'n/a' ?></p>
                                    </div>
                                </div>
                                <div class="reserve_1__main__right__list__card__main__item medium">
                                    <i class="icon-rear-drive"></i>
                                    <div class="card_wrapper">
                                        <p>
                                            <?= $model['attr_rear_drive'] ?: 'n/a' ?>
                                            <?= Yii::t('app', 'привод') ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="reserve_1__main__right__list__card__main__item">
                                    <i class="icon-conditioner"></i>
                                    <div class="card_wrapper">
                                        <p><?= $model['attr_conditioner'] == 'Да' ? Yii::t('app', 'С кондиционером') : ($model['attr_conditioner'] == 'Нет' ? Yii::t('app', 'Без кондиционера') : 'n/a') ?></p>
                                    </div>
                                </div>
                                <div class="reserve_1__main__right__list__card__main__item small">
                                    <i class="icon-engine"></i>
                                    <div class="card_wrapper">
                                        <p><?= $model['attr_engine'] ?: Yii::t('app', 'Двигатель'); ?><br><?= $model['attr_capacity'] ?: 'n/a' ?></p>
                                    </div>
                                </div>
                                <div class="reserve_1__main__right__list__card__main__item medium">
                                    <i class="icon-fuel"></i>
                                    <div class="card_wrapper">
                                        <p><?= Yii::t('app', 'Расход топлива') ?><br><?= $model['attr_fuel'] ?: 'n/a' ?> <?= Yii::t('app', 'л./100км') ?></p>
                                    </div>
                                </div>
                                <div class="reserve_1__main__right__list__card__main__item">
                                    <i class="icon-<?= $model['attr_transmission'] == 'Автоматическая' ? 'automat' : 'transmission' ?>"></i>
                                    <div class="card_wrapper">
                                        <p><?= $model['attr_transmission'] ?: 'n/a' ?> <?= Yii::t('app', 'трансмиссия') ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="reserve_1__main__right__list__card__bottom">
                                <div class="reserve_1__main__right__list__card__bottom__item">
                                    <p><?= Currency::dayPrice($reserve_period, $model['cityPrice']); ?> / <span><?= Yii::t('app', 'день') ?></span></p>
                                </div>
                                <div class="reserve_1__main__right__list__card__bottom__item">
                                    <p><?= Yii::t('app', 'залог') ?>: <span><?= Currency::format($model['deposit']); ?></span></p>
                                </div>
                                <div class="reserve_1__main__right__list__card__bottom__item">
                                    <p><?= Yii::t('app', 'итого') ?>: <span><?= Currency::periodPrice($reserve_period, $model['cityPrice'], $model['discount_type'], $model['discount']); ?></span></p>
                                    <?php if ($model['discount_type'] && $model['discount']) { ?>
                                    <div class="label active">
                                        <p><?= Yii::t('app', 'Сейчас') ?> -<?= Currency::formatDiscount($model['discount_type'], $model['discount']); ?></p>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
