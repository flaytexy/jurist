<?php

/**
 * @var \yii\web\View $this
 * @var \app\modules\page\models\Page $model
 * @var \app\modules\page\models\PageTranslation|array $translation_models
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\page\models\Page;
use vova07\imperavi\Widget as Redactor;
use app\models\Image;
use app\models\Language;
use app\modules\attachment\models\Attachment;

?>

<div class="item-editor-page">

    <div class="title-block">
        <h3 class="title"> <?= $model->isNewRecord ? 'Добавить' : 'Редактировать' ?> валюту <span class="sparkline bar" data-type="bar"></span></h3>
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

            <?php foreach (Language::getLanguages() as $language) { ?>
                <div class="language-row<?= $model->language === $language['local'] ? ' active' : ''; ?>" data-language="<?= $language['local']; ?>">
                    <a href="">
                        <img src="/img/flags/<?= $language['local']; ?>.png" alt="" width="16" height="11">
                        <?= $language['title']; ?>
                    </a>
                </div>
            <?php } ?>

            <?= $form->field($model, 'language')->label(false)->hiddenInput() ?>

            <?php ob_start(); ?>
            <script>
                $(document).on('click', '.language-row a', function(e) {
                    e.preventDefault();

                    $('.language-row').removeClass('active');
                    $(this).parent('.language-row').addClass('active');
                    $('#<?= Html::getInputId($model, 'language'); ?>').val($(this).parent('.language-row').data('language'));

                    $('[class*="language_"]').addClass('hidden');
                    $('.language_' + $(this).parent('.language-row').data('language')).removeClass('hidden');
                });
            </script>
            <?php $script = str_replace(['<script>', '</script>'], '', ob_get_contents()); ?>
            <?php ob_end_clean(); ?>

            <?php $this->registerJs($script); ?>

            <?php
                echo $form->field($model, "status")
                    ->label(false)
                    ->dropDownList(
                        [
                            Page::STATUS_DRAFT => 'Черновик',
                            Page::STATUS_PUBLISHED => 'Опубликовано',
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
            <div class="row">
            <?php
            echo $form->field($model, "iso", ['options' => ['class' => 'col-sm-12 form-group']])
                ->label(null, ['class' => 'form-control-label'])
                ->textInput(['class' => 'form-control boxed']);
            ?>
            <?php
            foreach ($translation_models as $language => $translation_model) {

                echo $form->field($translation_model, "[$language]title", ['options' => ['class' => 'col-sm-12 form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->label(null, ['class' => 'form-control-label'])
                    ->textInput(['class' => 'form-control boxed', 'autofocus' => ($model->language === $language ? true : false)]);

                echo $form->field($translation_model, "[$language]before", ['options' => ['class' => 'col-sm-4 form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->label(null, ['class' => 'form-control-label'])
                    ->textInput(['class' => 'form-control boxed']);

                echo $form->field($translation_model, "[$language]after", ['options' => ['class' => 'col-sm-4 form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->label(null, ['class' => 'form-control-label'])
                    ->textInput(['class' => 'form-control boxed']);

                echo $form->field($translation_model, "[$language]decimals", ['options' => ['class' => 'col-sm-4 form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->label(null, ['class' => 'form-control-label'])
                    ->textInput(['class' => 'form-control boxed']);

                echo $form->field($translation_model, "[$language]dec_point", ['options' => ['class' => 'col-sm-4 form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->label(null, ['class' => 'form-control-label'])
                    ->textInput(['class' => 'form-control boxed']);

                echo $form->field($translation_model, "[$language]thousands_sep", ['options' => ['class' => 'col-sm-4 form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->label(null, ['class' => 'form-control-label'])
                    ->textInput(['class' => 'form-control boxed']);

            }
            ?>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>