<?php
use frontend\modules\offers\api\Offers;
use frontend\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\MapsAsset;

MapsAsset::register($this);
$page = Page::get('page-offers');

if(!empty($page)) $this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;

?>

<div class="container">
    <h1><?= $page->seo('h1', $page->title) ?></h1>
    <div><?= $page->seo('div', $page->text) ?></div>
</div>

<script type="application/javascript">
    var myMarker = <?= $markers; ?>;
    var mapType = "<?= $mapType; ?>";
</script>

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

<section id="world-map-markers-block">
    <div class="row">
        <div class="col-md-12 hidden-xs">
            <article class="format-standard">
                <figure>
                    <div id="world-map-markers" style="margin:0 auto; width: 1020px; height: 400px"></div>
                </figure>
            </article>
        </div>
    </div>
</section>


<section id="offers">
    <div class="block">
        <div class="container">
            <nav id="menus" class="navbar">
<!--                <div class="navbar-header"><span id="category" class="visible-xs">Перечень офшоров</span>-->
<!--                    <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse"-->
<!--                            data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>-->
<!--                </div>-->
                <!--  offers -->
                <div class="">
                    <ul class="nav" id="offers-menu-block">
                        <?php foreach ($offers as $item) : ?>
                            <? if($region_name != $item->model->region_name  /*&&  $item->model->region_name!=false*/ ): ?>
                                <?php $region_name = $item->model->region_name; ?>
                                <li  style="clear: left" class='h5 ' id="reg_<?= $item->model->region_id ?>"><?= $region_name ?></li>
                            <? endif ?>
                            <li style="float: left;"><a data-show-block="b_<?= $item->id ?>"><?= $item->title ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </nav>
            <div id="menu-show-block-zone" class="" style="display: none;">
                <?php foreach ($offers as $item) : ?>
                    <div id="b_<?= $item->id ?>" class="block-zone row" style="display: none;">
                        <div class="col-md-4">
                            <div class="package-thumb">
                                <a href="<?= Url::to(['offers/'.$item->slug]) ?>" class="label label-info">
                                    <?= Html::img($item->thumbFile($item->image, 500, 375), array('class' => 'sadsa')) ?>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <span><b><?= $item->title ?></b></span>
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
                    <div class="villaeditors-picks offers-list">
                        <div class="packages style2 remove-ext2">
                            <div class="row">
                                <?php foreach ($offers as $item) : ?>
                                    <div class="col-md-4">
                                        <div class="package">
                                            <a href="<?= Url::to(['offers/'.$item->slug]) ?>">
                                            <div class="package-thumb">
                                                <?= Html::img($item->thumb(500, 375)) ?>
                                                <span><i>$<?= $item->model->price ?></i> / <? if ($item->model->how_days): ?><?= $item->model->how_days?> дней<? else: ?>Минимал<? endif; ?></span>
                                            </div>
                                            </a>
                                            <div class="package-detail">
<!--                                            <span class="cate">
                                                <?php /*foreach ($item->tags as $tag) : */?>
                                                    <a href="<?/*= Url::to(['/offers', 'tag' => $tag]) */?>"
                                                       class="label label-info"><?/*= $tag */?></a>
                                                <?php /*endforeach; */?>
                                            </span>-->
                                                <h4><?= Html::a($item->title, ['offers/view', 'slug' => $item->slug]) ?></h4>
                                                <ul class="location-book">
                                                    <li class="active"><i class="fa fa-map-marker"></i>
                                                        <span><a href="<?= Url::to(['offers/'.$item->slug]) ?>">Заказать</a></span></li>
                                                    <li class="book-btn"><i class="fa fa-thumbs-o-up"></i>
                                                        <?= Html::a('Детальней', ['offers/view', 'slug' => $item->slug]) ?>
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
                        <div><?= Offers::pages() ?></div>
                    </div>
                    <!-- Pagination -->
                </div>
            </div>
        </div>
    </div>
</section>