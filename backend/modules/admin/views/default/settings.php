<?php

/**
 * @var \backend\models\Settings|array $models
 * @var \backend\models\Settings $model
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use vova07\imperavi\Widget as Redactor;
use backend\models\Language;
use kartik\datetime\DateTimePicker;

$this->title = 'Основные настройки - Datarius Cryptobank';

?>


<div class="item-editor-page">

    <div class="title-block">
        <h3 class="title">Основные настройки <span class="sparkline bar" data-type="bar"></span></h3>
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

        <div class="card menu-manage">
            <div class="card-header">
                <div class="header-block">
                    <p class="title">Языки</p>
                </div>
            </div>
            <div class="card-block">
                <?php foreach (Language::getLanguages() as $language) { ?>
                    <div class="language-row<?= $language['id'] === 'ru' ? ' active' : ''; ?>" data-language="<?= $language['id']; ?>">
                        <a href="javascript:void(0);">
                            <img src="/img/flags/<?= $language['local']; ?>.png" alt="" width="16" height="11">
                            <?= $language['title']; ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="card menu-manage">
            <div class="card-header">
                <div class="header-block">
                    <p class="title">Управление</p>
                </div>
            </div>
            <div class="card-block">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-block']) ?>
            </div>
        </div>

    </div>
    <div class="col-sm-9 pull-sm-3">
        <?php foreach (Language::getLanguages() as $language) { ?>
            <div class="card menu-manage language_<?= $language['id']; ?> <?= $language['id'] !== 'ru' ? 'hidden' : ''; ?>">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title">Данные (<?= $language['name']; ?>)</p>
                    </div>
                </div>
                <div class="card-block">
                    <?php foreach ($models as $key => $model) { ?>

                        <?php
                        $form_element = $form
                            ->field($model, "[$key]value" . ($language['id'] !== 'ru' ? '_' . $language['id'] : ''));
                        ?>

                        <?php

                        switch ($key) {
                            case 'next_phase':
                                echo $form_element->widget(DateTimePicker::className(), [
                                    'language' => 'ru',
                                    'type' => DateTimePicker::TYPE_INPUT,
                                    'pickerButton' => false,
                                    'removeButton' => false,
                                    'options' => [
                                        'class' => 'form-control boxed'
                                    ],
                                    'pluginOptions' => [
                                        'startDate' => '',
                                        'autoclose' => true,
                                        'minuteStep' => 15,
                                        'format' => 'dd.mm.yyyy hh:ii',
                                        'todayHighlight' => true
                                    ]
                                ]);
                                break;
                            case 'description':
                            case 'politics':
                            case 'mailing':
                            case 'road_1':
                            case 'road_5':
                            case 'road_10':
                            case 'road_20':
                            case 'road_50':
                                echo $form_element->widget(Redactor::className(), [
                                    'settings' => [
                                        'lang' => 'ru',
                                        'minHeight' => 200,
                                        'imageUpload' => Url::to(['admin/image-upload']),
                                        'plugins' => [
                                            'fullscreen',
                                        ]
                                    ]
                                ]);
                                break;
                            case 'road_desc_1':
                            case 'road_desc_5':
                            case 'road_desc_10':
                            case 'road_desc_20':
                            case 'road_desc_50':
                                echo $form_element->textarea(['class' => 'form-control boxed', 'style' => 'min-height: 200px']);
                                break;
                            default:
                                echo $form_element->textInput(['class' => 'form-control boxed']);
                                break;
                        }

                        ?>

                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>


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
    
</div>
