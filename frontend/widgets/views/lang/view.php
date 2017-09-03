<?php
use yii\helpers\Html;
?>
<style>
    #lang {
        position: absolute;
        display: inline-block;
        color: white;
        right: 0;
    }

    #langs {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 10px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        padding: 12px 16px;
        z-index: 5;
        list-style: none;
        right: 0;
    }

    #lang:hover #langs {
        display: block;
    }
</style>

<div id="lang" style="float: right;">
    <span id="current-lang">
       <b> <?= $current->name;?></b> <span class="show-more-lang">▼</span>
    </span>
    <ul id="langs">
        <?php foreach ($langs as $lang):?>
            <li class="item-lang">
                <?= Html::a($lang->name, '/'.$lang->url.Yii::$app->getRequest()->getLangUrl()) ?>
            </li>
        <?php endforeach;?>
    </ul>
</div>
