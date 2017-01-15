<?php
use frontend\modules\banks\api\Banks;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\helpers\Image;

$this->title = $banks->seo('title', $banks->model->title);
$this->params['breadcrumbs'][] = ['label' => 'Banks', 'url' => ['banks/index']];
$this->params['breadcrumbs'][] = $banks->model->title;
?>

<div class="pagetop-sec">
    <div class="fixed-bg2" style="background-image: url(images/pagetop-bg.jpg);"></div>
    <div class="container">
        <div class="page-title">
            <strong>Packages <span>Detail</span></strong>
            <ul class="breadcrumbs">
                <li><a href="/" title="">Homepage</a></li>
                <li>Take A Tour</li>
            </ul><!-- Bread Crumbs -->
        </div>
    </div>
</div><!-- Page Top Sec -->

<section>
    <div class="block">
        <div class="container">
            <!-- 1-block -->
            <div class="row">
                <div class="col-md-12">
                    <div class="packages-detail">
                        <?php if (count($banks->photos) || !empty($banks->model->image)) : ?>
                            <div class="package-video">
                                <div>
                                    <?php if (!empty($banks->model->image)) : ?>
                                        <?= Html::img(Image::thumb($banks->model->image, 800, 200), ['width' => '100%', 'height' => '100%']) ?>
                                    <? else: ?>
                                        <?= Html::img(Image::thumb($banks->photos[1]->image, 800, 200), ['width' => '100%', 'height' => '100%']) ?>
                                    <? endif ?>
                                </div>
                                <div class="title-video alignleft">
                                    <h1><?= $offers->seo('h1', $offers->title) ?></h1>
                                    <span><?= $offers->seo('h1', $offers->short) ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="title1 alignleft">
                            <h1><?= $banks->seo('h1', $banks->title) ?></h1>
                            <span>Villa Special bank!!!</span>
                        </div>
                        <p>
                            <?= $banks->text ?>
                        </p>
                    </div>
                    <!-- Blog List Posts -->
                </div>
            </div>

            <!-- 3-block -->
            <div class="row" style="margin-top: 80px;">
                <div class="col-md-12">
                    <p>
                        <?php foreach ($banks->tags as $tag) : ?>
                            <a href="<?= Url::to(['/banks', 'tag' => $tag]) ?>"
                               class="label label-info"><?= $tag ?></a>
                        <?php endforeach; ?>
                    </p>

                    <div class="small-muted">Views: <?= $banks->views ?></div>
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