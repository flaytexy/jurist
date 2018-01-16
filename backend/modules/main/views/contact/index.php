<?php

use app\modules\main\Module;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\modules\main\models\form\ContactForm */

$this->title = Module::t('module', 'TITLE_CONTACT');
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="contacts">
    <div class="overlay"></div>
    <div class="contacts__title">
        <p>Contacts</p><a href="mail:<?=Yii::$app->settings->get('email')?>"><?=Yii::$app->settings->get('email')?></a><br/><a href="tel:<?=Yii::$app->settings->get('phone')?>"><?=Yii::$app->settings->get('phone')?> </a>
    </div>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
        <div class="alert alert-success">
            <?= Module::t('module', 'CONTACT_THANKS'); ?>
        </div>
    <?php else: ?>
        <?php $form = ActiveForm::begin(['id' => 'contact-form',
            'options' => [
                'class' => 'contacts__form',
                'csrf' => true
            ],
            'fieldConfig' => [
                'options' => [
                    //'class'=>'22',
                    'tag' => false,
                ],
            ],
        ]); ?>

        <?= $form->field($model, 'name', [
            'template' => '<label>YOUR NAME {input}</label>',
        ])->textInput([ 'class' => '']) ?>
        <?= $form->field($model, 'email', [
            'template' => '<label>YOUR EMAIL {input}</label>',
        ])->textInput([ 'class' => '']) ?>
        <?= $form->field($model, 'body', [
            'template' => '<label>MESSAGE {input}<div class="back_form"></div></label>',
        ])->textArea(['rows' => 6,'class' => '']) ?>
<!--        --><?//= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
//            'captchaAction' => '/main/contact/captcha',
//            'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
//        ]) ?>

        <?= Html::submitButton(Module::t('module', 'SUBMIT'), ['class' => 'submit_btn', 'name' => 'contact-button']) ?>

        <?php ActiveForm::end(); ?>


    <?php endif; ?>
<!--    -->
<!--    <form class="contacts__form" method="post">-->
<!--        <label>-->
<!--            Your name-->
<!--            <input type="text" name="name"/>-->
<!--        </label>-->
<!--        <label>-->
<!--            Your email-->
<!--            <input type="text" name="email"/>-->
<!--        </label>-->
<!--        <label>message-->
<!--            <textarea type="text"></textarea>-->
<!--            <div class="back_form"></div>-->
<!--        </label>-->
<!--        <input class="submit_btn" type="button" value="submit"/>-->
<!--    </form>-->


