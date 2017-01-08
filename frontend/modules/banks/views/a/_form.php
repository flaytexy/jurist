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

$module = $this->context->module->id;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'model-form']
]); ?>
<?= $form->field($model, 'title') ?>
<hr/>
<?= $form->field($model, 'location_title') ?>

<?= $form->field($model, 'type_id')->dropDownList([
    '1' => 'Корпоративный счет',
    '2' => 'Личный счет'
]) ?>
<?= $form->field($model, 'personal')->checkbox(['id' => 'personal', 'checked' => true])->label(false)->error(false) ?>


<?= $form->field($model, 'price') ?>
<?= $form->field($model, 'how_days') ?>

<?= $form->field($model, 'to_main')->checkbox(['id' => 'to_main', 'checked' => true])->label(false)->error(false) ?>


<hr/>

<?php if ($this->context->module->settings['enableThumb']) : ?>
    <?php if ($model->image) : ?>
        <img src="<?= Image::thumb($model->image, 240) ?>">
        <a href="<?= Url::to(['/admin/' . $module . '/a/clear-image', 'id' => $model->bank_id]) ?>"
           class="text-danger confirm-delete"
           title="<?= Yii::t('easyii', 'Clear image') ?>"><?= Yii::t('easyii', 'Clear image') ?></a>
    <?php endif; ?>
    <?= $form->field($model, 'image')->fileInput() ?>
<?php endif; ?>
<?php if ($this->context->module->settings['enableShort']) : ?>
    <?= $form->field($model, 'short')->textarea() ?>
<?php endif; ?>
<?= $form->field($model, 'text')->widget(Redactor::className(), [
    'options' => [
        'minHeight' => 400,
        'imageUpload' => Url::to(['/admin/redactor/upload', 'dir' => 'banks']),
        'fileUpload' => Url::to(['/admin/redactor/upload', 'dir' => 'banks']),
        'plugins' => ['fullscreen']
    ]
]) ?>

<?= $form->field($model, 'time')->widget(DateTimePicker::className()); ?>

<?php if ($this->context->module->settings['enableTags']) : ?>
    <?= $form->field($model, 'tagNames')->widget(TagsInput::className()) ?>
<?php endif; ?>

<?= $form->field($model, 'optionNames')->widget(OptionsInput::className()) ?>

<?php if (IS_ROOT) : ?>
    <?= $form->field($model, 'slug') ?>
    <?= SeoForm::widget(['model' => $model]) ?>
<?php endif; ?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
