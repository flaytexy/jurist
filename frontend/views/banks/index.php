<?php
use frontend\modules\banks\api\Banks;
use frontend\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\TablesAsset;

TablesAsset::register($this);

$page = Page::get('page-banks');

$this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;
?>
<div class="container">
    <h1><?= $page->seo('h1', $page->title) ?></h1>
    <div><?= $page->seo('div', $page->text) ?></div>
</div>

<section id="banks">
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <table class="table" id="table-js">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Страна</th>
                                <th>Сайт</th>
                                <th>Мин. депозит/баланс</th>
                                <th>Срок</th>
                                <th>Цена</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($banks as $item) : ?>
                            <tr>
                                <td>
                                    <?= $item->title ?>
                                </td>
                                <td>
                                    <?= $item->model->location_title ?>
                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <?= $item->model->how_days ?>
                                </td>
                                <td>
                                    <?= $item->price ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>