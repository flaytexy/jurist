<?php
use yii\helpers\Html;
?>
<style>
    @media (max-width: 1000px) {
        #lang {
            position: static !important;
        }
    }
    #lang {
        display: inline-block;
        color: white;
        top: 16%;
        right: 13px;
    }

    #langs {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        width: 42px;
        height: 23px;
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        padding: 4px 5px;
        z-index: 5;
        list-style: none;
        right: 0;
    }

    #lang:hover #langs {
        display: block;
    }
    .Rus {
        color: transparent;
        background-image: url(https://upload.wikimedia.org/wikipedia/commons/d/d4/Flag_of_Russia.png);
        background-size: 30px 15px;
        background-repeat: no-repeat;
        background-position: right top;

    }
    .Eng {
        color: transparent;
        background-image: url(https://qph.ec.quoracdn.net/main-qimg-45ee634d5a033b5bbb11d231864cc6c3);
        background-size: 30px 15px;
        background-repeat: no-repeat;
        background-position: right top;
    }
    .Eng a,
    .Rus a {
        color: transparent;
    }
</style>

<div id="lang">
     <span id="current-lang">
         <?php foreach ($langs as $lang):?>
      <b> <?= Html::a($lang->name, '/'.$lang->url.Yii::$app->getRequest()->getLangUrl()) ?></b>
          <?php endforeach;?>
   </span>
</div>

