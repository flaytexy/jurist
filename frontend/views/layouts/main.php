<?php
/** Created by CyberBrain  */
//use frontend\modules\shopcart\api\Shopcart;
//use frontend\modules\subscribe\api\Subscribe;
//use yii\helpers\Url;

/**
 * @var $this \yii\web\View
 */
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\helpers\Image;
use frontend\widgets\WLang;

$popularly = \frontend\models\Popularly::find()
    ->groupBy(['slug'])
    ->orderBy(['time' => SORT_DESC])
    ->limit(6)
    ->all();

$phoneStr = "+7 925 470 50 02";

$addeng = Yii::t('easyii', 'free');

?>
<?php $this->beginContent('@app/views/layouts/base.php'); ?>

<script language="JavaScript">
    document.onselectstart = function () {
        return false
    }
</script>
<header class="stick scrollup" id="top-header">
    <div class="top-bar visible-md-block visible-lg">
        <div class="container">
            <div class="topbar-data">
                <?= Menu::widget([
                    'options' => ['class' => 'top-menus', 'id' => 'top-menus'],
                    'items' => [
                        ['label' => Yii::t('easyii', 'funds'), 'url' => ['/fonds'], 'options' => ['title' => 'Фонды']],
                        ['label' => Yii::t('easyii', 'banks'), 'url' => ['/banks'],
                            'options' => ['class' => 'menu-item-has-children', 'title' => 'Банки'],
                        ],
                        //['label' => Yii::t('easyii', 'pay_system'), 'url' => ['/pay-system'], 'options' => ['title' => Yii::t('easyii', 'pay_system')]],
                        ['label' => Yii::t('easyii', 'companies'), 'url' => ['/offshornyie-predlozheniya'], 'options' => ['title' => 'Компании']],
                        ['label' => Yii::t('easyii', 'licenses'), 'url' => ['/licenses'], 'options' => ['title' => 'Лицензии']],
                        ['label' => Yii::t('easyii', 'offshores'), 'url' => ['/offshore'], 'options' => ['title' => 'Оффшоры']],
                        ['label' => Yii::t('easyii', 'processing'), 'url' => ['/processing'], 'options' => ['title' => 'Процессинг']],
                        ['label' => Yii::t('easyii', 'sells'), 'url' => ['/sale'], 'options' => ['title' => Yii::t('easyii', 'sells')]],
                        ['label' => 'contact', 'url' => ['/contact'], 'template' => '' ],
                    ],
                ]); ?>
                <?= WLang::widget() ?>
            </div>
        </div>
    </div>
    <!-- end: Top Bar -->
    <div class="logomenu-sec hidden-xs" id="logomenu-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-2 ">
                    <div class="logo logo_main"><a href="/" title=""><img id="logo-img" src="/uploads/logo/logo_main_png.png" data-src="/uploads/logo/logo_main_fsd_1.gif" alt=""></a>
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
                                ['label' => Yii::t('easyii', 'main'), 'url' => ['site/index']],
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

                                ['label' => Yii::t('easyii', 'faq'), 'url' => ['/faq']],
                                ['label' => Yii::t('easyii', 'about'), 'url' => ['/about']],
                                ['label' => Yii::t('easyii', 'contact'), 'url' => ['/contact']],
                                ['label' => 'contact', 'url' => ['/contact'],
                                    'template' => '
                                <li class="contact-m2">
                                    <div class="row">
                                        <div class="col-md-12 tel-m"><div><a href=' . Url::to('/contact') .'> <p class="lenta">' . $addeng . ' </p></a></div></div>
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
    <!-- end: Logo Menu Sec -->

    <div class="responsive-header">
        <div class="logomenu-bar">
            <div class="logodiv"><a href="/" title=""><img src="/uploads/logo/logo-small.png" alt=""></a></div>
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
            <gcse:search></gcse:search>
            <?= Menu::widget([
                'options' => ['class' => 'nav navbar-nav'],
                'items' => [
                    ['label' => Yii::t('easyii', 'main'), 'url' => ['site/index']],
                    ['label' => Yii::t('easyii', 'funds'), 'url' => ['/fonds']],
                    ['label' => Yii::t('easyii', 'banks'), 'url' => ['/banks']],
                    //['label' => Yii::t('easyii', 'pay_system'), 'url' => ['/pay-system'], 'options' => ['title' => Yii::t('easyii', 'pay_system')]],
                    ['label' => Yii::t('easyii', 'licenses'), 'url' => ['/licenses']],
                    ['label' => Yii::t('easyii', 'news'), 'url' => ['/news']],
                    ['label' => Yii::t('easyii', 'companies'), 'url' => ['/offshornyie-predlozheniya']],
                    ['label' => Yii::t('easyii', 'processing'), 'url' => ['/processing']],
                    ['label' => Yii::t('easyii', 'sells'), 'url' => ['/sale']],
                    ['label' => Yii::t('easyii', 'about'), 'url' => ['/about']],
                    ['label' => Yii::t('easyii', 'contact'), 'url' => ['/contact']],
                ],
            ]); ?>
            <div class="ps-scrollbar-x-rail" style="left: 0; bottom: 3px;">
                <div class="ps-scrollbar-x" style="left: 0; width: 0;"></div>
            </div>
            <div class="ps-scrollbar-y-rail" style="top: 0; right: 3px;">
                <div class="ps-scrollbar-y" style="top: 0; height: 0;"></div>
            </div>
            <div class="ps-scrollbar-x-rail" style="left: 0; bottom: 3px;">
                <div class="ps-scrollbar-x" style="left: 0; width: 0;"></div>
            </div>
            <div class="ps-scrollbar-y-rail" style="top: 0; right: 3px;">
                <div class="ps-scrollbar-y" style="top: 0; height: 0;"></div>
            </div>
        </div>
    </div>
    <!-- end: Responsive Header -->
</header>
<div class="theme-layout" id="theme-layout-js">
    <div class="row">
        <?php if ($this->context->id != 'site') : ?>
            <div class="pagetop-sec">
                <div class="fixed-bg2" style="background-image: url(<?= Image::thumb('/uploads/theme_villa/pagetop-bg.jpg', 1024, 159)?>);"></div>
                <div class="container">
                    <div class="page-title">
                        <h1>
                                <?php if (count($this->params['breadcrumbs'][0]) == 1): ?>
                                    <?= $this->params['breadcrumbs'][0] ?>
                                <? elseif (!empty($this->params['breadcrumbs'][1])): ?>
                                    <?= $this->params['breadcrumbs'][1] ?>
                                <? endif; ?>
                        </h1>
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

    <!-- popularly -->
    <section class="top20">
        <div class="block no-padding">
            <div class="row">
                <div class="col-md-12 top20">
                    <div class="instagram">
                        <div class="title1 light">
                            <h2> <?= Yii::t('easyii', 'lastviews') ?></h2>
                            <span> <?= Yii::t('easyii', 'maybe') ?></span>
                        </div>
                        <div class="instagram-gallery">
                            <ul>
                                <?php foreach ($popularly as $item) : ?>
                                    <?php if (!empty($item->image) || !empty($item->pre_image)): ?>
                                    <li>
                                        <a href="<?= Url::to([$item->slug]) ?>">
                                            <?= Html::img(\frontend\helpers\Image::thumb($item->image, 150, 150), array('class' => 'main-news')) ?>
                                            <div class="offered-serviceinfo">
                                                <span style="font-weight: bolder; color: white;  text-shadow: -5px 0 10px black, 0 5px 10px black, 5px 0 10px black, 0 -5px 10px black; "><?= $item->title ?></span>
                                            </div>
                                        </a>
                                    </li>
                                <? endif; ?><? endforeach; ?>
                            </ul>
                        </div>
                        <!-- Instagram Gallery -->
                    </div>
                    <!-- Instagram -->
                </div>
            </div>
        </div>
    </section>
    <!-- _end popularly -->
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
                                <a href="/" title=""><img src="/uploads/logo/logo-small.png" alt=""></a>
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
                                            class="fa fa-clock-o"></i> <?= Yii::t('easyii', 'worktime') ?></strong><br>
                                09:00-19:00</p>
                            <p style="color: white">
                                <strong style="color: #7dc20f"><i class="fa fa-envelope"></i> E-mail</strong><br>
                                <a href="mailto:one@iq-offshore.com">one@iq-offshore.com</a></p>
                            <p style="color: white"><strong style="color: #7dc20f"><i class="fa fa-skype"></i>
                                    Skype</strong><br>
                                <a href="skype:live:asmofad?call">IQ Decision</a></p>
                            <a class="theme-btn" title="" href="javascript:void( window.open( 'https://forms.amocrm.ru/forms/html/form_326401_ab9058f531bfbd2671c5d24aa0d8dc90.html?date=<?php echo time(); ?>', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )">
                                <?= Yii::t('easyii', 'contactus') ?></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="footer-widget">
                        <div id="map" style="height: 450px;width: 100%"></div>
                    </div>
                    <div class="footer-widget">
                        <div class="title1 style2">
                            <h2>Быстрый переход</h2>
                        </div>
                        <div class="menu-links">
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


<div id="stl_left" style="display: block; opacity: 1; width: 178px;" class="">
    <div id="stl_bg">
        <nobr id="stl_text">Вверх</nobr>
    </div>
</div>
<a href="#" class="scrollToTop"></a>
<div id="dialog-vyhodnoy" class="" style="display: none">
    Выходной 30 апреля на 1 мая.
</div>
<?php //if (!YII_DEBUG): ?>
<!--    <script type='text/javascript'>-->
<!--        var _d_site = _d_site || '411086831FF94A27DC0340B2';-->
<!--    </script>-->
<?php //endif; ?>
<script>
    //var target = document.querySelector("body");
    //target.innerHTML += "<link rel='stylesheet' type='text/css' href='/css/style_all.min.css' />";
</script>

<?php $this->endContent(); ?>
