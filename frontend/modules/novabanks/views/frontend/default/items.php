<?php
use common\modules\attachment\models\Attachment;
use yii\helpers\Url;
/**
 * @var \common\modules\attachment\models\Attachment|array $models
 * @var \common\modules\attachment\models\Attachment $model
 */

?>

<?php foreach ($models as $index => $model) { ?>
    <a class="grid-item wow fadeInUp" href="<?= Url::to(['/novabanks/default/view', 'id' => $model['id']]); ?>">
        <div class="grid-item__date">
            <p><?= Yii::$app->formatter->asDate($model['publish_date'], 'php:d/m/Y'); ?></p>
        </div>
        <img src="<?= Attachment::getImage($model['thumbnail']) ?>" srcset="<?= Attachment::getImage($model['thumbnail']) ?> 2x"/>
        <div class="grid-item__title">
            <p><?= $model['translation']['title']; ?></p>
        </div>
        <div class="grid-item__read_more">
            <p>read more <div class="grid-item__read_more__line"></div></p>
        </div>
    </a>
<?php } ?>