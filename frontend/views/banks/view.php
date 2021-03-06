<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\helpers\Image;

if(!$page->model){
    exit('MODEL NOT FOUND!');
}

$this->title = !empty($page->model->title) ? $page->seo('title', $page->model->title) : '';

if($descriptionSeo = !empty($page->seo('description','')) ? $page->seo('description','') : ''){
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

$this->params['breadcrumbs'][] = ['label' => 'Banks', 'url' => ['banks/index']];
$this->params['breadcrumbs'][] = $page->model->title;
?>

<section id="banks-view" class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <!-- 1-block -->
            <div class="row">
                <div class="col-md-12">
                    <div class="packages-detail">
                        <section class="client">
                            <div class="container">
                                <div class="row">
                                    <div class="carousel-client">
                                        <?php foreach ($banksPist as $itemList) : ?>
                                            <div class="slide"><h3><a href="<?= Url::to(['banks/'.$itemList->slug]) ?>"><?=$itemList->title?><br><b>€<?= $itemList->model->price ?></b></a></h3></div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <?php if (count($page->photos) || !empty($page->model->image)) : ?>
                            <div class="package-video">
                                <div>
                                    <?php if (!empty($page->model->image)) : ?>
                                        <?= Html::img(Image::thumb($page->model->image, 1200, 300), ['width' => '100%', 'height' => '100%']) ?>
                                    <? else: ?>
                                        <?= Html::img(Image::thumb($page->photos[1]->image, 1200, 300), ['width' => '100%', 'height' => '100%']) ?>
                                    <? endif ?>
                                </div>
                                <strong class="per-night" style="font-family: Arial"><span>€</span><?= $page->price; ?> <i><?= Yii::t('easyii', 'days') ?>: <?= $page->model->how_days; ?></i></strong>
                                <a href="javascript:void( window.open( 'https://form.jotformeu.com/82774951021356', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )" class="book-btn2" title=""><?= Yii::t('easyii', '10') ?></a>
                                <div class="title-video alignleft">
                                    <h1><?= $page->seo('h1', $page->title) ?></h1>
                                    <span><?= $page->seo('h1', $page->short) ?></span>
                                </div>
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
                            <a href="<?= Url::to(['/banks', 'tag' => $tag]) ?>"
                               class="label label-info"><?= $tag ?></a>
                        <?php endforeach; ?>
                    </p>

<!--                    <div class="small-muted">Views: --><?//= $page->views ?><!--</div>-->
                </div>
            </div>
            <? endif; ?>
        </div>
        <div class="col-md-3">
            <!-- Widget3 -->
            <div class="widget villa-photos-widget">
                <div class="title1 style2">
                    <h2><?= Yii::t('easyii', 'topBanks') ?></h2>
                    <span><?= Yii::t('easyii', 'bestTerm') ?></span>
                </div>
                <ul class="widget-gallery">
                    <?php foreach($top_banks as $item) : ?>
                        <li><a href="<?= Url::to(['banks/'.$item['slug']]) ?>">
                                <?= Html::img(Image::thumb($item['image'], 240, 120)) ?>
                            </a>
                            <span><a href="<?= Url::to(['banks/'.$item['slug']]) ?>"><?= $item['title'] ?></a></span> </li>
                    <?php endforeach; ?>
                </ul>
            </div><!-- end: Widget3 -->

            <!-- Widget1 -->
            <div class="widget vertical-menu-widget top10">
                <div class="recent-posts-widget">
                    <div class="title1 style2">
                        <h2><?= Yii::t('easyii', 'articles') ?></h2>
                        <span><?= Yii::t('easyii', 'popularNews') ?></span>
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
                </div>
            </div><!-- end: Widget1 -->

            <!-- Widget2 -->
            <div class="widget villa-photos-widget top20">
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
            </div><!-- end: Widget2 -->

            <!-- Widget4 -->
            <div class="widget vertical-menu">
                <a href="#" class="active"><?= Yii::t('easyii', 'banks') ?></a>
                <?php foreach ($banksPist as $itemList) : ?>
                    <a href="<?= Url::to(['banks/'.$itemList->slug]) ?>"><?=$itemList->title?> <b>€<?= $itemList->model->price ?></b></a>
                <?php endforeach; ?>
            </div><!-- end: Widget4 -->
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
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.5/jquery.bxslider.js"></script>
<script>
    $('.carousel-client').bxSlider({
        auto: true,
        slideWidth: 234,
        minSlides: 2,
        maxSlides: 5,
        controls: false
    });
</script>