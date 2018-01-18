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
        <h3 class="title"> Редактировать SEO страницы <span class="sparkline bar" data-type="bar"></span></h3>
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
                    <p class="title">Управление</p>
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-sm-12">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-block']) ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-sm-9 pull-sm-3">

        <div class="card menu-manage">
            <div class="card-header">
                <div class="header-block">
                    <p class="title">SEO</p>
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    <?=
                    $form->field($model, 'uri', ['options' => ['class' => 'form-group col-sm-12']])
                        ->textInput(['class' => 'form-control boxed']);
                    ?>
                    <?=
                    $form->field($model, 'title', ['options' => ['class' => 'form-group col-sm-12']])
                        ->textInput(['class' => 'form-control boxed']);
                    ?>
                    <?=
                    $form->field($model, 'keywords', ['options' => ['class' => 'form-group col-sm-12']])
                        ->textInput(['class' => 'form-control boxed']);
                    ?>
                    <?=
                    $form->field($model, 'description', ['options' => ['class' => 'form-group col-sm-12']])
                        ->textarea(['class' => 'form-control boxed', 'style' => 'min-height: 200px']);
                    ?>
                    <?=
                    $form->field($model, 'h1', ['options' => ['class' => 'form-group col-sm-12']])
                        ->textInput(['class' => 'form-control boxed']);
                    ?>
                    <?=
                    $form->field($model, 'text', ['options' => ['class' => 'form-group col-sm-12']])
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
                    ?>
                </div>
            </div>
        </div>

    </div>

    <?php ActiveForm::end(); ?>
</div>