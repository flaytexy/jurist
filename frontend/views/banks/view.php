<?php
use frontend\modules\banks\api\Banks;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\helpers\Image;


$this->title = $banks->seo('title', $banks->model->title);
$this->params['breadcrumbs'][] = ['label' => 'Banks', 'url' => ['banks/index']];
$this->params['breadcrumbs'][] = $banks->model->title;
?>

<section>
    <div class="block">
        <div class="container">
            <!-- 1-block -->
            <div class="row">
                <div class="col-md-12">
                    <div class="packages-detail">
                        <?php if (count($banks->photos)) : ?>
                            <div class="package-video">
                                <div>
                                    <?= Html::img(Image::thumb($banks->photos[1]->image, 800, 450), ['width' => '100%', 'height' => '100%']) ?>
                                </div>

                                <i class="fa fa-play-circle"></i>
                                <strong class="per-night"><span>$</span>750 <i>Per Night</i></strong>
                                <a href="#" class="book-btn2" title="">BOOK THIS VILL</a>
                                <iframe src="https://www.youtube.com/embed/dVTsZZh54Do"></iframe>
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