<?php
use frontend\modules\feedback\api\Feedback;
use frontend\modules\page\api\Page;

$page = Page::get('page-contact');

if(!empty($page)) $this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;
?>


<div class="container" id="page-contact">
    <div class="row contact-zone">
        <div class="col-md-6">
            <div class="row top10">
                <div class="col-md-12">
                    <h3 class="text-success"><?= $page->seo('h1', $page->title) ?></h3>
                    <?= $page->text ?>
                </div>
             </div>
        </div>

        <div class="col-md-6">
            <div class="row top10">
                <div class="col-md-12">
                    <?php if(Yii::$app->request->get(Feedback::SENT_VAR)) : ?>
                        <h3 class="text-success"><i class="glyphicon glyphicon-ok"></i> Message successfully sent</h3>
                    <?php else : ?>
                        <h3 class="text-success"><i class="glyphicon glyphicon"></i> Свяжитесь с нами</h3>
                        <div class="well-my well-sm-my">
                            <?= Feedback::form() ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="row top30">
                <!--    <div style="width: 560px; height: 400px;">
                            <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=mmkooEZKXnOxiZqGK4JZVGNlW6ppgKdB&amp;width=500&amp;height=400&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script>
                        </div>-->
                <iframe
                    width="600"
                    height="450"
                    frameborder="0" style="border:0"
                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCgaKViFluRzlg1BlKF8nTaqROPaHk4dqQ
    &q=Старый+Петровско-Разумовский+пр-д,+1%2F23с1,+Москва,+Россия,+127287" allowfullscreen>
                </iframe>



            </div>
        </div>
        <div><br></div>
    </div>
</div>

