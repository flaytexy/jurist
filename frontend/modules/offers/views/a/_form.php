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
use dosamigos\selectize\SelectizeTextInput;

$module = $this->context->module->id;

?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'model-form']
]); ?>
<?= $form->field($model, 'title') ?>
<hr/>

<?/*= $form->field($model, 'type_id')->dropDownList([
    '1' => 'Весь мир',
    '2' => 'Европа'
]) */?>
<?= $form->field($model, 'coordinates') ?>


<?/*= $form->field($model, 'countryNames')->widget(TagsInput::className()) */?>
<?php /* */ ?>
<?= $form->field($model, 'countryNames')
    ->widget(\akavov\countries\widgets\CountriesSelectizeTextInput::className(), [
        'countryModelNamespace' => 'common\models\country\CountryData',
        'customRender' => [
            'item'  => '<div> <span class="label flag flag-icon-background flag-icon-{item.alpha}">&nbsp;</span>&nbsp;<span class="name">{escape(item.name_en)}</span></div>',
            'option'  => '<div> <span class="label flag flag-icon-background flag-icon-{item.alpha}">&nbsp;</span>&nbsp;<span class="name">{escape(item.name_en)}</span></div>',
        ],
        'clientOptions' => [
            'valueField' => 'name_en',
            'labelField' => 'name_en',
            'searchField' => ['name_en'],
            'plugins' => ['remove_button'],
            'closeAfterSelect' => true,
            'maxItems' => 10,
            'delimiter' => ',',
            'persist' => false,
            'preload' => true,
            'items' => $model->countryNames,
            'create' => false,
        ],
    ]); ?>


<?= $form->field($model, 'price') ?>
<?= $form->field($model, 'how_days') ?>
<?= $form->field($model, 'to_main')->checkbox(['id' => 'to_main', 'checked' => true])->label(false)->error(false) ?>

<?php /*if ($model->pre_image) : */ ?><!--
    <img src="<? /*= Image::thumb($model->pre_image, 240) */ ?>">
--><?php /*endif; */ ?>

<? /*= $form->field($model, 'pre_image')->fileInput() */ ?>


<?= $form->field($model, 'pre_text')->textarea(array('rows' => 6)) ?>
<hr/>

<?php if ($this->context->module->settings['enableThumb']) : ?>
    <?php if ($model->image) : ?>
        <img src="<?= Image::thumb($model->image, 240) ?>">
        <a href="<?= Url::to(['/admin/' . $module . '/a/clear-image', 'id' => $model->offer_id]) ?>"
           class="text-danger confirm-delete"
           title="<?= Yii::t('easyii', 'Clear image') ?>"><?= Yii::t('easyii', 'Clear image') ?></a>
    <?php endif; ?>
    <?= $form->field($model, 'image')->fileInput() ?>
<?php endif; ?>
<?php if ($this->context->module->settings['enableShort']) : ?>
    <?= $form->field($model, 'short')->textarea(array('rows' => 6)) ?>
<?php endif; ?>

<? /*= $form->field($model, 'text')->widget(Redactor::className(), [
    'options' => [
        'minHeight' => 400,
        'imageUpload' => Url::to(['/admin/redactor/upload', 'dir' => 'offers']),
        'fileUpload' => Url::to(['/admin/redactor/upload', 'dir' => 'offers']),
        'plugins' => ['fullscreen']
    ]
]) */ ?>



<?= $form->field($model, 'text')->widget(CKEditor::className(), [
    'preset' => 'full',
    'clientOptions' => ElFinder::ckeditorOptions('elfinder',
        [
        'filebrowserImageUploadUrl' => Url::to(['/admin/redactor/uploader', 'dir' => 'offers']),
        'extraPlugins' => 'justify,embed,link,font,div,table,tableresize,tabletools,uicolor,colorbutton,colordialog',
        'toolbar' => [
            ['name' => 'document', 'groups' => ['mode', 'document', 'doctools'], 'items' => ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']],
            ['name' => 'clipboard', 'groups' => ['clipboard', 'undo'], 'items' => ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']],
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
?>

<?= $form->field($model, 'time')->widget(DateTimePicker::className()); ?>

<?php if ($this->context->module->settings['enableTags']) : ?>
<!--    --><?//= $form->field($model, 'tagNames')->widget(TagsInput::className()) ?>
<?php endif; ?>

<?= $form->field($model, 'tagNames')->widget(TagsInput::className(), [
    'options' => [
        'id' => 'qasd'
    ]
]) ?>

<?= $form->field($model, 'tagNames')->widget(TagsInput::className(), [
    'options' => [
        'id' => 'qasd2'
    ]
]) ?>


<?php
/*use dosamigos\selectize\SelectizeTextInput;

echo SelectizeTextInput::widget([
    'options' => ['class' => 'form-control'],
    'loadUrl' => '/admin/tags/list',
    'name' => 'tags',
    'value' => 'love, this, game',
    'clientOptions' => [
        'plugins' => ['remove_button'],
        'valueField' => 'name',
        'labelField' => 'name',
        'searchField' => ['name'],
        'create' => true,
    ],
]);


echo SelectizeTextInput::widget([
    'options' => ['class' => 'form-control2'],
    'loadUrl' => '/admin/tags/list',
    'name' => 'tags',
    'value' => 'love, this, game',
    'clientOptions' => [
        'plugins' => ['remove_button'],
        'valueField' => 'name',
        'labelField' => 'name',
        'searchField' => ['name'],
        'create' => true,
    ],
]);


*/?>


<?= $form->field($model, 'optionNames')->widget(OptionsInput::className()) ?>

<?php if (IS_ROOT || true) : ?>
    <?= $form->field($model, 'slug') ?>
    <?= SeoForm::widget(['model' => $model]) ?>
<?php endif; ?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
