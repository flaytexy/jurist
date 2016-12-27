<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\PacketsAsset;

use frontend\widgets\TagsInput;


PacketsAsset::register($this);

$class = get_class($this->context->model);
$item_id = $this->context->model->primaryKey;

$linkParams = [
    'class' => $class,
    'item_id' => $item_id,
];

$packetTemplate = '<tr data-id="{{packet_id}}">'.(IS_ROOT ? '<td>{{packet_id}}</td>' : '').'\
    <td>\
        <input class="form-control packet-price" type="text" name="Photo[price]" value="{{packet_price}}"  >\
        <input class="form-control packet-title" type="text" name="Photo[title]" value="{{packet_title}}"  >\
        <textarea class="form-control packet-description">{{packet_description}}</textarea>\
        '. TagsInput::widget([
            'model' => $model,
            'value' => "{{packet_tagNames}}",
            'name' => "tag_name_{{packet_id}}"
        ]).'\
        <a href="' . Url::to(['/admin/packets/description/{{packet_id}}']) . '" class="btn btn-sm btn-primary disabled save-packet-description">'. Yii::t('easyii', 'Save') .'</a>\
    </td>\
    <td class="control vtop">\
        <div class="btn-group btn-group-sm" role="group">\
            <a href="' . Url::to(['/admin/packets/up/{{packet_id}}'] + $linkParams) . '" class="btn btn-default move-up" title="'. Yii::t('easyii', 'Move up') .'"><span class="glyphicon glyphicon-arrow-up"></span></a>\
            <a href="' . Url::to(['/admin/packets/down/{{packet_id}}'] + $linkParams) . '" class="btn btn-default move-down" title="'. Yii::t('easyii', 'Move down') .'"><span class="glyphicon glyphicon-arrow-down"></span></a>\
            <a href="' . Url::to(['/admin/packets/delete/{{packet_id}}']) . '" class="btn btn-default color-red delete-photo" title="'. Yii::t('easyii', 'Delete item') .'"><span class="glyphicon glyphicon-remove"></span></a>\
        </div>\
    </td>\
</tr>';
$this->registerJs("
var packetTemplate = '{$packetTemplate}';
", \yii\web\View::POS_HEAD);
$packetTemplate = str_replace('>\\', '>', $packetTemplate);
?>
<button id="create-packet" data-url="/admin/packets/upload?class=frontend%5Cmodules%5Coffers%5Cmodels%5COffers&item_id=<?=$item_id?>" class="btn btn-success text-uppercase"><span class="glyphicon glyphicon-plus"></span>
    <?= Yii::t('easyii', 'New')?>
</button>


<table id="packet-table" class="table table-hover" style="display: <?= count($packets) ? 'table' : 'none' ?>;">
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
            ['{{packet_id}}', '{{packet_title}}', '{{packet_description}}', '{{packet_price}}' , '{{packet_tagNames}}'],
            [$packet->primaryKey, $packet->title, $packet->description, $packet->price, $packet->tagNames],
            $packetTemplate)
        ?>
    <?php endforeach; ?>
    </tbody>
</table>

<p class="empty" style="display: <?= count($packets) ? 'none' : 'block' ?>;"><?= Yii::t('easyii', 'No packets yet') ?>.</p>

