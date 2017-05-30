<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\helpers\Image;

$this->title = $offers->seo('title', $offers->model->title);
$this->params['breadcrumbs'][] = ['label' => 'Компании', 'url' => ['offers/index']];
$this->params['breadcrumbs'][] = $offers->model->title;
?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
      xmlns="http://www.w3.org/1999/html">

<style>
    .offertitle {
        position: relative;

        padding-left: 17px;
        padding-top: 17px;
        font-weight: bold;
        font-size: 52px;

    }
    .offertitle h2,
    .offertitle h3 {


        padding-left: 17px;
        font-family: Arial;

    }
    .offertitle:before {
        content: '';
        display: block;
        position: absolute;
        height: 100%;
        width: 10px;
        background: #7ec211;
        top: 0;
        left: 0;
        opacity: 1;
    }
    .packages-detail {
        padding-left: 25px !important;
        padding-right: 25px !important;
        -webkit-box-shadow:  0 4px 16px rgba(0,0,0,.5);
        -moz-box-shadow:  0 4px 16px rgba(0,0,0,.5);
        box-shadow:  0 4px 16px rgba(0,0,0,.5);
      /*  margin-left: 105px;
        margin-right: 105px;*/
    }
    .package-video {
        width: 104.5% !important;
        margin-left: -2.2%;
    }
    .packages-detail {
        padding-bottom: 17px;
    }
    .titlebg {
        background: rgba(157, 187, 63, 0.85);
        padding: 3.5% 0 2.5% 0;
        font-size: 20px;
        font-family: 'Roboto Condensed', sans-serif;
        text-transform: uppercase;
        color: white;
        margin-bottom: 20px;
        margin-left: -2.3%;
        margin-right: -2.3%;

    }
    @media (max-width: 999px) {
        .packages-detail {
            box-shadow: none;
            padding: 0 !important;
            margin: 0 !important;

        }
    }

    .titlebg {
        background: rgb(125, 194, 15);
        padding: 3.5% 0 2.5% 0;
        font-size: 20px;
        font-family: 'Roboto Condensed', sans-serif;
        text-transform: uppercase;
        color: white;
        margin-left: -2.3%;
        margin-right: -2.3%;
        margin-bottom: 20px;

    }
 .firstl:first-letter {
     margin-top: 0.65rem;
     margin-right: 1rem;
     float: left;
     padding: 12px 24px;
     color: #ffffff;
     background-color: #7ec211;
     font-size: 7rem;
     font-weight: 700;
     line-height: 7rem;
 }

    ol.simlist {
        list-style-type: none;
        list-style-type: decimal !ie; /*IE 7- hack*/

        margin: 0;
        margin-left: 1em;
        padding: 0;

        counter-reset: li-counter;
    }
    ol.simlist > li{
        position: relative;
        margin-bottom:  0.5em;
        padding: 1.5em;
        background-color: #eaeaea;
    }
    ol.simlist > li:before {
        position: absolute;
        top: 0em;
        left: -1.393em;
        width: 1.8em;
        height: 1.2em;
box-shadow: 0 4px 6px rgba(0,0,0,.5);
        font-size: 2em;
        line-height: 1.2;
        font-weight: bold;
        text-align: center;
        color: #ffffff;
        background-color: #7ec211;


        z-index: 1;
        overflow: hidden;

        content: counter(li-counter);
        counter-increment: li-counter;
    }
    ul.simlist {
        list-style-type: none;
        list-style-type: decimal !ie; /*IE 7- hack*/

        margin: 0;
        margin-left: 1em;
        padding: 0;

        counter-reset: li-counter;
    }
    ul.simlist > li{
        position: relative;
        margin-bottom:  0.5em;
        padding: 1.5em;
        background-color: #eaeaea;
    }
    ul.simlist > li:before {
        position: absolute;
        top: 0em;
        left: -1.393em;
        width: 1.8em;
        height: 1.2em;
        box-shadow: 0 4px 6px rgba(0,0,0,.5);
        font-size: 2em;
        line-height: 1.2;
        font-weight: bold;
        text-align: center;
        color: #ffffff;
        background-color: #7ec211;


        z-index: 1;
        overflow: hidden;
        font-family: FontAwesome;
        content: '\f00c';
        counter-increment: li-counter;
    }

    .packages-detail .table-fill {
        background: white;
        border-radius:3px;
        border-collapse: collapse;
        height: 320px;
        border-top: 1px solid #dbe6ee;
        margin-top: -3%;
        margin-left: -2.233%;
        padding:5px;
        width: 104.6%;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        animation: float 5s infinite;
    }

    .packages-detail th {
        color:#D5DDE5;;
        background:#1b1e24;
        border-bottom:4px solid #9ea7af;
        border-right: 1px solid #343a45;
        font-size:23px;
        font-weight: 100;
        padding:24px;
        text-align:left;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        vertical-align:middle;
    }

    .packages-detail th:first-child {
        border-top-left-radius:3px;
    }

    .packages-detail th:last-child {
        border-top-right-radius:3px;
        border-right:none;
    }

    .packages-detail tr {
        border-top: 1px solid #C1C3D1;
        border-bottom-: 1px solid #C1C3D1;
        color:#666B85;
        font-size:16px;
        font-weight:normal;
        text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);
    }

    .packages-detail tr:hover td {
        background:#7dc20f;
        color:#FFFFFF;

    }

    .packages-detail tr:first-child {
        border-top:none;
    }

    .packages-detail tr:last-child {
        border-bottom:none;
    }

    .packages-detail tr:nth-child(odd) td {
        background:#EBEBEB;
    }

    .packages-detail tr:nth-child(odd):hover td {
        background:#7dc20f;
    }

    .packages-detail tr:last-child td:first-child {
        border-bottom-left-radius:3px;
    }

    .packages-detail tr:last-child td:last-child {
        border-bottom-right-radius:3px;
    }

    .packages-detail td {
        background:#FFFFFF;
        padding:20px;
        text-align:left;
        vertical-align:middle;
        font-weight:300;
        font-size:18px;
        text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
        border-right: 1px solid #C1C3D1;
    }

    .packages-detail td:last-child {
        border-right: 0px;
    }

    .packages-detail th.text-left {
        text-align: left;
    }

    .packages-detail th.text-center {
        text-align: center;
    }

    .packages-detail th.text-right {
        text-align: right;
    }

    .packages-detail td.text-left {
        text-align: left;
    }

    .packages-detail td.text-center {
        text-align: center;
    }

    .packages-detail td.text-right {
        text-align: right;
    }
    .vertical-menu {
        width: 200px;
    }

    .vertical-menu a {
        background-color: #eee;
        color: black;
        display: block;
        padding: 12px;
        text-decoration: none;
    }

    .vertical-menu a:hover {
        background-color: #ccc;
    }

    .vertical-menu a.active {
        background-color: #4CAF50;
        color: white;
    }

    #toggle {
        display: block;
        width: 28px;
        height: 30px;
        margin: 30px auto 10px;
    }

    #toggle span:after,
    #toggle span:before {
        content: "";
        position: absolute;
        left: 0;
        top: -9px;
    }
    #toggle span:after{
        top: 9px;
    }
    #toggle span {
        position: relative;
        display: block;
    }

    #toggle span,
    #toggle span:after,
    #toggle span:before {
        width: 100%;
        height: 5px;
        background-color: #888;
        transition: all 0.3s;
        backface-visibility: hidden;
        border-radius: 2px;
    }

    /* on activation */
    #toggle.on span {
        background-color: transparent;
    }
    #toggle.on span:before {
        transform: rotate(45deg) translate(5px, 5px);
    }
    #toggle.on span:after {
        transform: rotate(-45deg) translate(7px, -8px);
    }
    #toggle.on + #menu {
        opacity: 1;
        visibility: visible;
    }

    /* menu appearance
    #menu {
        position: relative;
        color: #999;
        width: 200px;

        margin: auto;
        font-family: "Segoe UI", Candara, "Bitstream Vera Sans", "DejaVu Sans", "Bitstream Vera Sans", "Trebuchet MS", Verdana, "Verdana Ref", sans-serif;
        text-align: center;
        border-radius: 4px;
        background: white;
        box-shadow: 0 1px 8px rgba(0,0,0,0.05);

        opacity: 0;
        visibility: hidden;
        transition: opacity .4s;
    }
    #menu:after {
        position: absolute;
        top: -15px;
        left: 95px;
        content: "";
        display: block;
        border-left: 15px solid transparent;
        border-right: 15px solid transparent;
        border-bottom: 20px solid white;
    }
    #menu ul, li, li a {
        list-style: none;
        display: block;
        margin: 0;
        padding: 0;
    }
    #menu li a {
        padding: 5px;
        color: #888;
        text-decoration: none;
        transition: all .2s;
    }
    #menu li a:hover,
    #menu li a:focus {
        background: #1ABC9C;
        color: #fff;
    } */
    .wrap {
        overflow: hidden;
    }

    .carousel {
        display: flex;
        left: -100%;
        list-style: none;
        margin: 0;
        padding: 0;
        position: relative;
        transform: translateX(100%);
    }
    @media (min-width: 30em) {
        .carousel {
            left: -50%;
            transform: translateX(50%);
        }
    }
    @media (min-width: 40em) {
        .carousel {
            left: -33.33333%;
            transform: translateX(33.33333%);
        }
    }

    .carousel.is-reversing {
        transform: translateX(-100%);
    }
    @media (min-width: 30em) {
        .carousel.is-reversing {
            transform: translateX(-50%);
        }
    }
    @media (min-width: 40em) {
        .carousel.is-reversing {
            transform: translateX(-33.33333%);
        }
    }

    .carousel.is-set {
        transform: none;
        transition: transform 0.5s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .carousel-seat {
        background: #ddd;
        flex: 1 0 100%;
        order: 2;
    }
    .carousel-seat:nth-child(even) {
        background: #d5d5d5;
    }
    @media (min-width: 30em) {
        .carousel-seat {
            flex-basis: 50%;
        }
    }
    @media (min-width: 40em) {
        .carousel-seat {
            flex-basis: 33.33333%;
        }
    }

    .carousel-seat.is-ref {
        order: 1;
    }

    h2 {
        color: #aaa;
        font-size: 7em;
        font-weight: normal;
        margin: 0;
        padding: 0.6em 0;
        text-align: center;
    }

    .controls {
        padding: 2em;
        text-align: center;
    }
    .controls button {
        background: #aaa;
        border: 0;
        border-radius: 0.25em;
        color: #eee;
        padding: 0.5em 1em;
    }
    .controls button:hover, .controls button:focus {
        background: magenta;
    }
    .vertical-menu {
        width: 200px; /* Set a width if you like */
        position: absolute;
        left: 10px;
        -webkit-box-shadow:  0 4px 16px rgba(0,0,0,.5);
        -moz-box-shadow:  0 4px 16px rgba(0,0,0,.5);
        box-shadow:  0 4px 16px rgba(0,0,0,.5);
    }

    .vertical-menu a {
        background-color: #eee; /* Grey background color */
        color: black; /* Black text color */
        display: block; /* Make the links appear below each other */
        padding: 12px; /* Add some padding */
        text-decoration: none; /* Remove underline from links */
    }

    .vertical-menu a:hover {
        background-color: #ccc; /* Dark grey background on mouse-over */
    }

    .vertical-menu a.active {
        background-color: #4CAF50; /* Add a green color to the "active/current" link */
        color: white;
    }

    /****************/
    /*	 BX-SLIDER 	*/
    /****************/
    section.client {
        padding-top: 1em;
        text-align: center;
        background-color: #7ec211;

    }
   .slide a {
        font-family: Arial;
        font-size: large;
        color: #ffffff;
    }
    section.client .section-title {
        margin-bottom: 6em;
    }
    .bx-controls {
        position: relative;
    }
    .bx-wrapper .bx-pager {
        text-align: center;
        padding-top: 3px;
    }
    .bx-wrapper .bx-pager .bx-pager-item, .bx-wrapper .bx-controls-auto .bx-controls-auto-item {
        display: inline-block;
        *zoom: 1;
        *display: inline;
    }
    .bx-wrapper .bx-pager.bx-default-pager a {
        background: #ffffff;
        text-indent: -9999px;
        display: block;
        width: 10px;
        height: 10px;
        margin: 0 5px;
        outline: 0;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
    }
    @media (max-width: 1586px) {
        .vertical-menu {
            display: none !important;
        }
    }
    @media (max-width: 766px) {
       section.client {
            margin-bottom: 10px;
        }
    }
</style>

<section>
    <div class="block">
        <div class="vertical-menu">
            <a href="#" class="active">Home</a>
            <a href="#">Link 1</a>
            <a href="#">Link 2</a>
            <a href="#">Link 3</a>
            <a href="#">Link 4</a>
        </div>
        <div class="container">

            <!-- 1-block -->
            <div class="row">

                <div class="col-md-12">
                    <section class="client">
                        <div class="container">
                            <div class="row">
                                <div class="carousel-client">
                                    <?php foreach ($offersList as $itemList) : ?>
                                        <div class="slide"><h3><a href="#"><?=$itemList->title?></a></h3></div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="packages-detail">

                        <?php if (count($offers->photos) || !empty($offers->model->image)) : ?>

                        <div class="package-video">
                            <div>
                                <?php if (!empty($offers->model->image)) : ?>
                                    <?= Html::img(Image::thumb($offers->model->image, 1100, 300), ['width' => '100%', 'height' => '100%']) ?>
                                <? else: ?>
                                    <?= Html::img(Image::thumb($offers->photos[0]->image, 1100, 300), ['width' => '100%', 'height' => '100%']) ?>
                                <? endif ?>
                            </div>
                            <!-- <i class="fa fa-play-circle"></i>-->
                            <strong class="per-night"><span>$</span><?= $offers->price; ?> <i>Дней: <?= $offers->model->how_days; ?></i></strong>
                            <a href="#order-zone" class="book-btn2" title="">Заказать</a>
                            <!--<iframe src="https://www.youtube.com/embed/dVTsZZh54Do"></iframe>-->
                            <div class="title-video alignleft">
                                <h1><?= $offers->seo('h1', $offers->title) ?></h1>
                                <span><?= $offers->seo('h1', $offers->short) ?></span>
                            </div>
                        </div>
                        <?php endif; ?>

                        <p>
                            <?= $offers->text ?>
                        </p>

                        <script type="text/javascript"> /*          <div class="package-features" id="order-zone">
                            <!-- 2-block -->
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table">
                                        <tr>
                                            <td>Пакеты</td>
                                            <?php foreach ($packets as $packet) : ?>
                                                <td><?= $packet->title ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <?php foreach ($options as $option) : ?>
                                            <tr>
                                                <td>
                                                    <?= $option['title'] ?>
                                                </td>
                                                <?php foreach ($option['child'] as $opt) : ?>
                                                    <td><? if ($opt) : ?><i class="fa fa-check"
                                                                            aria-hidden="true"></i><? endif; ?></td>
                                                <?php endforeach; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td>Цены</td>
                                            <?php foreach ($packets as $packet) : ?>
                                                <td><span>$<?= $packet->price?></span></td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td>Заказ</td>
                                            <?php foreach ($packets as $packet) : ?>
                                                <td> <a class="btn btn-success bb" href="javascript:void( window.open( 'https://form.jotformeu.com/71136944138357', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )">Заказать</a></td>

                                            <?php endforeach; ?>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 60px;">
                                <div class="col-md-4">
                                    <div class="packageimg-gallery">
                                        <?php if (count($offers->photos)) : ?>
                                            <?php foreach ($offers->photos as $photo) : ?>
                                                <div class="packageimg-gallerythumb"><?= $photo->box(555, 483) ?></div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div> */  </script>
                    </div>
                    <!-- Blog List Posts -->
                </div>
            </div>

            <!-- 3-block -->
            <div class="row" style="margin-top: 80px;">
                <div class="col-md-12">
                    <p>
                        <?php foreach ($offers->tags as $tag) : ?>
                            <a href="<?= Url::to(['/offers', 'tag' => $tag]) ?>"
                               class="label label-info"><?= $tag ?></a>
                        <?php endforeach; ?>
                    </p>

<!--                    <div class="small-muted">Views: --><?//= $offers->views ?><!--</div>-->
                </div>
            </div>
        </div
>
    </div>
</section>
<!--
<div style="display:none">
    <div class="container-fluid" id="succes_packet">
        <form id="succes_packet_form" name="succes_packet_form" class="succes_packet_form" action="/admin/orders/send" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="row-fluid">
                        <div class="form-group">
                            <label for="firstName">ИМЯ</label>
                            <input name="Feedback[name]" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="form-group">
                            <label for="email">Е-МЕЙЛ</label>
                            <input name="Feedback[email]" class="form-control" type="email">
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="form-group">
                            <label for="password">ТЕЛЕФОН</label>
                            <input name="Feedback[phone]" class="form-control" type="text">
                        </div>
                    </div>


                </div>
                <div class="col-md-6">
                    <div class="row-fluid">
                        <div class="form-group">
                            <label for="password">ВАШ КОММЕНТАРИЙ</label><br/>
                            <textarea name="Feedback[comment]" class="form-control" rows="7"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="text-align: center;">
                    <hr>
                    <input id="top-save-button" type="submit" name="save" value="Подтвердить" class="btn btn-success regbutton" />
                </div>
            </div>
        </form>
    </div>
</div>
-->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.5/jquery.bxslider.js"></script>
<script>
 /*   var theToggle = document.getElementById('toggle');

    // based on Todd Motto functions
    // https://toddmotto.com/labs/reusable-js/

    // hasClass
    function hasClass(elem, className) {
        return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
    }
    // addClass
    function addClass(elem, className) {
        if (!hasClass(elem, className)) {
            elem.className += ' ' + className;
        }
    }
    // removeClass
    function removeClass(elem, className) {
        var newClass = ' ' + elem.className.replace( /[\t\r\n]/g, ' ') + ' ';
        if (hasClass(elem, className)) {
            while (newClass.indexOf(' ' + className + ' ') >= 0 ) {
                newClass = newClass.replace(' ' + className + ' ', ' ');
            }
            elem.className = newClass.replace(/^\s+|\s+$/g, '');
        }
    }
    // toggleClass
    function toggleClass(elem, className) {
        var newClass = ' ' + elem.className.replace( /[\t\r\n]/g, " " ) + ' ';
        if (hasClass(elem, className)) {
            while (newClass.indexOf(" " + className + " ") >= 0 ) {
                newClass = newClass.replace( " " + className + " " , " " );
            }
            elem.className = newClass.replace(/^\s+|\s+$/g, '');
        } else {
            elem.className += ' ' + className;
        }
    }

    theToggle.onclick = function() {
        toggleClass(this, 'on');
        return false;
    } */
 $('.carousel-client').bxSlider({
     auto: true,
     slideWidth: 234,
     minSlides: 2,
     maxSlides: 5,
     controls: false
 });
</script>