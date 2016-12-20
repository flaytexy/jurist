<?php
use frontend\helpers\Image;
use frontend\models\Photo;
use frontend\widgets\Fancybox;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\PhotosAsset;

PhotosAsset::register($this);
Fancybox::widget(['selector' => '.plugin-box']);

$class = get_class($this->context->model);
$item_id = $this->context->model->primaryKey;

$linkParams = [
    'class' => $class,
    'item_id' => $item_id,
];

$packetTemplate = '<tr data-id="{{photo_id}}">'.(IS_ROOT ? '<td>{{photo_id}}</td>' : '').'\
    <td>\
        <input type="text" name="Photo[title]" value="{{photo_title}}"  >\
        <textarea class="form-control photo-description">{{photo_description}}</textarea>\
        <a href="' . Url::to(['/admin/photos/description/{{photo_id}}']) . '" class="btn btn-sm btn-primary disabled save-photo-description">'. Yii::t('easyii', 'Save') .'</a>\
    </td>\
    <td class="control vtop">\
        <div class="btn-group btn-group-sm" role="group">\
            <a href="' . Url::to(['/admin/photos/up/{{photo_id}}'] + $linkParams) . '" class="btn btn-default move-up" title="'. Yii::t('easyii', 'Move up') .'"><span class="glyphicon glyphicon-arrow-up"></span></a>\
            <a href="' . Url::to(['/admin/photos/down/{{photo_id}}'] + $linkParams) . '" class="btn btn-default move-down" title="'. Yii::t('easyii', 'Move down') .'"><span class="glyphicon glyphicon-arrow-down"></span></a>\
            <a href="' . Url::to(['/admin/photos/edit/{{photo_id}}'] + $linkParams) . '" class="btn btn-default change-image-button" title="'. Yii::t('easyii', 'Change image') .'"><span class="glyphicon glyphicon-floppy-disk"></span></a>\
            <a href="' . Url::to(['/admin/photos/delete/{{photo_id}}']) . '" class="btn btn-default color-red delete-photo" title="'. Yii::t('easyii', 'Delete item') .'"><span class="glyphicon glyphicon-remove"></span></a>\
        </div>\
    </td>\
</tr>';
$this->registerJs("
var photoTemplate = '{$packetTemplate}';
", \yii\web\View::POS_HEAD);
$packetTemplate = str_replace('>\\', '>', $packetTemplate);
?>
<button id="photo-upload2" class="btn btn-success text-uppercase"><span class="glyphicon glyphicon-plus"></span>
    <?= Yii::t('easyii', 'New')?>
</button>


<table id="photo-table" class="table table-hover" style="display: <?= count($packets) ? 'table' : 'none' ?>;">
    <thead>
    <tr>
        <?php if(IS_ROOT) : ?>
        <th width="50">#</th>
        <?php endif; ?>
        <th></th>
        <th width="150"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($packets as $packet) : ?>
        <?= str_replace(
            ['{{photo_id}}', '{{photo_title}}', '{{photo_description}}'],
            [$packet->primaryKey, $packet->title, $packet->description],
            $packetTemplate)
        ?>
    <?php endforeach; ?>
    </tbody>
</table>

<p class="empty" style="display: <?= count($packets) ? 'none' : 'block' ?>;"><?= Yii::t('easyii', 'No packets yet') ?>.</p>

<?= Html::beginForm(Url::to(['/admin/photos/upload'] + $linkParams), 'post', ['enctype' => 'multipart/form-data']) ?>
<?= Html::fileInput('', null, [
    'id' => 'photo-file',
    'class' => 'hidden',
    'multiple' => 'multiple',
])
?>
<?php Html::endForm() ?>