<?php
use frontend\modules\offers\api\Offers;
use frontend\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\MapsAsset;

MapsAsset::register($this);
$page = Page::get('page-offers');

if(!empty($page)) $this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;

?>

<div class="container">
    <h1><?= $page->seo('h1', $page->title) ?></h1>
    <div><?= $page->seo('div', $page->text) ?></div>
</div>

<script type="application/javascript">
    var myMarker = <?= $markers; ?>;
    var mapType = "<?= $mapType; ?>";
</script>

<?php /*foreach($offers as $item) : ?>
    <div class="row">
        <div class="col-md-2">
            <?= Html::img($item->thumb(160, 120)) ?>
        </div>
        <div class="col-md-10">
            <?= Html::a($item->title, ['offers/view', 'slug' => $item->slug]) ?>
            <div class="small-muted"><?= $item->date ?></div>
            <p><?= $item->short ?></p>
            <p>
                <?php foreach($item->tags as $tag) : ?>
                    <a href="<?= Url::to(['/offers', 'tag' => $tag]) ?>" class="label label-info"><?= $tag ?></a>
                <?php endforeach; ?>
            </p>
        </div>
    </div>
    <br>
<?php endforeach; ?>

<?= Offers::pages() */ ?>

<section id="world-map-markers-block">
    <div class="row">
        <div class="col-md-12 hidden-xs">
            <article class="format-standard">
                <figure>
                    <div id="world-map-markers" style="margin:0 auto; width: 1020px; height: 400px"></div>
                </figure>
            </article>
        </div>
    </div>
</section>

<!-- НОВЫЙ СПИСОК -->
<style>
    /*author MARY LOU */
    /* COMPONENTS */

    .box {
        width: 300px;
        height: 460px;
        position: relative;
        background: rgba(255,255,255,1);
        display: inline-block;
        margin: 10px 10px;
        cursor: pointer;
        color: #2c3e50;
        box-shadow: inset 0 0 0 3px #2c3e50;
        -webkit-transition: background 0.4s 0.5s;
        transition: background 0.4s 0.5s;
    }

    .box img {

        width: 100%;
        padding-bottom: 50px;
    }
    .box:hover {
        background: rgba(255,255,255,0);
        -webkit-transition-delay: 0s;
        transition-delay: 0s;
    }

    .box h3 {

        font-size: 20px;

        margin: 0;
        font-weight: 400;
        width: 100%;
    }


    .box span {
        display: block;
        font-weight: 400;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 13px;
        padding: 5px;
    }

    .box h3,

    .box span {
        -webkit-transition: color 0.4s 0.5s;
        transition: color 0.4s 0.5s;
        color: #7bbf0f;
    }


    .box:hover h3,
    .box:hover a,
    .box:hover span {
        color: #fff;
        -webkit-transition-delay: 0s;
        transition-delay: 0s;
    }

    .box svg {
        position: absolute;
        top: 0;
        left: 0;
    }

    .box svg line {
        stroke-width: 3;
        stroke: #7bbf0f;
        fill: none;
        -webkit-transition: all .8s ease-in-out;
        transition: all .8s ease-in-out;
    }

    .box:hover svg line {
        -webkit-transition-delay: 0.1s;
        transition-delay: 0.1s;
    }

    .box svg line.top,
    .box svg line.bottom {
        stroke-dasharray: 330 240;
    }

    .box svg line.left,
    .box svg line.right {
        stroke-dasharray: 490 400;
    }

    .box:hover svg line.top {
        -webkit-transform: translateX(-600px);
        transform: translateX(-600px);
    }

    .box:hover svg line.bottom {
        -webkit-transform: translateX(600px);
        transform: translateX(600px);
    }

    .box:hover svg line.left {
        -webkit-transform: translateY(920px);
        transform: translateY(920px);
    }

    .box:hover svg line.right {
        -webkit-transform: translateY(-920px);
        transform: translateY(-920px);
    }

    /* Alternatives */



    /* Frame */
    .Gio-98 .box {
        background: rgba(0,0,0,0);
        color: #fff;
        box-shadow: none;
        -webkit-transition: background 0.3s;
        transition: background 0.3s;
    }

    .Gio-98 .box:hover {
        background: rgba(123, 191, 15, 0.4);
    }

    .Gio-98 .box h3,
    .Gio-98 .box span {
        -webkit-transition: none;
        transition: none;
    }

    .Gio-98 .box svg line {
        -webkit-transition: all .5s;
        transition: all .5s;
    }

    .Gio-98 .box:hover svg line {
        stroke-width: 10;
        -webkit-transition-delay: 0s;
        transition-delay: 0s;
    }

    .Gio-98 .box:hover svg line.top {
        -webkit-transform: translateX(-300px);
        transform: translateX(-300px);
    }

    .Gio-98 .box:hover svg line.bottom {
        -webkit-transform: translateX(300px);
        transform: translateX(300px);
    }

    .Gio-98 .box:hover svg line.left {
        -webkit-transform: translateY(460px);
        transform: translateY(460px);
    }

    .Gio-98 .box:hover svg line.right {
        -webkit-transform: translateY(-460px);
        transform: translateY(-460px);
    }

    /* COMPONENTS */

    /* CSS */
    @import url(http://fonts.googleapis.com/css?family=Lato:300,400,700|Ruthie);
    @font-face {
        font-weight: normal;
        font-style: normal;
        font-family: 'Gioicons';
        src:url('http://disantimonia.pixub.com/codepen/codropsicons/Gioicons.eot');
        src:url('http://disantimonia.pixub.com/codepen/codropsicons/Gioicons.eot?#iefix') format('embedded-opentype'),
        url('http://disantimonia.pixub.com/codepen/codropsicons/Gioicons.woff') format('woff'),
        url('http://disantimonia.pixub.com/codepen/codropsicons/Gioicons.ttf') format('truetype'),
        url('http://disantimonia.pixub.com/codepen/codropsicons/Gioicons.svg#Gioicons') format('svg');
    }

    *, *:after, *:before { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; }
    .clearfix:before, .clearfix:after { content: ''; display: table; }
    .clearfix:after { clear: both; }

    body {

        color: #ecf0f1;
        font-size: 100%;
        line-height: 1.25;
        font-family: 'Lato', Arial, sans-serif;
    }

    a {
        color: #95a5a6;
        text-decoration: none;
        outline: none;
    }

    a:hover, a:focus {
        color: #fff;
    }

    .Gio-header {
        margin: 0 auto;
        padding: 2em;
        text-align: center;
    }

    .Gio-header h1 {
        margin: 0;
        font-weight: 300;
        font-size: 2.5em;
    }

    .Gio-header h1 span {
        display: block;
        padding: 0 0 0.6em 0.1em;
        font-size: 0.6em;
        opacity: 0.7;
    }

    /* To Navigation Style */
    .Gio-top {
        width: 100%;
        text-transform: uppercase;
        font-weight: 700;
        font-size: 0.69em;
        line-height: 2.2;
    }

    .Gio-top a {
        display: inline-block;
        padding: 0 1em;
        text-decoration: none;
        letter-spacing: 1px;
    }

    .Gio-top span.right {
        float: right;
    }

    .Gio-top span.right a {
        display: block;
        float: left;
    }

    .Gio-icon:before {
        margin: 0 4px;
        text-transform: none;
        font-weight: normal;
        font-style: normal;
        font-variant: normal;
        font-family: 'Gioicons';
        line-height: 1;
        speak: none;
        -webkit-font-smoothing: antialiased;
    }

    .Gio-icon-drop:before {
        content: "\e001";
    }

    .Gio-icon-prev:before {
        content: "\e004";
    }

    #juust section {
        padding: 4em 2em;
        text-align: center;
    }

     #juust section h2 {
        font-weight: 300;
        font-size: 2em;
        padding: 1em 0;
    }

    .Gio-header + section {
        padding-top: 1.5em;
    }

    .related p {
        font-size: 1.5em;
    }

    .related > a {
        background: rgba(0,0,0,0.05);
        display: inline-block;
        text-align: center;
        margin: 20px 10px;
        padding: 25px;
        -webkit-transition: color 0.3s, background-color 0.3s;
        transition: color 0.3s, background-color 0.3s;
    }

    .related a:hover {
        background-color: rgba(0,0,0,0.4);
    }

    .related a img {
        max-width: 100%;
        opacity: 0.8;
        -webkit-transition: opacity 0.3s;
        transition: opacity 0.3s;
    }

    .related a:hover img,
    .related a:active img {
        opacity: 1;
    }

    .related a h3 {
        margin: 0;
        padding: 0.5em 0 0.3em;
        max-width: 300px;
        text-align: left;
    }

    @media screen and (max-width: 25em) {

        .Gio-icon span {
            display: none;
        }

    }
    /* CSS */

    /* NORMALIZE */
    article,aside,details,figcaption,figure,footer,header,hgroup,main,nav,section,summary{display:block;}audio,canvas,video{display:inline-block;}audio:not([controls]){display:none;height:0;}[hidden]{display:none;}html{font-family:sans-serif;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;}body{margin:0;}a:focus{outline:thin dotted;}a:active,a:hover{outline:0;}h1{font-size:2em;margin:0.67em 0;}abbr[title]{border-bottom:1px dotted;}b,strong{font-weight:bold;}dfn{font-style:italic;}hr{-moz-box-sizing:content-box;box-sizing:content-box;height:0;}mark{background:#ff0;color:#000;}code,kbd,pre,samp{font-family:monospace,serif;font-size:1em;}pre{white-space:pre-wrap;}q{quotes:"\201C" "\201D" "\2018" "\2019";}small{font-size:80%;}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline;}sup{top:-0.5em;}sub{bottom:-0.25em;}img{border:0;}svg:not(:root){overflow:hidden;}figure{margin:0;}fieldset{border:1px solid #c0c0c0;margin:0 2px;padding:0.35em 0.625em 0.75em;}legend{border:0;padding:0;}button,input,select,textarea{font-family:inherit;font-size:100%;margin:0;}button,input{line-height:normal;}button,select{text-transform:none;}button,html input[type="button"],input[type="reset"],input[type="submit"]{-webkit-appearance:button;cursor:pointer;}button[disabled],html input[disabled]{cursor:default;}input[type="checkbox"],input[type="radio"]{box-sizing:border-box;padding:0;}input[type="search"]{-webkit-appearance:textfield;-moz-box-sizing:content-box;-webkit-box-sizing:content-box;box-sizing:content-box;}input[type="search"]::-webkit-search-cancel-button,input[type="search"]::-webkit-search-decoration{-webkit-appearance:none;}button::-moz-focus-inner,input::-moz-focus-inner{border:0;padding:0;}textarea{overflow:auto;vertical-align:top;}table{border-collapse:collapse;border-spacing:0;}
    /* NORMALIZE */
</style>

<section id="offers">
    <div class="block">
        <div class="container">
            <nav id="menus" class="navbar">
<!--                <div class="navbar-header"><span id="category" class="visible-xs">Перечень офшоров</span>-->
<!--                    <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse"-->
<!--                            data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>-->
<!--                </div>-->
                <!--  offers -->
                <style>
                    #offers-menu-block a {
                       background-color: rgba(121,188,14,0.3);


                    }
                    #offers-menu-block a:hover {
                        background: none ;


                    }
                </style>




                <div class="">
                    <ul class="nav" id="offers-menu-block">
                        <?php foreach ($offers as $item) : ?>
                            <? if($region_name != $item->model->region_name  /*&&  $item->model->region_name!=false*/ ): ?>
                                <?php $region_name = $item->model->region_name; ?>
                                <li  style="clear: left" class='h5 ' id="reg_<?= $item->model->region_id ?>"><?= $region_name ?></li>
                            <? endif ?>
                            <li class="sidelines" style="margin-top: 10px; float: left;"><a href="<?= Url::to(['offers/'.$item->slug]) ?>"  data-show-block="b_<?= $item->id ?>"><?= $item->title ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </nav>
            <div id="menu-show-block-zone" class="" style="display: none; ">
                <?php foreach ($offers as $item) : ?>
                    <div id="b_<?= $item->id ?>" class="block-zone row" style="display: none;">
                        <div class="col-md-4">
                            <div class="package-thumb">
                                <a href="<?= Url::to(['offers/'.$item->slug]) ?>" class="label label-info">
                                    <?= Html::img($item->thumbFile($item->image, 500, 375), array('class' => 'sadsa')) ?>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <span><b><?= $item->title ?></b></span>
                            <?= $item->short ?>

                            <ul>
                                <?php foreach ($item->properties as $prop) : ?>
                                    <li>
                                        <?= $prop->name ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <div class="btn abtn">
                                <?= Html::a('Подробнее', ['offers/view', 'slug' => $item->slug], ['class'=>'btn btn-default']) ?>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>


        <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="villaeditors-picks offers-list">
                        <div class="packages style2 remove-ext2">
                            <div class="row">
                                <?php foreach ($offers as $item) : ?>
                                    <div class="col-md-4">
                                        <div class="package">
                                            <a href="<?= Url::to(['offers/'.$item->slug]) ?>">
                                                <div class="package-thumb">
                                                    <?= Html::img($item->thumb(500, 375)) ?>
                                                    <span><i>$<?= $item->model->price ?></i> / <? if ($item->model->how_days): ?><?= $item->model->how_days?> дней<? else: ?>Минимал<? endif; ?></span>
                                                </div>
                                            </a>
                                            <div class="package-detail">
                                                <!— <span class="cate">
<?php /*foreach ($item->tags as $tag) : */?>
                                                    <a href="<?/*= Url::to(['/offers', 'tag' => $tag]) */?>"
                                                       class="label label-info"><?/*= $tag */?></a>
                                                    <?php /*endforeach; */?>
</span>-->
                                                <h4><?= Html::a($item->title, ['offers/view', 'slug' => $item->slug]) ?></h4>
                                                <ul class="location-book">
                                                    <li class="active"><i class="fa fa-info"></i>
                                                        <span style="font-size: 15px; font-family: arial" class="blacklink" ><a href="<?= Url::to(['offers/'.$item->slug]) ?>">Подробнее</a></span></li>
                                                    <li class="book-btn"><i class="fa fa-shopping-basket"></i>
                                                        <a href="javascript:void( window.open( 'https://form.jotformeu.com/71136944138357', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )">Заказать</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <!-- Villa Editors Picks -->
                    <div id="pagination">
                        <div><?= Offers::pages() ?></div>
                    </div>
                    <!-- Pagination -->
                </div>
            </div>
        </div>
            </div>

</section>
