<?php
use frontend\modules\licenses\api\Licenses;

use frontend\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;


$page = Page::get('page-licenses');

if(!empty($page)) $this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;
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


$this->params['seo'][] = $page->seo('keywords');
?>





<section class="container top10">
    <div class="row">

        <div class="col-md-12">
            <style>


                .license-type img{
                    display:block;
                    font-size: 1.5rem;

                }
                .license-type > .license__link i, .license-type > .license__mob i {
                    display:block;
                    font-size: 80px;
                    margin: 20px auto;
                }

                .license-type > .license__mob i{
                    font-size: 50px;
                    margin: 5px auto;
                }

                .license-type a
                {
                    display: block;
                    text-align: center;
                    color: black;
                }

                .license-type{
                    min-width: 120px;
                    position: relative;
                    max-width:18%;
                }
                .license-type:hover  i{
                    color: #7dc20f;
                }
                .license__country{
                    list-style: none;
                    padding: 0;
                    width: 100%;
                    z-index:1200;
                    background: transparent;
                    border-radius: 10px;
                    position: absolute;
                    transition: all 400ms ease-in;
                    top: 65%;
                    left: 0%;
                }
                .license__country {
                    box-shadow: 0 0 10px rgba(0,0,0,0.5);
                    display: none;
                }
                .license__country > li{
                    display:block;
                    text-align: center;
                    background: #fff;
                    color: #7dc20f;
                    position: relative;
                }
                .license__country > li:first-child{
                    border-radius: 10px 10px  0 0;
                }
                .license__country > li:last-child{
                    border-radius: 0 0 10px 10px ;
                }
                .license__country > li:first-child:before{
                    display: block;
                    content: '';
                    width: 0px;
                    height: 0px;
                    border-bottom: 10px solid #fff;
                    border-right: 9px solid transparent;
                    border-left: 9px solid transparent;
                    position: absolute;
                    left: 50%;
                    transform: translateX(-50%);
                    top: -10px;
                }
                .license__country > li:hover:before{
                    border-bottom: 10px solid  #7dc20f;
                }
                .license__country > li:hover{
                    background:  #7dc20f;
                }
                .license__country > li:hover > a{
                    color: #fff;
                }
                /*.license__country > li:first-child{*/
                    /*border-top: 1px solid black;*/
                /*}*/
                .license__country.active
                {
                    display: block;
                }
                .license-type > .license__mob{
                    display: none;

                }
                .license__link{
                    padding-bottom: 30px;
                }
                .license__mob > div {
                    text-align:center;
                    font-size: 10px;
                }
                @media (min-width:992px){
                    .license-type:hover > ul{
                       display: block;
                    }
                }
                @media(max-width: 991px){
                    .license-type > .license__link{
                        display:none;
                    }
                    .license-type {
                        min-width: 0px;
                        position: static;

                    }

                    .license-type >.license__mob{
                        display: block;
                    }
                    .license-menu {
                        position:relative;
                    }
                    .license__country {
                        left:15%;
                        width: 70%;

                    }
                    .license__country > li{
                        padding: 2% 5%;

                        font-size: 1.2rem;
                    }
                    .license__country > li > a{
                        border-bottom: 2px solid rgb(247, 247, 247);
                    }
                    .license__country > li:hover > a{
                        border-color: transparent;
                    }

                }
            </style>

            <script>
                function showCountryList(num){
                    var countryList =  document.getElementsByClassName('license__country');
                    if (countryList[num].classList.contains('active')){
                        countryList[num].classList.remove('active');
                    }
                    else{
                        for( var i=0; i<countryList.length; i++){
                            countryList[i].classList.remove('active');
                        }
                        countryList[num].classList.add('active');
                    }

                }
            </script>

            <div class="villaeditors-picks offers-list">
                        <div class="packages style2 remove-ext2">
                            <div class="license-menu">
                                <h3 style="text-align:center; color:#7dc20f;">Типы лицензий</h3>
                                <div class="row justify-content-around"  style=" background: transparent;"">

                                <div class="license-type">
                                    <a href="<?=Url::to(['licenses/index', 'lic_type' => 1])?>" class="license__link"><i class="icon-wallet"></i><div>E-money License</div></a>
                                    <a href="#" class="license__mob" onclick="showCountryList(0)" ><i class="icon-wallet"></i><div>E-money</div></a>
                                    <ul class="license__country">
                                        <?php
                                        $cat = Licenses::getcountry(1);
                                        foreach ($cat as $item):
                                            ?>
                                            <li>
                                                <?= Html::a(Html::encode($item->country),Url::to(['licenses/index', 'lic_type' => 1,'country'=>Html::encode($item->country)]))?>
                                            </li>
                                            <!--                                           --><?//=Html::tag('li', Html::encode($item->country));?>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div class="license-type">
                                    <a href="<?=Url::to(['licenses/index', 'lic_type' => 2])?>" class="license__link"><i class="icon-piggy-bank"></i><div>Asset management</div></a>
                                    <a href="#" class="license__mob" onclick="showCountryList(1)"><i class="icon-piggy-bank"></i><div>Assets</div></a>
                                    <ul class="license__country">
                                        <?php
                                        $cat = Licenses::getcountry(2);
                                        foreach ($cat as $item):
                                            ?>
                                            <li>
                                                <?= Html::a(Html::encode($item->country),Url::to(['licenses/index', 'lic_type' => 2,'country'=>Html::encode($item->country)]))?>
                                            </li>
                                            <!--                                           --><?//=Html::tag('li', Html::encode($item->country));?>
                                        <?php endforeach; ?>
                                    </ul>

                                </div>
                                <div class="license-type">
                                    <a href="<?=Url::to(['licenses/index', 'lic_type' => 3])?>" class="license__link"><i class="icon-stock-earnings"></i><div>Forex</div></a>
                                    <a href="#" class="license__mob" onclick="showCountryList(2)"><i class="icon-stock-earnings"></i><div>Forex</div></a>
                                    <ul class="license__country">
                                        <?php
                                        $cat = Licenses::getcountry(3);
                                        foreach ($cat as $item):
                                            ?>
                                            <li>
                                                <?= Html::a(Html::encode($item->country),Url::to(['licenses/index', 'lic_type' => 3,'country'=>Html::encode($item->country)]))?>
                                            </li>
                                            <!--                                           --><?//=Html::tag('li', Html::encode($item->country));?>
                                        <?php endforeach; ?>
                                    </ul>

                                </div>
                                <div class="license-type">
                                    <a href="<?=Url::to(['licenses/index', 'lic_type' => 4])?>" class="license__link"><i class="icon-gambling"></i><div>Gambling License</div></a>
                                    <a href="#" class="license__mob" onclick="showCountryList(3)"><i class="icon-gambling"></i><div>Gambling</div></a>
                                    <ul class="license__country">
                                        <?php
                                        $cat = Licenses::getcountry(4);
                                        foreach ($cat as $item):
                                            ?>
                                            <li>
                                                <?= Html::a(Html::encode($item->country),Url::to(['licenses/index', 'lic_type' => 4,'country'=>Html::encode($item->country)]))?>
                                            </li>
                                            <!--                                           --><?//=Html::tag('li', Html::encode($item->country));?>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div class="license-type">
                                    <a href="<?=Url::to(['licenses/index', 'lic_type' => 5])?>" class="license__link"><i class="icon-bitcoin"></i><div>Cryptocurrency</div></a>
                                    <a href="#" class="license__mob" onclick="showCountryList(4)"><i class="icon-bitcoin"></i><div>Crypto</div></a>
                                    <ul class="license__country">
                                        <?php
                                        $cat = Licenses::getcountry(5);
                                        foreach ($cat as $item):
                                            ?>
                                            <li>
                                                <?= Html::a(Html::encode($item->country),Url::to(['licenses/index', 'lic_type' => 5,'country'=>Html::encode($item->country)]))?>
                                            </li>
                                            <!--                                           --><?//=Html::tag('li', Html::encode($item->country));?>
                                        <?php endforeach; ?>
                                    </ul>

                                </div>
                                <div class="iq__line"></div>
                            </div>



                            </div>

                            <div class="row">
                                <?php foreach ($licensesPerPage as $item) : ?>
                                    <div class="col-md-4">
                                        <div class="package">

                                            <a href="<?= Url::to(['licenses/'.$item->slug]) ?>">
                                                <div class="package-thumb">
                                                    <?= Html::img($item->thumb(500, 375)) ?>

                                                </div>
                                            </a>
                                            <div class="package-detail">
                                                <h4><?= Html::a($item->title, ['licenses/view', 'slug' => $item->slug]) ?></h4>
                                                <ul class="location-book">
                                                    <li class="book-btn"><i class="fa fa-info"></i>
                                                       <a href="<?= Url::to(['licenses/'.$item->slug]) ?>"><?= Yii::t('easyii', 'more_details') ?></a></li>
                                                    <li class="book-btn"><i class="fa fa-shopping-basket"></i>
                                                        <a href="javascript:void( window.open( 'https://form.jotformeu.com/82774951021356', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )"><?= Yii::t('easyii', '10') ?></a>
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
                        <div><?= Licenses::pages() ?></div>
                    </div>
                    <!-- Pagination -->

        </div>
    </div>
</section>
