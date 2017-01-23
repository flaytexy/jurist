<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$module = $this->context->module->id;

?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'model-form']
]); ?>
<?/*= $form->field($model, 'title') */?>
<!--<hr/>-->


<?= $form->field($model, 'sitemap')->fileInput() ?>
<?= $form->field($model, 'robots')->textarea(array('rows' => 30)) ?>
<?= $form->field($model, 'scripts_footer')->textarea(array('rows' => 30)) ?>

<?//= Html::beginTag('div', ['class'=>'form-group field-seo-robots']) ?>
<?//= Html::label('Robots.txt', 'agree', ['class'=>'control-label']) ?>
<?//= Html::textarea('robots', '' , ['rows' => '36', 'class' => 'form-control']); ?>
<!--<div class="help-block"></div>-->
<?//= Html::endTag('div') ?>




<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
