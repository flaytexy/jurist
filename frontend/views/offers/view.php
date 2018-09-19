<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\helpers\Image;

$this->title = $offers->seo('title', $offers->model->title);
$this->params['breadcrumbs'][] = ['label' => 'Компании', 'url' => ['offers/index']];
$this->params['breadcrumbs'][] = $offers->model->title;
?>

<style>
    .title-video h1 {
        color: white !important;
    }
    .packages-detail {
        padding-left: 25px !important;
        padding-right: 25px !important;
        -webkit-box-shadow:  0 4px 16px rgba(0,0,0,.5);
        -moz-box-shadow:  0 4px 16px rgba(0,0,0,.5);
        box-shadow:  0 4px 16px rgba(0,0,0,.5);
        background-color: #fff;
        display: inline-block;

    }
    .package-video {
        width: 104.5% !important;
        margin-left: -2.2%;
    }
    .packages-detail {
        padding-bottom: 17px;
    }

    @media (max-width: 999px) {
        .packages-detail {
            box-shadow: none;
            padding: 0 !important;
            margin: 0 !important;

        }
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
        padding: 8px;
        text-align:left;
        vertical-align:middle;
        font-weight:300;
        font-size:18px;
        text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
        border-right: 1px solid #C1C3D1;
    }

    .packages-detail td:last-child {
        border-right: 0;
    }
    .sidesidebar, .sidesidebar2 {
        position: absolute;
    }
    .sidesidebar2 {
        right:0;
        width: 260px;

    }
    .sidesidebar2 h2,
    .sidesidebar2 span,
    .sidesidebar h2,
    .sidesidebar span {
        padding: 5px;

    }
    .widget-gallery [href="/banks/sent-lusia"] {
        display: none;
    }

    .vertical-menu {
        width: 200px; /* Set a width if you like */
        position: relative;
        margin-bottom: 50px;
        -webkit-box-shadow:  0 4px 16px rgba(0,0,0,.5);
        -moz-box-shadow:  0 4px 16px rgba(0,0,0,.5);
        box-shadow:  0 4px 16px rgba(0,0,0,.5);
    }
    .vertical-menu-widget {
        width: 280px; /* Set a width if you like */
        position: relative;
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

    .vertical-menu .active   {
        background-color: #3a3a3a; /* Add a green color to the "active/current" link */
        color: white;
    }
    .widget {
        -webkit-box-shadow:  0 4px 16px rgba(0,0,0,.5);
        -moz-box-shadow:  0 4px 16px rgba(0,0,0,.5);
        box-shadow:  0 4px 16px rgba(0,0,0,.5);
    }

    .widget-gallery span {
        bottom: 10px !important;
        top: unset !important;
    }
    .widget-gallery li:before {
       content: "";
       position:absolute;
       width: 100%;
       height: 100%;
       background: rgb(0,0,0);
        opacity: 0.6;
   }

    #dottedbord img {
        border: 3px solid;
        border-color: #2e2e2e;
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
        font-family: Arial, sans-serif;
        font-size: large;
        color: #ffffff;
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
.client {
    width: 104.5% !important;
    margin-left: -2.2%;
}
    @media (max-width: 1800px) {

        .packages-detail {
            max-width: 80%;
            margin: auto;
            margin-left: 105px;

        }

    }
    @media (max-width: 1488px) {
            .sidesidebar, .sidesidebar2 {
                display: none !important;
            }
        .packages-detail {
            margin: 0 !important;
            max-width: none;
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
        <div class="sidesidebar">
        <div class="vertical-menu">
            <a href="#" class="active"><?= Yii::t('easyii', 'juris') ?></a>
            <?php foreach ($offersList as $itemList) : ?>
                <a href="<?= Url::to(['offers/'.$itemList->slug]) ?>"><?=$itemList->title?> <b>€<?= $itemList->model->price ?></b></a>
            <?php endforeach; ?>
        </div>
        <div class="vertical-menu-widget">
            <div class="widget recent-posts-widget">
                <div class="title1 style2">
                    <h2><?= Yii::t('easyii', 'articles') ?> </h2>
                    <span><?= Yii::t('easyii', 'popularNews') ?> </span>
                </div>
                <div class="recent-posts">
                    <?php foreach($top_news as $item) : ?>
                        <div class="recent-post">
                            <?= Html::img(\frontend\helpers\Image::thumb($item->image, 90, 90)) ?>
                            <h4><a href="<?= Url::to(['news/'.$item->slug]) ?>"><?= $item->title ?></a></h4>
                            <span><i class="fa fa-calendar"></i> <?= $item->date ?></span>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div><!-- Widget -->
        </div>
        </div>
        <div class="sidesidebar2">

                <div class="widget villa-photos-widget">
                    <div class="title1 style2">
                        <h2><?= Yii::t('easyii', 'goodPropositions') ?></h2>
                        <span><?= Yii::t('easyii', 'interestingCountries') ?></span>
                    </div>
                    <ul class="widget-gallery">
                        <?php foreach($top_offers as $item) : ?>
                            <li><a href="<?= Url::to(['offers/'.$item['slug']]) ?>">
                                    <?= Html::img(\frontend\helpers\Image::thumb($item['image'], 300, 200)) ?>
                                </a>
                                <span><a href="<?= Url::to(['offers/'.$item['slug']]) ?>"><?= $item['title'] ?><br><b>€<?= $item['price'] ?> / <?= Yii::t('easyii', 'days') ?>: <?= $item['how_days']?></b></a></span></li>
                        <?php endforeach; ?>

                    </ul>
                </div><!-- Widget -->

            <!-- Widget2 -->
            <div class="widget villa-photos-widget">
                <div class="title1 style2">
                    <h2>Банки</h2>
                    <span>Лучшие банковские условия</span>
                </div>
                <ul class="widget-gallery" id="dottedbord">
                    <?php foreach($top_banks as $item) : ?>
                        <li><a href="<?= Url::to(['banks/'.$item['slug']]) ?>">
                                <?= Html::img(\frontend\helpers\Image::thumb($item['image'], 300, 200)) ?>
                            </a>
                            <span><a href="<?= Url::to(['banks/'.$item['slug']]) ?>"><?= $item['title'] ?></a></span> </li>
                    <?php endforeach; ?>

                </ul>
            </div><!-- Widget2 -->
        </div>
        <div class="container">

            <!-- 1-block -->
            <div class="row">

                <div class="col-md-12">

                    <div class="packages-detail">
                        <section class="client">
                            <div class="container">
                                <div class="row">
                                    <div class="carousel-client">
                                        <?php foreach ($offersList as $itemList) : ?>
                                            <div class="slide"><h3><a href="<?= Url::to(['offers/'.$itemList->slug]) ?>"><?=$itemList->title?><br><b>€<?= $itemList->model->price ?></b></a></h3></div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </section>
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
                            <strong class="per-night" style="font-family: Arial"><span>€</span><?= $offers->price; ?> <i><?= Yii::t('easyii', 'days') ?>: <?= $offers->model->how_days; ?></i></strong>
                            <a href="javascript:void( window.open( 'https://form.jotformeu.com/71136944138357', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )" class="book-btn2" title=""><?= Yii::t('easyii', '10') ?></a>

                            <div class="title-video alignleft">
                                <h1><?= $offers->seo('h1', $offers->title) ?></h1>
                                <span><?= $offers->seo('h1', $offers->short) ?></span>
                            </div>
                        </div>
                        <?php endif; ?>

                        <p>
                            <?= $offers->text ?>
                        </p>

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
                </div>
            </div>
        </div>

    </div>

</section>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.5/jquery.bxslider.js"></script>
<script>
 $('.carousel-client').bxSlider({
     auto: true,
     slideWidth: 234,
     minSlides: 2,
     maxSlides: 5,
     controls: false
 });
</script>