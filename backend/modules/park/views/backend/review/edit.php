<?php

/**
 * @var \yii\web\View $this
 * @var \app\modules\page\models\Review $model
 * @var \app\modules\page\models\ReviewTranslation|array $translation_models
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\page\models\Review;
use vova07\imperavi\Widget as Redactor;
use app\models\Language;
use app\modules\attachment\models\Attachment;
use kartik\date\DatePicker;

?>

<div class="item-editor-page">

    <div class="title-block">
        <h3 class="title"> Редактировать отзыв <span class="sparkline bar" data-type="bar"></span></h3>
    </div>

    <?php
        $form = ActiveForm::begin([
            'enableClientValidation' => false,
            'options' => [
                'class' => 'row',
            ],
        ]);
    ?>

    <div class="col-sm-3 push-sm-9">

        <div class="card card-block">

            <?php
                echo $form->field($model, "status", ['options' => ['class' => 'form-group']])
                    ->label(false)
                    ->dropDownList(
                        [
                            Review::STATUS_DRAFT => 'Черновик',
                            Review::STATUS_PUBLISHED => 'Опубликовано',
                        ],
                        [
                            'class' => 'c-select form-control boxed',
                        ]
                    );
            ?>

            <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => 'btn btn-primary btn-block']) ?>
        </div>

    </div>
    <div class="col-sm-9 pull-sm-3">
        <div class="card card-block">
            <?php

                echo $form->field($model, "name", ['options' => ['class' => 'form-group ']])
                    ->label(null, ['class' => 'form-control-label'])
                    ->textInput(['class' => 'form-control boxed', 'autofocus' => true]);

                echo $form->field($model, "comment", ['options' => ['class' => 'form-group ']])
                    ->label(null, ['class' => 'form-control-label'])
                    ->textarea(['class' => 'form-control boxed', 'style' => 'min-height: 200px']);

            ?>

        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>