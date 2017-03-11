<?php
/** Created by CyberBrain  */
//use frontend\modules\shopcart\api\Shopcart;
//use frontend\modules\subscribe\api\Subscribe;
//use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\Url;

$popularly = \frontend\models\Popularly::find()->limit(12)->all();

?>
<?php $this->beginContent('@app/views/layouts/base.php'); ?>

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
</style>

<div class="theme-layout" style="padding-top: 156px;">
    <header class="stick scrollup">
        <div class="top-bar">
            <div class="container">
                <div class="topbar-data">
                    <ul class="top-menus">
                        <li><a href="/contact" title="Наш телефон">+7 925 175 44 17</a></li>
                        <li class="skype" title="Вызов в skype: IQ Decision"><a href="skype:IQ Decision?call"><div style="background-image: url('http://www.skypeassets.com/i/scom/images/skype-buttons/callbutton_16px.png');width: 16px; height: 16px;padding-left: 18px;"></div></a></li>-->
<!--                        <li>-->
<!--                            <script type="text/javascript" src="https://secure.skypeassets.com/i/scom/js/skype-uri.js"></script>-->
<!--                            <div id="SkypeButton_Call_IQ_Decision_1">-->
<!--                                <script type="text/javascript">-->
<!--                                    Skype.ui({-->
<!--                                        name: "call",-->
<!--                                        "element": "SkypeButton_Call_IQ_Decision_1",-->
<!--                                        "participants": ["IQ Decision"]-->
<!--                                    });-->
<!--                                </script>-->
<!--                            </div>-->
<!--                        </li>-->
                        <li><a href="/fonds" title="Фонды">Фонды</a></li>
                        <li><a href="/banks" title="Банки">Банки</a></li>
                        <li><a href="/offshornyie-predlozheniya" title="Компании">Компании</a></li>
                        <li><a href="/licenses" title="Лицензии">Лицензии</a></li>
                        <li><a href="/processing" title="Эквайринг" style="line-height: 0.9">Мерчант (процессинг)<br/>
                                Эквайринг</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Top Bar -->
        <div class="logomenu-sec hidden-xs" id="logomenu-sec">
            <div class="container">

                <div class="row">
                    <div class="col-md-2">
                        <div class="logo logo_main"><a href="/" title=""><img src="/uploads/logo/logo_main.png" alt=""></a>
                        </div>
                    </div>
                    <div class="col-md-4">
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
                    <div class="col-md-6">
                        <nav class="navbar22 navbar-default22">
                            <?= Menu::widget([
                                'options' => ['class' => 'nav navbar-nav'],
                                'items' => [
                                    ['label' => 'Главная', 'url' => ['site/index']],
                                    //['label' => 'Оффшорные предложения', 'url' => ['/offshornyie-predlozheniya']],
                                    //['label' => 'Европейские компании', 'url' => ['/evropejskie-kompanii']],
                                    //['label' => 'Shop', 'url' => ['shop/index']],
                                    ['label' => 'Новости', 'url' => ['/news']],
                                    //['label' => 'Банки', 'url' => ['/banks']],
                                    //['label' => 'Articles', 'url' => ['articles/index']],
                                    //['label' => 'Gallery', 'url' => ['gallery/index']],
                                    //['label' => 'Guestbook', 'url' => ['guestbook/index']],
                                    //['label' => 'Информация', 'url' => ['/faq']],
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
            <div class="container">
                <div class="logo"><a href="/" title=""><img src="/uploads/logo/logo.png" alt=""></a></div>
                <span class="menu-btn"><i class="fa fa-list"></i></span>
            </div>
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
                                                <?= Html::img(\frontend\helpers\Image::thumb($item->image, 150, 150)) ?>
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
</footer>-->

<footer>
    <div class="block dark">
        <div class="container">
            <div class="row">
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
                            <!--                            <ul>
                                                            <li><span>Address:</span> Russia, Moscow</li>
                                                            <li><span>Phone:</span> +79251754417</li>
                                                            <li><span>Email:</span> <a href="/contact" title="">sendme@it-offshore.com</a></li>
                                                        </ul>-->
                            <a href="/contact" class="theme-btn" title="">Связаться с нами</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="footer-widget">
                        <div class="title1 style2">
                            <h2>Факты о нас</h2>

                        </div>
                        <div class="fun-facts">
                            <ul>
                                <li>
                                    <div class="fun-fact">
                                        <span>Успешный опыт регистраций </span>
                                        <i class="flaticon-house"></i>
                                        в <strong>28</strong>
                                        <span>странах мира</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="fun-fact">
                                        <span>Отрываем счета</span>
                                        <i class="flaticon-people-1"></i>
                                        в <strong>35</strong>
                                        <span>банках мира и активно расширяем список</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="fun-fact">
                                        <span>Консультации в удобное для Вас время</span>
                                        <i class="flaticon-people"></i>
                                        <!--<strong>91K</strong>-->
                                    </div>
                                </li>
                                <li>
                                    <div class="fun-fact">
                                                     <span>Мы терпеливо
                                            расскажем с чего
                                            начать, даже если
                                            это Ваш первый
                                            бизнес
                                        </span>
                                        <i class="flaticon-transport"></i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- Fun Facts -->
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="footer-widget">
                        <div class="title1 style2">
                            <h2>Быстрый переход</h2>
                        </div>
                        <div class="menu-links">
                            <ul>
                                <!-- <li><a href="/faq" title="">Faq's</a></li>-->
                                <li><a href="/contact" title="">Support</a></li>
                                <li><a href="/contact" title="">Contact us</a></li>
                            </ul>
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

<!--Start of Tawk.to Script-->
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
<!--End of Tawk.to Script-->

<?php $this->endContent(); ?>
