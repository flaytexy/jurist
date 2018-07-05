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

<style>
    .bdanzer-card {
        min-height: 245px;
    }
</style>

<? if (true): ?>
    <section>
        <div class="block no-padding">
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
        </div>
    </section>
<? endif; ?>

<section>
    <div class="block gray no-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="search-luxuriousvilla overlape">
                        <!-- WIP -->
                        <div class="ticker__viewport">
                            <ul class="ticker__list" data-ticker="list">
                            <? foreach ($ticker_viewport as $item): ?>
                            <li class="ticker__item" data-ticker="item"><a href="<?= $item->url ?>"><?= $item->title ?></a></li>
                            <? endforeach; ?>
                            </ul>
                        </div>
                        <? if (isset($slide_small) && count($slide_small) > 0): ?>
                        <div class="Modern-Slider" id="Modern-Slider" style="display: none">
                                <!-- Item -->
                                <? foreach ($slide_small as $item): ?>

                                <div class="item">
                                    <div class="img-fill">
                                        <!--<img src="//i.imgur.com/8mwd9AL.jpg?1" alt="">-->
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
    </div>
</section>
<section id="paddinglist" class="top20">
    <div class="block no-padding gray2">
        <div class="container">
            <h2 style="text-align: center;"><?= Yii::t('easyii', '49') ?></h2>
            <div class="row">
                <? foreach ($news as $item): ?>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="package">
                            <a href="/news/<?= $item->slug ?>">
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
                                           aria-hidden="true"><b></i> <?= $item->views * 3 ?> <?= Yii::t('easyii', 'viewed') ?></b>

                                    </div>
                                    <div class="package-centered">
                                        <div id="centered-package">
                                            <h4><a href="/news/<?= $item->slug ?>"><?= $item->title ?></a></h4><br>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>
            <div class='containerrr'>
                <div class="button-container">
                    <div class='button -green center'><b><a href="/news/"><?= Yii::t('easyii', 'othernews') ?></a> </b>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sponsor Carousel -->
    </div>
</section>
<section>
    <div class="block ext-toppadd-one">
        <div class="fixed-bg2" style="background-image: url('<?= Image::thumb('/uploads/theme_villa/parallax2.jpg', 900, 420) ?>');"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="villaeditors-picks">
                        <div class="title1">
                            <h2><?= Yii::t('easyii', '6') ?></h2>
                            <span><?= Yii::t('easyii', '7') ?></span>

                            <p><?= Yii::t('easyii', '8') ?></p>
                        </div>
                        <div class="packages remove-ext2">
                            <div class="row">
                                <? foreach ($offers as $offer): ?>
                                    <div class="col-md-4">
                                        <div class="package">
                                            <a href="/offers/<?= $offer->slug ?>">
                                                <div class="package-thumb">
                                                    <?= Html::img($offer->thumb(280, 200), array('class' => 'sadsa')) ?>
                                                    <span style="font-family: Arial; font-stretch: extra-condensed"><i>€<?= $offer->price ?></i> <b> / <?= Yii::t('easyii', 'days') ?>
                                                            : <?= $offer->how_days ?></b>  </span>
                                                </div>
                                            </a>
                                            <div class="package-detail">
                                                <span class="line"></span>
                                                <a class="cate" href="/offers/<?= $offer->slug ?>"
                                                   title="">Регистрация компании:</a>
                                                <h4><a href="/offers/<?= $offer->slug ?>"
                                                       title="<?= $offer->title ?>"><?= $offer->title ?></a>
                                                </h4>


                                                <ul class="location-book">
                                                    <li class="book-btn"><i class="fa fa-info"></i>
                                                        <a
                                                                href="/offers/<?= $offer->slug ?>"
                                                                title=""><?= Yii::t('easyii', '9') ?></a></li>
                                                    <li class="book-btn"><i class="fa fa-shopping-basket"></i>
                                                        <a href="javascript:void( window.open( 'https://forms.amocrm.ru/forms/html/form_326401_ab9058f531bfbd2671c5d24aa0d8dc90.html?date=<?php echo time(); ?>', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )">
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
    </div>
</section>

<section>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="villa-arrangements">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="villa-arrangementsinfo">
                                    <div class="title1">
                                        <h2><?= Yii::t('easyii', '11') ?></h2>
                                        <span><?= Yii::t('easyii', '12') ?></span>
                                    </div>
                                    <p><?= Yii::t('easyii', '13') ?></p>
                                    <ul class="about-serlist style2">
                                        <li><?= Yii::t('easyii', '14') ?></li>
                                        <li><?= Yii::t('easyii', '15') ?></li>
                                        <li><?= Yii::t('easyii', '16') ?></li>
                                    </ul>
                                    <a href="/banks" class="theme-btn"
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
                                                    <h4>Корпоративный счет!</h4>
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
    </div>
</section>

<?php if (true): ?>
<section>
    <div class="block" id="block1">
        <div class="fixed-bg2" style="background-image: url('<?= Image::thumb('/uploads/theme_villa/parallax3.jpg', 900, 420) ?>');"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="villa-locations">
                        <div class="title1">
                            <h2><?= Yii::t('easyii', '17') ?></h2>
                            <span><?= Yii::t('easyii', '18') ?></span>
                            <p><?= Yii::t('easyii', '19') ?></p>
                        </div>
                        <div class="villa-locationslist">
                            <ul><? foreach ($licenses as $item): ?>
                                <li>
                                    <div class="villa-location" onclick="location.href='/licenses/<?= $item->model->slug ?>'">
                                        <img src="<?= $item->thumb(200, 330) ?>" class="main-banks"/>
                                        <div class="villa-locationinfo">
                                            <span><?= $item->model->title ?></span>
                                        </div>
                                    </div>
                                </li><? endforeach; ?>
                                <li>
                                    <div class="villa-location last" onclick="location.href='/licenses'">
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
    </div>
</section>
<? endif; ?>

<section>
    <div class="block" id="block2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="recent-news">
                        <div class="title1">
                            <h2><a href="/processing"><?= Yii::t('easyii', '21') ?></a></h2>
                            <span><?= Yii::t('easyii', '22') ?></span>

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
                            <div class="recentnews-carousel">
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
                            </div>
                            <!-- Recent News Carousel -->
                        </div>
                    </div>
                    <!-- Recent News -->
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="block grayish high-opacity">
        <div class="fixed-bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="spec-services">
                        <div class="title1 vertical">
                            <h2><?= Yii::t('easyii', '31') ?> <span><?= Yii::t('easyii', '32') ?></span></h2>
                            <span><?= Yii::t('easyii', '33') ?></span>
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
    </div>
</section>

<section class="top20">
    <div class="container">

        <div class="row">
            <div class="col-md-12 h2 text-center">Отзывы</div>
            <div class="col-md-6">
                <div class="bdanzer-card">
                    <div class="h3">Виктория</div>
                    <div><p>"Нигде не могли открыть счет на компанию. Получили около десяти отказов из европейских и
                            азиатских банков. Когда обратились в компанию IQ Decision, то были удивлены оперативности и
                            компетентности юристов. Нам предложили интересное решение и открыли счет. Проконсультировали
                            по подготовке документов, а перевод взяли на себя. С учетом времени, потраченного на сбор
                            документов, на открытие счета ушло всего несколько дней. Благодарим за плодотворное
                            сотрудничество."</p></div>
                </div>
            </div>


            <div class="col-md-6">
                <div class="bdanzer-card">
                    <div class="h3">Инесса</div>
                    <div><p>"Деятельность нашей фирмы такого рода, что у банков все время возникают претензии
                            относительно лицензирования. Хотя, уточню, в нашем случае законом разрешено работать без
                            лицензии. Устав от бесконечных отказов и постоянных претензий банков – решили обратиться к
                            специалистам. Нам открыли счет в европейском и азиатском государствах, что было просто
                            необходимо и важно для нашего бизнеса. Выражаем благодарность за содействие."</p></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="bdanzer-card">
                    <div class="h3">Александр</div>
                    <div><p>"Не мог открыть счет ни в одном банке, куда обращался, чтобы вывести деньги из Латвии.
                            Обратился в IQ Decision и получил консультацию и помощь в этом вопросе. Счет открыли –
                            деньги вывели. Всем доволен. Рекомендую."</p></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="bdanzer-card">
                    <div class="h3">Иван</div>
                    <div><p>"Искал возможность легально оформить криптообменник. Одна юридическая фирма предложила свою
                            помощь, но в результате – так ничего не сделали, только тянули время и обещали. Обращаясь в
                            IQ Decision, особо ни на что не рассчитывал. В итоге, мне все оформили по выгодной цене и
                            довольно быстро."</p></div>
                </div>
            </div>


            <div class="col-md-6">
                <div class="bdanzer-card">
                    <div class="h3">Владимир</div>
                    <div><p>"Имел опыт работы с другой компанией, но столкнулся с мошенничеством. Предоплату взяли, а
                            счет не открыли. Я ходил к ним три месяца подряд, но каждый раз требовалось что-то новое.
                            Партнеры по бизнесу посоветовали обратится к вам. Спасибо, что быстро и четко решили мою
                            проблему. Надеюсь на дальнейшее сотрудничество."</p></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="bdanzer-card">
                    <div class="h3">Михаил</div>
                    <div><p>"В виду постоянной занятости – ценю время. Специалисты компании четко и понятно объяснили,
                            как обстоят дела в Прибалтике и посоветовали конкретные действия. Вначале проконсультировали
                            по телефону, а после назначили личную встречу в ходе которой – были приняты решения. Быстро
                            и законно все оформили. Я остался очень доволен. Рекомендую.
                            "</p></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="bdanzer-card">
                    <div class="h3">Марина</div>
                    <div><p>"Обратилась с деликатной проблемой – важно было решить вопрос с регистрацией бизнеса за
                            рубежом и налогообложением в родной стране. Проконсультировали, помогли, оказали
                            сопровождение. Не ожидала, что все так быстро решится. Теперь периодически обращаюсь за
                            советами. Надежная, проверенная компания."</p></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="bdanzer-card">
                    <div class="h3">Ксения</div>
                    <div><p>"Хотела зарегистрировать компанию за границей, но не знала с чего начать. Как начинающий
                            стартапер - допустила ряд ошибок. Хорошо, что в интернете нашла эту юридическую компанию.
                            Спасибо IQ Decision, что проконсультировали и помогли. Кроме того, подсказали где и как
                            лучше открыть счет на мою компанию и какие могут быть нюансы. В будущем также буду
                            пользоваться их услугами. "</p></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="bdanzer-card">
                    <div class="h3">Ольга</div>
                    <div><p>"Давно занимаюсь бизнесом в Украине. Недавно получила предложение из-за границы насчет
                            сотрудничества. Для этого было необходимо зарегистрировать компанию и открыть счет. По
                            неопытности сначала повелась на предложение одного «юриста» зарегистрировать компанию на
                            Маршалловых островах, но хороший знакомый посоветовал проконсультироваться у специалистов
                            компании IQ Decision насчет альтернативных вариантов. Оказалось, что в 2018 году на компанию
                            на Маршалловых островах практически невозможно открыть счет – банки воспринимают компании из
                            этого государства – как оффшор. Таким образом, я чуть не купила себе проблемы. Благодаря IQ
                            Decision, оформила бизнес в Европе (счет и компанию) и планирую дальше расширять свое дело.
                            Искренне благодарю!"</p></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="bdanzer-card">
                    <div class="h3">Марк</div>
                    <div><p>"Я давно занимаюсь форексом как трейдер. Недавно решил оформить брокерство и открыть счет,
                            чтобы иметь возможность увеличить доход. Не думал, что столкнусь с таким количеством
                            сложностей: получить лицензию тяжело, а оформить счет на форекс – вообще оказалось
                            нереально. К счастью, в интернете наткнулся на IQ Decision и обратился к ним. Девушка уже по
                            телефону подробно и бесплатно проконсультировала по моему вопросу. После того как я принял
                            окончательное решение – мне помогли открыть счет. Причем предлагали несколько вариантов с
                            разными преимуществами – я выбрал оптимальный для себя. Спасибо."</p></div>
                </div>
            </div>
        </div>
    </div>
</section>

<? if(false): ?>
<section>
    <div class="block no-padding blackish high2-opacity">
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
    </div>
</section>
<? endif; ?>

