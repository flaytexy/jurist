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
        position: absolute;
        color: white;
        top: 35%;
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
    #current-lang .Rus {
        color: transparent;
        background-image: url('/images/flag/Flag_of_Russia.png');
        background-size: 30px 15px;
        background-repeat: no-repeat;
        background-position: right top;

    }
    #current-lang .Eng {
        color: transparent;
        background-image: url('/images/flag/eng.jpg');
        background-size: 30px 15px;
        background-repeat: no-repeat;
        background-position: right top;
    }
    #current-lang .Eng a,
    #current-lang .Rus a {
        color: transparent;
    }
</style>

<div id="lang">
     <span id="current-lang">
         <?php foreach ($langs as $lang):?>
           <b><?= Html::a($lang->name, '/'.$lang->url.Yii::$app->getRequest()->getLangUrl()) ?></b>
          <?php endforeach;?>
     </span>
</div>

