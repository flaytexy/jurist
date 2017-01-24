<?php
use frontend\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\helpers\Image;

$page = Page::get('page-'.$typeTitle);

$this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;

?>

<div class="container">
    <h1><?= $page->seo('h1', $page->title) ?></h1>
    <?php if($page->text): ?><div><?= $page->seo('div', $page->text) ?></div><? endif; ?>
</div>

<section id="pages" class="content-zone top20">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="villaeditors-picks">
                    <div class="packages style2 remove-ext2">
                        <div class="row">
                            <?php foreach ($pages as $item) : ?>
                                <div class="col-md-4">
                                    <div class="package">

                                        <div class="package-thumb">
                                            <a href="<?= Url::to([$typeTitle.'/'.$item->slug]) ?>" class="">
                                                <?= Html::img($item->thumb(500, 375)) ?>
                                            </a>
                                            <!--<span><i>$<?/*= $item->model->price */?></i> / <?/* if ($item->model->how_days): */?><?/*= $item->model->how_days*/?><?/* else: */?>Минимал<?/* endif; */?></span>-->
                                        </div>
                                        <div class="package-detail">
<!--                                        <span class="cate">
                                            <?php /*foreach ($item->tags as $tag) : */?>
                                                <a href="<?/*= Url::to(['/pages', 'tag' => $tag]) */?>"
                                                   class="label label-info"><?/*= $tag */?></a>
                                            <?php /*endforeach; */?>
                                        </span>-->
                                            <h4><?= Html::a($item->title, Url::to([$typeTitle.'/'.$item->slug])) ?></h4>
                                            <ul class="location-book">
                                                <li class="active"><i class="fa fa-map-marker"></i>
                                                    <span><?= $item->date ?></span></li>
                                                <li class="book-btn"><i class="fa fa-thumbs-o-up"></i>
                                                    <?= Html::a('Детальней', ['pages/view', 'slug' => $item->slug]) ?>
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
                    <div><?= Page::pages() ?></div>
                </div>
                <!-- Pagination -->
            </div>
        </div>
    </div>
</section>