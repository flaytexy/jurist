<?php

/**
 * @var \yii\web\View $this
 * @var \backend\modules\page\models\Page $model
 * @var \backend\modules\page\models\PageTranslation|array $translation_models
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\page\models\Page;
use vova07\imperavi\Widget as Redactor;
use backend\models\Image;
use backend\models\Language;
use backend\modules\attachment\models\Attachment;

?>

<div class="item-editor-page">

    <div class="title-block">
        <h3 class="title"> <?= $model->isNewRecord ? 'Добавить' : 'Редактировать' ?> страницу услуг <span class="sparkline bar" data-type="bar"></span></h3>
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
                foreach ($translation_models as $language => $translation_model) {
                    echo $form->field($translation_model, "[$language]status", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
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
                }
            ?>

            <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => 'btn btn-primary btn-block']) ?>
        </div>

        <div class="card card-block">

            <label for=""><?= $model->getAttributeLabel('thumbnail') ?></label>

            <div class="file-input">
                <div id="image-manager-preview"><?= $model->thumbnail ? Html::img(Attachment::getImage($model->thumbnail)) : ''; ?></div>

                <a href="#" id="image-manager-set"<?= $model->thumbnail ? ' class="hidden"' : ''; ?>>Задать изображение</a>
                <a href="#" id="image-manager-reset"<?= !$model->thumbnail ? ' class="hidden"' : ''; ?>>Удалить изображение</a>
            </div>

            <?= $form->field($model, 'thumbnail', ['options' => ['tag' => false]])->label(false)->error(false)->hiddenInput(['id' => 'image-manager-thumbnail']) ?>

        </div>

    </div>
    <div class="col-sm-9 pull-sm-3">
        <div class="card card-block">
            <?php
            foreach ($translation_models as $language => $translation_model) {

                echo $form->field($translation_model, "[$language]title", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->label(null, ['class' => 'form-control-label'])
                    ->textInput(['class' => 'form-control boxed', 'autofocus' => ($model->language === $language ? true : false)]);

                echo $form->field($translation_model, "[$language]link", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->label(null, ['class' => 'form-control-label'])
                    ->textInput(['class' => 'form-control boxed']);
            }
            ?>

        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>