<?php
use frontend\modules\seo\models\Seo;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('easyii/seo', 'Seo');
$module = $this->context->module->id;

?>
<?= $this->render('_menu') ?>

<?php if($this->context->module->settings['enablePhotos']) echo $this->render('_submenu', ['model' => $model]) ?>

<?= $this->render('_form', ['model' => $model]) ?>