<?php

/**
 * @var \yii\web\View $this
 * @var \backend\modules\page\models\Page $model
 * @var \backend\modules\page\models\PageTranslation|array $translation_models
 */

use backend\models\Language;
use backend\modules\attachment\models\Attachment;
use backend\modules\page\models\Page;
use kartik\date\DatePicker;
use vova07\imperavi\Widget as Redactor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<div class="item-editor-page">

    <div class="title-block">
        <h3 class="title"> <?= $model->isNewRecord ? 'Добавить' : 'Редактировать' ?> новость <span class="sparkline bar"
                                                                                                   data-type="bar"></span>
        </h3>
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
                <div class="language-row<?= $model->language === $language['local'] ? ' active' : ''; ?>"
                     data-language="<?= $language['local']; ?>">
                    <a href="">
                        <img src="/img/flags/<?= $language['local']; ?>.png" alt="" width="16" height="11">
                        <?= $language['title']; ?>
                    </a>
                </div>
            <?php } ?>

            <?= $form->field($model, 'language')->label(false)->hiddenInput() ?>

            <?php ob_start(); ?>
            <script>
                $(document).on('click', '.language-row a', function (e) {
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

            <?=
            $form->field($model, 'publish_date')
                ->widget(DatePicker::className(), [
                    'buttonOptions' => [
                        'label' => '<i class="fa fa-calendar-o"></i>',
                    ],
                    'language' => 'ru',
                    'type' => DatePicker::TYPE_INPUT,
                    'pickerButton' => false,
                    'removeButton' => false,
                    'pluginOptions' => [
                        'format' => 'dd.mm.yyyy',
                        'todayHighlight' => true,
                    ],
                    'options' => [
                        'class' => 'form-control boxed krajee-datepicker',
                    ],
                ]);
            ?>

            <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => 'btn btn-primary btn-block']) ?>
        </div>

        <div class="card card-block">

            <label for=""><?= $model->getAttributeLabel('thumbnail') ?></label>

            <div class="file-input">
                <div id="image-manager-preview">
                    <?= $model->thumbnail ? Html::img(Attachment::getImage($model->thumbnail), ['class'=>'bbbbbbbbbb']) : ''; ?>
                </div>

                <a href="#" id="image-manager-set"<?= $model->thumbnail ? ' class="hidden"' : ''; ?>>Задать
                    миниатюру</a>
                <a href="#" id="image-manager-reset"<?= !$model->thumbnail ? ' class="hidden"' : ''; ?>>Удалить
                    миниатюру</a>
            </div>

            <div class="hidden">
                <?php
                echo Redactor::widget([
                    'name' => 'image-manager',
                    'id' => 'image-manager',
                    'settings' => [
                        'imageUpload' => Url::to(['/admin/default/image-upload']),
                        'imageManagerJson' => Url::to(['/admin/default/images-get']),
                        'plugins' => [
                            'imagemanager',
                            'fontsize',
                        ],
                        'imageUploadCallback' => new \yii\web\JsExpression('imageManagerUpload'),
                    ]
                ]);
                ?>
            </div>

            <?= $form->field($model, 'thumbnail', ['options' => ['tag' => false]])->label(false)->error(false)->hiddenInput(['id' => 'image-manager-thumbnail']) ?>

        </div>
        <div>

            <?php
            // http://loc.ak.yabloko.studio/admin/news/default/cropImage?id=dfjksjkfsfd

            echo \demi\cropper\Cropper::widget([
                // If true - it's output button for toggle modal crop window
                'modal' => true,
                // You can customize modal window. Copy /vendor/demi/cropper/views/modal.php
                'modalView' => '@vendor/demi/cropper/views/modal.php',
                // URL-address for the crop-handling request
                // By default, sent the following post-params: x, y, width, height, rotate
                'cropUrl' => ['cropImage', 'id' => $model->id],
                // Url-path to original image for cropping
                'image' => Yii::$app->request->baseUrl . '' . Attachment::getImage($model->thumbnail),
                // The aspect ratio for the area of cropping
                'aspectRatio' => 4 / 3, // or 16/9(wide) or 1/1(square) or any other ratio. Null - free ratio
                // Additional params for JS cropper plugin
                'pluginOptions' => [
                    // All possible options: https://github.com/fengyuanchen/cropper/blob/master/README.md#options
                    'minCropBoxWidth' => 400, // minimal crop area width
                    'minCropBoxHeight' => 300, // minimal crop area height
                ],
                // HTML-options for widget container
                'options' => [],
                // HTML-options for cropper image tag
                'imageOptions' => [],
                // Translated messages
                'messages' => [
                    'cropBtn' => Yii::t('app', 'Crop'),
                    'cropModalTitle' => Yii::t('app', 'Select crop area and click "Crop" button'),
                    'closeModalBtn' => Yii::t('app', 'Close'),
                    'cropModalBtn' => Yii::t('app', 'Crop selected'),
                ],
                // Additional ajax-options for send crop-request. See jQuery $.ajax() options
                'ajaxOptions' => [
                    'success' => new \yii\web\JsExpression(
                        <<<JS
                            function(data) {
                                // data - your JSON response from [[cropUrl]]
                                $("#myImage").attr("src", data.croppedImageSrc);
                            }
JS
                    ),
                ],
            ]);
            ?>
        </div>

    </div>
    <div class="col-sm-9 pull-sm-3">
        <div class="card card-block">
            <?php
            foreach ($translation_models as $language => $translation_model) {

                echo $form->field($translation_model, "[$language]title", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->label(null, ['class' => 'form-control-label'])
                    ->textInput(['class' => 'form-control boxed', 'autofocus' => ($model->language === $language ? true : false)]);

                echo $form->field($translation_model, "[$language]short_description", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->widget(Redactor::className(), [
                        'settings' => [
                            'lang' => 'ru',
                            'minHeight' => 100,
                            'imageUpload' => Url::to(['/admin/default/image-upload']),
                            'imageManagerJson' => Url::to(['/admin/default/images-get']),
                            'plugins' => [
                                'fullscreen',
                                'imagemanager',
                                'fontsize',
                            ],
                        ]
                    ]);

                echo $form->field($translation_model, "[$language]description", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->widget(Redactor::className(), [
                        'settings' => [
                            'lang' => 'ru',
                            'minHeight' => 200,
                            'imageUpload' => Url::to(['/admin/default/image-upload']),
                            'imageManagerJson' => Url::to(['/admin/default/images-get']),
                            'plugins' => [
                                'fullscreen',
                                'imagemanager',
                                'fontsize',
                            ],
                        ]
                    ]);

//                echo $form->field($translation_model, "[$language]slug", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
//                    ->label(null, ['class' => 'form-control-label'])
//                    ->textInput(['class' => 'form-control boxed']);
            }
            ?>

        </div>

        <div class="card menu-manage">
            <div class="card-header">
                <div class="header-block">
                    <p class="title">Галерея</p>
                </div>
            </div>
            <div class="card-block">
                <div class="car-images row">
                    <?php foreach ($model->images as $image) { ?>
                        <div class="car-image col-md-3">
                            <img src="<?= Attachment::getImage($image->attachment_id, [300, 200]); ?>" alt="">
                            <div class="car-image-controls">
                                <i class="fa fa-arrows"></i>
                                <i class="fa fa-remove"></i>
                            </div>
                            <input type="hidden" name="Images[]" value="<?= $image->attachment_id; ?>">
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="card-footer">
                <a href="#" id="image-manager-gallery-set">Добавить</a>
            </div>
        </div>

    </div>

    <?php ActiveForm::end(); ?>
</div>