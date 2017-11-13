<?php
use frontend\modules\offers\api\Offers;
use yii\helpers\Url;

$this->title = $offers->seo('title', $offers->model->title);
$this->params['breadcrumbs'][] = ['label' => 'Offers', 'url' => ['offers/index']];
$this->params['breadcrumbs'][] = $offers->model->title;
?>
<h1><?= $offers->seo('h1', $offers->title) ?></h1>

<?= $offers->text ?>

<?php if(count($offers->photos)) : ?>
    <div>
        <h4>Photos</h4>
        <?php foreach($offers->photos as $photo) : ?>
            <?= $photo->box(100, 100) ?>
        <?php endforeach;?>
        <?php Offers::plugin() ?>
    </div>
    <br/>
<?php endif; ?>
<p>
    <?php foreach($offers->tags as $tag) : ?>
        <a href="<?= Url::to(['/offers', 'tag' => $tag]) ?>" class="label label-info"><?= $tag ?></a>
    <?php endforeach; ?>
</p>

<div class="small-muted">Views: <?= $offers->views?></div>