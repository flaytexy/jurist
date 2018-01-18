<?php

/**
 * @var \yii\web\View $this
 * @var \backend\modules\video\models\Video $model
 * @var \backend\modules\video\models\Video $next
 */

use yii\helpers\Url;
use backend\modules\attachment\models\Attachment;

?>
<section class="video_open_page container">
    <ul class="breadcrumb">
        <li><a href="<?= Url::to(['/main/default/index']); ?>"><?= Yii::t('app', 'Главная'); ?></a></li>
        <li><a href="<?= Url::to(['/video/default/index']); ?>"><?= Yii::t('app', 'Новости'); ?></a></li>
        <li>
            <span class="current">
                <?= $model['translation']['title'] ?>
            </span>
        </li>
    </ul>
    <div class="video_open_page__main">
        <img src="<?= Attachment::getImage($model['thumbnail'], [1170, 580]); ?>" srcset="<?= Attachment::getImage($model['thumbnail'], [2340, 1160]); ?> 2x"/>
        <div class="video_open_page__main__text">
            <div class="video_open_page__main__title">
                <p><?= $model['translation']['title'] ?></p>
            </div>
            <?= $model['translation']['description'] ?>
            <div class="video_open_page__main__nav">
                <a class="video_open_page__main__nav__left" href="<?= Url::to(['/video/default/index']); ?>">
                    <img src="/img/cars/arrow_left.png"/>
                    <p><?= Yii::t('app', 'Назад'); ?></p>
                </a>
                <?php if ($next) { ?>
                <a class="video_open_page__main__nav__right" href="<?= Url::to(['/video/default/view', 'id' => $next['id']]); ?>">
                    <p><?= Yii::t('app', 'Следующая новость'); ?></p>
                    <img src="/img/cars/arrow_right.png"/>
                </a>
                <?php } ?>
            </div>
        </div>
    </div>
</section>