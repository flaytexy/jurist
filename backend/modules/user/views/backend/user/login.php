<?php

/**
 * @var \yii\web\View $this
 * @var \app\modules\user\forms\LoginForm $model
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="auth">
    <div class="auth-container">
        <div class="card">
            <header class="auth-header">
                <img src="/img/intro/logo.png"/>
            </header>
            <div class="auth-content">
                <?php
                $form = ActiveForm::begin([
                    'action' => Url::to(['']),
                    'id' => 'login-form',
                    'enableClientValidation' => true,
                    'validateOnBlur' => false,
                ]);
                ?>

                <input type="text" name="__fake_username" style="position:absolute;left:-9999px">
                <input type="password" name="__fake_password" style="position:absolute;left:-9999px">

                <?=
                $form->field($model, 'username')
                    ->textInput(['class' => 'form-control underlined', 'autofocus' => true]);
                ?>

                <?=
                $form->field($model, 'password')
                    ->passwordInput(['class' => 'form-control underlined']);
                ?>

                <div class="form-group">

                    <label for="<?= Html::getInputId($model, 'rememberMe'); ?>">
                        <?=
                        $form->field($model, 'rememberMe', ['options' => ['tag' => false]])
                            ->label(false)
                            ->error(false)
                            ->checkbox(['class' => 'checkbox'], false);
                        ?>
                        <span><?= $model->getAttributeLabel('rememberMe'); ?></span>
                    </label>

                </div>

                <?= Html::submitButton('Войти', ['class' => 'btn btn-block btn-primary']); ?>

                <?php ActiveForm::end(); ?>


                <!--                <form id="login-form" action="" method="GET" novalidate="">-->
                <!---->
                <!--                    <div class="form-group">-->
                <!--                        <label for="username">Логин</label>-->
                <!--                        <input type="text" class="form-control underlined" name="username" id="username" required autofocus>-->
                <!--                    </div>-->
                <!--                    <div class="form-group">-->
                <!--                        <label for="password">Пароль</label>-->
                <!--                        <input type="password" class="form-control underlined" name="password" id="password" required>-->
                <!--                    </div>-->
                <!--                    <div class="form-group">-->
                <!---->
                <!--                        <label for="remember">-->
                <!--                            <input class="checkbox" id="remember" type="checkbox">-->
                <!--                            <span>Запомнить меня</span>-->
                <!--                        </label>-->
                <!---->
                <!--                        <a href="--><?//= Url::to(['/admin/auth/reset']); ?><!--" class="forgot-btn pull-right">Забыли пароль?</a>-->
                <!--                    </div>-->
                <!--                    <div class="form-group">-->
                <!--                        <button type="submit" class="btn btn-block btn-primary">Войти</button>-->
                <!--                    </div>-->
                <!--                </form>-->
            </div>
        </div>
        <div>
            <a href="/" class="btn btn-link">
                ← Перейти на сайт
            </a>
        </div>
    </div>
</div>