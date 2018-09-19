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

if(!empty($parentPage->title)){
    $this->params['breadcrumbs'][] = ['label' => $parentPage->title, 'url' => Url::to([$pageParentUrl.'/'])];
}

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
        font-family: Arial, sans-serif;
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

    #pricing-table {
        margin: 50px auto;
        text-align: center;
        width: 100%; /* total computed width = 222 x 3 + 226 */
        padding-left: 18%;
    }

    #pricing-table .plan {
        font: 12px 'Lucida Sans', 'trebuchet MS', Arial, Helvetica;
        text-shadow: 0 1px rgba(255,255,255,.8);
        background: #fff;
        border: 1px solid #ddd;
        color: #333;
        padding: 20px;
        width: 180px; /* plan width = 180 + 20 + 20 + 1 + 1 = 222px */
        float: left;
        position: relative;
    }

    #pricing-table #most-popular {
        z-index: 2;
        top: -13px;
        border-width: 3px;
        padding: 30px 20px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        -moz-box-shadow: 20px 0 10px -10px rgba(0, 0, 0, .15), -20px 0 10px -10px rgba(0, 0, 0, .15);
        -webkit-box-shadow: 20px 0 10px -10px rgba(0, 0, 0, .15), -20px 0 10px -10px rgba(0, 0, 0, .15);
        box-shadow: 20px 0 10px -10px rgba(0, 0, 0, .15), -20px 0 10px -10px rgba(0, 0, 0, .15);
    }

    #pricing-table .plan:nth-child(1) {
        -moz-border-radius: 5px 0 0 5px;
        -webkit-border-radius: 5px 0 0 5px;
        border-radius: 5px 0 0 5px;
    }

    #pricing-table .plan:nth-child(4) {
        -moz-border-radius: 0 5px 5px 0;
        -webkit-border-radius: 0 5px 5px 0;
        border-radius: 0 5px 5px 0;
    }

    /* --------------- */

    #pricing-table h3 {
        font-size: 20px;
        font-weight: normal;
        padding: 20px;
        margin: -20px -20px 5px -20px;
        background-color: #eee;
        background-image: -moz-linear-gradient(#fff,#eee);
        background-image: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#eee));
        background-image: -webkit-linear-gradient(#fff, #eee);
        background-image: -o-linear-gradient(#fff, #eee);
        background-image: -ms-linear-gradient(#fff, #eee);
        background-image: linear-gradient(#fff, #eee);
    }

    #pricing-table #most-popular h3 {
        background-color: #ddd;
        background-image: -moz-linear-gradient(#eee,#ddd);
        background-image: -webkit-gradient(linear, left top, left bottom, from(#eee), to(#ddd));
        background-image: -webkit-linear-gradient(#eee, #ddd);
        background-image: -o-linear-gradient(#eee, #ddd);
        background-image: -ms-linear-gradient(#eee, #ddd);
        background-image: linear-gradient(#eee, #ddd);
        margin-top: -30px;
        padding-top: 30px;
        -moz-border-radius: 5px 5px 0 0;
        -webkit-border-radius: 5px 5px 0 0;
        border-radius: 5px 5px 0 0;
    }

    #pricing-table .plan:nth-child(1) h3 {
        -moz-border-radius: 5px 0 0 0;
        -webkit-border-radius: 5px 0 0 0;
        border-radius: 5px 0 0 0;
    }

    #pricing-table .plan:nth-child(4) h3 {
        -moz-border-radius: 0 5px 0 0;
        -webkit-border-radius: 0 5px 0 0;
        border-radius: 0 5px 0 0;
    }

    #pricing-table  p {
        font-family: arial !important;
        display: block;
        font: bold 25px/100px Georgia, Serif;
        color: #777;
        background: #fff;
        border: 5px solid #fff;
        height: 100px;
        width: 100px;
        margin: 10px auto 5px;
        -moz-border-radius: 100px;
        -webkit-border-radius: 100px;
        border-radius: 100px;
        -moz-box-shadow: 0 5px 20px #ddd inset, 0 3px 0 #999 inset;
        -webkit-box-shadow: 0 5px 20px #ddd inset, 0 3px 0 #999 inset;
        box-shadow: 0 5px 20px #ddd inset, 0 3px 0 #999 inset;
    }

    /* --------------- */

    #pricing-table ul {
        margin: 20px 0 0 0;
        padding: 0;
        list-style: none;
    }

    #pricing-table li {
        border-top: 1px solid #ddd;
        padding: 10px 0;
    }

    /* --------------- */

    #pricing-table .signup {
        position: relative;
        padding: 8px 20px;
        margin: 20px 0 0 0;
        color: #fff;
        font: bold 14px Arial, Helvetica;
        text-transform: uppercase;
        text-decoration: none;
        display: inline-block;
        background-color: #72ce3f;
        background-image: -moz-linear-gradient(#72ce3f, #62bc30);
        background-image: -webkit-gradient(linear, left top, left bottom, from(#72ce3f), to(#62bc30));
        background-image: -webkit-linear-gradient(#72ce3f, #62bc30);
        background-image: -o-linear-gradient(#72ce3f, #62bc30);
        background-image: -ms-linear-gradient(#72ce3f, #62bc30);
        background-image: linear-gradient(#72ce3f, #62bc30);
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
        border-radius: 3px;
        text-shadow: 0 1px 0 rgba(0,0,0,.3);
        -moz-box-shadow: 0 1px 0 rgba(255, 255, 255, .5), 0 2px 0 rgba(0, 0, 0, .7);
        -webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, .5), 0 2px 0 rgba(0, 0, 0, .7);
        box-shadow: 0 1px 0 rgba(255, 255, 255, .5), 0 2px 0 rgba(0, 0, 0, .7);
    }

    #pricing-table .signup:hover {
        background-color: #62bc30;
        background-image: -moz-linear-gradient(#62bc30, #72ce3f);
        background-image: -webkit-gradient(linear, left top, left bottom, from(#62bc30), to(#72ce3f));
        background-image: -webkit-linear-gradient(#62bc30, #72ce3f);
        background-image: -o-linear-gradient(#62bc30, #72ce3f);
        background-image: -ms-linear-gradient(#62bc30, #72ce3f);
        background-image: linear-gradient(#62bc30, #72ce3f);
    }

    #pricing-table .signup:active, #pricing-table .signup:focus {
        background: #62bc30;
        top: 2px;
        -moz-box-shadow: 0 0 3px rgba(0, 0, 0, .7) inset;
        -webkit-box-shadow: 0 0 3px rgba(0, 0, 0, .7) inset;
        box-shadow: 0 0 3px rgba(0, 0, 0, .7) inset;
    }
</style>

<section>
    <div class="block">
        <div class="sidesidebar">

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

            <!-- Widget2
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
            </div> Widget2 -->
        </div>
        <div class="container">
            <!-- 1-block -->
            <div class="row">
                <div class="col-md-12">

                    <div class="packages-detail">
                        <?php if (count($page->photos) || !empty($page->model->image)) : ?>
                            <div class="package-video">
                                <div>
                                    <?php if (!empty($page->model->image)) : ?>
                                        <?= Html::img(Image::thumb($page->model->image, 1100, 300), ['width' => '100%', 'height' => '100%']) ?>
                                    <? else: ?>
                                        <?= Html::img(Image::thumb($page->photos[1]->image, 1100, 300), ['width' => '100%', 'height' => '100%']) ?>
                                    <? endif ?>
                                </div>
                                <? if($page->model->short): ?>
                                <div class="title-video alignleft">
                                    <span><?= $page->model->short ?></span>
                                </div>
                                <?php endif; ?>
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
                            <a href="<?= Url::to(['/pages', 'tag' => $tag]) ?>"
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