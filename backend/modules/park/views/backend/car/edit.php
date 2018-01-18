<?php

/**
 * @var \yii\web\View $this
 * @var \backend\modules\park\models\Car $model
 * @var \backend\modules\park\models\CarTranslation|array $translation_models
 * @var Attribute $attribute
 * @var \backend\modules\park\models\CarPrices|array  $prices
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\page\models\Page;
use backend\models\Language;
use backend\modules\park\models\Attribute;
use yii\helpers\ArrayHelper;
use backend\modules\attachment\models\Attachment;
use backend\modules\park\models\Car;

?>

<div class="item-editor-page">

    <div class="title-block">
        <h3 class="title"> <?= $model->isNewRecord ? 'Добавить' : 'Редактировать' ?> автомобиль <span class="sparkline bar" data-type="bar"></span></h3>
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

            <?=
            $form->field($model, 'show_in_homepage', ['options' => ['template' => '{input}']])
                ->checkbox([
                    'class' => 'radio squared',
                    'label' => '<span>' . $model->getAttributeLabel('show_in_homepage') . '</span>'
                ]);
            ?>

            <?=
            $form->field($model, 'sticker_id', ['options' => ['class' => 'form-group']])->dropDownList(
                \backend\modules\park\models\Sticker::getDropdownList(),
                [
                    'class' => 'form-control boxed',
                    'prompt' => '- Выбрать -',
                ]
            );
            ?>

            <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => 'btn btn-primary btn-block']) ?>
        </div>

        <div class="card menu-manage">
            <div class="card-header">
                <div class="header-block">
                    <p class="title"><?= $model->getAttributeLabel('thumbnail') ?></p>
                </div>
            </div>
            <div class="card-block">

                <div class="file-input">
                    <div id="image-manager-preview"><?= $model->thumbnail ? Html::img(\backend\modules\attachment\models\Attachment::getImage($model->thumbnail)) : ''; ?></div>

                    <a href="#" id="image-manager-set"<?= $model->thumbnail ? ' class="hidden"' : ''; ?>>Задать миниатюру</a>
                    <a href="#" id="image-manager-reset"<?= !$model->thumbnail ? ' class="hidden"' : ''; ?>>Удалить миниатюру</a>
                </div>

                <?= $form->field($model, 'thumbnail', ['options' => ['tag' => false]])->label(false)->error(false)->hiddenInput(['id' => 'image-manager-thumbnail']) ?>
            </div>
        </div>

        <div class="card menu-manage">
            <div class="card-header">
                <div class="header-block">
                    <p class="title">Галерея</p>
                </div>
            </div>
            <div class="card-block">

                <div class="car-images">
                    <?php foreach ($model->images as $image) { ?>
                        <div class="car-image">
                            <img src="<?= Attachment::getImage($image->attachment_id); ?>" alt="">
                            <div class="car-image-controls">
                                <i class="fa fa-arrows"></i>
                                <i class="fa fa-remove"></i>
                            </div>
                            <input type="hidden" name="CarImage[]" value="<?= $image->attachment_id; ?>">
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="card-footer">
                <a href="#" id="image-manager-gallery-set">Добавить</a>
            </div>
        </div>

    </div>
    <div class="col-sm-9 pull-sm-3">
        <div class="card card-block">
            <?php
            foreach ($translation_models as $language => $translation_model) {

                echo $form->field($translation_model, "[$language]title", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->label(null, ['class' => 'form-control-label'])
                    ->textInput(['class' => 'form-control boxed', 'autofocus' => ($model->language === $language ? true : false)]);

                echo $form->field($translation_model, "[$language]slug", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->label(null, ['class' => 'form-control-label'])
                    ->textInput(['class' => 'form-control boxed']);

                echo $form->field($translation_model, "[$language]equipment", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->label(null, ['class' => 'form-control-label'])
                    ->textInput(['class' => 'form-control boxed']);

                echo $form->field($translation_model, "[$language]youtube_id", ['options' => ['class' => 'form-group language_' . $language . ($model->language !== $language ? ' hidden' : '')]])
                    ->label(null, ['class' => 'form-control-label'])
                    ->textInput(['class' => 'form-control boxed']);
            }
            ?>

        </div>
        <div class="card menu-manage">
            <div class="card-header">
                <div class="header-block">
                    <p class="title">Основное</p>
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    <?=
                        $form->field($model, 'brand_id', ['options' => ['class' => 'form-group col-sm-4']])->dropDownList(
                            \backend\modules\park\models\Brand::getDropdownList(),
                            [
                                'class' => 'form-control boxed',
                                'prompt' => '- Выбрать -',
                            ]
                        );
                    ?>
                    <?=
                        $form->field($model, 'model_id', ['options' => ['class' => 'form-group col-sm-4']])->dropDownList(
                            $model->brand_id ? \backend\modules\park\models\Model::getDropdownList($model->brand_id) : [],
                            [
                                'class' => 'form-control boxed',
                                'prompt' => '- Выбрать -',
                            ]
                        );
                    ?>
                    <?php ob_start(); ?>
                    <script>
                        $(document).on('change', '#<?= Html::getInputId($model, 'brand_id'); ?>', function() {
                            $.post(
                                '<?= \yii\helpers\Url::to(['/admin/park/model/get-dropdown-list']) ?>',
                                {
                                    brand_id: $(this).val()
                                },
                                function (data) {
                                    if (data) {
                                        $('#<?= Html::getInputId($model, 'model_id'); ?>').replaceWith(data);
                                    }
                                }
                            );
                        });
                    </script>
                    <?php $script = str_replace(['<script>', '</script>'], '', ob_get_contents()); ?>
                    <?php ob_end_clean(); ?>

                    <?php $this->registerJs($script); ?>

                    <?=
                    $form->field($model, 'category_id', ['options' => ['class' => 'form-group col-sm-4']])->dropDownList(
                        \backend\modules\park\models\Category::getDropdownList(),
                        [
                            'class' => 'form-control boxed',
                            'prompt' => '- Выбрать -',
                        ]
                    );
                    ?>

                    <?=
                    $form->field($model, 'acriss', ['options' => ['class' => 'form-group col-sm-4']])
                        ->textInput(['class' => 'form-control boxed']);
                    ?>
                </div>
            </div>
        </div>
        <div class="card menu-manage">
            <div class="card-header">
                <div class="header-block">
                    <p class="title">Характеристики</p>
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    <?=
                    $form->field($model, 'attr_seat', ['options' => ['class' => 'col-sm-6 col-md-4']])
                        ->textInput(['class' => 'form-control boxed']);
                    ?>
                    <?=
                    $form->field($model, 'attr_rear_drive', ['options' => ['class' => 'col-sm-6 col-md-4']])
                        ->dropDownList(
                            [
                                'Передний' => 'Передний',
                                'Задний' => 'Задний',
                                'Полный' => 'Полный',
                            ],
                            [
                                'class' => 'form-control boxed',
                                'prompt' => '- Выбрать -',
                            ]
                        );
                    ?>
                    <?=
                    $form->field($model, 'attr_conditioner', ['options' => ['class' => 'col-sm-6 col-md-4']])
                        ->dropDownList(
                            [
                                'Да' => 'Да',
                                'Нет' => 'Нет',
                            ],
                            [
                                'class' => 'form-control boxed',
                                'prompt' => '- Выбрать -',
                            ]
                        );
                    ?>
                    <?=
                    $form->field($model, 'attr_capacity', ['options' => ['class' => 'col-sm-6 col-md-4']])
                        ->textInput(['class' => 'form-control boxed']);
                    ?>
                    <?=
                    $form->field($model, 'attr_fuel', ['options' => ['class' => 'col-sm-6 col-md-4']])
                        ->textInput(['class' => 'form-control boxed']);
                    ?>
                    <?=
                    $form->field($model, 'attr_transmission', ['options' => ['class' => 'col-sm-6 col-md-4']])
                        ->dropDownList(
                            [
                                'Автоматическая' => 'Автоматическая',
                                'Механическая' => 'Механическая',
                            ],
                            [
                                'class' => 'form-control boxed',
                                'prompt' => '- Выбрать -',
                            ]
                        );
                    ?>

                    <?=
                    $form->field($model, 'attr_engine', ['options' => ['class' => 'col-sm-6 col-md-4']])
                        ->dropDownList(
                            [
                                'Бензин' => 'Бензин',
                                'Дизель' => 'Дизель',
                                'Электро' => 'Электро',
                            ],
                            [
                                'class' => 'form-control boxed',
                                'prompt' => '- Выбрать -',
                            ]
                        );
                    ?>
                    <?=
                    $form->field($model, 'attr_body', ['options' => ['class' => 'col-sm-6 col-md-4']])
                        ->dropDownList(
                            [
                                'Хетчбек' => 'Хетчбек',
                                'Седан' => 'Седан',
                                'Универсал' => 'Универсал',
                                'Кабриолет' => 'Кабриолет',
                                'Внедорожник' => 'Внедорожник',
                                'Пикап' => 'Пикап',
                                'Минивен' => 'Минивен',
                            ],
                            [
                                'class' => 'form-control boxed',
                                'prompt' => '- Выбрать -',
                            ]
                        );
                    ?>

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
                <div class="row">
                <?=
                $form->field($model, 'deposit', ['options' => ['class' => 'form-group col-sm-4']])
                    ->textInput(['class' => 'form-control boxed']);
                ?>
                <?=
                $form->field($model, 'discount_type', ['options' => ['class' => 'form-group col-sm-4']])
                    ->dropDownList(
                        [
                            Car::DISCOUNT_TYPE_FIXED => 'Фиксированая',
                            Car::DISCOUNT_TYPE_PERCENT => 'Процент',
                        ],
                        [
                            'class' => 'c-select form-control boxed',
                            'prompt' => '- Выбрать -'
                        ]
                    );
                ?>
                <?=
                $form->field($model, 'discount', ['options' => ['class' => 'form-group col-sm-4']])
                    ->textInput(['class' => 'form-control boxed']);
                ?>
                </div>
            </div>
            <div class="card-block">
                <div class="card">
                    <div class="card-header">
                        <div class="header-block">
                            <p class="title">Суперстраховка 50</p>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <?=
                                $form->field($prices['insurance_50'], '[insurance_50]price_1', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                            ?>
                            <?=
                                $form->field($prices['insurance_50'], '[insurance_50]price_3', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                            ?>
                            <?=
                                $form->field($prices['insurance_50'], '[insurance_50]price_6', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                            ?>
                        </div>
                        <div class="row">
                            <?=
                                $form->field($prices['insurance_50'], '[insurance_50]price_8', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                            ?>
                            <?=
                                $form->field($prices['insurance_50'], '[insurance_50]price_15', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                            ?>
                            <?=
                                $form->field($prices['insurance_50'], '[insurance_50]price_29', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <div class="card">
                    <div class="card-header">
                        <div class="header-block">
                            <p class="title">Суперстраховка 100</p>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <?=
                                $form->field($prices['insurance_100'], '[insurance_100]price_1', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                            ?>
                            <?=
                                $form->field($prices['insurance_100'], '[insurance_100]price_3', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                            ?>
                            <?=
                                $form->field($prices['insurance_100'], '[insurance_100]price_6', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                            ?>
                        </div>
                        <div class="row">
                            <?=
                                $form->field($prices['insurance_100'], '[insurance_100]price_8', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                            ?>
                            <?=
                                $form->field($prices['insurance_100'], '[insurance_100]price_15', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                            ?>
                            <?=
                                $form->field($prices['insurance_100'], '[insurance_100]price_29', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <div class="card">
                    <div class="card-header">
                        <div class="header-block">
                            <p class="title">Ассистанс</p>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <?=
                                $form->field($prices['assistance'], '[assistance]price_1', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                            ?>
                            <?=
                                $form->field($prices['assistance'], '[assistance]price_3', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                            ?>
                            <?=
                                $form->field($prices['assistance'], '[assistance]price_6', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                            ?>
                        </div>
                        <div class="row">
                            <?=
                                $form->field($prices['assistance'], '[assistance]price_8', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                            ?>
                            <?=
                                $form->field($prices['assistance'], '[assistance]price_15', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                            ?>
                            <?=
                                $form->field($prices['assistance'], '[assistance]price_29', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card menu-manage menu-manage-small">
            <div class="card-header">
                <div class="header-block">
                    <p class="title">Цены по городам</p>
                </div>
            </div>
            <?php foreach ($city_prices as $key => $city_price) { ?>
                <div class="card-block">
                    <div class="card">
                        <div class="card-header">
                            <div class="header-block">
                                <p class="title"><?= $city_price->title ?></p>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <?=
                                $form->field($city_price, '[' . $key . ']price_1', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                                ?>
                                <?=
                                $form->field($city_price, '[' . $key . ']price_3', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                                ?>
                                <?=
                                $form->field($city_price, '[' . $key . ']price_6', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                                ?>
                            </div>
                            <div class="row">
                                <?=
                                $form->field($city_price, '[' . $key . ']price_8', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                                ?>
                                <?=
                                $form->field($city_price, '[' . $key . ']price_15', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                                ?>
                                <?=
                                $form->field($city_price, '[' . $key . ']price_29', ['options' => ['class' => 'form-group col-sm-4']])
                                    ->textInput(['class' => 'form-control boxed']);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>