<?php
use frontend\modules\banks\api\Banks;
use frontend\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;

use frontend\assets\TablesAsset;

TablesAsset::register($this);

use frontend\assets\SwitcherAsset;
use akavov\countries\assets\CountriesAsset;
CountriesAsset::register($this);
SwitcherAsset::register($this);


$page = Page::get('page-banks');
if ($page) {
    $this->title = $page->seo('title', $page->model->title);
    //$this->view->registerMetaTag(['name' => 'keywords', 'content' => 'yii, framework, php']);
    $this->registerMetaTag([
        'name' => 'title',
        'content' => $page->seo('title', '')
    ]);
    $this->registerMetaTag([
        'name' => 'keywords',
        'content' => $page->seo('keywords', '')
    ]);
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $page->seo('description', '')
    ]);
}

$this->params['breadcrumbs'][] = $page->model->title;
?>
    <div class="container">
        <h1><?= $page->seo('h1', $page->title) ?></h1>
        <?php if ($page->text): ?>
            <div><?= $page->seo('div', $page->text) ?></div><? endif; ?>
    </div>

    <section id="banks2" class="scroll-container">
        <div class="container">
            <div class="row top30">
                <form>
                    <div class="col-md-4">
                        <ul class="list-inline" id="sw-list">
                            <li>Корпоративный счет</li>
                            <li class="">
                                <div class="switcher">
                                    <input value="0" class="switch" js-filter="js-filter-type-id" name="switchName"
                                           type="checkbox"/>
                                </div>
                            </li>
                            <li>Личный счет</li>
                        </ul>

                    </div>
                    <div class="col-md-4">
                        <ul class="list-inline" id="sw-list">
                            <li>С посещением банка</li>
                            <li class="">
                                <div class="switcher">
                                    <input value="0" class="switch" js-filter="js-filter-personal" name="switchName2"
                                           type="checkbox"/>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-inline" id="sw-list">
                            <li>С минимальным депозитом</li>
                            <li class="">
                                <div class="switcher">
                                    <input value="0" class="switch" js-filter="js-filter-min-deposit" js-filter-switch-only="1" name="switchName3"
                                           type="checkbox"/>
                                </div>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>

            <div class="row bank-new-list">
                <div class="col-md-12" id="switchAllBanks">

                 <!--   <h4>Africa</h4>-->
                    <?php foreach ($banks as $item) : ?>
                        <? if($region_name != $item->model->region_name && $item->model->region_name != 'Polar: Arctic' /*&&  $item->model->region_name!=false*/ ): ?>
                           <?php $region_name = $item->model->region_name; ?>
                           <div class='h4 top20 region-id-mark' id="reg_<?= $item->model->region_id ?>"><?= $region_name ?></div>
                        <? endif ?>
                        <table data-region-assign="reg_<?= $item->model->region_id ?>"
                            class="table reg_<?= $item->model->region_id ?> table-bordered <?= $item->model->type_id ?>_<?= $item->model->personal ?>_<?= $item->model->min_deposit ?>"
                            <? if ($item->model->type_id !== 1): ?> js-filter-type-id="1" <? else: ?> js-filter-type-id="0" <? endif; ?>
                            <? if ($item->model->personal === 1): ?> js-filter-personal="1" <? else: ?> js-filter-personal="0" <? endif; ?>
                            <? if ($item->model->min_deposit > 0): ?> js-filter-min-deposit="1" <? else: ?> js-filter-min-deposit="0" <? endif; ?>
                            >
                            <tr>
                                <td class="col-md-8 col-lg-2">
                                    <h6>
                                        <?= Html::a($item->title, ['banks/view', 'slug' => $item->slug]) ?>
                                    </h6>

                                    <div class="no-margin inl-block">
                                        <div class="hide-for-small-down">
                                            <a href="<?= Url::to(['banks/view', 'slug' => $item->slug]) ?>"><?= Html::img($item->thumb(120, 31)) ?></a>
                                        </div>
                                        <div class="top10 row">
                                            <? if ($item->model->countries[0]->alpha): ?><div class="col-xs-3"><div class="b-flag"> <div class="label flag flag-icon-background flag-icon-<?= $item->model->countries[0]->alpha ?>">&nbsp;</div></div></div><? endif ?>
                                            <div class="col-xs-9"><div class="left tBankLi" style="margin: 2px 0 0 0"><? if ($item->model->countries[0]->name_ru): ?><?= $item->model->countries[0]->name_ru ?><? else: ?><?= $item->model->location_title ?><? endif ?></div></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden-xs hidden-sm hidden-md  col-lg-8">
                                    <table class="table border-none tBankLi">
                                        <tr>
                                            <td>

                                                <?php if ($item->model->type_id === 2): ?>
                                                    <p class="f">﻿Личный счет</p>
                                                    <div class="green_yes "><i class="fa fa-check fa-3"
                                                                               aria-hidden="true"></i></div>
                                                <? else: ?>
                                                    <p class="f">Корпоративный счет</p>
                                                    <div class="green_yes "><i class="fa fa-check fa-3"
                                                                               aria-hidden="true"></i></div>
                                                <? endif; ?>
                                            </td>

                                            <td>
                                                <p class="f" title="Открытие счета без личного присутствия">
                                                    С посещением банка </p>
                                                <?php if ($item->model->personal === 1): ?>
                                                    <div class="green_yes "><i class="fa fa-check fa-3"
                                                                               aria-hidden="true"></i></div><? else: ?>
                                                    <div class="green_no"><i class="fa fa-times fa-3"
                                                                             aria-hidden="true"></i></div><? endif; ?>
                                            </td>

                                            <td>
                                                <p class="f">Сайт банка</p>

                                                <div class="hegg"><?= $item->model->website ?></div>
                                                <!--<div class="green_no"><i class="fa fa-times fa-3" aria-hidden="true"></i></div>-->
                                            </td>
                                            <td>
                                                <p class="f">Минимальный депозит</p>

                                                <div class="hegg"><? if ($item->model->min_deposit > 0): ?><?= $item->model->min_deposit ?><? else: ?>
                                                        <div class="">
                                                            0
                                                        </div><? endif ?>
                                                </div>
                                                <!--   <div class="green_yes "><i class="fa fa-check fa-3" aria-hidden="true"></i></div>-->
                                            </td>
                                            <td>
                                                <p class="f">Срок</p>

                                                <div class="tBankDays tBankOter"><p><?= $item->how_days ?></p></div>
                                            </td>
                                            <!--<td>
                                                <p class="">Initial Deposit</p>
                                                <p class="">USD 0</p>
                                            </td>
                                            <td>
                                                <p class=""> Min. Balance</p>
                                                <p class="">USD 0</p>
                                            </td>-->
                                        </tr>
                                    </table>
                                </td>
                                <td class="col-md-4 col-lg-2 bg-green-price">
                                    <div class="h6 text-center">
                                        <span>Цена</span>
                                    </div>
                                    <div class="h6 text-center cena">$<?= $item->price ?></div>

                                    <div class="text-center" style="height:35px;">
                                        <a href="<?= Url::to(['banks/view', 'slug' => $item->slug]) ?>"
                                           class="btn btn-success">Заказать</a>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    <? endforeach; ?>

                </div>
            </div>
        </div>
    </section>




<? if (true): ?>
    <section id="pages" class="top30">
        <div class="block">

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="font-color">Подробнее о наших банках</h3>
                        <div class="villaeditors-picks">
                            <div class="packages style2 remove-ext2">
                                <div class="row">
                                    <?php foreach ($banksList as $item) : ?>
                                        <div class="col-md-4">
                                            <div class="package">

                                                <div class="package-thumb">
                                                    <?= Html::img($item->thumb(240, 160)) ?>
                                                    <!--<span><i>$<? /*= $item->model->price */ ?></i> / <? /* if ($item->model->how_days): */ ?><? /*= $item->model->how_days*/ ?><? /* else: */ ?>Минимал<? /* endif; */ ?></span>-->
                                                </div>
                                                <div class="package-detail">
                                                    <!--                                            <span class="cate">
                                                <?php /*foreach ($item->tags as $tag) : */ ?>
                                                    <a href="<? /*= Url::to(['/pages', 'tag' => $tag]) */ ?>"
                                                       class="label label-info"><? /*= $tag */ ?></a>
                                                <?php /*endforeach; */ ?>
                                            </span>-->
                                                    <h4><?= Html::a($item->title,
                                                            ['banks/view', 'slug' => $item->slug]) ?></h4>
                                                    <ul class="location-book">
                                                        <li class="active"><i class="fa fa-map-marker"></i>
                                                            <span><?= $item->date ?></span></li>
                                                        <li class="book-btn"><i class="fa fa-thumbs-o-up"></i>
                                                            <?= Html::a('Детальней',
                                                                ['banks/view', 'slug' => $item->slug]) ?>
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
                            <div><?= $banksPagination ?></div>
                        </div>
                        <!-- Pagination -->
                    </div>
                </div>
            </div>
        </div>
    </section>
<? endif; ?>