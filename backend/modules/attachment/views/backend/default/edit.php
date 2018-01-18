<?php

/**
 * @var \backend\modules\attachment\models\Attachment $model
 */

use yii\helpers\Url;
use backend\models\Language;

?>

<div class="modal fade" id="modal-attachment">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Файл</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Закрыть</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-attachment form-group">
                <?php if (strpos($model->type, 'image/') === 0) { ?>
                    <img src="<?= Yii::getAlias('@web/uploads/' . $model->name) ?>" alt="">
                <?php } else { ?>
                    <i class="fa fa-file fa-4x"></i>
                <?php } ?>
                </div>
                <div class="form-group">
                    <label for="attachment-url">URL</label>
                    <input id="attachment-url" class="form-control boxed" type="text" disabled value="<?= Url::to(['/main/default/index'], true) .  trim(Yii::getAlias('@web/uploads/' . $model->name), '/') ?>">
                </div>
                <div class="form-group">
                    <label>Заголовок</label>
                    <?php foreach (Language::getLanguages() as $language) { ?>
                        <div class="input-group">
                            <span class="input-group-addon"><img src="/img/flags/<?= $language['local'] ?>.png" alt="" width="16" height="11"></span>
                            <input id="attachment_translation_<?= $language['local']; ?>" name="AttachmentTranslation[<?= $language['local']; ?>][title]" class="form-control boxed" type="text" value="<?= $translation_models[$language['local']]->title; ?>">
                        </div>
                    <?php } ?>
                </div>
                <input type="hidden" name="Attachment[id]" value="<?= $model->id; ?>">
            </div>
            <div class="modal-footer">
                <div class="pull-left"><a href="#" id="attachment-delete">Удалить навсегда</a></div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" id="attachment-save">Сохранить</button>
            </div>
        </div>
    </div>
</div>