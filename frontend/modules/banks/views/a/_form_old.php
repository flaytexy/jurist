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
<?= $form->field($model, 'title') ?>
<hr/>

<?= $form->field($model, 'type_id')->dropDownList([
    '1' => 'Корпоративный счет',
    '2' => 'Личный счет'
]) ?>
<?= $form->field($model, 'personal')->checkbox(['id' => 'personal', 'checked' => true])->label(false)->error(false) ?>


<?= $form->field($model, 'price') ?>
<?= $form->field($model, 'how_days') ?>

<?= $form->field($model, 'website') ?>
<?= $form->field($model, 'min_deposit') ?>
<hr/>
<?/*= $form->field($model, 'to_main')->checkbox(['id' => 'to_main', 'checked' => true])->label(false)->error(false) */?>
<?= $form->field($model, 'rating')->input('text', ['placeholder' => "Чем больше тем выше в рейтинге"])->label("Рейтинг (попадает при > 0)"); ?>
<?= $form->field($model, 'rating_to_main')->input('text', ['placeholder' => "Чем больше тем выше в рейтинге"])->label("Рейтинг на главной (попадает при > 0)"); ?>
<hr/>
<?= $form->field($model, 'location_zone_id')->dropDownList([
    '0'  => 'Не выбрано',
    '1' => 'Европа',
    '2' => 'Азия',
    '3' => 'Америка',
    '4' => 'Африка',
    '5' => 'Островная',
    '8' => 'Австралия',
]) ?>

<?= $form->field($model, 'countryNames')
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
            'items' => $model->countryNames,
            'create' => false,
        ],
    ]); ?>

<?= $form->field($model, 'location_title') ?>


<?php if (false && $model->image_flag) : ?>
    <img src="<?= Image::thumb($model->image_flag, 240) ?>">
<?php endif; ?>
<?= $form->field($model, 'image_flag')->fileInput() ?>

<hr/>
<?php if ($model->image) : ?>
    Оригинал:<br />

    <img src="<?= Image::thumb($model->image) ?>" style="width: 100%; height: auto">
    <a href="<?= Url::to(['/admin/' . $module . '/a/clear-image', 'id' => $model->bank_id]) ?>"
       class="text-danger confirm-delete"
       title="<?= Yii::t('easyii', 'Clear image') ?>"><?= Yii::t('easyii', 'Clear image') ?></a><br /><br /><br />
    Как на сайте будет:<br />
    <img src="<?= Image::thumb($model->image, 480, 120) ?>"><br />
<?php endif; ?>
<span>Картинка главная (jpg, jpeg) (длинная) (1600x400, 1240x310, 800x200, 640x160) (90% качетсва)</span><br />
<?= $form->field($model, 'image')->fileInput() ?>

<hr/>
<?php if ($model->pre_image) : ?>
    <?= Html::img(Image::thumb($model->pre_image, 320, 180), array('class' => 'sadsa', 'style'=> 'width:320px; height: 180px;')) ?><br />
<?php endif; ?>
<span>Картинка (jpg, jpeg) для вревью (1600x900, 1366x768, 800x450, 640x360) (90% качетсва)</span><br />
<?= $form->field($model, 'pre_image')->fileInput() ?>
<hr/>
<?php if ($this->context->module->settings['enableShort']) : ?>
    <?= $form->field($model, 'short')->textarea() ?>
<?php endif; ?>

<? /*= $form->field($model, 'text')->widget(Redactor::className(), [
    'options' => [
        'minHeight' => 400,
        'imageUpload' => Url::to(['/admin/redactor/upload', 'dir' => 'banks']),
        'fileUpload' => Url::to(['/admin/redactor/upload', 'dir' => 'banks']),
        'plugins' => ['fullscreen']
    ]
]) */ ?>
<span>Картинки в редактор  загружать (70% качетсва)</span><br />
<?= $form->field($model, 'text')->widget(CKEditor::className(), [
    'preset' => 'full',
    'clientOptions' => ElFinder::ckeditorOptions('elfinder',
        [
            //'allowedContent' => true,
            //"extraAllowedContent" => 'span;ul;li;table;td;style;*[id];*(*);*{*}', // all-style: *{*}, all-class: *(*), all-id: *[id]
            "extraAllowedContent" => '*(*);*[id];table{*};', // all-style: *{*}, all-class: *(*), all-id: *[id]
            'filebrowserImageUploadUrl' => Url::to(['/admin/redactor/uploader', 'dir' => 'offers']),
            'extraPlugins' => 'justify,link,font,div,table,tableresize,tabletools,uicolor,colorbutton,colordialog',
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
?>


<?= $form->field($model, 'time')->widget(DateTimePicker::className()); ?>

<?php if ($this->context->module->settings['enableTags']) : ?>
    <?= $form->field($model, 'tagNames')->widget(TagsInput::className()) ?>
<?php endif; ?>

<?= $form->field($model, 'optionNames')->widget(OptionsInput::className()) ?>

<?php if (IS_ROOT || true) : ?>
    <?= $form->field($model, 'slug') ?>
    <?= SeoForm::widget(['model' => $model]) ?>
<?php endif; ?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
