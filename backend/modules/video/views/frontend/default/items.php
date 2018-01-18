<?php
use backend\modules\attachment\models\Attachment;
/**
 * @var \backend\modules\attachment\models\Attachment|array $models
 * @var \backend\modules\attachment\models\Attachment $model
 */

?>

<?php foreach ($models as $index => $model) { ?>
    <a data-fancybox href="<?php if ($model['translation']['video_link']): ?><?= $model['translation']['video_link']?><?php else: ?><?= Attachment::getImage($model['thumbnail']) ?><?php endif; ?>" class="video__items__item wow fadeInUp"><img src="<?= Attachment::getImage($model['thumbnail'], [300,200]) ?>" srcset="<?= Attachment::getImage($model['thumbnail'], [600,400]) ?> 2x"/>
        <div class="video__items__item__title">
            <p><?= $model['translation']['title']; ?></p>
        </div>
    </a>
<?php } ?>