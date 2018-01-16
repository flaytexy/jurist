<?php

use app\modules\currency\models\Currency;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use app\modules\attachment\models\Attachment;

?>
<section class="news_open_page container car_page review_page">
    <ul class="breadcrumb">
        <li><a href="<?= Url::to(['/main/default/index']); ?>"><?= Yii::t('app', 'Главная'); ?></a></li>
        <li>
            <span class="current">
                <?= Yii::t('app', 'Отзывы клиентов') ?>
            </span>
        </li>
    </ul>
    <div class="car_review">
        <div class="car_review__left">
            <div class="news_page__title">
                <p><?= Yii::t('app', 'Отзывы клиентов'); ?></p>
            </div>
            <?php if($reviews_pages->totalCount) { ?>
                <?php foreach ($reviews as $review) { ?>
                    <div class="car_review__left__item">
                        <div class="car_review__left__item__title">
                            <p><?= $review['translation']['title']; ?> <span><?= Yii::$app->formatter->asDatetime($review['publish_date'], 'php:d.m.Y H:i'); ?></span></p>
                        </div>
                        <div class="car_review__left__item__text">
                            <p><?= Yii::$app->formatter->asHtml($review['translation']['description']); ?></p>
                            <?php if ($review['translation']['youtube_link']) { ?>
                                <div class="car_review_video">
                                    <a href="javascript:void(0);" data-youtube-id="<?= $review['translation']['youtube_link']; ?>">
                                        <img src="/img/youtube.svg" alt="" width="38" height="38"><span><?= Yii::t('app', 'Смотреть видео отзыв'); ?></span>
                                    </a>
                                </div>
                            <?php } ?>
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
            <?php } else { ?>
                <div class="car_review__left__item"><?= Yii::t('app', 'Нет отзывов.') ?></div>
            <?php } ?>
        </div>
        <?php Pjax::begin(['enablePushState' => false]); ?>
        <form action="<?= Url::to(['/page/review/index']); ?>" method="post" class="car_review__right" data-pjax="1">
            <div class="car_review__right__title">
                <p><?= Yii::t('app', 'Оставить отзыв'); ?></p>
            </div>
            <?php if ($flash_message = Yii::$app->session->getFlash('flash-review-add-success')) { ?>
                <div class="car-review-added">
                    <?= $flash_message; ?>
                </div>
            <?php } ?>
            <div class="form_wrapper">
                <label for="<?= Html::getInputId($review_translation_models[Yii::$app->language], '[' . Yii::$app->language . ']title'); ?>"><?= Yii::t('app', 'Имя'); ?></label>
                <input type="text" id="<?= Html::getInputId($review_translation_models[Yii::$app->language], '[' . Yii::$app->language . ']title'); ?>" name="<?= Html::getInputName($review_translation_models[Yii::$app->language], '[' . Yii::$app->language . ']title'); ?>" value="<?= $review_translation_models[Yii::$app->language]->title; ?>" />
                <div class="car-review-error"><?= $review_translation_models[Yii::$app->language]->getFirstError('title'); ?></div>
            </div>
            <div class="form_wrapper">
                <label for="<?= Html::getInputId($review_translation_models[Yii::$app->language], '[' . Yii::$app->language . ']description'); ?>"><?= Yii::t('app', 'Ваш отзыв'); ?></label>
                <textarea id="<?= Html::getInputId($review_translation_models[Yii::$app->language], '[' . Yii::$app->language . ']description'); ?>" name="<?= Html::getInputName($review_translation_models[Yii::$app->language], '[' . Yii::$app->language . ']description'); ?>"><?= $review_translation_models[Yii::$app->language]->description; ?></textarea>
                <div class="car-review-error"><?= $review_translation_models[Yii::$app->language]->getFirstError('description'); ?></div>
            </div>
            <input class="send_btn" type="submit" value="<?= Yii::t('app', 'Оставить отзыв'); ?>" />
        </form>
        <?php Pjax::end(); ?>
    </div>
</section>