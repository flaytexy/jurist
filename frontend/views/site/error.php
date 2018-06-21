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
            <?= nl2br(Html::encode($error_text)) ?> <?php if($message): ?><span><?= $message ?></span><? endif; ?>
        </div>

        <p class="top10">
            Ошибка 404. Невозможно обработать запрос.<br />
        </p>
        <p class="bold top30">
            Воспользуйтесь пожалуйста меню, чтобы перейти в нужный раздел:
        </p>

    </div>
    <div class="top-bar-error">
        <div class="topbar-data-error">
            <ul class="list-inline">
                <li><a class href="/fonds" title="Банки">Фонды</a></li>
                <li><a href="/banks" title="Банки">Банки</a></li>
                <li><a href="/offshornyie-predlozheniya" title="Компании">Компании</a></li>
                <li><a href="/licenses" title="Банки">Лицензии</a></li>
                <li><a href="/processing" title="Банки" style="line-height: 0.9">Мерчант (процессинг)<br /> Эквайринг</a></li>
                <li><a href="/news" title="Банки">Новости</a></li>
            </ul>
        </div>
    </div><!-- Top Bar -->
</div>
