<?php
use backend\modules\attachment\models\Attachment;
use yii\helpers\Url;
/**
 * @var \backend\modules\attachment\models\Attachment|array $models
 * @var \backend\modules\attachment\models\Attachment $model
 */

?>

<?php foreach ($models as $index => $model) { ?>
    <a class="grid-item wow fadeInUp" href="<?= Url::to(['/album/default/view', 'id' => $model['id']]); ?>">
        <img src="<?= Attachment::getImage($model['thumbnail']) ?>" srcset="<?= Attachment::getImage($model['thumbnail']) ?> 2x"/>
        <div class="grid-item__title">
            <p><?= $model['translation']['title']; ?></p>
        </div>
        <div class="grid-item__read_more">
            <p>read more <div class="grid-item__read_more__line"></div></p>
        </div>
    </a>
<?php } ?>