<?php
/**
 * Created by CyberBrain
 *
 * @var \frontend\modules\novanews\api\NovanewsObject $page
 */

use yii\helpers\Html;
use frontend\assets\MainAsset;
use frontend\helpers\Image;
use yii\helpers\Url;
MainAsset::register($this);
$iteration = 1;

//$this->title = $page->seo('meta_title', $page->title); // seo from site/index

?>



<? if (true): ?>
    <section>

            <div class="row">
                <div class="col-md-12">
                    <div id="Slider-Main" class="" style="display: none">
                        <? foreach ($slide_main as $item): ?>
                            <div class="item blo<?php $div = ($iteration % 2); echo"$div"; ?> ">
                                <div class="img-fill-main">
                                    <div class="item-img adslightSpeedIn" style="background-image: url('<?= $item->model->image ?>');">
                                    </div>
                                    <div class="info">
                                        <div>
                                            <!-- LAYER NR. 1 -->
                                            <div class="slimain slick-div1 sli-01-01 anim1"
                                                 data-x="center" data-hoffset=""
                                                 data-y="70" data-voffset=""
                                                 data-width="['auto','auto','auto','auto']"
                                                 data-height="['auto','auto','auto','auto']"
                                                 data-transform_idle="o:1;"
                                                 data-transform_in="x:[175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0.01;s:3000;e:Power3.easeOut;"
                                                 data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;"
                                                 data-mask_in="x:[-100%];y:0;s:inherit;e:inherit;"
                                                 data-start="500"
                                                 data-splitin="none"
                                                 data-splitout="none"
                                                 data-responsive_offset="on"
                                                 data-elementdelay="0.05"
                                                 onclick="location.href='<?= $item->model->url ?>'"
                                                 style="">
                                                <? if ( Yii::$app->language==='en-US'): ?>
                                                    <?=  $item->model->title_en ?>
                                                <? else: ?>
                                                    <?=  $item->model->title ?>
                                                <? endif; ?>
                                            </div>

                                            <!-- LAYER NR. 2 -->
                                            <div class="slimain slick-div2 sli-01-02 anim2"
                                                 data-x="center" data-hoffset=""
                                                 data-y="143" data-voffset=""
                                                 data-width="['auto','auto','auto','auto']"
                                                 data-height="['auto','auto','auto','auto']"
                                                 data-transform_idle="o:1;"
                                                 data-transform_in="x:[175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0.01;s:3000;e:Power3.easeOut;"
                                                 data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;"
                                                 data-mask_in="x:[-100%];y:0;s:inherit;e:inherit;"
                                                 data-start="500"
                                                 data-splitin="none"
                                                 data-splitout="none"
                                                 data-responsive_offset="on"
                                                 data-elementdelay="0.05"
                                                 onclick="location.href='<?= $item->model->url ?>'"
                                                 style="">
                                            <span>
                                            <? if ( Yii::$app->language==='en-US'): ?>
                                                <?=  $item->model->short_en ?>
                                            <? else: ?>
                                                <?=  $item->model->short ?>
                                            <? endif; ?>
                                            </span>
                                            </div>

                                            <!-- LAYER NR. 3 -->
                                            <p class="slimain slick-div3 sli-01-01 anim3"
                                               data-x="center" data-hoffset=""
                                               data-y="197" data-voffset=""
                                               data-width="['auto','auto','auto','auto']"
                                               data-height="['auto','auto','auto','auto']"
                                               data-transform_idle="o:1;"
                                               data-transform_in="x:[175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0.01;s:3000;e:Power3.easeOut;"
                                               data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;"
                                               data-mask_in="x:[-100%];y:0;s:inherit;e:inherit;"
                                               data-start="500"
                                               data-splitin="none"
                                               data-splitout="none"
                                               data-responsive_offset="on"
                                               data-elementdelay="0.05"
                                               onclick="location.href='<?= $item->model->url ?>'"
                                               style="">
                                                <? if ( Yii::$app->language==='en-US'): ?>
                                                    <?=  $item->model->text_en ?>
                                                <? else: ?>
                                                    <?=  $item->model->text ?>
                                                <? endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $iteration++; ?>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>
    </section>
<? endif; ?>

<section class="gray">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="search-luxuriousvilla overlape">
                        <!-- WIP -->
                        <div class="ticker__viewport">
                            <ul class="ticker__list" data-ticker="list">
                            <? foreach ($ticker_viewport as $item): ?>
                            <li class="ticker__item" data-ticker="item"><a href="<?= $item->url ?>"><? if ( Yii::$app->language==='en-US'): ?><?= $item->model->title_en ?><? else: ?><?= $item->model->title ?><? endif; ?></a></li>
                            <? endforeach; ?>
                            </ul>
                        </div>
                        <? if (isset($slide_small) && count($slide_small) > 0): ?>
                        <div class="Modern-Slider" id="Modern-Slider" style="display: none">
                                <!-- Item -->
                                <? foreach ($slide_small as $item): ?>
                                <div class="item">
                                    <div class="img-fill">
                                        <div class="info">
                                            <div>
                                                <? if ( Yii::$app->language==='en-US'): ?>
                                                <div class="h3"><?= $item->model->title_en ?></div>
                                                <div class="h5"><?= $item->model->text_en ?></div>
                                                <? else: ?>
                                                    <div class="h3"><?= $item->model->title ?></div>
                                                    <div class="h5"><?= $item->model->text ?></div>
                                                <? endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- // Item -->
                                <? endforeach; ?>
                            </div>
                        <? endif; ?>
                    </div>
                    <!-- Search Luxurious Form -->
                </div>
                <!-- Search luxurious Villa -->
            </div>
        </div>
</section>
<? if(isset($news) && !empty($news)): ?>
<section id="paddinglist" class="gray2 pad">
        <div class="container">
            <h2 style="text-align: center;"><?= Yii::t('easyii', '49') ?></h2>
            <div class="row">
                <? foreach ($news as $item): ?>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="package ">
                            <a href="<?= Url::to(['news/'.$item->slug]) ?>">
                                <div class="package-thumb">
                                    <div class="image">
                                        <?php if(isset($item->model->pre_image) && !empty($item->model->pre_image)): ?>
                                            <?= Html::img(Image::thumb($item->model->pre_image, 400, 225)) ?>
                                        <?php else: ?>
                                            <?= Html::img(Image::thumb($item->model->image, 400, 225)) ?>
                                        <?php endif; ?>
                                    </div>
                                    <div id="newsinfo">
                                        <i class="fa fa-calendar"></i><b> <?= $item->date ?></b> /
                                        <i class="fa fa-eye"
                                           aria-hidden="true"><b></i> <?= $item->views * 2 ?> <?= Yii::t('easyii', 'viewed') ?></b>

                                    </div>
                                    <div class="package-centered">
                                        <div id="centered-package">
                                            <h4><a href="<?= Url::to(['news/'.$item->slug]) ?>"><?= $item->title ?></a></h4><br>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>
            <div class='container'>
                <div class="row">
                    <div class="col-md-12">
                        <div class="button-container">
                            <div class='button -green center'><b><a href="<?= Url::to(['news/']) ?>"><?= Yii::t('easyii', 'othernews') ?></a> </b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 top20">
                        <div class="subs-main text-center">
                            <a href="https://t.me/iqoffshore" target="_blank" rel="nofollow"><button class="btn btn-success"><?= Yii::t('easyii', 'subscribenews') ?></button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sponsor Carousel -->
</section>
<? endif; ?>
<section class="popular-yuris pad">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="villaeditors-picks">
                        <div class="title1">
                            <h2><?= Yii::t('easyii', '6') ?></h2>
                            <div><?= Yii::t('easyii', '7') ?></div>

                            <p><?= Yii::t('easyii', '8') ?></p>
                        </div>
                        <div class="packages remove-ext2">
                            <div class="row">
                                <? foreach ($offers as $offer): ?>
                                    <div class="col-md-4">
                                        <div class="package">
                                            <a href="<?= Url::to(['offers/'.$offer->slug]) ?>">
                                                <div class="package-thumb">
                                                    <?= Html::img($offer->thumb(280, 200), array('class' => 'sadsa')) ?>
                                                    <span style="font-family: Arial; font-stretch: extra-condensed"><i>€<?= $offer->price ?></i> <b> / <?= Yii::t('easyii', 'days') ?>
                                                            : <?= $offer->how_days ?></b>  </span>
                                                </div>
                                            </a>
                                            <div class="package-detail">
                                                <span class="line"></span>
                                                <a class="cate" href="<?= Url::to(['offers/'.$offer->slug]) ?>" title=""><?= Yii::t('easyii', 'reg_company') ?></a>
                                                <h4>
                                                    <a href="<?= Url::to(['offers/'.$offer->slug]) ?>" title="<?= $offer->title ?>"><?= $offer->title ?></a>
                                                </h4>


                                                <ul class="location-book">
                                                    <li class="book-btn"><i class="fa fa-info"></i>
                                                        <a href="<?= Url::to(['offers/'.$offer->slug]) ?>" title=""><?= Yii::t('easyii', '9') ?></a></li>
                                                    <li class="book-btn"><i class="fa fa-shopping-basket"></i>
                                                        <a href="javascript:void( window.open( 'https://form.jotformeu.com/82774951021356', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )">
                                                            <?= Yii::t('easyii', '10') ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <? endforeach; ?>
                                <div class='containerrr2'>
                                    <div class="button-container">
                                        <div class='button -green2 center'><b><a
                                                        href="//iq-offshore.com/ru/offshornyie-predlozheniya"><?= Yii::t('easyii', 'othercompany') ?></a>
                                            </b></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Villa Editors Picks -->
                </div>
            </div>
        </div>
</section>

<section class="pad">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="villa-arrangements">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="villa-arrangementsinfo">
                                    <div class="title1">
                                        <h2><?= Yii::t('easyii', '11') ?></h2>
                                        <div><?= Yii::t('easyii', '12') ?></div>
                                    </div>
                                    <p><?= Yii::t('easyii', '13') ?></p>
                                    <ul class="about-serlist style2">
                                        <li><a href="<?= Url::to(['banks/'.$toMainBank->slug]) ?>"><?= Yii::t('easyii', '14') ?></a></li>
                                        <li><a href="<?= Url::to(['processing/']) ?>"><?= Yii::t('easyii', '15') ?></a></li>
                                        <li><a href="<?= Url::to(['news/kak-otkryt-licnyj-scet']) ?>"><?= Yii::t('easyii', '16') ?></a></li>
                                    </ul>
                                    <a href="<?= Url::to('/banks') ?>" class="theme-btn"
                                       title="Банки"><?= Yii::t('easyii', 'detail') ?></a>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="we-offers">
                                    <div class="row">
                                        <? foreach ($banks as $toMainBank): ?>
                                        <div class="col-md-6">
                                            <div class="offered-service" onclick="location.href='<?= Url::to(['banks/'.$toMainBank->slug]) ?>'">
                                                <?= Html::img(
                                                    Image::thumb($toMainBank->image, 296, 187),
                                                    ['class' => 'main-banks']
                                                ); ?>
                                                <div class="offered-serviceinfo">
                                                    <h4><a href="<?= Url::to(['banks/'.$toMainBank->slug]) ?>" title=""><?= $toMainBank->title ?></a></h4>
                                                    <span style="font-weight: bold; font-size: large; color: white"><?= $toMainBank->model->bank->location_title ?></span>
                                                    <span style="font-weight: bolder; font-size: large; color: white; font-family: Verdana;">€<?= $toMainBank->model->bank->price ?></span>
                                                    <h4><?= Yii::t('easyii', 'corpacc') ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                         <? endforeach; ?>

                                        <div class="col-md-6">
                                            <div class="offered-service">
                                                <?= Html::img(
                                                    Image::thumb('/uploads/theme_villa/offered-service6.jpg', 296, 187),
                                                    ['class' => 'main-banks']
                                                ); ?>
                                                <div class="offered-serviceinfo">
                                                    <h4><a href="/banks"
                                                           title=""><?= Yii::t('easyii', 'otherbanks') ?></a></h4>
                                                    <!--<span>banks</span>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- We Offers -->
        </div>
</section>

<?php if (true): ?>
<section class="license pad">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="villa-locations">
                        <div class="title1">
                            <h2><?= Yii::t('easyii', '17') ?></h2>
                            <div><?= Yii::t('easyii', '18') ?></div>
                            <p><?= Yii::t('easyii', '19') ?></p>
                        </div>
                        <div class="villa-locationslist">
                            <ul><? foreach ($licenses as $item): ?>
                                <li>
                                    <div class="villa-location" onclick="location.href='<?= Url::to(["licenses/".$item->model->slug]) ?>'">
                                        <img src="<?= $item->thumb(200, 330) ?>" class="main-banks"/>
                                        <div class="villa-locationinfo">
                                            <span><?= $item->model->title ?></span>
                                        </div>
                                    </div>
                                </li><? endforeach; ?>
                                <li>
                                    <div class="villa-location last" onclick="location.href='<?= Url::to(["licenses/"]) ?>'">
                                        <?= Html::img(Image::thumb("/uploads/licenses/license (5).jpg", 200, 330), array('class' => 'main-banks')) ?>
                                        <div class="villa-locationinfo">
                                            <span><?= Yii::t('easyii', '20') ?></span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Villa Locations -->
                </div>
            </div>
        </div>
</section>
<? endif; ?>

<section class="pad">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="recent-news">
                        <div class="title1">
                            <h2><a href="/processing"><?= Yii::t('easyii', '21') ?></a></h2>
                            <div><?= Yii::t('easyii', '22') ?></div>

                            <p><?= Yii::t('easyii', '23') ?></p>

                            <div class="remove-ext">
                                <div class="recentnews-carousel2">
                                    <div class="recentnew-post">
                                        <?= Html::img(
                                            Image::thumb('/uploads/processing/processing_main.jpg', 660, 372),
                                            ['alt' => 'Процессинг Мерчант', 'onclick' => "location.href='/processing'", 'class' => 'recimg']
                                        ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="remove-ext">
                            <div class="h5"><?= Yii::t('easyii', '24') ?></div>
                            <div class="recentnews-carousel" id="recentnews-carouselka">
                                <? foreach ($fonds as $item): ?>
                                    <div class="recentnew-post"
                                         onclick="location.href='/fonds/<?= $item->model->slug ?>'">
                                        <?= Html::img($item->thumb(315, 200), array('class' => 'main-banks')) ?>

                                        <div class="recentnew-detail">
                                            <h4>
                                                <a href="/fonds/<?= $item->model->slug ?>"
                                                   title="<?= $item->model->title ?>"><?= $item->model->title ?></a>
                                            </h4>
                                        </div>
                                    </div>
                                <? endforeach; ?>
                            </div>
                            <div>
                                <p><?= Yii::t('easyii', '25') ?></p>
                                <p class="text-center">
                                    <span class="h5"><?= Yii::t('easyii', '26') ?></span>
                                </p>
                                <ul>
                                    <li><?= Yii::t('easyii', '27') ?></li>
                                    <li><?= Yii::t('easyii', '28') ?></li>
                                    <li><?= Yii::t('easyii', '29') ?></li>
                                    <li><?= Yii::t('easyii', '30') ?></li>
                                </ul>
                                <div class="text-center">
                                    <a href="<?= Url::to(['fonds/']) ?>" class = "theme-btn theme-btn--inline"><?= Yii::t('easyii', '9') ?></a>
                                </div>
                            </div>
                            <!-- Recent News Carousel -->
                        </div>
                    </div>
                    <!-- Recent News -->
                </div>
            </div>
        </div>
</section>
<section class=" grayish high-opacity pad">
        <div class="fixed-bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="spec-services">
                        <div class="title1 vertical">
                            <h2><?= Yii::t('easyii', '31') ?> <span><?= Yii::t('easyii', '32') ?></span></h2>
                            <div><?= Yii::t('easyii', '33') ?></div>
                        </div>
                        <div class="about-services">
                            <p><?= Yii::t('easyii', '34') ?></p>
                            <ul class="about-serlist">
                                <li><a href="#" title=""><?= Yii::t('easyii', '35') ?></a></li>
                                <li><a href="#" title=""><?= Yii::t('easyii', '36') ?></a></li>
                                <li><a href="#" title=""><?= Yii::t('easyii', '37') ?></a></li>
                            </ul>
                        </div>
                        <div class="services-list1" id="services-list1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="service1">
                                        <span><i class="flaticon-new-india-republic"></i></span>
                                        <h4><a href="#services-list1" title=""><?= Yii::t('easyii', '38') ?></a></h4>
                                        <i><?= Yii::t('easyii', '39') ?></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="service1">
                                        <span><i class="flaticon-new-worlwide"></i></span>
                                        <h4><a href="#services-list1" title="">SWIFT</a></h4>
                                        <i><?= Yii::t('easyii', '40') ?></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="service1">
                                        <span><i class="flaticon-new-credit-card-pay-mode"></i></span>
                                        <h4><a href="#services-list1" title=""><?= Yii::t('easyii', '41') ?></a></h4>
                                        <i>Visa & MasterCard</i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="service1">
                                        <span><i class="flaticon-new-credit-card-2"></i></span>
                                        <h4>
                                            <a href="//iq-offshore.com/news/otkryt-anonimnyj-bankovskij-debitnyj-scet-predoplaty"
                                               title=""><?= Yii::t('easyii', '42') ?></a></h4>
                                        <i><?= Yii::t('easyii', '43') ?></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="service1">
                                        <span><i class="flaticon-new-coin"></i></span>
                                        <h4><a href="#services-list1" title=""><?= Yii::t('easyii', '44') ?></a></h4>
                                        <i><?= Yii::t('easyii', '45') ?></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <a href="/offshornyie-predlozheniya" title=""
                                       class="theme-btn"><?= Yii::t('easyii', '46') ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Special Services -->
                </div>
            </div>
        </div>
</section>

<section class="top20 pad">
    <div class="container">

        <div class="row">
            <div class="col-md-12 h2 text-center"><?= Yii::t('easyii', 'reviews') ?></div>
        </div>
        <div class="row recentnews-carousel" id="recent-comments">
            <div class="fcol-md-6">
                <div class="bdanzer-card">
                    <div class="h3"><?= Yii::t('easyii', 'Victoria') ?></div>
                    <div><p><?= Yii::t('easyii', 'VictoriaReview') ?></p></div>
                </div>
            </div>


            <div class="fcol-md-6">
                <div class="bdanzer-card">
                    <div class="h3"><?= Yii::t('easyii', 'Inessa') ?></div>
                    <div><p><?= Yii::t('easyii', 'InessaReview') ?></p></div>
                </div>
            </div>

            <div class="fcol-md-6">
                <div class="bdanzer-card">
                    <div class="h3"><?= Yii::t('easyii', 'Alexander') ?></div>
                    <div><p><?= Yii::t('easyii', 'AlexanderReview') ?></p></div>
                </div>
            </div>

            <div class="fcol-md-6">
                <div class="bdanzer-card">
                    <div class="h3"><?= Yii::t('easyii', 'Ivan') ?></div>
                    <div><p><?= Yii::t('easyii', 'IvanReview') ?></p></div>
                </div>
            </div>


            <div class="fcol-md-6">
                <div class="bdanzer-card">
                    <div class="h3"><?= Yii::t('easyii', 'Vladimir') ?></div>
                    <div><p><?= Yii::t('easyii', 'VladimirReview') ?></p></div>
                </div>
            </div>

            <div class="fcol-md-6">
                <div class="bdanzer-card">
                    <div class="h3"><?= Yii::t('easyii', 'Michael') ?></div>
                    <div><p><?= Yii::t('easyii', 'MichaelReview') ?></p></div>
                </div>
            </div>

            <div class="fcol-md-6">
                <div class="bdanzer-card">
                    <div class="h3"><?= Yii::t('easyii', 'Marina') ?></div>
                    <div><p><?= Yii::t('easyii', 'MarinaReview') ?></p></div>
                </div>
            </div>

            <div class="fcol-md-6">
                <div class="bdanzer-card">
                    <div class="h3"><?= Yii::t('easyii', 'Ksenia') ?></div>
                    <div><p><?= Yii::t('easyii', 'KseniaReview') ?></p></div>
                </div>
            </div>

            <div class="fcol-md-6">
                <div class="bdanzer-card">
                    <div class="h3"><?= Yii::t('easyii', 'Olga') ?></div>
                    <div><p><?= Yii::t('easyii', 'OlgaReview') ?></p></div>
                </div>
            </div>

            <div class="fcol-md-6">
                <div class="bdanzer-card">
                    <div class="h3"><?= Yii::t('easyii', 'Mark') ?></div>
                    <div><p><?= Yii::t('easyii', 'MarkReview') ?></p></div>
                </div>
            </div>
        </div>
    </div>
</section>

<? if(false): ?>
<section class="blackish high2-opacity">
        <div class="parallax" data-velocity="-.4"
             style="background-image: url('<?= Image::thumb('/uploads/theme_villa/parallax4-3.jpg', 900, 420) ?>');"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="single-property">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="logo2">
                                    <span><img src="/uploads/logo/logo2-small.png" alt=""/></span>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <strong><?= Yii::t('easyii', '47') ?></strong>
                                <span><?= Yii::t('easyii', '48') ?></span>
                            </div>
                            <div class="col-md-3">
                                <a href="/contact" class="theme-btn"
                                   title="Написать"><?= Yii::t('easyii', 'write') ?></a>
                            </div>
                        </div>
                    </div>
                    <!-- Single Property -->
                </div>
            </div>
        </div>
</section>
<? endif; ?>

