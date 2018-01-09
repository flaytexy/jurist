<?php
/** Created by CyberBrain  */
//use frontend\modules\shopcart\api\Shopcart;
//use frontend\modules\subscribe\api\Subscribe;
//use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$popularly = \frontend\models\Popularly::find()->limit(7)->all();

$phoneStr = "+7 925 470 50 02";

$addeng = Yii::t('easyii', 'free');
$addlang = frontend\widgets\WLang::widget();



?>
<?php $this->beginContent('@app/views/layouts/base.php'); ?>

<!--<link href="https://fonts.googleapis.com/css?family=Cabin" rel="stylesheet">-->
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">-->
<!--<link rel='stylesheet prefetch' href='http://cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css'>-->
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
<!--<link rel="stylesheet" href="/uploads/style.css?v=2017-11-26-v1">-->
<script language="JavaScript">
    document.onselectstart = function () {
        return false
    }
</script>

<div class="theme-layout" id="theme-layout-js">
    <header class="stick scrollup visible-md-block visible-lg">
        <div class="top-bar">
            <div class="container">
                <div class="topbar-data">
                    <? if (false): ?>
                        <ul class="top-menus" id="top-menus">
                            <li><a href="/fonds" title="Фонды">Фонды</a></li>
                            <li class="dropdown">
                                <a class="" title="Банки" data-toggle="dropdown" data-submenu=""
                                   href="/banks">Банки<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-submenu">
                                        <a tabindex="0">Europe</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="" href="/banks" title="Банки">Банк1</a></li>
                                            <li><a class="" href="/banks" title="Банки">Банк1</a></li>
                                            <li><a class="" href="/banks" title="Банки">Банк1</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a tabindex="0">Asia and the Pacific</a>

                                        <ul class="dropdown-menu">
                                            <li><a class="" href="/banks" title="Банки">Банк1</a></li>
                                            <li><a class="" href="/banks" title="Банки">Банк1</a></li>
                                            <li><a class="" href="/banks" title="Банки">Банк1</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="/offshornyie-predlozheniya" title="Компании">Компании</a></li>
                            <li><a href="/licenses" title="Лицензии">Лицензии</a></li>
                            <li><a href="/offshore" title="Оффшоры">Оффшоры</a></li>
                            <li><a href="/processing" title="Процессинг">Процессинг</a></li>
                            <li><a href="/sale" title="Продается">Продается</a></li>
                            <li class="contact-m">
                                <div class="row">
                                    <div class="col-md-12 tel-m"><a
                                                href="tel: <?php echo str_replace(' ', '', $phoneStr); ?>"
                                                title="Наш телефон"><?= $phoneStr ?></a></div>
                                </div>
                                <div class="row back-m" onclick="location.href='/contact'">
                                    Связаться с нами
                                </div>
                            </li>
                            <li class="skype hidden-xs" title="Вызов в skype: IQ Decision">
                                <a href="skype:IQ Decision?call">
                                    <div></div>
                                </a>
                            </li>
                        </ul>
                    <? endif; ?>
                    <?= Menu::widget([
                        'options' => ['class' => 'top-menus', 'id' => 'top-menus'],
                        'items' => [
                            ['label' => Yii::t('easyii', 'funds'), 'url' => ['/fonds'], 'options' => ['title' => 'Фонды']],
                            ['label' => Yii::t('easyii', 'banks'), 'url' => ['/banks'],
                                'options' => ['class' => 'menu-item-has-children', 'title' => 'Банки'],
//                                        'items' => [
//                                            ['label' => 'New Arrivals', 'url' => ['news/index', 'tag' => 'new'],
//                                                'options' => ['class' => 'menu-item-has-children'],
//                                                'items' => [
//                                                    ['label' => 'New Arrivals', 'url' => ['news/index', 'tag' => 'new']],
//                                                    ['label' => 'Most Popular', 'url' => ['news/index', 'tag' => 'popular']],
//                                                ],
//                                            ],
//                                            ['label' => 'Most Popular', 'url' => ['news/index', 'tag' => 'popular']],
//                                        ],
                                //'template' => '<li class="menu-item-has-children"><a href="{url}" class="mylink">{label}</a></li>',
                            ],
                            ['label' => Yii::t('easyii', 'companies'), 'url' => ['/offshornyie-predlozheniya'], 'options' => ['title' => 'Компании']],
                            ['label' => Yii::t('easyii', 'licenses'), 'url' => ['/licenses'], 'options' => ['title' => 'Лицензии']],
                            ['label' => Yii::t('easyii', 'offshores'), 'url' => ['/offshore'], 'options' => ['title' => 'Оффшоры']],
                            ['label' => Yii::t('easyii', 'processing'), 'url' => ['/processing'], 'options' => ['title' => 'Процессинг']],
                            ['label' => Yii::t('easyii', 'sells'), 'url' => ['/sale'], 'options' => ['title' => 'Продается']],

                            ['label' => 'contact', 'url' => ['/contact'],
                                'template' => '
                                <li class="contact-m">
                                <!--    <div class="row">
                                        <div class="col-md-12 tel-m"><a href="tel: ' . str_replace(' ', '', $phoneStr) . '" title="Наш телефон">' . $phoneStr . '</a></div>
                                    </div>
                                    <div class="row back-m" onclick="location.href=\'/contact\'">
                                        Связаться с нами
                                    </div>
                                </li>-->
                                <li class="skype hidden-xs" title="Вызов в skype: IQ Decision">
                                    <a href="skype:iq.decision@gmail.com?call"><i class="fa fa-skype" aria-hidden="true"></i><br><b style="font-size: 12px">IQ Decision</b></a>
                                </li>'
                            ],
                        ],
                    ]); ?>
                    <?= frontend\widgets\WLang::widget(); ?>
                </div>
            </div>
        </div>
        <!-- Top Bar -->
        <div class="logomenu-sec hidden-xs" id="logomenu-sec">
            <div class="container">
                <div class="row">
                    <div class="col-md-2 ">
                        <div class="logo logo_main"><a href="/" title=""><img src="/uploads/logo/logo_main.gif" alt=""></a>
                        </div>
                    </div>
                    <div class="col-md-3" id="searchBlock">
                        <? if (false): ?>
                            <? $form = ActiveForm::begin(['action' => 'search', 'id' => 'forum_post',
                                'method' => 'post',
                            ]); ?>
                            <div class="search-inp row no-padding">
                                <div class="col-md-9 no-padding ">
                                    <?= Html::input('text', 'search', $search, []) ?>
                                </div>
                                <div class="col-md-3 no-padding ">
                                    <?= Html::submitButton(Yii::t('easyii', 'Search'), ['class' => 'btn btn-primary submit']) ?>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                        <? endif ?>

                        <gcse:search></gcse:search>
                    </div>
                    <div class="col-md-7 ">
                        <nav class="navbar22 navbar-default22">
                            <?= Menu::widget([
                                'options' => ['class' => 'inline'],
                                'items' => [
                                    //['label' => 'Главная', 'url' => ['site/index'], 'template' => '<li class="22"><a href="{url}" class="mylink"><span>{label}</span></a></li>'],
                                    ['label' => Yii::t('easyii', 'main'), 'url' => ['site/index']],
                                    //['label' => 'Оффшорные предложения', 'url' => ['/offshornyie-predlozheniya']],
                                    //['label' => 'Европейские компании', 'url' => ['/evropejskie-kompanii']],
                                    //['label' => 'Shop', 'url' => ['shop/index']],
                                    ['label' => Yii::t('easyii', 'news'),
                                        'url' => ['/news'],
                                        'options' => ['class' => 'menu-item-has-children'],
//                                        'items' => [
//                                            ['label' => 'New Arrivals', 'url' => ['news/index', 'tag' => 'new'],
//                                                'options' => ['class' => 'menu-item-has-children'],
//                                                'items' => [
//                                                    ['label' => 'New Arrivals', 'url' => ['news/index', 'tag' => 'new']],
//                                                    ['label' => 'Most Popular', 'url' => ['news/index', 'tag' => 'popular']],
//                                                ],
//                                            ],
//                                            ['label' => 'Most Popular', 'url' => ['news/index', 'tag' => 'popular']],
//                                        ],
                                        //'template' => '<li class="menu-item-has-children"><a href="{url}" class="mylink">{label}</a></li>',
                                    ],
                                    //['label' => 'Банки', 'url' => ['/banks']],
                                    //['label' => 'Articles', 'url' => ['articles/index']],
                                    //['label' => 'Gallery', 'url' => ['gallery/index']],
                                    //['label' => 'Guestbook', 'url' => ['guestbook/index']],
                                    //['label' => 'Информация', 'url' => ['/faq']],
                                    ['label' => Yii::t('easyii', 'faq'), 'url' => ['/faq']],
                                    ['label' => Yii::t('easyii', 'contact'), 'url' => ['/contact']],
                                    ['label' => 'contact', 'url' => ['/contact'],
                                        'template' => '
                                <li class="contact-m">
                                    <div class="row">
                                        <div class="col-md-12 tel-m"><a href="tel: ' . str_replace(' ', '', $phoneStr) . '" title="Наш телефон">' . $phoneStr . '</a><a href="tel: +380671931117" title="Наш телефон">+38 067 193 11 17</a><p class="lenta">' . $addeng . ' </p></div>
                                    </div>
                                </li>'
                                    ],
                                ],
                            ]); ?>
                        </nav>
                    </div>
                </div>

            </div>
        </div>
        <!-- Logo Menu Sec -->
    </header>

    <!-- Header -->
    <div class="responsive-header">

        <div class="top-bar">
            <!--            <ul class="sign-btns">
                            <li><a href="#" title=""><i class="fa fa-unlock-alt"></i> Log In</a></li>
                            <li><a href="#" title=""><i class="fa fa-plus"></i> Sign Up</a></li>
                        </ul>-->
            <!--            <ul class="language-select">
                            <li><img src="/uploads/theme_villa/lang1.jpg" alt=""></li>
                        </ul>-->
        </div>


        <div class="logomenu-bar">

            <div class="logodiv"><a href="/" title=""><img src="/uploads/logo/logo.png" alt=""></a></div>

            <div class="container">


                <div class="centeredmenulist">

                    <span class="vmenu"><a href="/banks"><?= Yii::t('easyii', 'banks') ?>&nbsp;</a></span>
                    <span class="vmenu">|&nbsp;</span>
                    <span class="vmenu"><a href="/offshornyie-predlozheniya"><?= Yii::t('easyii', 'companies') ?>
                            &nbsp;</a></span>
                    <span class="vmenu">|&nbsp;</span>
                    <span class="vmenu"><a href="/licenses"><?= Yii::t('easyii', 'licenses') ?>&nbsp;</a></span>
                    <span class="vmenu">|&nbsp;</span>
                    <span class="vmenu"><a href="/fonds"><?= Yii::t('easyii', 'funds') ?>&nbsp;</a></span>


                </div>

            </div>
            <div class="btncenter"><span class="menu-btn">&nbsp;<i class="fa fa-list"></i></span></div>
        </div>
        <div class="responsive-menu ps-container" data-ps-id="3359a5b1-f4a3-6575-dffa-5413f2e717d2">
            <span class="close-btn"><i class="fa fa-close"></i></span>
            <script>
                (function () {
                    var cx = '014824414261944164439:sfk3fpa6eoq';
                    var gcse = document.createElement('script');
                    gcse.type = 'text/javascript';
                    gcse.async = true;
                    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(gcse, s);
                })();
            </script>
            <?= frontend\widgets\WLang::widget(); ?><br><br>
            <gcse:search></gcse:search>
            <?= Menu::widget([
                'options' => ['class' => 'nav navbar-nav'],
                'items' => [
                    ['label' => Yii::t('easyii', 'main'), 'url' => ['site/index']],


                    ['label' => Yii::t('easyii', 'funds'), 'url' => ['/fonds']],
                    ['label' => Yii::t('easyii', 'banks'), 'url' => ['/banks']],
                    ['label' => Yii::t('easyii', 'companies'), 'url' => ['/offshornyie-predlozheniya']],
                    ['label' => Yii::t('easyii', 'licenses'), 'url' => ['/licenses']],
                    ['label' => Yii::t('easyii', 'processing'), 'url' => ['/processing']],
                    ['label' => Yii::t('easyii', 'sells'), 'url' => ['/sale']],
                    //['label' => 'Европейские компании', 'url' => ['/evropejskie-kompanii']],
                    //['label' => 'Shop', 'url' => ['shop/index']],
                    ['label' => Yii::t('easyii', 'news'), 'url' => ['/news']],
                    //['label' => 'Articles', 'url' => ['articles/index']],
                    //['label' => 'Gallery', 'url' => ['gallery/index']],
                    //['label' => 'Guestbook', 'url' => ['guestbook/index']],
                    //['label' => 'Информация', 'url' => ['/faq']],
                    ['label' => Yii::t('easyii', 'contact'), 'url' => ['/contact']],
                ],
            ]); ?>
            <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;">
                <div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div>
            </div>
            <div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px;">
                <div class="ps-scrollbar-y" style="top: 0px; height: 0px;"></div>
            </div>
            <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;">
                <div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div>
            </div>
            <div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px;">
                <div class="ps-scrollbar-y" style="top: 0px; height: 0px;"></div>
            </div>
        </div>
        <!-- Responsive Menu -->
        <ul class="topbar-contact">
            <!--  <li class="active"><i class="fa fa-envelope-o"></i> contacts@yoursites.com</li>-->
            <!--           <li><i class="fa fa-phone"></i> +79251754417</li>-->
        </ul>
    </div>
    <!-- Responsive Header -->
    <div class="row">
        <?php if ($this->context->id != 'site') : ?>
            <div class="pagetop-sec">
                <div class="fixed-bg2" style="background-image: url('/uploads/theme_villa/pagetop-bg.jpg');"></div>
                <div class="container">
                    <div class="page-title">
                        <strong><span>
                                <?php if (count($this->params['breadcrumbs'][0]) == 1): ?>
                                    <?= $this->params['breadcrumbs'][0] ?>
                                <? elseif (!empty($this->params['breadcrumbs'][1])): ?>
                                    <?= $this->params['breadcrumbs'][1] ?>
                                <? endif; ?>
                            </span>
                        </strong>
                        <?= Breadcrumbs::widget([
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            'class' => 'breadcrumbs'
                        ]) ?>
                    </div>
                </div>
            </div><!-- Page Top Sec -->
        <?php endif; ?>
    </div>

    <?= $content ?>
    <div class="push"></div>

    <section>
        <div class="block no-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="instagram">
                        <div class="title1 light">
                            <h2> <?= Yii::t('easyii', 'lastviews') ?></h2>
                            <span> <?= Yii::t('easyii', 'maybe') ?></span>

                        </div>
                        <div class="instagram-gallery">

                            <ul>


                                <?php foreach ($popularly as $item) : ?>

                                    <?php if (!empty($item->image)): ?>
                                        <li>
                                            <a href="<?= Url::to([$item->slug]) ?>">

                                                <?= Html::img(\frontend\helpers\Image::thumb($item->image, 150, 150), array('class' => 'main-news')) ?>
                                                <div class="offered-serviceinfo">
                                                    <span style="font-weight: bolder; color: white;  text-shadow: -5px 0 10px black, 0 5px 10px black, 5px 0 10px black, 0 -5px 10px black; "><?= $item->title ?></span>

                                                </div>


                                            </a>

                                        </li>
                                    <? endif; ?>
                                <? endforeach; ?>
                            </ul>

                        </div>
                        <!-- Instagram Gallery -->
                    </div>
                    <!-- Instagram -->
                </div>
            </div>
        </div>
    </section>
</div>
<footer>
    <div class="block dark">
        <div class="container">




            <div class="row">
                <div class="col-md-12">
                    <section>
                        <div class="feature-box-grid">
                            <div class="col-md-4 col-sm-4">
                                <div class="featured-item border-box text-center">
                                    <div class="icon">
                                        <i class="fa fa-globe"></i>
                                    </div>
                                    <div class="title text-uppercase">
                                        <h4><?= Yii::t('easyii', 'successful') ?></h4>
                                    </div>
                                    <div class="desc">
                                        <?= Yii::t('easyii', 'reg28') ?><br><br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="featured-item border-box text-center">
                                    <div class="icon">
                                        <i class="fa fa-university"></i>
                                    </div>
                                    <div class="title text-uppercase">
                                        <h4><?= Yii::t('easyii', 'openaccounts') ?></h4>
                                    </div>
                                    <div class="desc">
                                        <?= Yii::t('easyii', '48banks') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="featured-item border-box text-center">
                                    <div class="icon">
                                        <i class="flaticon-people"></i>
                                    </div>
                                    <div class="title text-uppercase">
                                        <h4><?= Yii::t('easyii', 'consult') ?></h4>
                                    </div>
                                    <div class="desc">
                                        <?= Yii::t('easyii', 'goodtime') ?><br><br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="featured-item border-box text-center">
                                    <div class="icon">
                                        <i class="fa fa-handshake-o"></i>
                                    </div>
                                    <div class="title text-uppercase">
                                        <h4><?= Yii::t('easyii', 'terpelivo') ?></h4>
                                    </div>
                                    <div class="desc">
                                        <?= Yii::t('easyii', 'talkyou') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="footer-widget">
                        <div class="about-widget">
                            <div class="logo">
                                <a href="/" title=""><img src="/uploads/logo/logo.png" alt=""></a>
                            </div>
                            <p><?= Yii::t('easyii', 'text1') ?><br/>
                                <?= Yii::t('easyii', 'text2') ?></p>

                            <p><?= Yii::t('easyii', 'text3') ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer-widget">
                        <div class="address-widget">
                            <p style="color: white">
                                <strong style="color: #7dc20f"><i
                                            class="fa fa-map-marker"></i> <?= Yii::t('easyii', 'address') ?>
                                </strong><br>
                                <?= Yii::t('easyii', 'addressinfo1') ?>
                            </p>
                            <p style="color: white">
                                <strong style="color: #7dc20f"><i
                                            class="fa fa-map-marker"></i> <?= Yii::t('easyii', 'address') ?>
                                    2</strong><br>
                                <?= Yii::t('easyii', 'addressinfo2') ?>
                            </p>
                            <p style="color: white"><strong style="color: #7dc20f"><i
                                            class="fa fa-phone"></i> <?= Yii::t('easyii', 'number') ?></strong><br>
                                +7 925 470 50 02 <br> +38 067 193 11 17</p>
                            <p style="color: white"><strong style="color: #7dc20f"><i
                                            class="fa fa-clock-o"></i><?= Yii::t('easyii', 'worktime') ?></strong><br>
                                09:00-19:00</p>
                            <p style="color: white">
                                <strong style="color: #7dc20f"><i class="fa fa-envelope"></i> E-mail</strong><br>
                                <a href="mailto:one@iq-offshore.com">one@iq-offshore.com</a></p>
                            <p style="color: white"><strong style="color: #7dc20f"><i class="fa fa-skype"></i>
                                    Skype</strong><br>
                                <a href="skype:IQ Decision?call">IQ Decision</a></p>
                            <a href="javascript:void( window.open( 'https://form.jotformeu.com/71136944138357', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=left' ) )"
                               class="theme-btn" title=""><?= Yii::t('easyii', 'contactus') ?></a>
                        </div>
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="footer-widget">
                        <div id="map" style="height: 450px;width: 100%"></div>
                    </div>

                </div>
                <div class="col-md-2">
                    <div class="footer-widget">
                        <div class="title1 style2">
                            <h2>Быстрый переход</h2>
                        </div>
                        <div class="menu-links">
                            <script type='text/javascript'> var _d_site = _d_site || '411086831FF94A27DC0340B2'; </script>
                            <div class="privy-embed-form" data-campaign="216143"></div>
                        </div>
                    </div>
                </div>


            </div>


        </div>

    </div>
    <div class="bottom-line">
        <div class="bottom-menu">
            <div class="container">
                <ul class="footer-links">
                    <li><a href="/" title=""><?= Yii::t('easyii', 'main') ?></a></li>
                    <li><a href="/news" title=""><?= Yii::t('easyii', 'news') ?></a></li>
                    <li><a href="/contact" title=""><?= Yii::t('easyii', 'contact') ?></a></li>
                </ul>
                <ul class="Social-btn">
                    <li><a href="#" title=""><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#" title=""><i class="fa fa-linkedin"></i></a></li>
                    <li><a href="#" title=""><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#" title=""><i class="fa fa-skype"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <?php /*<div class="container">
                <p><span>Copyright 2016.</span> Created by <a title="Cyber Brain - Web Studio">Cyber Brain </a></p>
            </div> */ ?>
        </div>
    </div>
    <!-- Bottom Line -->
</footer>

<aside id="sticky-social">
<ul class="list-social">
    <li><a href="viber://add?number=+79254705002"><img
                    src="https://images-na.ssl-images-amazon.com/images/I/51-aTeYbibL.png"
                    height="38" width="38" alt="В целях безопасности клиентов"></a></li>
    <li><a href="https://api.whatsapp.com/send?phone=79254705002"><img
                    src="http://icons.iconarchive.com/icons/dtafalonso/android-l/512/WhatsApp-icon.png"
                    height="38" width="38" alt="В целях безопасности клиентов"></a></li>
    <li><img src="http://downdetector.com/i/logo/threema.png" height="32" width="32"
             alt="В целях безопасности клиентов"></li>
    <li><a href="#"><img
                    src="https://seeklogo.com/images/T/telegram-logo-AD3D08A014-seeklogo.com.png"
                    height="38" width="38" alt="В целях безопасности клиентов"></a></li>
    <li><a href="skype:iq.decision@gmail.com?call"><img
                    src="https://upload.wikimedia.org/wikipedia/commons/0/05/Skype_t.png"
                    height="38" width="38" alt="В целях безопасности клиентов"></a></li>
    <li>
        <input name="" width="30" type="image" src="http://iq-offshore.com/uploads/logo/arrow.png"
               value="Click me" id="clicky" />
    </li>
</ul>

</aside>


<div id="stl_left" style="display: block; opacity: 1; width: 178px;" class="">
    <div id="stl_bg">
        <nobr id="stl_text">Вверх</nobr>
    </div>
</div>
<a href="#" class="scrollToTop"></a>

<?php if (!YII_DEBUG): ?>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWVV9qdg3P78sJnnzvx1o9CJ6nqSKagG0&callback=initMap" type="text/javascript">
</script>
<!-- BEGIN PRIVY WIDGET CODE -->
<script type='text/javascript'>
    var _d_site = _d_site || '411086831FF94A27DC0340B2';
    //google.maps.event.addDomListener(window, 'load', initMap);

    function initMap() {
        var mapOptions = {
            zoom: 15,
            center: new google.maps.LatLng(55.800312, 37.565437), // New York
            //styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#4f595d"},{"visibility":"on"}]}]
        };

        var mapElement = document.getElementById('map');
        var map = new google.maps.Map(mapElement, mapOptions);

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(55.800312, 37.565437),
            map: map,
            title: 'Snazzy!'
        });
    }
</script>
<!-- END PRIVY WIDGET CODE -->

<script src="https://cdn.jotfor.ms/static/feedback2.js">
    document.addEventListener("DOMContentLoaded", function(event) {
        new JotformFeedback({
            formId: "72341635329355",
            buttonText: "<?= Yii::t('easyii', '74')?>",
            base: "https://form.jotformeu.com/",
            background: "#7dc20f",
            fontColor: "#FFFFFF",
            buttonSide: "left",
            buttonAlign: "center",
            type: 1,
            width: 550,
            height: 450
        });
    });
</script>

<!--Start of Tawk.to Script-->
<script async defer  type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5a295e135d3202175d9b6ea0/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->
<?php endif; ?>

<?php $this->endContent(); ?>
