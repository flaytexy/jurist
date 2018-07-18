<?php

/**
 * @var \yii\web\View $this
 * @var \app\modules\page\models\page $model
 * @var \app\modules\page\models\page $next
 */

use yii\helpers\Url;
use app\modules\attachment\models\Attachment;

?>

<section class="about">
    <div class="overlay"></div>
    <div class="about__left">
        <div class="about__left__title">
          <p><?= $model['translation']['title'] ?></p>
        </div>
        <div class="about__left__info">
            <?= $model['translation']['description'] ?>
        </div>
        <div class="about__left__social">
            <p>follow alexei</p>
            <div class="about__left__social__links">
                <a class="social_icons" href="<?=Yii::$app->settings->get('twitter')?>"></a>
                <a class="social_icons" href="<?=Yii::$app->settings->get('facebook')?>"></a>
                <a class="social_icons" href="<?=Yii::$app->settings->get('telegram')?>"></a>
            </div>
            <div class="about__left__social__lines"><img src="/img/about/lines.png"/></div>
        </div>
    </div>
    <div class="about_wrapper">
        <div class="about__right"><img src="/img/about/back.jpg"/></div>
    </div>
    <?php if(isset($model['translation']['short_description'])): ?>
    <div class="about__quote">
        <?= $model['translation']['short_description'] ?>
        <div class="about__quote__twits"><img src="/img/about/twit_quote.png"/><img src="/img/about/total_twits_img.png"/></div>
    </div>
    <?php endif; ?>
</section>




<?php ob_start(); ?>
    <script>
        (function () {
            var node = $("div.about__left__title p").contents().filter(function () { return this.nodeType == 3 }).first(),
                text = node.text(),
                first = text.slice(0, text.indexOf(" "));

            if (!node.length)
                return;

            anotherText = text.slice(first.length);

            $("div.about__left__title p").html('' + first + '<br/><span>'+ anotherText + '</span>');
        })();
    </script>
<?php $script = str_replace(['<script>', '</script>'], '', ob_get_contents()); ?>
<?php ob_end_clean(); ?>

<?php $this->registerJs($script); ?>

