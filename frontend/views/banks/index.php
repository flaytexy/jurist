<?php
use frontend\modules\banks\api\Banks;
use frontend\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;

use frontend\assets\TablesAsset;

TablesAsset::register($this);

use frontend\assets\SwitcherAsset;

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
                            <li>Персональное присутствие</li>
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
                            <li>Минимальный депозит</li>
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
                        <table
                            class="table border-none <?= $item->model->type_id ?>_<?= $item->model->personal ?>_<?= $item->model->min_deposit ?>"
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
                                            <a href="<?= Url::to(['banks/view', 'slug' => $item->slug]) ?>"><?= Html::img($item->thumb(70, 48)) ?></a>
                                        </div>
                                        <div class="top10">
                                            <?= Html::img(\frontend\helpers\Image::thumb($item->model->image_flag, 32, 18)) ?>
                                            <span class="left tBankLi"
                                                  style="margin: 2px 0 0 0"><?= $item->model->location_title ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden-xs hidden-sm hidden-md  col-lg-8">
                                    <table class="table border-none tBankLi">
                                        <tr>
                                            <td>
                                                <p class="f">﻿Личный счет</p>
                                                <?php if ($item->model->type_id === 2): ?>
                                                    <div class="green_yes "><i class="fa fa-check fa-3"
                                                                               aria-hidden="true"></i></div><? else: ?>
                                                    <div class="green_no"><i class="fa fa-times fa-3"
                                                                             aria-hidden="true"></i></div><? endif; ?>
                                            </td>
                                            <td>
                                                <p class="f">Корпоративный счет</p>
                                                <?php if ($item->model->type_id === 1): ?>
                                                    <div class="green_yes "><i class="fa fa-check fa-3"
                                                                               aria-hidden="true"></i></div><? else: ?>
                                                    <div class="green_no"><i class="fa fa-times fa-3"
                                                                             aria-hidden="true"></i></div><? endif; ?>
                                            </td>
                                            <td>
                                                <p class="f" title="Открытие счета без личного присутствия">
                                                    Персональное присутствие </p>
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

                                                <div
                                                    class="hegg"><? if ($item->model->min_deposit > 0): ?><?= $item->model->min_deposit ?><? else: ?>
                                                        <div class="green_no"><i class="fa fa-times fa-3"
                                                                                 aria-hidden="true"></i>
                                                        </div><? endif ?></div>
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
                                <td class="col-md-4 col-lg-2">
                                    <h6 class="text-center">
                                        <span>Цена</span>
                                    </h6>
                                    <h6 class="text-center">$<?= $item->price ?></h6>

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
                                                    <?= Html::img($item->thumb(500, 375)) ?>
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