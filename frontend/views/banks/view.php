<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\helpers\Image;

$this->title = !empty($page->seo('title', $page->model->title)) ? $page->seo('title', $page->model->title) : '';
if($descriptionSeo = !empty($page->seo('description')) ? $page->seo('description') : ''){
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $descriptionSeo,
    ]);
}
if($keywordsSeo = !empty($page->seo('keywords')) ? $page->seo('keywords') : ''){
    $this->registerMetaTag([
        'name' => 'keywords',
        'content' => $keywordsSeo,
    ]);
}

$this->params['breadcrumbs'][] = ['label' => 'Banks', 'url' => ['banks/index']];
$this->params['breadcrumbs'][] = $page->model->title;
?>
<style>
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
        .bx-wrapper {
            max-width: 950px !important;
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
        .bx-wrapper {
            max-width: 1170px !important;
        }

    }
    @media (max-width: 766px) {
        section.client {
            margin-bottom: 10px;
        }
    }
    .ribbon-wrapper {
        width: 85px;
        height: 88px;
        overflow: hidden;
        position: absolute;
        top: -3px;
        left: -4px;
    }


    .ribbon {
        font: bold 15px Sans-Serif;
        color: #ffffff;
        text-align: center;
        text-shadow: rgba(255,255,255,0.5) 0px 1px 0px;
        -webkit-transform: rotate(-45deg);
        -moz-transform:    rotate(-45deg);
        -ms-transform:     rotate(-45deg);
        -o-transform:      rotate(-45deg);
        position: relative;
        padding: 7px 0;
        left: -30px;
        top: 13px;
        width: 120px;
        background: #7dc20f;
        -webkit-box-shadow: 0px 0px 3px rgba(0,0,0,0.3);
        -moz-box-shadow:    0px 0px 3px rgba(0,0,0,0.3);
        box-shadow:         0px 0px 3px rgba(0,0,0,0.3);
    }

    .ribbon:before, .ribbon:after {
        content: "";
        border-top:   3px solid #6e8900;
        border-left:  3px solid transparent;
        border-right: 3px solid transparent;
        position:absolute;
        bottom: -3px;
    }

    .ribbon:before {
        left: 0;
    }
    .ribbon:after {
        right: 0;
    }
</style>


<section>
    <div class="block">
        <div class="sidesidebar">
            <div class="vertical-menu">
                <a href="#" class="active">Банки</a>
                <?php foreach ($banksPist as $itemList) : ?>
                    <a href="<?= Url::to(['banks/'.$itemList->slug]) ?>"><?=$itemList->title?> <b>€<?= $itemList->model->price ?></b></a>
                <?php endforeach; ?>
            </div>
            <div class="vertical-menu-widget">
                <div class="widget recent-posts-widget">
                    <div class="title1 style2">
                        <h2>Интересные статьи</h2>
                        <span>Популярные новости</span>
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
                    <h2>Хорошие предложения</h2>
                    <span>Интересные страны для бизнеса</span>
                </div>
                <ul class="widget-gallery">
                    <?php foreach($top_offers as $item) : ?>
                        <li><a href="<?= Url::to(['offers/'.$item['slug']]) ?>">
                                <?= Html::img(\frontend\helpers\Image::thumb($item['image'], 300, 200)) ?>
                            </a>
                            <span><a href="<?= Url::to(['offers/'.$item['slug']]) ?>"><?= $item['title'] ?><br><b>€<?= $item['price'] ?> / Дней: <?= $item['how_days']?></b></a></span></li>
                    <?php endforeach; ?>

                </ul>
            </div><!-- Widget -->

            <!-- Widget2 -->
            <div class="widget villa-photos-widget">
                <div class="title1 style2">
                    <h2>Банки</h2>
                    <span>Лучшие банковские условия</span>
                </div>
                <ul class="widget-gallery">
                    <?php foreach($top_banks as $item) : ?>
                        <li><a href="<?= Url::to(['banks/'.$item['slug']]) ?>">
                                <?= Html::img(Image::thumb($item['image'], 240, 180)) ?>
                            </a>
                            <span><a href="<?= Url::to(['banks/'.$item['slug']]) ?>"><?= $item['title'] ?></a></span> </li>
                    <?php endforeach; ?>

                </ul>
            </div>
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
                                        <?php foreach ($banksPist as $itemList) : ?>
                                            <div class="slide"><h3><a href="<?= Url::to(['banks/'.$itemList->slug]) ?>"><?=$itemList->title?><br><b>€<?= $itemList->model->price ?></b></a></h3></div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <?php if (count($page->photos) || !empty($page->model->image)) : ?>
                            <div class="package-video">
                                <div>
                                    <?php if (!empty($page->model->image)) : ?>
                                        <?= Html::img(Image::thumb($page->model->image, 1200, 300), ['width' => '100%', 'height' => '100%']) ?>
                                    <? else: ?>
                                        <?= Html::img(Image::thumb($page->photos[1]->image, 1200, 300), ['width' => '100%', 'height' => '100%']) ?>
                                    <? endif ?>
                                </div>
                                <strong class="per-night" style="font-family: Arial"><span>€</span><?= $page->price; ?> <i>Дней: <?= $page->model->how_days; ?></i></strong>
                                <a href="javascript:void( window.open( 'https://form.jotformeu.com/71136944138357', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )" class="book-btn2" title="">Заказать</a>
                                <div class="title-video alignleft">
                                    <h1><?= $page->seo('h1', $page->title) ?></h1>
                                    <span><?= $page->seo('h1', $page->short) ?></span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <p>
                            <?= $page->text ?>
                        </p>
                    </div>
                    <!-- Blog List Posts -->
                </div>
            </div>

            <?php if (false): ?>
            <!-- 3-block -->
            <div class="row" style="margin-top: 80px;">
                <div class="col-md-12">
                    <p>
                        <?php foreach ($page->tags as $tag) : ?>
                            <a href="<?= Url::to(['/banks', 'tag' => $tag]) ?>"
                               class="label label-info"><?= $tag ?></a>
                        <?php endforeach; ?>
                    </p>

<!--                    <div class="small-muted">Views: --><?//= $page->views ?><!--</div>-->
                </div>
            </div>
            <? endif; ?>
        </div>
    </div>
</section>

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