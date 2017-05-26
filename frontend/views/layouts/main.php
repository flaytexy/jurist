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


?>
<?php $this->beginContent('@app/views/layouts/base.php'); ?>

<script src="//load.sumome.com/" data-sumo-site-id="3e9ad4ed5127b8e285ee649aa55e8340bf5eb21a370f52999a717953ee42fd89" async="async"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>


<link href="https://fonts.googleapis.com/css?family=Cabin" rel="stylesheet">
<div class="js"><div id="preloader"><hr class="hr-text" data-content="IQ Decision">
       <div class="preloader">
            <div class="circ1"></div>
            <div class="circ2"></div>
            <div class="circ3"></div>
            <div class="circ4"></div>
        </div></div></div>
<style>


    .hr-text {
        line-height: 1em;
        position: relative;
        outline: 0;
        border: 0;
        color: black;
        text-align: center;
        height: 1.5em;
        opacity: 1;
top: 250px;


    }
    .hr-text:before {
        content: '';
        background: -webkit-linear-gradient(left, transparent, #72c2a1, transparent);
        background: linear-gradient(to right, transparent, #72c2a1, transparent);
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 1px;
    }
    .hr-text:after {
        content: attr(data-content);
        position: relative;
        display: inline-block;
        color: black;
        padding: 0 .5em;
        line-height: 1.5em;
        color: #72c2a1;
        background-color: #ffffff;
        font-size: 20px;
        font-family: 'Cabin', sans-serif;
    }
    .powered-by-sumo {
        display: none !important;
    }
    iframe#sumome-jquery-iframe{
        display: none !important;
    }
    div#sumome-modal-mask{
        display: none !important;
    }
    a[title="Sumo"]{
       visibility: hidden !important;
        opacity: 0 !important;
    }
    .js div#preloader { position: fixed; left: 0; top: 0; z-index: 999999; width: 100%; height: 100%; overflow: visible; background: #fff url('') no-repeat center center; }
    .preloader {
        margin: 300px auto;
        width: 70px;
        height: 30px;
        text-align: center;
        font-size: 10px;
    }

    .preloader > div {
        background-color: #72c2a1;
        height: 10px;

        width: 10px;
        border-radius: 50%;
        display: inline-block;

        -webkit-animation: stretchdelay 0.7s infinite ease-in-out;
        animation: stretchdelay 0.7s infinite ease-in-out;
    }

    .preloader .circ2 {
        -webkit-animation-delay: -0.6s;
        animation-delay: -0.6s;
    }

    .preloader .circ3 {
        -webkit-animation-delay: -0.5s;
        animation-delay: -0.5s;
    }

    .preloader .circ4 {
        -webkit-animation-delay: -0.4s;
        animation-delay: -0.4s;
    }

    .preloader .circ5 {
        -webkit-animation-delay: -0.3s;
        animation-delay: -0.3s;
    }

    @-webkit-keyframes stretchdelay {
        0%, 40%, 100% { -webkit-transform: translateY(-10px) }
        20% { -webkit-transform: translateY(-20px) }
    }

    @keyframes stretchdelay {
        0%, 40%, 100% {
            transform: translateY(-10px);
            -webkit-transform: translateY(-10px);
        } 20% {
              transform: translateY(-20px);
              -webkit-transform: translateY(-20px);
          }
    }

</style>

<style>

</style>
<script>

</script>
<script language="JavaScript">
    document.onselectstart=function(){return false}

</script>
<? if (YII_ENV_PROD) : ?>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function () {
                try {
                    w.yaCounter42375894 = new Ya.Metrika({
                        id: 42375894,
                        clickmap: true,
                        trackLinks: true,
                        accurateTrackBounce: true,
                        webvisor: true
                    });
                } catch (e) {
                }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () {
                    n.parentNode.insertBefore(s, n);
                };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else {
                f();
            }
        })(document, window, "yandex_metrika_callbacks");
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/42375894" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript"> (function (d, w, c) {
            (w[c] = w[c] || []).push(function () {
                try {
                    w.yaCounter43132404 = new Ya.Metrika({
                        id: 43132404,
                        clickmap: true,
                        trackLinks: true,
                        accurateTrackBounce: true
                    });
                } catch (e) {
                }
            });
            var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () {
                n.parentNode.insertBefore(s, n);
            };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/watch.js";
            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else {
                f();
            }
        })(document, window, "yandex_metrika_callbacks"); </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/43132404" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript> <!-- /Yandex.Metrika counter -->

    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-90951237-1', 'auto');
        ga('send', 'pageview');

    </script>


    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-92818031-1', 'auto');
        ga('send', 'pageview');

    </script>


<? endif ?>
<style>
    .skype {
        padding-top: 6px;
    }
    @media (max-width: 1000px) {
        .top-bar {
            display: none;
        }
        .fun-facts > ul > li:nth-child(2n+1) {
            padding-right: 50px !important;
        }

        .fun-facts > ul > li:nth-child(2n) {
            padding-left: 10px !important;
        }

        .instagram .title1::before {
            display: none;
        }
        #rc-phone {

            bottom: 0 !important;
            top: 0 !important;
            right: 0 !important;
            left: 5px !important;
            transition: none !important;
            width: 30px !important;
            height: 30px !important;
        }
        .rc-mobile #rc-phone-back {
            margin-top: 0 !important;
        }
        .feature-box-grid {
            display:none;
        }


    }
    .vmenu
     {
        color: #fbfbfb;
        cursor: pointer;
        float: right;
        font-size: 15px;
        margin-right: 0;
        padding-top: 5px;
    }
    .vmenu a {
        color: #fbfbfb;
        cursor: pointer;
        float: right;
        font-size: 15px;
        margin-right: 2px;

    }
</style>

<div class="theme-layout" id="theme-layout-js">
    <header class="stick scrollup">
        <div class="top-bar">
            <div class="container">
                <div class="topbar-data">
                    <? if(false): ?>
                    <ul class="top-menus" id="top-menus">
                        <li><a href="/fonds" title="Фонды">Фонды</a></li>
                        <li class="dropdown">
                            <a class=""  title="Банки" data-toggle="dropdown" data-submenu="" href="/banks">Банки<span class="caret"></span></a>
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
                        <li class="contact-m">
                            <div class="row">
                                <div class="col-md-12 tel-m"><a href="tel: <?php echo str_replace(' ','',$phoneStr);?>" title="Наш телефон"><?=$phoneStr?></a></div>
                                <!--                                <div class="skype" title="Вызов в skype: IQ Decision">-->
                                <!--                                <a href="skype:IQ Decision?call">-->
                                <!--                                    <div style="background-image: url(&quot;http://www.skypeassets.com/i/scom/images/skype-buttons/callbutton_16px.png&quot;); width: 16px; height: 16px; padding-left: 18px; top: 0px; position: relative; right: -127px;"></div>-->
                                <!--                                </a>-->
                                <!--                                </div>-->
                            </div>
                            <div class="row back-m" onclick="location.href='/contact'">
                                Связаться с нами
                            </div>
                        </li>
                        <li class="skype hidden-xs" title="Вызов в skype: IQ Decision">
                            <a href="skype:IQ Decision?call"><div></div></a>
                        </li>
                    </ul>
                    <? endif; ?>
                    <?= Menu::widget([
                        'options' => ['class' => 'top-menus', 'id' => 'top-menus'],
                        'items' => [
                            ['label' => 'Фонды', 'url' => ['/fonds'], 'options' => ['title' => 'Фонды']],
                            ['label' => 'Банки', 'url' => ['/banks'],
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
                            ['label' => 'Компании', 'url' => ['/offshornyie-predlozheniya'], 'options' => ['title' => 'Компании']],
                            ['label' => 'Лицензии', 'url' => ['/licenses'], 'options' => ['title' => 'Лицензии']],
                            ['label' => 'Оффшоры', 'url' => ['/offshore'], 'options' => ['title' => 'Оффшоры']],
                            ['label' => 'Процессинг', 'url' => ['/processing'], 'options' => ['title' => 'Процессинг']],

                            ['label' => 'contact', 'url' => ['/contact'],
                                'template' => '
                                <li class="contact-m">
                                    <div class="row">
                                        <div class="col-md-12 tel-m"><a href="tel: '. str_replace(' ','',$phoneStr).'" title="Наш телефон">'.$phoneStr.'</a></div>
                                    </div>
                                    <div class="row back-m" onclick="location.href=\'/contact\'">
                                        Связаться с нами
                                    </div>
                                </li>
                                <li class="skype hidden-xs" title="Вызов в skype: IQ Decision">
                                    <a href="skype:IQ Decision?call"><div></div></a>
                                </li>'
                            ],
                        ],
                    ]); ?>

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
                    <div class="col-md-3 ">
                        <? if (false): ?>
                        <? $form = ActiveForm::begin([ 'action' => 'search', 'id' => 'forum_post',
                            'method' => 'post',
                        ]); ?>
                        <div class="search-inp row no-padding">
                            <div class="col-md-9 no-padding ">
                                <?= Html::input('text','search', $search,[]) ?>
                            </div>
                            <div class="col-md-3 no-padding ">
                                <?= Html::submitButton(Yii::t('easyii', 'Search'), ['class' => 'btn btn-primary submit']) ?>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                        <? endif ?>
        <!--                <script>
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
                        <gcse:search></gcse:search>-->
                    </div>
                    <div class="col-md-7 ">
                        <nav class="navbar22 navbar-default22">
                            <?= Menu::widget([
                                'options' => ['class' => 'nav navbar-nav'],
                                'items' => [
                                    //['label' => 'Главная', 'url' => ['site/index'], 'template' => '<li class="22"><a href="{url}" class="mylink"><span>{label}</span></a></li>'],
                                    ['label' => 'Главная', 'url' => ['site/index']],
                                    //['label' => 'Оффшорные предложения', 'url' => ['/offshornyie-predlozheniya']],
                                    //['label' => 'Европейские компании', 'url' => ['/evropejskie-kompanii']],
                                    //['label' => 'Shop', 'url' => ['shop/index']],
                                    ['label' => 'Новости',
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
                                    ['label' => 'Вопросы ответы', 'url' => ['/faq']],
                                    ['label' => 'Контакты', 'url' => ['/contact']]
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

    <span  class="vmenu"><a href="/banks">Банки&nbsp;</a></span>
    <span  class="vmenu">|&nbsp;</span>
    <span  class="vmenu"><a href="/offshornyie-predlozheniya">Компании&nbsp;</a></span>
    <span  class="vmenu">|&nbsp;</span>
    <span  class="vmenu"><a href="/licenses">Лицензии&nbsp;</a></span>
    <span  class="vmenu">|&nbsp;</span>
    <span  class="vmenu"><a href="/fonds">Фонды&nbsp;</a></span>


</div>
            </div>
          <div class="btncenter"><span class="menu-btn">&nbsp;<i class="fa fa-list"></i></span></div>
        </div>
        <div class="responsive-menu ps-container" data-ps-id="3359a5b1-f4a3-6575-dffa-5413f2e717d2">
            <span class="close-btn"><i class="fa fa-close"></i></span>
            <?= Menu::widget([
                'options' => ['class' => 'nav navbar-nav'],
                'items' => [
                    ['label' => 'Главная', 'url' => ['site/index']],


                    ['label' => 'Фонды', 'url' => ['/fonds']],
                    ['label' => 'Банки', 'url' => ['/banks']],
                    ['label' => 'Компании', 'url' => ['/offshornyie-predlozheniya']],
                    ['label' => 'Лицензии', 'url' => ['/licenses']],
                    ['label' => 'Мерчант', 'url' => ['/processing']],
                    //['label' => 'Европейские компании', 'url' => ['/evropejskie-kompanii']],
                    //['label' => 'Shop', 'url' => ['shop/index']],
                    ['label' => 'Новости', 'url' => ['/news']],

                    //['label' => 'Articles', 'url' => ['articles/index']],
                    //['label' => 'Gallery', 'url' => ['gallery/index']],
                    //['label' => 'Guestbook', 'url' => ['guestbook/index']],
                    //['label' => 'Информация', 'url' => ['/faq']],
                    ['label' => 'Контакты', 'url' => ['/contact']]
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
                            <h2>Последнее просмотренное нашими посетителями:</h2>
                            <span>Возможно, это и Вас заинтересует</span>
                        </div>
                        <div class="instagram-gallery">

                            <ul>



                                <?php foreach ($popularly as $item) : ?>

                                    <?php if (!empty($item->image)): ?>
                                        <li>
                                            <a href="<?= Url::to([$item->slug]) ?>">

                                                <?= Html::img(\frontend\helpers\Image::thumb( $item->image, 150, 150), array('class' => 'main-news'))   ?>
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
    <!--
        You need to include this script tag on any page that has a Google Map.

        The following script tag will work when opening this example locally on your computer.
        But if you use this on a localhost server or a live website you will need to include an API key.
        Sign up for one here (it's free for small usage):
            https://developers.google.com/maps/documentation/javascript/tutorial#api_key

        After you sign up, use the following script tag with YOUR_GOOGLE_API_KEY replaced with your actual key.
            <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_API_KEY"></script>
    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=
AIzaSyAxsOMhMNNlJe38h-ON-0MkOxBLCT78MRU&callback=initMap"></script>

    <script type="text/javascript">
        // When the window has finished loading create our google map below
        google.maps.event.addDomListener(window, 'load', init);

        function init() {
            // Basic options for a simple Google Map
            // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
            var mapOptions = {
                // How zoomed in you want the map to start at (always required)
                zoom: 15,

                // The latitude and longitude to center the map (always required)
                center: new google.maps.LatLng(55.800312,37.565437), // New York

                // How you would like to style the map.
                // This is where you would paste any style found on Snazzy Maps.
                styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#4f595d"},{"visibility":"on"}]}]
            };

            // Get the HTML DOM element that will contain your map
            // We are using a div with id="map" seen below in the <body>
            var mapElement = document.getElementById('map');

            // Create the Google Map using our element and options defined above
            var map = new google.maps.Map(mapElement, mapOptions);

            // Let's also add a marker while we're at it
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(55.800312,37.565437),
                map: map,
                title: 'Snazzy!'
            });
        }
    </script>

    <style>
        #map {
            width: 100%;
            height: 360px;
            margin-top: 60px;
        }
        @import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900,900italic);


        .feature-box-grid {
            background-color: #131313;
            float: left;
            overflow: hidden;
            width: 100%;
        }
        .feature-box-grid .col-md-4{
            padding: 0;
            float: left;
            max-width: 25%;
            overflow: hidden;
            width: 100%;
        }
        .featured-item.border-box{
            -webkit-transition: all 0.3s ease;
            transition: all 0.3s ease;
        }
        .featured-item.border-box {

            padding: 50px;
            margin-left: -1px;
            margin-bottom: -1px;
        }
        .text-center {
            text-align: center;
        }
        .featured-item .icon {
            padding: 0 0 30px 0;
        }
        .featured-item .icon i {
            font-size: 36px;
        }
        .text-uppercase {
            text-transform: uppercase;
        }
        .featured-item .title h4 {
            margin-bottom: 20px;
            letter-spacing: 1px;
            font-weight: normal;
            -webkit-transition: all 0.3s ease;
            transition: all 0.3s ease;
        }
        .featured-item .desc {
            color: #7e7e7e;
        }
        .featured-item.border-box, .featured-item.border-box:hover, .featured-item.border-box h4, .featured-item.border-box:hover h4, .featured-item.border-box .icon i .featured-item.border-box:hover .icon i {
            -webkit-transition: all 0.3s ease;
            transition: all 0.3s ease;
        }
        .featured-item.border-box:hover {

            background: #222222;
            color: #7e7e7e;
        }
        .featured-item.border-box {

            padding: 10px;
            margin-left: -1px;
            margin-bottom: -1px;
        }
        .featured-item.border-box:hover {

            background: #222222;
            color: #7e7e7e;
        }
        .featured-item.border-box:hover .icon i{
            color: #7DC20F;
        }
        .featured-item.border-box:hover h4 {
            color: #fff;
        }



    </style>

</div>


<!--<footer>
    <div class="container footer-content">
        <div class="row">
            <div class="col-md-2">
                Subscribe to newsletters
            </div>
            <div class="col-md-6">
                <?php /*if(Yii::$app->request->get(Subscribe::SENT_VAR)) : */ ?>
                    You have successfully subscribed
                <?php /*else : */ ?>
                    <? /*= Subscribe::form() */ ?>
                <?php /*endif; */ ?>
            </div>
            <div class="col-md-4 text-right">
                ©2015 noumo
            </div>
        </div>
    </div>
</footer> ГЛАВНОЕ-->

<footer>
    <div class="block dark">
        <div class="container">
            <div class="row">

                <section>

                    <div class="feature-box-grid">


                        <div class="col-md-4 col-sm-4">
                            <div class="featured-item border-box text-center">
                                <div class="icon">
                                    <i class="fa fa-globe"></i>
                                </div>
                                <div class="title text-uppercase">
                                    <h4>Успешный опыт</h4>
                                </div>
                                <div class="desc">
                                    регистрации в 28 странах мира.<br><br>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="featured-item border-box text-center">
                                <div class="icon">
                                    <i class="fa fa-university"></i>
                                </div>
                                <div class="title text-uppercase">
                                    <h4>Открываем счета</h4>
                                </div>
                                <div class="desc">
                                    в 35 банках мира и активно расширяем список.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="featured-item border-box text-center">
                                <div class="icon">
                                    <i class="flaticon-people"></i>
                                </div>
                                <div class="title text-uppercase">
                                    <h4>Консультации</h4>
                                </div>
                                <div class="desc">
                                    в удобное для Вас время.<br><br>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="featured-item border-box text-center">
                                <div class="icon">
                                    <i class="fa fa-handshake-o"></i>
                                </div>
                                <div class="title text-uppercase">
                                    <h4>Терпеливо</h4>
                                </div>
                                <div class="desc">
                                    расскажем с чего начать, даже если это Ваш первый бизнес.
                                </div>
                            </div>
                        </div>
                    </div>

                </section>

                <div class="col-md-3">

                    <div class="footer-widget">
                        <div class="about-widget">
                            <div class="logo">
                                <a href="/" title=""><img src="/uploads/logo/logo.png" alt=""></a>
                            </div>
                            <p>Оптимизация налогообложения Вашей компании
                                законным путем это то, на чем мы специализируемся.<br/>
                                Мы не несем ответственность за успех Вашего бизнеса,
                                но поспособствовать получению возможности уменьшить
                                затраты и вручить зарегистрированную новую компанию
                                в нужной юрисдикции мы можем.</p>

                            <p>Чтобы получить результат стоит с чего-то начать,
                                например написать нам в чат и мы согласуем запуск
                                выполнения Вашего заказа.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer-widget">
                        <div class="address-widget">
                            <p  style="color: white">
                                <strong  style="color: #7dc20f"><i class="fa fa-map-marker"></i> Адрес</strong><br>
                                Старый Петровско-Разумовский проезд, 1/23 стр.1, Москва, 127287
                            </p>
                            <p style="color: white"><strong style="color: #7dc20f"><i class="fa fa-phone"></i> Номер телефона</strong><br>
                                +7 925 470 50 02</p>
                            <p style="color: white"><strong style="color: #7dc20f"><i class="fa fa-clock-o"></i> Часы работы</strong><br>
                                09:00-19:00</p>
                            <p style="color: white">
                                <strong style="color: #7dc20f"><i class="fa fa-envelope"></i> E-mail</strong><br>
                                <a href="mailto:one@iq-offshore.com">one@iq-offshore.com</a></p>
                            <p style="color: white"><strong style="color: #7dc20f"><i class="fa fa-skype"></i> Skype</strong><br>
                                <a href="skype:IQ Decision?call">IQ Decision</a></p>
                            <a href="javascript:void( window.open( 'https://form.jotformeu.com/71136944138357', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )" class="theme-btn" title="">Связаться с нами</a>
                        </div>
                    </div>
                </div>









                <div class="col-md-4">
                    <div class="footer-widget">
                        <div id="map"></div>
                        <!-- Fun Facts -->
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="footer-widget">
                        <div class="title1 style2">
                            <h2>Быстрый переход</h2>
                        </div>
                        <div class="menu-links">

                            <!-- This is the HTML element that, when clicked, will cause the popup to appear. -->

                            <!-- BEGIN PRIVY WIDGET CODE -->
                            <script type='text/javascript'> var _d_site = _d_site || '411086831FF94A27DC0340B2'; </script>

                            <!-- END PRIVY WIDGET CODE -->
                            <div class="privy-embed-form" data-campaign="216143"></div>
                            <script>
                                $(window).load(function() {

                                };

                            </script>

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
                    <li><a href="/" title="">Главная</a></li>
                    <li><a href="/news" title="">Новости</a></li>
                    <li><a href="/contact" title="">Информация</a></li>
                    <li><a href="/contact" title="">Контакты</a></li>
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
<div id="stl_left" style="display: block; opacity: 1; width: 178px;" class="">
    <div id="stl_bg">
        <nobr id="stl_text">Вверх</nobr>
    </div>
</div>



<a href="#" class="scrollToTop"></a>


<style type="text/css">

    .scrollToTop{
        width:70px;
        margin-right: -10px;
        height:120px;
        padding:10px;
        text-align:center;
        background: whiteSmoke;
        font-weight: bold;
        color: #444;
        text-decoration: none;
        position:fixed;
        bottom:50%;
        top:50%;
        left:1%;
        opacity: 0.3;
        display:none;
        background: url("http://iq-offshore.com/uploads/1/scrollup.png") no-repeat 0px 20px;
        background-size: 60px 60px;
        z-index: 2;
    }
    .scrollToTop:hover{
        text-decoration:none;
    }

</style>
<script>
    $(window).scroll(function(i) {
        var scrollVar = $(window).scrollTop();
        $(".scroll-fade").css({ opacity: 3.14 * scrollVar / 100 });
    });
</script>
<script>
    $(document).ready(function(){

        //Check to see if the window is top if not then display button
        $(window).scroll(function(){
            if ($(this).scrollTop() > 500) {
                $('.scrollToTop').fadeIn();
            } else {
                $('.scrollToTop').fadeOut();
            }
        });

        //Click event to scroll to top
        $('.scrollToTop').click(function(){
            $('html, body').animate({scrollTop : 0},800);
            return false;
        });
        //Scroll header mobile version


// site preloader -- also uncomment the div in the header and the css style for #preloader
        $(window).load(function(){

            $('#rhlpscrtg').fadeOut('slow',function(){$(this).show();});
            $("#status").fadeOut();
            $('#preloader').delay(1000).fadeOut('slow',function(){$(this).remove();});

        });
        setTimeout(function() {
            var script = document.createElement('script');
            script.src = '//widget.privy.com/assets/widget.js';
            script.type = 'text/javascript';
            document.head.appendChild(script);
        }, 2500);
        setTimeout(function() {
            var script = document.createElement('script');
            script.src = 'https://web.redhelper.ru/service/main.js?c=romanovalexander5';
            script.type = 'text/javascript';
            script.id = 'rhlpscrtg';
            script.charset = 'utf-8';
            script.async = 'async';
            document.head.appendChild(script);
        }, 2000);


    });


</script>


<!-- RedConnect -->
<!-- RedConnect -->

<div style="display: none"><a class="rc-copyright"
                              href="http://redconnect.ru">Сервис обратного звонка RedConnect</a></div>
<!--/RedConnect -->



<!--Start of Tawk.to Script
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/588fad1957968e2dc9688b7f/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
End of Tawk.to Script-->



<?php $this->endContent(); ?>
