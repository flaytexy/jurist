<?php
use yii\helpers\Url;

$action = $this->context->action->id;
$module = $this->context->module->id;
?>

<!--<ul class="nav nav-tabs">
    <li <?/*= ($action === 'edit') ? 'class="active"' : '' */?>><a href="<?/*= Url::to(['/admin/'.$module.'/a/edit', 'id' => $model->primaryKey]) */?>"><?/*= Yii::t('easyii/seo', 'Edit seo') */?></a></li>
    <li <?/*= ($action === 'photos') ? 'class="active"' : '' */?>><a href="<?/*= Url::to(['/admin/'.$module.'/a/photos', 'id' => $model->primaryKey]) */?>"><span class="glyphicon glyphicon-camera"></span> <?/*= Yii::t('easyii', 'Photos') */?></a></li>
    <li <?/*= ($action === 'packets') ? 'class="active"' : '' */?>><a href="<?/*= Url::to(['/admin/'.$module.'/a/packets', 'id' => $model->primaryKey]) */?>"><span class="glyphicon glyphicon-camera"></span> <?/*= Yii::t('easyii', 'Packets') */?></a></li>
</ul>
<br>-->