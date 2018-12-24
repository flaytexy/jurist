<?php
use frontend\modules\sale\api\Sale;

use frontend\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;


$page = Page::get('page-sale');

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

                <div class="row">
                    <?php foreach ($offersPerPage as $item) : ?>
                        <div class="col-md-4">
                            <div class="package">

                                <a href="<?= Url::to(['sale/'.$item->slug]) ?>">
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
            <div><?= Sale::pages() ?></div>
        </div>
        <!-- Pagination -->

    </div>
    </div>
</section>
