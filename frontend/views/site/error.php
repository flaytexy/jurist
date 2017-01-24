<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="container">
    <div class="site-error">

        <h1><?= Html::encode('Houston, we have a problem.') ?></h1>

        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>

        <p>
            Ошибка 404. Невозможно обработать запрос.
        </p>
        <p>
            Воспользуйтесь пожалуйста меню, чтобы перейти в нужный раздел.
        </p>

    </div>
</div>
