<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\widgets\Redactor;
use mihaildev\elfinder\ElFinder;
use dosamigos\ckeditor\CKEditor;

?>
<?php $form = ActiveForm::begin([
    'options' => ['class' => 'model-form']
]); ?>

<?= $form->field($model, 'question') ?>
<?= $form->field($model, 'answer')->widget(CKEditor::className(), [
    'preset' => 'full',
    'clientOptions' => ElFinder::ckeditorOptions('elfinder',
        [
            //'allowedContent' => true,
            //"extraAllowedContent" => 'span;ul;li;table;td;style;*[id];*(*);*{*}', // all-style: *{*}, all-class: *(*), all-id: *[id]
            "extraAllowedContent" => '*(*);*[id];table{*};', // all-style: *{*}, all-class: *(*), all-id: *[id]
            'filebrowserImageUploadUrl' => Url::to(['/admin/redactor/uploader', 'dir' => 'offers']),
            'extraPlugins' => 'justify,link,font,div,table,tableresize,tabletools,uicolor,colorbutton,colordialog,liststyle',
            'contentsCss' => ['/css/style_all.min.css?v=2018-02-07-v03'],
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
<?= Html::submitButton(Yii::t('easyii','Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>