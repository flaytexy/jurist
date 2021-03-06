<?php

/**
 * @var \yii\web\View $this
 * @var \backend\modules\press\models\Press $model
 * @var \backend\modules\press\models\Press $next
 */

use yii\helpers\Url;
use backend\modules\attachment\models\Attachment;

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
                    <div class="press_prev_item"><a href="<?= Url::to(['/press/default/view', 'id' => $prev['id']]); ?>" title="<?=$prev['translation']['title']?>"><?= Yii::t('app', 'Previous press'); ?></a></div>
                <?php } ?>
                <?php if ($next) { ?>
                    <div class="press_next_item"><a href="<?= Url::to(['/press/default/view', 'id' => $next['id']]); ?>" title="<?=$next['translation']['title']?>"><?= Yii::t('app', 'Next press'); ?></a></div>
                <?php } ?>
                <p><?= $model['translation']['title'] ?></p>
                <p><?= Yii::$app->formatter->asDate($model['publish_date'], 'php:d/m/Y'); ?></p>
                <?= $model['translation']['description'] ?>
            </div>
        </div>
    </div>
</section>
