<?php
use frontend\modules\shopcart\api\Shopcart;
use frontend\modules\subscribe\api\Subscribe;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;

$goodsCount = count(Shopcart::goods());
?>
<?php $this->beginContent('@app/views/layouts/base.php'); ?>
<div class="theme-layout" style="padding-top: 156px;">
    <header class="stick scrollup">
        <div class="top-bar">
            <div class="container">
                <div class="topbar-data">
                    <ul class="top-menus">
                        <li><a href="/offshornyie-predlozheniya" title="Оффшорные предложения">Оффшорные предложения</a></li>
                        <li><a href="/evropejskie-kompanii" title="Европейские компании">Европейские компании</a></li>
                        <li><a href="/banki-i-proczessing" title="Банки и процессинг">Банки и процессинг</a></li>
                        <li><a href="/liczenzii-beliza" title="Лицензии Белиза">Лицензии Белиза</a></li>
                        <li><a href="/licenzii" title="Лицензии">Лицензии</a></li>
                    </ul>
                </div>
            </div>
        </div><!-- Top Bar -->
        <div class="logomenu-sec">
            <div class="container">
                <div class="logo"><a href="index.html" title=""><img src="/uploads/theme_villa/logo.png" alt=""></a></div>
                <nav class="navbar22 navbar-default22">
                            <?= Menu::widget([
                                'options' => ['class' => 'nav navbar-nav'],
                                'items' => [
                                    ['label' => 'Главная', 'url' => ['site/index']],
                                    //['label' => 'Shop', 'url' => ['shop/index']],
                                    ['label' => 'Новости', 'url' => ['news/index']],
                                    ['label' => 'Articles', 'url' => ['articles/index']],
                                    ['label' => 'Gallery', 'url' => ['gallery/index']],
                                    ['label' => 'Guestbook', 'url' => ['guestbook/index']],
                                    ['label' => 'Информация', 'url' => ['faq/index']],
                                    ['label' => 'Контакты', 'url' => ['/contact/index']],
                                ],
                            ]); ?>
                </nav>
            </div>
        </div><!-- Logo Menu Sec -->
    </header><!-- Header -->
    <div class="responsive-header">
        <div class="top-bar">
            <ul class="sign-btns">
                <li><a href="#" title=""><i class="fa fa-unlock-alt"></i> Log In</a></li>
                <li><a href="#" title=""><i class="fa fa-plus"></i> Sign Up</a></li>
            </ul>
            <ul class="language-select">
                <li><img src="/uploads/theme_villa/lang1.jpg" alt=""></li>
            </ul>
        </div>
        <div class="logomenu-bar">
            <div class="container">
                <div class="logo"><a href="http://themes.webinane.com/getvilla/index2.html" title=""><img src="/uploads/theme_villa/logo3.png" alt=""></a></div>
                <span class="menu-btn"><i class="fa fa-list"></i></span>
            </div>
        </div>
        <div class="responsive-menu ps-container" data-ps-id="3359a5b1-f4a3-6575-dffa-5413f2e717d2">
            <span class="close-btn"><i class="fa fa-close"></i></span>
            <?= Menu::widget([
                'options' => ['class' => 'nav navbar-nav'],
                'items' => [
                    ['label' => 'Главная', 'url' => ['site/index']],
                    //['label' => 'Shop', 'url' => ['shop/index']],
                    ['label' => 'Новости', 'url' => ['news/index']],
                    ['label' => 'Articles', 'url' => ['articles/index']],
                    ['label' => 'Gallery', 'url' => ['gallery/index']],
                    ['label' => 'Guestbook', 'url' => ['guestbook/index']],
                    ['label' => 'Информация', 'url' => ['faq/index']],
                    ['label' => 'Контакты', 'url' => ['/contact/index']],
                ],
            ]); ?>
            <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px;"><div class="ps-scrollbar-y" style="top: 0px; height: 0px;"></div></div><div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px;"><div class="ps-scrollbar-y" style="top: 0px; height: 0px;"></div></div></div><!-- Responsive Menu -->
        <ul class="topbar-contact">
            <li class="active"><i class="fa fa-envelope-o"></i> contacts@yoursites.com</li>
            <li><i class="fa fa-phone"></i> 111-4558-3333</li>
        </ul>
    </div><!-- Responsive Header -->

    <?php if($this->context->id != 'site') : ?>
        <br/>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ])?>
    <?php endif; ?>

    <?= $content ?>
    <div class="push"></div>

    <section>
        <div class="block no-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="instagram">
                        <div class="title1 light">
                            <h2>Instagram Images</h2>
                            <span>We Provide Best Services</span>
                        </div>
                        <div class="instagram-gallery">
                            <ul>
                                <li><a href="#" title=""><img src="images/resource/instagram1.jpg" alt="" /></a></li>
                                <li><a href="#" title=""><img src="images/resource/instagram2.jpg" alt="" /></a></li>
                                <li><a href="#" title=""><img src="images/resource/instagram3.jpg" alt="" /></a></li>
                                <li><a href="#" title=""><img src="images/resource/instagram4.jpg" alt="" /></a></li>
                                <li><a href="#" title=""><img src="images/resource/instagram5.jpg" alt="" /></a></li>
                                <li><a href="#" title=""><img src="images/resource/instagram6.jpg" alt="" /></a></li>
                            </ul>
                        </div><!-- Instagram Gallery -->
                    </div><!-- Instagram -->
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
                <?php /*if(Yii::$app->request->get(Subscribe::SENT_VAR)) : */?>
                    You have successfully subscribed
                <?php /*else : */?>
                    <?/*= Subscribe::form() */?>
                <?php /*endif; */?>
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
                                <a href="index.html" title=""><img src="/uploads/theme_villa/logo2.png" alt=""></a>
                            </div>
                            <p>Vestibulum at magna tellus ivamus sagitt is etnunc utaliquac vulputate leo vehicu auris porttitor eros vels aphicula mconse quat rhoncus elit diam nonumy nibidunt utthering does work.</p>
                            <p>Aenean molestie senec tus etnetus malei uada. Cnsectetuer adipisc, sed diam non ummy nibh.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer-widget">
                        <div class="address-widget">
                            <ul>
                                <li><span>Address:</span> New York City, NY - 10001 United States.</li>
                                <li><span>Phone:</span> 215 - 123 - 4567</li>
                                <li><span>Email:</span> <a href="#" title="">info@webinane.com</a></li>
                            </ul>
                            <a href="#" class="theme-btn" title="">Contact Us Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="footer-widget">
                        <div class="title1 style2">
                            <h2>Fun Facts</h2>
                            <span>We Provide Best Services</span>
                        </div>
                        <div class="fun-facts">
                            <ul>
                                <li>
                                    <div class="fun-fact">
                                        <i class="flaticon-house"></i>
                                        <strong>28</strong>
                                        <span>Offices Worldwide</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="fun-fact">
                                        <i class="flaticon-people-1"></i>
                                        <strong>35+</strong>
                                        <span>Expert Mumbers</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="fun-fact">
                                        <i class="flaticon-people"></i>
                                        <strong>91K</strong>
                                        <span>Happy Customers</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="fun-fact">
                                        <i class="flaticon-transport"></i>
                                        <strong>487</strong>
                                        <span>Project Completed</span>
                                    </div>
                                </li>
                            </ul>
                        </div><!-- Fun Facts -->
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="footer-widget">
                        <div class="title1 style2">
                            <h2>Quick Links</h2>
                            <span>We Provide Best Services</span>
                        </div>
                        <div class="menu-links">
                            <ul>
                                <li><a href="#" title="">Faq's</a></li>
                                <li><a href="#" title="">Support</a></li>
                                <li><a href="#" title="">Community</a></li>
                                <li><a href="#" title="">Membership</a></li>
                                <li><a href="#" title="">Events</a></li>
                                <li><a href="#" title="">Contact us</a></li>
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
                    <li><a href="#" title="">Home</a></li>
                    <li><a href="#" title="">Our Services</a></li>
                    <li><a href="#" title="">Properties</a></li>
                    <li><a href="#" title="">Our Blog</a></li>
                    <li><a href="#" title="">Contact Us</a></li>
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
            <div class="container">
                <p><span>Copyright 2016.</span> All Rights Reserved <span>by</span> <a href="#" title="">webinane - Multi Property Theme.</a></p>
            </div>
        </div>
    </div><!-- Bottom Line -->
</footer>

<?php $this->endContent(); ?>
