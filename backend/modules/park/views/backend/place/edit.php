<?php

/**
 * @var \yii\web\View $this
 * @var \backend\modules\park\models\Place $model
 * @var \backend\modules\park\models\PlaceTranslation|array $translation_models
 */

use backend\models\Language;
use backend\modules\page\models\Page;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\park\models\PlaceTranslation;

?>

<div class="item-editor-page">

    <div class="title-block">
        <h3 class="title"> <?= $model->isNewRecord ? 'Добавить' : 'Редактировать' ?> местоположение <span class="sparkline bar" data-type="bar"></span></h3>
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
                                PlaceTranslation::STATUS_DRAFT => 'Черновик',
                                PlaceTranslation::STATUS_PUBLISHED => 'Опубликовано',
                            ],
                            [
                                'class' => 'c-select form-control boxed',
                            ]
                        );
                }

                $cities = [];
                /**
                 * @var \backend\modules\park\models\City $city
                 */
                foreach (\backend\modules\park\models\City::find()->with('translations')->all() as $city) {
                    $cities[$city['id']] = $city->getTitle();
                }

                echo $form->field($model, 'city_id')->dropDownList(
                    $cities,
                    [
                        'class' => 'c-select form-control boxed',
                        'prompt' => '- Выбрать -'
                    ]
                );
            ?>

            <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => 'btn btn-primary btn-block']) ?>
        </div>

    </div>

    <div class="col-sm-9 pull-sm-3">
        <div class="card card-block">
            <?php
            foreach ($translation_models as $language => $translation_model) {

                echo $form->field($translation_model, "[$language]title", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->label(null, ['class' => 'form-control-label'])
                    ->textInput(['class' => 'form-control boxed', 'autofocus' => ($model->language === $language ? true : false)]);
            }
            ?>
        </div>


        <div class="card menu-manage menu-manage-small">
            <div class="card-header">
                <div class="header-block">
                    <p class="title">Время работы</p>
                </div>
            </div>

            <div class="card-block">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="header-block">
                                    <p class="title">Начало</p>
                                </div>
                            </div>
                            <div class="card-block">
                                <?php for ($i = 1; $i <=7; $i++) { ?>
                                    <?=
                                    $form->field($model, 'time_in_' . $i)
                                        ->textInput(['class' => 'form-control boxed']);
                                    ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="header-block">
                                    <p class="title">Конец</p>
                                </div>
                            </div>
                            <div class="card-block">
                                <?php for ($i = 1; $i <=7; $i++) { ?>
                                    <?=
                                    $form->field($model, 'time_out_' . $i)
                                        ->textInput(['class' => 'form-control boxed']);
                                    ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card menu-manage menu-manage-small">
            <div class="card-header">
                <div class="header-block">
                    <p class="title">Цены</p>
                </div>
            </div>
            <div class="card-block">

                <div class="card">
                    <div class="card-header">
                        <div class="header-block">
                            <p class="title">Аэропортовый сбор</p>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <?=
                            $form->field($model, 'price_airport_work_time', ['options' => ['class' => 'form-group col-sm-6']])
                                ->textInput(['class' => 'form-control boxed']);
                            ?>
                            <?=
                            $form->field($model, 'price_airport_not_work_time', ['options' => ['class' => 'form-group col-sm-6']])
                                ->textInput(['class' => 'form-control boxed']);
                            ?>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="header-block">
                            <p class="title">Выдача</p>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="header-block">
                                            <p class="title">рабочее время</p>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <?=
                                        $form->field($model, 'price_out_office_work_time')
                                            ->textInput(['class' => 'form-control boxed']);
                                        ?>
                                        <?=
                                        $form->field($model, 'price_out_city_work_time')
                                            ->textInput(['class' => 'form-control boxed']);
                                        ?>
                                        <?=
                                        $form->field($model, 'price_out_airport_work_time')
                                            ->textInput(['class' => 'form-control boxed']);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="header-block">
                                            <p class="title">не рабочее время</p>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <?=
                                        $form->field($model, 'price_out_office_not_work_time')
                                            ->textInput(['class' => 'form-control boxed']);
                                        ?>
                                        <?=
                                        $form->field($model, 'price_out_city_not_work_time')
                                            ->textInput(['class' => 'form-control boxed']);
                                        ?>
                                        <?=
                                        $form->field($model, 'price_out_airport_not_work_time')
                                            ->textInput(['class' => 'form-control boxed']);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="header-block">
                            <p class="title">Прием</p>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="header-block">
                                            <p class="title">рабочее время</p>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <?=
                                        $form->field($model, 'price_in_office_work_time')
                                            ->textInput(['class' => 'form-control boxed']);
                                        ?>
                                        <?=
                                        $form->field($model, 'price_in_city_work_time')
                                            ->textInput(['class' => 'form-control boxed']);
                                        ?>
                                        <?=
                                        $form->field($model, 'price_in_airport_work_time')
                                            ->textInput(['class' => 'form-control boxed']);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="header-block">
                                            <p class="title">не рабочее время</p>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <?=
                                        $form->field($model, 'price_in_office_not_work_time')
                                            ->textInput(['class' => 'form-control boxed']);
                                        ?>
                                        <?=
                                        $form->field($model, 'price_in_city_not_work_time')
                                            ->textInput(['class' => 'form-control boxed']);
                                        ?>
                                        <?=
                                        $form->field($model, 'price_in_airport_not_work_time')
                                            ->textInput(['class' => 'form-control boxed']);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>