<?php
$this->title = $model->title;
?>

<?= $this->render('_menu') ?>

<?php if($this->context->module->settings['enablePhotos'] || true) echo $this->render('_submenu', ['model' => $model]) ?>

<?= $this->render('_form', ['model' => $model]) ?>