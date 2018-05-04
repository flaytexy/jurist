<?php

/**
 * @var \yii\web\View $this
 * @var \frontend\modules\video\models\Video|array $models
 * @var \frontend\modules\video\models\Video $model
 * @var \yii\data\Pagination $pages
 */

use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\modules\attachment\models\Attachment;
use yii\widgets\Pjax;

?>

<section class="video_page container">
    <ul class="breadcrumb">
        <li><a href="<?= Url::to(['/main/default/index']); ?>"><?= Yii::t('app', 'Главная'); ?></a></li>
        <li>
            <span class="current">
                <?= Yii::t('app', 'Новости') ?>
            </span>
        </li>
    </ul>
    <div class="video_page__title">
        <p><?= Yii::t('app', 'Новости') ?></p>
    </div>
    <?php Pjax::begin(); ?>
    <div class="video_page__items">
        <?php
            $n = 0;
            $nth_child = [];
            while (($index = 6 * $n - 1) <= count($models)) {
                $nth_child[$index - 1] = 1;
                $n++;
            }

            $n = 0;
            $nth_child2 = [];
            while (($index = 6 * $n) <= count($models)) {
                $nth_child2[$index - 1] = 1;
                $n++;
            }
        ?>
        <?php foreach ($models as $index => $model) { ?>
            <?php
            if (isset($nth_child[$index]) || isset($nth_child2[$index])) {
                $image_size = [
                    [570, 370],
                    [1140, 740],
                ];
            } else {
                $image_size = [
                    [290, 180],
                    [580, 360],
                ];
            }
            ?>
            <a data-pjax="0" class="video_page__items__item" href="<?= Url::to(['/video/default/view', 'id' => $model['id']]); ?>" <?= (($index + 1) === (6 * $index - 1) ? '+' : '-') ?> <?= $index ?> <?= $index+1 ?> <?= (6 * $index - 1) ?>>
                <div class="video_page__items__item__left">
                    <div class="video_page__items__item__left__date">
                        <p><?= Yii::$app->formatter->asDate($model['publish_date'], 'php:d.m.Y'); ?></p>
                    </div>
                    <div class="video_page__items__item__left__title">
                        <p><?= $model['translation']['title']; ?></p>
                    </div>
                    <div class="video_page__items__item__left__desc">
                        <p><?= $model['translation']['short_description']; ?></p>
                    </div>
                </div>
                <div class="video_page__items__item__right"><img src="<?= Attachment::getImage($model['thumbnail'], $image_size[0]) ?>" srcset="<?= Attachment::getImage($model['thumbnail'], $image_size[1]) ?> 2x"/></div>
            </a>
        <?php } ?>
        <div class="video_page__items__item indent-clear"></div>
        <div class="video_page__items__item indent-clear"></div>
    </div>
    <?php $offers_links = $pages->getLinks(); ?>
    <?php if (isset($offers_links['next'])) { ?>
    <div class="video_page__more">
        <a href="<?= $offers_links['next']; ?>">
            <?= Yii::t('app', 'Загрузить больше') ?>
            <div class="video_page__more__overlay"></div>
        </a>
    </div>
    <?php } ?>
    <?php Pjax::end(); ?>
</section>