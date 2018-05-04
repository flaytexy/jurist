<?php

/**
 * @var \yii\web\View $this
 * @var \common\modules\news\models\News|array $models
 * @var \common\modules\news\models\News $model
 * @var \yii\data\Pagination $pages
 */

?>
<?php

/**
 * @var \common\modules\attachment\models\Attachment $model
 */

?>

<div class="modal fade" id="modal-select-attachment">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Изображения</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Закрыть</span>
                </button>
            </div>
            <div class="modal-body">
            <?= $this->render('index', ['models' => $models]) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" id="attachment-select" disabled>Выбрать</button>
            </div>
        </div>
    </div>
</div>