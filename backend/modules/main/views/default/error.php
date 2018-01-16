<?php

use yii\helpers\Url;
use app\modules\menu\models\MenuItem;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;

$menu_items = MenuItem::find()
    ->where([
        'menu_id' => 6,
        'parent_id' => 0,
    ])
    ->joinWith('translation')
    ->asArray()
    ->all();
?>

<section class="main-error container">
    <div class="line line-1"></div>
    <div class="line line-2"></div>
    <div class="line line-3"></div>
    <div class="line line-4"></div>
    <div class="line line-5"></div>
    <div class="line line-6"></div>
    <div class="line line-7"></div>
    <div class="main-error-content">
        <img src="/img/404.svg" alt="" width="750" height="593">
        <ul class="main-error-menu">
            <?php foreach ($menu_items as $menu_item) { ?>
                <li>
                    <a href="<?= $menu_item['translation']['link']; ?>"><?= $menu_item['translation']['title']; ?></a>
                </li>
            <?php } ?>
        </ul>
        <div class="main-error-message">
            <p><?= $message; ?></p>
            <a href="<?= Url::to(['/main/index']) ?>"><?= Yii::t('app', 'Вернутся на главную') ?></a>
        </div>
    </div>
</section>
