<?php
use frontend\modules\banks\api\Banks;
use frontend\modules\page\api\Page;

use frontend\helpers\Image;

use yii\helpers\Html;
use yii\helpers\Url;

\frontend\assets\BanksAsset::register($this);

/**
 * @var  \yii\web\View $this
 * @propperty  $page \frontend\modules\page\api\Page
 */

$page = Page::get('page-banks');
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

$this->params['breadcrumbs'][] = $page->model->title;

//e_print('BEGIN_WIEV');
?>

    <style>
        .package-thumb > span {
            font-size: 14px;
            font-family: Arial, Arial, Helvetica, Tahoma, sans-serif;
            -webkit-transform: translateY(-240%) translateX(-40%);
            -moz-transform: translateY(-240%) translateX(-40%);
            -ms-transform: translateY(-240%) translateX(-40%);
            -o-transform: translateY(-240%) translateX(-40%);
            transform: translateY(-240%) translateX(-40%);
        }

        .listcenter {
            font-size: 20px;

            position: relative;
            right: 1px;
        }

        @media (max-width: 800px) {
            .listcenter {
                right: 0;
            }
        }
        #tpb {
            position: absolute;
            top: 295px;
            left: -281px;
            transform: rotate(-90deg);
        }
        #tpb h3
        {
            font-size: 1em;
            font-weight: bold;
            position: relative;
            margin: -35px 0 0 0;
            float: right;
            color: #222;
            padding: 10px 250px;
            text-shadow: 0 1px rgba(255,255,255,.8);
            /* Permalink - use to edit and share this gradient: //colorzilla.com/gradient-editor/#ffffff+0,7dc20f+100&0+0,1+100 */
            background: -moz-linear-gradient(left,  rgba(255,255,255,0) 0%, rgba(125,194,15,1) 100%); /* FF3.6-15 */
            background: -webkit-linear-gradient(left,  rgba(255,255,255,0) 0%,rgba(125,194,15,1) 100%); /* Chrome10-25,Safari5.1-6 */
            background: linear-gradient(to right,  rgba(255,255,255,0) 0%,rgba(125,194,15,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00ffffff', endColorstr='#7dc20f',GradientType=1 ); /* IE6-9 */
        }
        #tpb h3:before, #tpb h3:after{
            content: '';
            position: absolute;
            border-style: solid;
            border-color: transparent;
        }

        .dataTables_wrapper .dataTables_filter input::placeholder {
            color: #d6d6d6;
            font-size: 13px;
            padding-left: 3px;
        }
        table.dataTable thead th, table.dataTable thead td {
            border-bottom: 0;
        }
        .dataTables_filter > label {
            margin-bottom: 10px;
        }

    .sidesidebar, .sidesidebar2 {
        position: absolute;
        display: none;
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
<?php /*if ($this->beginCache(md5(serialize(Yii::$app->request->get())), ['duration' => 700])) : */?>

    <div class="container">
        <h1><?= $page->seo('h1', $page->title) ?></h1>
        <?php if ($page->text): ?>
            <div><?= $page->seo('div', $page->text) ?></div><? endif; ?>
    </div>

    <?php if ($items): ?>
    <section id="banks2" class="scroll-container">
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
                <div class="row top30">

                </div>

                <div class="row bank-new-list top20">
                    <div class="col-md-12" id="switchAllBanks">
                        <table id="example" class="table table-bordered display" style="width:100%">
                            <thead>
                            <tr>
                                <th>Имя</th>
                                <th>С посещением банка</th>
                                <th>Цена</th>

                            </tr>
                            </thead>
                            <tbody>

                        <?php if ($items): ?>
                            <?php foreach ($items as $item) : ?>
                                <tr>
                                    <td data-order="<?= $item->title ?>" class="col-md-8 col-lg-2">
                                        <h6>
                                            <?= Html::a($item->title, ['banks/view', 'slug' => $item->slug]) ?>
                                        </h6>

                                        <div class="no-margin inl-block">
                                            <div class="hide-for-small-down">
                                                <a href="<?= Url::to(['banks/view', 'slug' => $item->slug]) ?>"><?= Html::img($item->thumb(120, 31)) ?></a>
                                            </div>
                                            <div class="top10 row">
                                                <? if ($item->model->countries[0]->alpha): ?><div class="col-xs-3"><div class="b-flag"> <div class="label flag flag-icon-background flag-icon-<?= $item->model->countries[0]->alpha ?>">&nbsp;</div></div></div><? endif ?>
                                                <div class="col-xs-9"><div class="left tBankLi" style="margin: 2px 0 0 0"><? if ($item->model->countries[0]->name_ru): ?><?= $item->model->countries[0]->name_ru ?><? else: ?><?= $item->model->location_title ?><? endif ?></div></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-order="<?= $item->model->personal ?>" class="hidden-xs hidden-sm hidden-md  col-lg-8">
                                        <table class="table border-none tBankLi">
                                            <tr>
                                                <td>

                                                    <?php if ($item->model->type_id === 2): ?>
                                                        <p class="f">﻿Личный счет</p>
                                                        <div class="green_yes "><i class="fa fa-check fa-3"
                                                                                   aria-hidden="true"></i></div>
                                                    <? else: ?>
                                                        <p class="f">Корпоративный счет</p>
                                                        <div class="green_yes "><i class="fa fa-check fa-3"
                                                                                   aria-hidden="true"></i></div>
                                                    <? endif; ?>
                                                </td>

                                                <td>
                                                    <p class="f" title="Открытие счета без личного присутствия">
                                                        С посещением банка </p>
                                                    <?php if ($item->model->personal === 1): ?>
                                                        <div class="green_yes "><i class="fa fa-check fa-3"
                                                                                   aria-hidden="true"></i></div><? else: ?>
                                                        <div class="green_no"><i class="fa fa-times fa-3"
                                                                                 aria-hidden="true"></i></div><? endif; ?>
                                                </td>

                                                <td>
                                                    <p class="f">Сайт банка</p>

                                                    <div class="hegg"><?= $item->model->website ?></div>
                                                    <!--<div class="green_no"><i class="fa fa-times fa-3" aria-hidden="true"></i></div>-->
                                                </td>
                                                <td>
                                                    <p class="f">Минимальный депозит</p>

                                                    <div class="hegg"><? if ($item->model->min_deposit > 0): ?><?= $item->model->min_deposit ?><? else: ?>
                                                            <div class="">
                                                                0
                                                            </div><? endif ?>
                                                    </div>
                                                    <!--   <div class="green_yes "><i class="fa fa-check fa-3" aria-hidden="true"></i></div>-->
                                                </td>
                                                <td>
                                                    <p class="f">Срок</p>

                                                    <div class="tBankDays tBankOter"><p><?= $item->how_days ?></p></div>
                                                </td>
                                                <!--<td>
                                                    <p class="">Initial Deposit</p>
                                                    <p class="">USD 0</p>
                                                </td>
                                                <td>
                                                    <p class=""> Min. Balance</p>
                                                    <p class="">USD 0</p>
                                                </td>-->
                                            </tr>
                                        </table>
                                    </td>
                                    <td data-order="<?= $item->price ?>" class="col-md-4 col-lg-2 bg-green-price">
                                        <div class="h6 text-center">
                                            <span>Цена</span>
                                        </div>
                                        <div style="font-weight: bolder; font-size: large; font-family: Verdana;" class="h6 text-center cena">€<?= $item->price ?></div>

                                        <div class="text-center" style="height:35px;">

                                            <a class="btn btn-success" href="javascript:void( window.open( 'https://form.jotformeu.com/71136944138357', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )">Заказать</a>
                                            <!--    <a href="<?= Url::to(['banks/view', 'slug' => $item->slug]) ?>"
                                               class="btn btn-success">Заказать</a>-->
                                        </div>
                                    </td>
                                </tr>
                        <? endforeach; ?>
                        <? endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <? endif; ?>

    <?php if (true): ?>
        <section id="pages" class="top20">
            <div class="block">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="font-color">Подробнее о наших банках</h3>
                            <div class="villaeditors-picks">
                                <div class="packages style2 remove-ext2">
                                    <div class="row">
                                        <?php foreach ($banksList as $item) : ?>
                                            <div class="col-md-4">
                                                <div class="package">
                                                    <div class="package-thumb">
                                                        <?= Html::img($item->thumb(240, 120)) ?>
                                                        <span><b><? if ($item->model->countries[0]->name_ru): ?><?= $item->countries[0]->name_ru ?><? else: ?><?= $item->model->location_title ?><? endif; ?></b></span>
                                                    </div>
                                                    <div class="package-detail">
                                                        <!--                                            <span class="cate">
                                                <?php /*foreach ($item->tags as $tag) : */ ?>
                                                    <a href="<? /*= Url::to(['/pages', 'tag' => $tag]) */ ?>"
                                                       class="label label-info"><? /*= $tag */ ?></a>
                                                <?php /*endforeach; */ ?>
                                            </span>-->
                                                        <h4><?= Html::a($item->title,
                                                                ['banks/view', 'slug' => $item->slug]) ?></h4>
                                                        <ul class="location-book">
                                                            <li class="book-btn"><i class="fa fa-info"></i>
                                                                <?= Html::a('Подробнее',
                                                                    ['banks/view', 'slug' => $item->slug]) ?></li>
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
                                <div>
                                    <?= Banks::pages() ?>
                                </div>
                            </div>
                            <!-- Pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

<?php //$this->endCache(); ?>
<?php //endif; ?>


<!--<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/autofill/2.2.2/js/dataTables.autoFill.min.js"></script>-->