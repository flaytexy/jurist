<?php
use frontend\modules\page\api\Pages;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\helpers\Image;

$this->title = $pages->seo('title', $pages->model->title);
$this->params['breadcrumbs'][] = ['label' => $parentPage->title, 'url' => Url::to([$pageParentUrl.'/'])];
$this->params['breadcrumbs'][] = $pages->model->title;
?>

<section>
    <div class="block">
        <div class="container">
            <!-- 1-block -->
            <div class="row">
                <div class="col-md-12">
                    <div class="packages-detail">
                        <?php if (count($pages->photos) || !empty($pages->model->image)) : ?>
                            <div class="package-video">
                                <div>
                                    <?php if (!empty($pages->model->image)) : ?>
                                        <?= Html::img(Image::thumb($pages->model->image, 1100, 300), ['width' => '100%', 'height' => '100%']) ?>
                                    <? else: ?>
                                        <?= Html::img(Image::thumb($pages->photos[1]->image, 1100, 300), ['width' => '100%', 'height' => '100%']) ?>
                                    <? endif ?>
                                </div>
                                <div class="title-video alignleft">
                                    <h1><?= $pages->seo('h1', $pages->title) ?></h1>
                                    <span><?= $pages->seo('h1', $pages->short) ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <p>
                            <?= $pages->text ?>
                        </p>
                    </div>
                    <!-- Blog List Posts -->
                </div>
            </div>

            <!-- 3-block -->
            <div class="row" style="margin-top: 80px;">
                <div class="col-md-12">
                    <p>
                        <?php foreach ($pages->tags as $tag) : ?>
                            <a href="<?= Url::to(['/pages', 'tag' => $tag]) ?>"
                               class="label label-info"><?= $tag ?></a>
                        <?php endforeach; ?>
                    </p>

<!--                    <div class="small-muted">Views: --><?//= $pages->views ?><!--</div>-->
                </div>
            </div>
        </div>
    </div>
</section>

<div style="display:none">
    <div class="container-fluid" id="succes_packet">
        <form id="succes_packet_form" name="succes_packet_form" class="succes_packet_form" action="/admin/orders/send" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="row-fluid">
                        <div class="form-group">
                            <label for="firstName">ИМЯ</label>
                            <input name="Feedback[name]" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="form-group">
                            <label for="email">Е-МЕЙЛ</label>
                            <input name="Feedback[email]" class="form-control" type="email">
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="form-group">
                            <label for="password">ТЕЛЕФОН</label>
                            <input name="Feedback[phone]" class="form-control" type="text">
                        </div>
                    </div>


                </div>
                <div class="col-md-6">
                    <div class="row-fluid">
                        <div class="form-group">
                            <label for="password">ВАШ КОММЕНТАРИЙ</label><br/>
                            <textarea name="Feedback[comment]" class="form-control" rows="7"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="text-align: center;">
                    <hr>
                    <input id="top-save-button" type="submit" name="save" value="Подтвердить" class="btn btn-success regbutton" />
                </div>
            </div>
        </form>
    </div>
</div>