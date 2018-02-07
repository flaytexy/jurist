<?php
use frontend\widgets\DateTimePicker;
use frontend\helpers\Image;
use frontend\widgets\TagsInput;
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
<?= $form->field($model, 'title') ?>


<?= $form->field($model, 'category_detail')->dropDownList($categories); ?>
<? /*= $form->field($model, 'type_id')->dropDownList([
    '1' => 'Страница',
    '2' => 'Новости',
    '3' => 'Лицензии',
    '4' => 'Фонды',
    '5' => 'Процессинг'
]) */ ?>

<?= $form->field($model, 'to_main')->checkbox(['id' => 'to_main', 'checked' => true])->label(false)->error(false) ?>


<?php if ($this->context->module->settings['enableThumb']) : ?>
    <?php if ($model->image) : ?>
        <img src="<?= Image::thumb($model->image, 240) ?>">
        <a href="<?= Url::to(['/admin/' . $module . '/a/clear-image', 'id' => $model->page_id]) ?>"
           class="text-danger confirm-delete"
           title="<?= Yii::t('easyii', 'Clear image') ?>"><?= Yii::t('easyii', 'Clear image') ?></a>
    <?php endif; ?>
    <?= $form->field($model, 'image')->fileInput() ?>
<?php endif; ?>
<?php if ($this->context->module->settings['enableShort']) : ?>
    <?= $form->field($model, 'short')->textarea() ?>
<?php endif; ?>
<? //= $form->field($model, 'text')->widget(Redactor::className(),[
//    'options' => [
//        'minHeight' => 400,
//        'imageUpload' => Url::to(['/admin/redactor/upload', 'dir' => 'page']),
//        'fileUpload' => Url::to(['/admin/redactor/upload', 'dir' => 'page']),
//        'plugins' => ['fullscreen']
//    ]
//]) ?>

<?= $form->field($model, 'text')->widget(CKEditor::className(), [
    'preset' => 'full',
    'clientOptions' => ElFinder::ckeditorOptions('elfinder',
        [
            //'allowedContent' => true,
            //"extraAllowedContent" => 'span;ul;li;table;td;style;*[id];*(*);*{*}', // all-style: *{*}, all-class: *(*), all-id: *[id]
            "extraAllowedContent" => '*(*);*[id];table{*};', // all-style: *{*}, all-class: *(*), all-id: *[id]
            'filebrowserImageUploadUrl' => Url::to(['/admin/redactor/uploader', 'dir' => 'offers']),
            'extraPlugins' => 'justify,link,font,div,table,tableresize,tabletools,uicolor,colorbutton,colordialog,liststyle',
            'contentsCss' => ['/css/style_all.min.css'],
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
    <?= $form->field($model, 'tagNames')->widget(TagsInput::className()) ?>
<?php endif; ?>

<?php if (IS_ROOT || true) : ?>
    <?= $form->field($model, 'slug') ?>
    <?= SeoForm::widget(['model' => $model]) ?>
<?php endif; ?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
