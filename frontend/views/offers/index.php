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
    #myInput {
        background-image: url('/css/searchicon.png'); /* Add a search icon to input */
        background-position: 10px 12px; /* Position the search icon */
        background-repeat: no-repeat; /* Do not repeat the icon image */
        width: 100%; /* Full-width */
        font-size: 16px; /* Increase font-size */
        padding: 12px 20px 12px 40px; /* Add some padding */
        border: 1px solid #ddd; /* Add a grey border */
        margin-bottom: 12px; /* Add some space below the input */
    }

    #myUL {
        /* Remove default list styling */
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    #myUL li a {
        border: 1px solid #ddd; /* Add a border to all links */
        margin-top: -1px; /* Prevent double borders */
        background-color: #f6f6f6; /* Grey background color */
        padding: 8px 6px; /* Add some padding */
        text-decoration: none; /* Remove default text underline */
        font-size: 18px; /* Increase the font-size */
        color: black; /* Add a black text color */
        display: block; /* Make it into a block element to fill the whole list */
    }
    #myUL li a > b, #myUL li a > span {
        font-size: 15px;
    }

    #myUL li a.header {
        background-color: rgba(0, 0, 0, 0.68); /* Add a darker background color for headers */
        cursor: default; /* Change cursor style */
        color: aliceblue;
    }

    #myUL li a:hover:not(.header) {
        background-color: #eee; /* Add a hover effect to all links, except for headers */
    }
</style>

<section id="offers" class="top30">
    <div class="">
        <div class="col-md-3">
            <nav id="menus" class="navbar">
                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Поиск юрисдикции..">

                <ul id="myUL" class="off-ul">
                    <?php foreach ($offers as $item) : ?><? if($region_name != $item->model->region_name  /*&&  $item->model->region_name!=false*/ ): ?>
                    <?php $region_name = $item->model->region_name; ?>
                    <li  id="reg_<?= $item->model->region_id ?>"><a href="#" class="header"><?= $region_name ?></a></li><? endif ?>
                    <li><a href="<?= Url::to(['offers/'.$item->slug]) ?>"  data-show-block="b_<?= $item->id ?>"><?= $item->title ?> / <span>€<?= $item->model->price ?> / Дней: <?= $item->model->how_days?></span></a></li>
                    <?php endforeach; ?>
                </ul>

                <div class="">
                    <ul class="nav" id="offers-menu-block">

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

                             <a id="autoclicking" href="<?= Url::to(['offers/view', 'slug' => $item->slug]) ?>"><button>Подробнее</button></a>
                            </div>
                            <!--['class'=>'btn btn-default']-->

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-md-9">
            <div class="">
                    <div class="villaeditors-picks offers-list">
                        <div class="packages style2 remove-ext2">
                            <div class="row">
                                <?php foreach ($offersPerPage as $item) : ?>
                                    <div class="col-md-4">
                                        <div class="package">

                                            <a href="<?= Url::to(['offers/'.$item->slug]) ?>">
                                                <div class="package-thumb">
                                                    <?= Html::img($item->thumb(500, 375)) ?>
                                                    <span style="font-family: Arial; font-stretch: extra-condensed"><i>€<?= $item->model->price ?></i><b> / <? if ($item->model->how_days): ?>Дней: <?= $item->model->how_days?><? else: ?>Минимал<? endif; ?></b></span>
                                                </div>
                                            </a>
                                            <div class="package-detail">
                                                <h4><?= Html::a($item->title, ['offers/view', 'slug' => $item->slug]) ?></h4>
                                                <ul class="location-book">
                                                    <li class="book-btn"><i class="fa fa-info"></i>
                                                       <a href="<?= Url::to(['offers/'.$item->slug]) ?>">Подробнее</a></li>
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
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    function myFunction() {
        // Declare variables
        var input, filter, ul, li, a, i;
        input = document.getElementById('myInput');
        filter = input.value.toUpperCase();
        ul = document.getElementById("myUL");
        li = ul.getElementsByTagName('li');

        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }
</script>