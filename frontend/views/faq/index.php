<?php
use frontend\modules\faq\api\Faq;
use frontend\modules\page\api\Page;

$page = Page::get('page-faq');

if(!empty($page)) $this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;
?>

<div class="container">
    <h1><?= $page->seo('h1', $page->title) ?></h1>
    <div><?= $page->seo('div', $page->text) ?></div>
</div>

<section class="faq-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">


                <ul class="faq">
                    <?php foreach(Faq::items() as $item) : ?>
                        <li class="q"><p><b><?=Yii::t('easyii', 'Question')?>: </b><?= $item->question ?></p></li>
                        <li class="a"><blockquote><b><?=Yii::t('easyii', 'Answer')?>: </b><?= $item->answer ?></blockquote></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>