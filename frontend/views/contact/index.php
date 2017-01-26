<?php
use frontend\modules\feedback\api\Feedback;
use frontend\modules\page\api\Page;

$page = Page::get('page-contact');

if(!empty($page)) $this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;
?>

<div class="container">
    <h1><?= $page->seo('h1', $page->title) ?></h1>
</div>


<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?= $page->text ?>
        </div>
        <div class="col-md-4">
            <?php if(Yii::$app->request->get(Feedback::SENT_VAR)) : ?>
                <h4 class="text-success"><i class="glyphicon glyphicon-ok"></i> Message successfully sent</h4>
            <?php else : ?>
                <div class="well well-sm">
                    <?= Feedback::form() ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

