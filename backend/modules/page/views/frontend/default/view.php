<?php

/**
 * @var \yii\web\View $this
 * @var \app\modules\page\models\page $model
 * @var \app\modules\page\models\page $next
 */

use yii\helpers\Url;
use app\modules\attachment\models\Attachment;

?>

<section class="press">
    <div class="press__title">
        <p>Press</p>
    </div>
    <div class="press__items">
        <div class="press__items__item">
            <div class="press__items__item__photo">
                <img src="/img/press/sample.jpg"/><img src="/img/press/sample2.jpg"/><img src="/img/press/sample3.jpg"/><img src="/img/press/sample.jpg"/><img src="/img/press/sample2.jpg"/>
            </div>
            <div class="press__items__item__desc">
                <?php if ($prev) { ?>
                    <div class="press_prev_item"><a href="<?= Url::to(['/page/default/view', 'id' => $prev['id']]); ?>" title="<?=$prev['translation']['title']?>"><?= Yii::t('app', 'Previous page'); ?></a></div>
                <?php } ?>
                <?php if ($next) { ?>
                    <div class="press_next_item"><a href="<?= Url::to(['/page/default/view', 'id' => $next['id']]); ?>" title="<?=$next['translation']['title']?>"><?= Yii::t('app', 'Next page'); ?></a></div>
                <?php } ?>
                <p><?= $model['translation']['title'] ?></p>
                <p><?= Yii::$app->formatter->asDate($model['publish_date'], 'php:d/m/Y'); ?></p>
                <?= $model['translation']['description'] ?>
            </div>
        </div>
    </div>
</section>
