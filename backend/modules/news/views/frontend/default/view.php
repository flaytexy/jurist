<?php

/**
 * @var \yii\web\View $this
 * @var \app\modules\news\models\News $model
 * @var \app\modules\news\models\News $next
 */

use app\modules\attachment\models\Attachment;
use yii\helpers\Url;

?>

<section class="press">
    <div class="press__title">
        <p>Press</p>
    </div>
    <div class="press__items">
        <div class="press__items__item">
            <div class="press__items__item__photo"><?php foreach ($model['images'] as $index => $galleryImage) { ?>
                    <img src="<?= Attachment::getImage($galleryImage['attachment_id']) ?>" srcset="<?= Attachment::getImage($galleryImage['attachment_id']) ?> 2x"/><?php } ?>
            </div>
            <div class="press__items__item__desc">
                <?php if ($prev) { ?>
                    <div class="press_prev_item">
                        <a href="<?= Url::to(['/news/default/view', 'id' => $prev['id']]); ?>" title="<?= $prev['translation']['title'] ?>"><?= Yii::t('app', 'Previous news'); ?></a>
                    </div>
                <?php } ?>
                <?php if ($next) { ?>
                    <div class="press_next_item">
                        <a href="<?= Url::to(['/news/default/view', 'id' => $next['id']]); ?>" title="<?= $next['translation']['title'] ?>"><?= Yii::t('app', 'Next news'); ?></a>
                    </div>
                <?php } ?>
                <p><?= $model['translation']['title'] ?></p>
                <p><?= Yii::$app->formatter->asDate($model['publish_date'], 'php:d/m/Y'); ?></p>
                <?= $model['translation']['description'] ?>
            </div>
        </div>
    </div>
</section>
