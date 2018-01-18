<?php

/**
 * @var \backend\modules\park\models\Car $model
 * @var \backend\modules\park\models\City $city
 * @var \backend\modules\park\models\Review $reviews
 * @var \yii\data\Pagination $reviews_pages
 * @var \backend\modules\park\models\Review $review_model
 */

use backend\modules\currency\models\Currency;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use backend\modules\attachment\models\Attachment;

?>

<section class="news_open_page container car_page">
    <ul class="breadcrumb">
        <li><a href="<?= Url::to(['/main/default/index']); ?>"><?= Yii::t('app', 'Главная'); ?></a></li>
        <li><a href="<?= Url::to(['/park/default/index']); ?>"><?= Yii::t('app', 'Парк авто'); ?></a></li>
        <li>
            <span class="current">
                <?= $model['translatedBrand']['translation']['title']; ?>
                <?= $model['translatedModel']['translation']['title']; ?>
                <?= $model['translation']['title']; ?>
            </span>
        </li>
    </ul>
    <div class="car_page__head">
        <div class="car_page__head__left">
            <ul class="pgwSlideshow">
                <li><img src="<?= Attachment::getImage($model['thumbnail']) ?>"/></li>
                <?php foreach ($model['images'] as $image) { ?>
                    <li><img src="<?= Attachment::getImage($image['attachment_id']) ?>"/></li>
                <?php } ?>
                <?php if ($model['translation']['youtube_id']) { ?>
                    <li class="youtube-link" data-youtube-id="<?= $model['translation']['youtube_id']; ?>">
                        <img src="/img/youtube.svg" data-large-src="http://img.youtube.com/vi/<?= $model['translation']['youtube_id']; ?>/mqdefault.jpg">
                        <span><?= Yii::t('app', 'Смотреть видео') ?></span>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="car_page__head__right">
            <?php Pjax::begin(['id' => 'pjax-car-price']); ?>
            <div class="reserve_1__main__right__list">
                <div class="reserve_1__main__right__list__city">
                    <p>
                        <?= Yii::t('app', 'Ваш город'); ?>:
                        <span><?= $city['translation']['title']; ?></span>
                        <i class="icon icon-chevron-down"></i>
                    </p>
                    <ul>
                        <?php foreach ($model['translatedCities'] as $item) { ?>
                            <li><a href="<?= Url::to(['/park/car/index', 'id' => $model['id'], 'city' => $item['id']]) ?>"><?= $item['translation']['title']; ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="reserve_1__main__right__list__card card_auto">
                <div class="card_auto_wrap">
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
                            <?php for($i = 0; $i < 3; $i++) { ?>
                                <div class="reserve_1__main__right__list__card__main__item"></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php if ($model['translation']['equipment']) { ?>
                    <div class="news_page__more car_all_comlect">
                        <a href="#">
                            <?= Yii::t('app', 'Вся комплектация') ?>
                            <div class="news_page__more__overlay"></div>
                            <div class="img">
                                <div class="hor"></div>
                                <div class="vert"></div>
                            </div>
                        </a>
                    </div>
                    <ul class="all_complect">
                        <?= '<li><p>' . implode('</p></li><li><p>', array_filter(array_map('trim', explode(',', $model['translation']['equipment'])))) . '</p></li>'; ?>
                    </ul>
                <?php } ?>
                <div class="card_auto_park">
                    <div class="park_auto_row">
                        <div class="park_auto_col title_col">
                            <p><?= Yii::t('app', 'Кол-во дней'); ?></p>
                        </div>
                        <div class="park_auto_col">
                            <p>1-2</p>
                        </div>
                        <div class="park_auto_col">
                            <p>3-5</p>
                        </div>
                        <div class="park_auto_col">
                            <p>6=7</p>
                        </div>
                        <div class="park_auto_col">
                            <p>8-14</p>
                        </div>
                        <div class="park_auto_col">
                            <p>15-28</p>
                        </div>
                        <div class="park_auto_col">
                            <p>29+</p>
                        </div>
                        <div class="park_auto_col">
                            <p><?= Yii::t('app', 'Залог'); ?></p>
                        </div>
                    </div>
                    <div class="park_auto_row">
                        <div class="park_auto_col title_col">
                            <p><?= Currency::getCurrent()['before']; ?> <?= Yii::t('app', 'Цена'); ?> <?= Currency::getCurrent()['after']; ?></p>
                        </div>
                        <div class="park_auto_col">
                            <p><?= Currency::format($model['prices']['price_1'], false); ?></p>
                        </div>
                        <div class="park_auto_col">
                            <p><?= Currency::format($model['prices']['price_3'], false); ?></p>
                        </div>
                        <div class="park_auto_col">
                            <p><?= Currency::format($model['prices']['price_6'], false); ?></p>
                        </div>
                        <div class="park_auto_col">
                            <p><?= Currency::format($model['prices']['price_8'], false); ?></p>
                        </div>
                        <div class="park_auto_col">
                            <p><?= Currency::format($model['prices']['price_15'], false); ?></p>
                        </div>
                        <div class="park_auto_col">
                            <p><?= Currency::format($model['prices']['price_29'], false); ?></p>
                        </div>
                        <div class="park_auto_col">
                            <p><?= Currency::format($model['deposit'], false); ?></p>
                        </div>
                    </div>
                </div>
                <div class="reserve_1__main__right__list__card__head__right">
                    <a href="#" class="car-reserve" data-url="<?= Url::to(['/reserve/ajax/reserve-form']); ?>" data-id="<?= $model['id']; ?>">
                        <?= Yii::t('app', 'Бронировать'); ?>
                    </a>
                </div>
            </div>
            <?php Pjax::end(); ?>
        </div>
    </div>
    <div class="car_review">
        <div class="car_review__left">
            <div class="news_page__title">
                <p><?= Yii::t('app', 'Отзывы клиентов'); ?></p>
            </div>
            <?php if($reviews_pages->totalCount) { ?>
                <?php Pjax::begin(); ?>
                <?php foreach ($reviews as $review) { ?>
                <div class="car_review__left__item">
                    <div class="car_review__left__item__title">
                        <p><?= $review['name']; ?> <span><?= Yii::$app->formatter->asDatetime($review['created_at'], 'php:d.m.Y H:i'); ?></span></p>
                    </div>
                    <div class="car_review__left__item__text">
                        <p><?= Yii::$app->formatter->asNtext($review['comment']); ?></p>
                    </div>
                </div>
                <?php } ?>
                <?=
                \yii\widgets\LinkPager::widget([
                    'pagination' => $reviews_pages,
                    'options' => [
                        'class' => 'car_pagination',
                    ],
                    'activePageCssClass' => 'active_page',
                    'prevPageLabel' => '<i class="icon-chevron-left"></i>',
                    'nextPageLabel' => '<i class="icon-chevron-right"></i>',
                    'maxButtonCount' => 5,
                ]);
                ?>
                <?php Pjax::end(); ?>
            <?php } else { ?>
                <div class="car_review__left__item"><?= Yii::t('app', 'Нет отзывов.') ?></div>
            <?php } ?>
        </div>
        <?php Pjax::begin(); ?>
        <form action="<?= Url::to(['/park/car/index', 'id' => $model['id']]); ?>" method="post" class="car_review__right" data-pjax="1">
            <div class="car_review__right__title">
                <p><?= Yii::t('app', 'Оставить отзыв'); ?></p>
            </div>
            <?php if ($flash_message = Yii::$app->session->getFlash('flash-review-add-success')) { ?>
                <div class="car-review-added">
                    <?= $flash_message; ?>
                </div>
            <?php } ?>
            <div class="form_wrapper">
                <label for="<?= Html::getInputId($review_model, 'name'); ?>"><?= Yii::t('app', 'Имя'); ?></label>
                <input type="text" id="<?= Html::getInputId($review_model, 'name'); ?>" name="<?= Html::getInputName($review_model, 'name'); ?>" value="<?= $review_model->name; ?>" />
                <div class="car-review-error"><?= $review_model->getFirstError('name'); ?></div>
            </div>
            <div class="form_wrapper">
                <label for="<?= Html::getInputId($review_model, 'comment'); ?>"><?= Yii::t('app', 'Ваш отзыв'); ?></label>
                <textarea id="<?= Html::getInputId($review_model, 'comment'); ?>" name="<?= Html::getInputName($review_model, 'comment'); ?>"><?= $review_model->comment; ?></textarea>
                <div class="car-review-error"><?= $review_model->getFirstError('comment'); ?></div>
            </div>
            <input class="send_btn" type="submit" value="<?= Yii::t('app', 'Оставить отзыв'); ?>" />
        </form>
        <?php Pjax::end(); ?>
    </div>
</section>