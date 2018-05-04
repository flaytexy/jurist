<?php

/**
 * @var \common\modules\attachment\models\Attachment|array $models
 * @var \common\modules\attachment\models\Attachment $model
 */

?>

<?php foreach ($models as $model) { ?>
<div class="b-thumb" data-id="<?= $model->id; ?>">
    <div class="b-thumb__preview">
        <div class="b-thumb__preview__pic">
            <div class="b-thumb__preview__centered">
            <?php if (strpos($model->type, 'image/') === 0) { ?>
                <img src="<?= Yii::getAlias('@web/uploads') . DIRECTORY_SEPARATOR . $model->name; ?>">
            <?php } ?>
            </div>
        </div>
        <?php if (strpos($model->type, 'image/') === false) { ?>
            <i class="fa fa-file fa-3x"></i>
            <div class="b-thumb__name"><?= $model->getTitle(); ?></div>
        <?php } ?>
    </div>
</div>
<?php } ?>