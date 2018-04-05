<?php
use frontend\widgets\DateTimePicker;
use frontend\helpers\Image;
use frontend\widgets\TagsInput;
use frontend\widgets\OptionsInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\widgets\Redactor;
use frontend\widgets\SeoForm;
use dosamigos\ckeditor\CKEditor;
use dosamigos\ckeditor\CKEditorInline;
//use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

$module = $this->context->module->id;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'model-form']
]); ?>
<?php if($this->context->module->settings['enableThumb']) : ?>
    <?php if($model->image) : ?>
        <img src="<?= Image::thumb($model->image) ?>" style="width: 100%;height: auto"><br />
        <div class="text-center top10">
            <a href="<?= Url::to(['/admin/'.$module.'/a/clear-image', 'id' => $model->slide_main_id]) ?>" class="text-danger confirm-delete" title="<?= Yii::t('easyii', 'Clear image')?>"><?= Yii::t('easyii', 'Clear image')?></a>
        </div>
    <?php endif; ?>
    <?= $form->field($model, 'image')->fileInput() ?>
<?php endif; ?>
<hr />
<?= $form->field($model, 'title') ?>
<?= $form->field($model, 'short') ?>
<?= $form->field($model, 'text') ?>
<br />
<?= $form->field($model, 'pre_text') ?>
<hr />
<?= $form->field($model, 'title_en') ?>
<?= $form->field($model, 'short_en') ?>
<?= $form->field($model, 'text_en') ?>
<br />
<?= $form->field($model, 'pre_text_en') ?>

<hr />
<?= $form->field($model, 'url') ?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
