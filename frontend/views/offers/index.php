<?php
use frontend\modules\offers\api\Offers;
use frontend\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;

$page = Page::get('page-offers');

$this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;
?>
<h1><?= $page->seo('h1', $page->title) ?></h1>
<br/>

<?php /*foreach($offers as $item) : ?>
    <div class="row">
        <div class="col-md-2">
            <?= Html::img($item->thumb(160, 120)) ?>
        </div>
        <div class="col-md-10">
            <?= Html::a($item->title, ['offers/view', 'slug' => $item->slug]) ?>
            <div class="small-muted"><?= $item->date ?></div>
            <p><?= $item->short ?></p>
            <p>
                <?php foreach($item->tags as $tag) : ?>
                    <a href="<?= Url::to(['/offers', 'tag' => $tag]) ?>" class="label label-info"><?= $tag ?></a>
                <?php endforeach; ?>
            </p>
        </div>
    </div>
    <br>
<?php endforeach; ?>

<?= Offers::pages() */ ?>
<section>
    <div class="row">
        <div class="col-md-12">
            <div class="map-bg">
                <div id="map-pos" class="map-pos">
                    <a href="#!id58" style="top: 234px; left: 118px;" class="offshores_map_marker  copy-link bg1" data-cost="399" data-open-block="b58">Белиз</a>
                    <a href="#!id97" style="top: 314px; left: 613px;" class="offshores_map_marker  copy-link bg1" data-cost="399" data-open-block="b97">Сейшелы</a>
                    <a href="#!id101" style="top: 258px; left: 139px;" class="offshores_map_marker  copy-link bg1" data-cost="850" data-open-block="b101">Панама</a>
                    <a href="#!id65" style="top: 203px; left: 821px;" class="offshores_map_marker  copy-link bg3" data-cost="1250" data-open-block="b65">Гонконг</a>
                    <a href="#!id66" style="top: 124px; left:23px;" class="offshores_map_marker  copy-link bg4" data-cost="399" data-open-block="b66">США (Орегон) </a>
                    <a href="#!id121" style="top: 286px; left:790px;" class="offshores_map_marker  copy-link active" data-cost="3600" data-open-block="b121">Сингапур</a>
                    <a href="#!id125" style="top: 153px; right: 539px;" class="offshores_map_marker offshores_map_marker__onright copy-link" data-cost="999" data-open-block="b125">Гибралтар</a>
                    <a href="#!id126" style="top: 161px; left: 520px;" class="offshores_map_marker  copy-link" data-cost="1100" data-open-block="b126">Кипр</a>
                    <a href="#!id127" style="top: 145px; left: 472px;" class="offshores_map_marker  copy-link" data-cost="2100" data-open-block="b127">Мальта</a>
                    <a href="#!id289" style="top: 185px; left: 597px;" class="offshores_map_marker  copy-link" data-cost="" data-open-block="b289">ОАЭ</a>
                    <a href="#!id293" style="top: 92px; left: 141px;" class="offshores_map_marker  copy-link" data-cost="899" data-open-block="b293">Канада</a>
                    <a href="#!id342" style="top: 79px; left: 449px;" class="offshores_map_marker offshores_map_marker__onright_ copy-link" data-cost="2800" data-open-block="b342">Дания</a>
                    <a href="#!id305" style="top: 237px; left: 195px;" class="offshores_map_marker  copy-link" data-cost="1650" data-open-block="b305">БВО</a>
                    <a href="#!id313" style="top: 394px; left: 916px;" class="offshores_map_marker  copy-link to_left2" data-cost="" data-open-block="b313">Острова Кука</a>
                    <a href="#!id317" style="top: 94px; left: 319px;" class="offshores_map_marker  copy-link to_left3" data-cost="950" data-open-block="b317">Шотландия</a>
                    <a href="#!id346" style="top: 107px; left: 450px;" class="offshores_map_marker  copy-link to_left4" data-cost="" data-open-block="b346">Люксембург</a>
                    <a href="#!id350" style="top: 119px; left: 362px;" class="offshores_map_marker  copy-link offshores_map_marker__onright" data-cost="500" data-open-block="b350">Лихтенштейн</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="offers">
    <div class="block">
        <div class="container">
            <nav id="menus" class="navbar">
                <div class="navbar-header"><span id="category" class="visible-xs">Перечень офшоров</span>
                    <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
                </div>
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav" id="menu-show-block">
                        <?php foreach($offers as $item) : ?>
                        <li><a data-show-block="b_<?= $item->id ?>" ><?= $item->title ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </nav>
            <div id="menu-show-block-zone" class="" style="display: none;">
                <?php foreach($offers as $item) : ?>
                <div id="b_<?= $item->id ?>" class="block-zone row" style="display: none;">
                    <div class="col-md-4">
                        <div class="package-thumb">
                            <?= Html::img($item->thumb(500, 375) , array('class'=>'sadsa') ) ?>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <?= $item->short ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="villaeditors-picks">
                        <div class="packages style2 remove-ext2">
                            <div class="row">
                                <?php foreach($offers as $item) : ?>
                                    <div class="col-md-4">
                                        <div class="package">
                                            <div class="package-thumb">
                                                <?= Html::img($item->thumb(500, 375)) ?>
                                                <span><i>$380</i> / Минимал</span>
                                            </div>
                                            <div class="package-detail">
                                            <span class="cate">
                                                <?php foreach($item->tags as $tag) : ?>
                                                    <a href="<?= Url::to(['/offers', 'tag' => $tag]) ?>" class="label label-info"><?= $tag ?></a>
                                                <?php endforeach; ?>
                                            </span>
                                                <h4><?= Html::a($item->title, ['offers/view', 'slug' => $item->slug]) ?></h4>
                                                <ul class="location-book">
                                                    <li class="active"><i class="fa fa-map-marker"></i> <span><?= $item->date ?></span></li>
                                                    <li class="book-btn"><i class="fa fa-thumbs-o-up"></i><a href="#" title="">BOOK NOW</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div><!-- Villa Editors Picks -->
                    <div id="pagination">
                        <div><?= Offers::pages() ?></div>
                    </div><!-- Pagination -->
                </div>
            </div>
        </div>
    </div>
</section>