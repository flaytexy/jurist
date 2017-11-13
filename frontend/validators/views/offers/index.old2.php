<?php
use frontend\modules\offers\api\Offers;
use frontend\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;

$page = Page::get('page-offers');

if(!empty($page)) $this->title = $page->seo('title', $page->model->title);
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
            <div class="<? if($offer_type==2) : ?>map-bg-eu<? else: ?>map-bg<? endif; ?>">
                <div id="map-pos" class="map-pos">
                    <?php foreach ($offers as $item) : ?>
                    <a class="map-marker" style="top: <?= $item->position[0] ?>px; left: <?= $item->position[1] ?>px;" data-show-block="b_<?= $item->id ?>"><?= $item->title ?></a>
                    <?php endforeach; ?>
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
                    <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse"
                            data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
                </div>
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav" id="menu-show-block">
                        <?php foreach ($offers as $item) : ?>
                            <li><a data-show-block="b_<?= $item->id ?>"><?= $item->title ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </nav>
            <div id="menu-show-block-zone" class="" style="display: none;">
                <?php foreach ($offers as $item) : ?>
                    <div id="b_<?= $item->id ?>" class="block-zone row" style="display: none;">
                        <div class="col-md-4">
                            <div class="package-thumb">
                                <?= Html::img($item->thumb(500, 375), array('class' => 'sadsa')) ?>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <?= $item->short ?>

                            <ul>
                                <?php foreach ($item->properties as $prop) : ?>
                                    <li>
                                        <?= $prop->name ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <div class="btn abtn">
                                <?= Html::a('Подробнее', ['offers/view', 'slug' => $item->slug], ['class'=>'btn btn-default']) ?>
                            </div>

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
                                <?php foreach ($offers as $item) : ?>
                                    <div class="col-md-4">
                                        <div class="package">

                                            <div class="package-thumb">
                                                <?= Html::img($item->thumb(500, 375)) ?>
                                                <span><i>$380</i> / Минимал</span>
                                            </div>
                                            <div class="package-detail">
                                            <span class="cate">
                                                <?php foreach ($item->tags as $tag) : ?>
                                                    <a href="<?= Url::to(['/offers', 'tag' => $tag]) ?>"
                                                       class="label label-info"><?= $tag ?></a>
                                                <?php endforeach; ?>
                                            </span>
                                                <h4><?= Html::a($item->title, ['offers/view', 'slug' => $item->slug]) ?></h4>
                                                <ul class="location-book">
                                                    <li class="active"><i class="fa fa-map-marker"></i>
                                                        <span><?= $item->date ?></span></li>
                                                    <li class="book-btn"><i class="fa fa-thumbs-o-up"></i><a href="#"
                                                                                                             title="">BOOK
                                                            NOW</a></li>
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
                        <div><?= Offers::pages() ?></div>
                    </div>
                    <!-- Pagination -->
                </div>
            </div>
        </div>
    </div>
</section>