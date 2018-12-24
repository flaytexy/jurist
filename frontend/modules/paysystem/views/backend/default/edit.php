<?php

/**
 * @var \yii\web\View $this
 * @var \frontend\modules\paysystem\models\Paysystem $model
 * @var \frontend\modules\paysystem\models\PaysystemTranslation|array $translation_models
 */

use frontend\modules\paysystem\models\Paysystem;

use common\models\Language;
use common\modules\attachment\models\Attachment;

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use frontend\widgets\DateTimePicker;
use frontend\helpers\Image;
use frontend\widgets\TagsInput;
use frontend\widgets\SeoForm;

use dosamigos\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

if(IS_ROOT){
    e_print(IS_ROOT,'IS_ROOT');
}

?>

<div class="item-editor-page">

    <div class="title-block">
        <h3 class="title">
            <?= $model->isNewRecord ? 'Добавить' : 'Редактировать' ?> новость
            <span class="sparkline bar" data-type="bar"></span>
            <a href="<?= Url::to(['/admin/paysystem/default/edit', 'id' => 0]); ?>" class="btn btn-primary btn-sm rounded-s">
                добавить
            </a>
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
            <div class="language-row">
            <?php foreach (Language::getLanguages() as $language) { ?>
                <div class="col-sm-3 language-row<?= $model->language === $language['local'] ? ' active' : ''; ?>" data-language="<?= $language['local']; ?>">
                    <a href="">
                        <img src="/img/flags/<?= $language['local']; ?>.png" alt="" width="16" height="11">
                        <?= $language['name']; ?>
                    </a>
                </div>
            <?php } ?>
            </div>

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
                echo $form->field($translation_model, "[$language]public_status", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->label(false)
                    ->dropDownList(
                        [
                            Paysystem::STATUS_OFF => 'Черновик',
                            Paysystem::STATUS_ON => 'Опубликовано',
                        ],
                        [
                            'class' => 'c-select form-control boxed',
                        ]
                    );
            }
            ?>

            <!--            --><? //=
            //            $form->field($model, 'publish_date')
            //                ->widget(DatePicker::className(), [
            //                    'buttonOptions' => [
            //                        'label' => '<i class="fa fa-calendar-o"></i>',
            //                    ],
            //                    'language' => 'ru',
            //                    'type' => DatePicker::TYPE_INPUT,
            //                    'pickerButton' => false,
            //                    'removeButton' => false,
            //                    'pluginOptions' => [
            //                        'format' => 'dd.mm.yyyy',
            //                        'todayHighlight' => true,
            //                    ],
            //                    'options' => [
            //                        'class' => 'form-control boxed krajee-datepicker',
            //                    ],
            //                ]);
            //            ?>

            <?= Html::submitButton($model->isNewRecord ? 'Сохранить(new)' : 'Сохранить', ['class' => 'btn btn-primary btn-block']) ?>
        </div>


        <div class="card menu-manage">
            <?php if ($model->image) : ?>
                <div class="card-block">
                    <div class="car-images row">
                        <img src="<?= Image::thumb($model->image, 480, 120) ?>" style="width: 100%; height: 100%;"><br/>
                    </div>
                </div>
            <?php endif; ?>
            <div class="card-footer">
                <?= $form->field($model, 'image')->fileInput()->label(false) ?>
            </div>
            <div class="card-header">
                <div class="header-block">
                    <p class="title">Картинка главная</p><br/>
                    <span>(jpg, jpeg) (длинная) (1600x400, 1240x310, 800x200, 640x160) (90% качетсва)</span>
                </div>
            </div>
        </div>

        <div class="card menu-manage">
            <?php if ($model->pre_image) : ?>
                <div class="card-block">
                    <div class="car-images row">
                        <?= Html::img(Image::thumb($model->pre_image, 320, 180), array('class' => 'sadsa', 'style' => 'width: 100%; height: 100%;')) ?>
                        <br/>
                    </div>
                </div>
            <?php endif; ?>
            <div class="card-footer">
                <?= $form->field($model, 'pre_image')->fileInput()->label(false) ?>
            </div>
            <div class="card-header">
                <div class="header-block">
                    <p class="title">Картинка для вревью</p><br/>
                    <span>(jpg, jpeg) (1600x900, 1366x768, 800x450, 640x360) (90% качетсва)</span>
                </div>
            </div>
        </div>

        <div class="card menu-manage">
            <div class="card-block">
                <div class="car-images row">
                    <?= $form->field($model, 'rating')->input('text', ['placeholder' => "Чем больше тем выше в рейтинге"])->label("Рейтинг (попадает при > 0)"); ?>
                    <?= $form->field($model, 'rating_to_main')->input('text', ['placeholder' => "Чем больше тем выше в рейтинге"])->label("Рейтинг на главной (попадает при > 0)"); ?>
                </div>
            </div>
        </div>

        <?php if($child): ?>
        <div class="card menu-manage">
            <div class="card-block">
                <div class="car-images row">
                    <?= $form->field($child, 'location_zone_id')->dropDownList([
                        '0'  => 'Не выбрано',
                        '1' => 'Европа',
                        '2' => 'Азия',
                        '3' => 'Америка',
                        '4' => 'Африка',
                        '5' => 'Островная',
                        '8' => 'Австралия',
                    ]) ?>
                    <?= $form->field($child, 'countryNames')
                        ->widget(\akavov\countries\widgets\CountriesSelectizeTextInput::className(), [
                            'countryModelNamespace' => 'common\models\country\CountryData',
                            'customRender' => [
                                'item' => '<div> <span class="label flag flag-icon-background flag-icon-{item.alpha}">&nbsp;</span>&nbsp;<span class="name"> {escape(item.name_en)}&nbsp;&nbsp;&nbsp;{escape(item.name_ru)}</span></div>',
                                'option' => '<div> <span class="label flag flag-icon-background flag-icon-{item.alpha}">&nbsp;</span>&nbsp;<span class="name"> {escape(item.name_en)}&nbsp;&nbsp;&nbsp;{escape(item.name_ru)}</span></div>',
                            ],
                            'clientOptions' => [
                                'valueField' => 'name_en',
                                'labelField' => 'name_en',
                                'searchField' => ['name_en', 'name_ru'],
                                'plugins' => ['remove_button'],
                                'closeAfterSelect' => true,
                                'maxItems' => 10,
                                'delimiter' => ',',
                                'persist' => false,
                                'preload' => true,
                                'items' => $child->countryNames,
                                'create' => false,
                            ],
                    ]); ?>
                    <?= $form->field($child, 'location_title') ?>
                </div>
            </div>
        </div>
        <div class="card menu-manage">
            <div class="card-block">
                <div class="car-images row">
                    <?= $form->field($child, 'type_id')->dropDownList([
                        '1' => 'Корпоративный счет',
                        '2' => 'Личный счет'
                    ]) ?>
                    <?= $form->field($child, 'personal')->checkbox(['id' => 'personal', 'checked' => true])->error(false) ?>

                    <?= $form->field($child, 'price') ?>
                    <?= $form->field($child, 'how_days') ?>

                    <?= $form->field($child, 'website') ?>
                    <?= $form->field($child, 'min_deposit') ?>
                </div>
            </div>
        </div>
        <? endif; ?>


        <?php if (false) : ?>
            <div class="card card-block">
                <label for=""><?= $model->getAttributeLabel('thumbnail') ?></label>

                <div class="file-input">
                    <div id="image-manager-preview">
                        <?= $model->thumbnail ? Html::img(Attachment::getImage($model->thumbnail), ['class' => 'bbbbbbbbbb']) : ''; ?>
                    </div>
                    <a href="#" id="image-manager-set"<?= $model->thumbnail ? ' class="hidden"' : ''; ?>>Задать
                        миниатюру</a>
                    <a href="#" id="image-manager-reset"<?= !$model->thumbnail ? ' class="hidden"' : ''; ?>>Удалить
                        миниатюру</a>
                </div>

                <?= $form->field($model, 'thumbnail', ['options' => ['tag' => false]])->label(false)->error(false)->hiddenInput(['id' => 'image-manager-thumbnail']) ?>
            </div>

            <div>
                <?php
                // http://loc.ak.yabloko.studio/admin/paysystem/default/cropImage?id=dfjksjkfsfd

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
                    'aspectRatio' => 16 / 9, // or 16/9(wide) or 1/1(square) or any other ratio. Null - free ratio
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
                        'cropModal ' => Yii::t('app', 'Select crop area and click "Crop" button'),
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
        <?php endif; ?>
    </div>
    <div class="col-sm-9 pull-sm-3">
        <div class="card card-block">

            <?= $form->field($model, 'category_detail')->dropDownList($categories); ?>
            <? /*= $form->field($model, 'type_id')->dropDownList([
                '1' => 'Страница',
                '2' => 'Новости',
                '3' => 'Лицензии',
                '4' => 'Фонды',
                '5' => 'Процессинг'
            ]) */ ?>

            <?php
            foreach ($translation_models as $language => $translation_model) { //@todo lang + 1
            //foreach (Language::getLanguages() as $language) {
               //$language = $language['local'];
               //if(isset($translation_models[$language])){
               //    $translation_model = $translation_models[$language];
               //}

                echo $form->field($translation_model, "[$language]name", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->label(null, ['class' => 'form-control-label'])
                    ->textInput(['class' => 'form-control boxed', 'autofocus' => ($model->language === $language ? true : false)]);

                echo $form->field($translation_model, "[$language]short_description", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->textarea();

                echo $form->field($translation_model, "[$language]description", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->widget(CKEditor::className(), [
                    'preset' => 'full',
                    'clientOptions' => ElFinder::ckeditorOptions('elfinder',
                        [
                            'disallowedContent' => 'h1 h2 span; p li{color,background*,text-align,font-size,list-style*}',
                            //'allowedContent' => true,
                            //"extraAllowedContent" => 'span;ul;li;table;td;style;*[id];*(*);*{*}', // all-style: *{*}, all-class: *(*), all-id: *[id]
                            "extraAllowedContent" => '*(*);*[id];table{*};', // all-style: *{*}, all-class: *(*), all-id: *[id]
                            'filebrowserImageUploadUrl' => Url::to(['/admin/redactor/uploader', 'dir' => 'offers']),
                            'extraPlugins' => 'justify,link,font,div,table,tableresize,tabletools,uicolor,colorbutton,colordialog,liststyle,inserthtmlfile,googleDocPastePlugin',
                            'contentsCss' => ['/css/style_all.min.css?v=2018-02-07-v03'],
                            'toolbar' => [
                                ['name' => 'document', 'groups' => ['mode', 'document', 'doctools'], 'items' => ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']],
                                ['name' => 'clipboard', 'groups' => ['clipboard', 'undo'], 'items' => ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo','inserthtmlfile']],
                                ['name' => 'editing', 'groups' => ['find', 'selection', 'spellchecker'], 'items' => ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']],
                                ['name' => 'forms', 'items' => ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField']],
                                '/',
                                ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup'], 'items' => ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat']],
                                ['name' => 'paragraph', 'groups' => ['list', 'indent', 'blocks', 'align', 'bidi'], 'items' => ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']],
                                ['name' => 'links', 'items' => ['Link', 'Unlink', 'Anchor']],
                                ['name' => 'insert', 'items' => ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']],
                                '/',
                                ['name' => 'styles', 'items' => ['Styles', 'Format', 'Font', 'FontSize']],
                                ['name' => 'colors', 'items' => ['TextColor', 'BGColor']],
                                ['name' => 'tools', 'items' => ['Maximize', 'ShowBlocks']],
                                ['name' => 'others', 'items' => ['-']],
                                ['name' => 'about', 'items' => ['About']]
                            ]
                        ]
                    ),
                ]);

                /*
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
                */

//               echo $form->field($translation_model, "[$language]meta_h1", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
//                   ->label(null, ['class' => 'form-control-label'])
//                   ->textInput(['class' => 'form-control boxed']);

                echo $form->field($translation_model, "[$language]meta_title", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->label(null, ['class' => 'form-control-label'])
                    ->textInput(['class' => 'form-control boxed']);

                echo $form->field($translation_model, "[$language]meta_keywords", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->label(null, ['class' => 'form-control-label'])
                    ->textInput(['class' => 'form-control boxed']);

                echo $form->field($translation_model, "[$language]meta_description", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->label(null, ['class' => 'form-control-label'])
                    ->textInput(['class' => 'form-control boxed']);

                if (IS_ROOT) {
                    echo $form->field($translation_model, "[$language]slug", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                        ->label(null, ['class' => 'form-control-label'])
                        ->textInput(['class' => 'form-control boxed']);
                }else{
                    echo $form->field($translation_model, "[$language]slug", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                        ->label(null, ['class' => 'form-control-label'])
                        ->textInput(['class' => 'form-control boxed', 'readonly'=>'readonly']);
                }
            }

            echo $form->field($model, 'to_main')->checkbox(['id' => 'to_main', 'checked' => true])->label(false)->error(false);
            echo $form->field($model, 'time')->widget(DateTimePicker::className());
            echo $form->field($model, 'tagNames')->widget(TagsInput::className()) ;

            if (IS_ROOT) {
                echo $form->field($model, 'slug')->textInput(['class' => 'form-control boxed']);
                echo \frontend\widgets\SeoForm::widget(['model' => $model]);
            }else{
                if(!empty($model->slug)){
                    if($model->isNewRecord || $model->hasErrors()){
                        echo $form->field($model, 'slug')->textInput(['class' => 'form-control boxed']);
                    }else{
                        echo $form->field($model, 'slug')->textInput(['class' => 'form-control boxed', 'readonly'=>'readonly']);
                    }
                }
            }
            ?>
        </div>

        <? if (false): ?>
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
        <? endif; ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
