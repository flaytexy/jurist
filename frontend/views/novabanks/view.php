<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\helpers\Image;

/**
 * @var \frontend\modules\novanews\api\NovanewsObject[] $top_news
 * @var \frontend\modules\novabanks\api\NovabanksObject[] $top_banks
 * @var \frontend\modules\novaoffers\api\NovaoffersObject[] $top_offers
 */
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
                                            <div class="slide"><h3><a href="<?= Url::to(['banks/'.$itemList->slug]) ?>"><?=$itemList->title?><br><b>€<?= $itemList->model->bank->price ?></b></a></h3></div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <?php if (!empty($page->model->image)) : ?>
                            <div class="package-video">
                                <div>
                                    <?php if (!empty($page->model->image)) : ?>
                                        <?= Html::img(Image::thumb($page->model->image, 1200, 300), ['width' => '100%', 'height' => '100%']) ?>
                                    <? endif ?>
                                </div>
                                <strong class="per-night" style="font-family: Arial"><span>€</span><?= $page->model->bank->price; ?> <i>Дней: <?= $page->model->bank->how_days; ?></i></strong>
                                <a href="javascript:void( window.open( 'https://form.jotformeu.com/71136944138357', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )" class="book-btn2" title="">Заказать</a>
                            </div><!-- Widget -->
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

            <?php if(isset($top_banks) && count($top_banks)>0): ?>
            <!-- Widget3 -->
            <div class="widget villa-photos-widget">
                <div class="title1 style2">
                    <h2>Топ банки</h2>
                    <span>Лучшие банковские условия</span>
                </div>
                <ul class="widget-gallery">
                    <?php foreach($top_banks as $item) : ?>
                        <li><a href="<?= Url::to(['banks/'.$item->slug]) ?>">
                                <?= Html::img(Image::thumb($item->image, 240, 120)) ?>
                            </a>
                            <span><a href="<?= Url::to(['banks/'.$item->slug]) ?>"><?= $item->title ?></a></span> </li>
                    <?php endforeach; ?>
                </ul>
            </div><!-- end: Widget3 -->
            <? endif; ?>
            <?php if(isset($top_news) && count($top_news)>0): ?>
            <!-- Widget1 -->
            <div class="widget vertical-menu-widget top10">
                <div class="recent-posts-widget">
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
                </div>
            </div><!-- end: Widget1 -->
            <? endif; ?>
            <?php if(isset($top_offers) && count($top_offers)>0): ?>
            <!-- Widget2 -->
            <div class="widget villa-photos-widget top20">
                <div class="title1 style2">
                    <h2>Хорошие предложения</h2>
                    <span>Интересные страны для бизнеса</span>
                </div>
                <ul class="widget-gallery">
                    <?php foreach($top_offers as $item) : ?>
                        <li><a href="<?= Url::to(['offers/'.$item->slug]) ?>">
                                <?= Html::img(\frontend\helpers\Image::thumb($item->image, 300, 200)) ?>
                            </a>
                            <span><a href="<?= Url::to(['offers/'.$item->slug]) ?>"><?= $item->title ?><br><b>€<?= $item->model->offer->price ?> / Дней: <?= $item->model->offer->how_days ?></b></a></span></li>
                    <?php endforeach; ?>

                </ul>
            </div><!-- end: Widget2 -->
            <? endif; ?>
            <?php if(isset($banksPist) && count($banksPist)>0): ?>
            <!-- Widget4 -->
            <div class="widget vertical-menu">
                <a href="#" class="active">Банки</a>
                <?php foreach ($banksPist as $itemList) : ?>
                    <a href="<?= Url::to(['banks/'.$itemList->slug]) ?>"><?=$itemList->title?> <b>€<?= $itemList->model->bank->price ?></b></a>
                <?php endforeach; ?>
            </div><!-- end: Widget4 -->
            <? endif; ?>
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