<?php

use backend\modules\user\Module;

/* @var $this yii\web\View */
/* @var $user backend\modules\user\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['user/default/email-confirm', 'token' => $user->email_confirm_token]);
?>

<?= Module::t('module', 'HELLO {username}', ['username' => $user->username]); ?>

<?= Module::t('module', 'FOLLOW_TO_CONFIRM_EMAIL') ?>

<?= $confirmLink ?>

<?= Module::t('module', 'IGNORE_IF_DO_NOT_REGISTER') ?>