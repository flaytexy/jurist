<?php

/**
 * @var \yii\web\View $this
 * @var \app\modules\park\models\Car|array $models
 * @var \app\modules\park\models\Car $model
 * @var \yii\data\Pagination $pages
 */

use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<div class="items-list-page">

<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="title">
                    Автомобили
                    <a href="<?= Url::to(['/admin/park/car/edit', 'id' => 0]); ?>" class="btn btn-primary btn-sm rounded-s">
                        добавить
                    </a>
                    <a href="#" id="import-cars" class="btn btn-secondary btn-sm rounded-s">
                        импортировать
                    </a>
                </h3>

                <form action="<?= Url::to(['import']); ?>" method="post" enctype="multipart/form-data" class="js-fileapi-wrapper" style="display: none">
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                    <div class="btn btn-secondary js-fileapi-button">
                        <span>Выбрать файл</span>
                        <input type="file" name="import" accept="application/json">
                    </div>
                </form>

                <?php ob_start(); ?>
                <script>

                    $('#import-cars').on('click', function (e) {
                        e.preventDefault();
                        $('.js-fileapi-wrapper').toggle();
                    });

                    $('.js-fileapi-button').on('click', function (e) {
                        if (e.originalEvent) {
                            $('input[type="file"]', '.js-fileapi-button').trigger('click');
                        }
                    });

                    $('.js-fileapi-wrapper').on('change', function (e) {
                        $(this).submit();
                    });

                </script>
                <?php $script = str_replace(['<script>', '</script>'], '', ob_get_contents()); ?>
                <?php ob_end_clean(); ?>

                <?php $this->registerJs($script); ?>
            </div>
        </div>
    </div>
</div>

<div class="card items">
    <ul class="item-list striped">
        <li class="item item-list-header hidden-sm-down">
            <div class="item-row">
                <div class="item-col item-col-header item-col-title">
                    <div> <span>Автомобили</span> </div>
                </div>
                <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
            </div>
        </li>
        <?php if (!empty($models)) { ?>
            <?php foreach ($models as $model) { ?>
                <li class="item">
                    <div class="item-row">

                        <div class="item-col fixed pull-left item-col-title">
                            <div class="item-heading">Заголовок</div>
                            <div>
                                <a href="<?= $model->getEditLink(); ?>">
                                    <h4 class="item-title"><?= $model->getTitle(); ?></h4>
                                </a>
                            </div>
                        </div>

                        <div class="item-col fixed item-col-actions-dropdown">
                            <div class="item-actions-dropdown">
                                <a class="item-actions-toggle-btn">
                                    <span class="inactive"><i class="fa fa-cog"></i></span>
                                    <span class="active"><i class="fa fa-chevron-circle-right"></i></span>
                                </a>
                                <div class="item-actions-block">
                                    <ul class="item-actions-list">
                                        <li>
                                            <a class="remove" href="<?= Url::to(['/admin/park/car/delete', 'id' => $model->id]); ?>">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="edit" href="<?= $model->getEditLink(); ?>">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            <?php } ?>
        <?php } else { ?>
        <li class="item">
            <div class="item-row py-1">
                <small><em>список автомобилей пуст...</em></small>
            </div>
        </li>
        <?php } ?>
    </ul>
</div>
<nav class="text-xs-center">
    <?=
        LinkPager::widget([
            'pagination' => $pages,
            'linkOptions' => [
                'class' => 'page-link',
            ],
            'pageCssClass' => 'page-item',
            'prevPageCssClass' => 'page-item',
            'nextPageCssClass' => 'page-item',
            'disabledListItemSubTagOptions' => [
                'class' => 'page-link',
            ],
        ]);
    ?>
</nav>
</div>