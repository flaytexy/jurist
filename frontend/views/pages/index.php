<?php
use frontend\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;

$page = Page::get('page-'.$typeTitle);

$this->title = !empty($page->seo('title', $pages->model->title)) ? $page->seo('title', $page->model->title) : '';

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



$this->params['breadcrumbs'][] = $page->model->title;
$this->params['seo'][] = $page->seo('keywords');

?>

<div class="container" id="h1text">
    <h1><?= $page->seo('h1', $page->title) ?></h1>
    <?php if($page->text): ?><div><?= $page->seo('div', $page->text) ?></div><? endif; ?>
</div>
<style>
    #h1text{
        margin: auto;
        text-align: center !important;

    }

    #h1text h1{
        font-family: unset !important;
        font-size: 30px;
        border-bottom: 2px solid;
    }
</style>
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
                                                <li class="book-btn"><i class="fa fa-info"></i>

                                                    <?= Html::a('Подробнее', [$typeTitle.'/'.$item->slug]) ?></li>
                                                <li class="book-btn"><i class="fa fa-shopping-basket"></i>
                                                    <a href="javascript:void( window.open( 'https://form.jotformeu.com/71136944138357', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )">Заказать</a>
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