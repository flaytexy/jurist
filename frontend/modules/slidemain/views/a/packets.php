<?php
use frontend\widgets\Packets;

$this->title = $model->title;
?>

<?= $this->render('_menu') ?>
<?= $this->render('_submenu', ['model' => $model]) ?>

<?= Packets::widget(['model' => $model])?>