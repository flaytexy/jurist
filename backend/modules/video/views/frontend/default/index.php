<?php
/**
 * @var \yii\web\View $this
 * @var \backend\modules\video\models\Video|array $models
 * @var \backend\modules\video\models\Video $model
 * @var \yii\data\Pagination $pages
 */

use yii\helpers\Url;

?>

<section class="video">
    <div class="video__title">
        <p><?= Yii::t('app', 'Video') ?></p>
    </div>

    <div class="video__items add-ajax-content">
        <?php echo $this->render('items',['models' => $models]); ?>
    </div>

    <?php $offers_links = $pages->getLinks(); ?>
    <?php if (isset($offers_links['next'])) { ?>
        <div class="load-more hidden">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
    <?php } ?>

    <?php ob_start(); ?>
    <script>
        var selector = ".add-ajax-content";
        var pageSize = "<?=$pages->pageSize?>";
        var countShowElements = "<?=$pages->pageSize?>";
        var load_more = false;
        $(window).on('scroll', function () {
            var scroll_bottom = $(document).height() - $(this).outerHeight(true) - $(this).scrollTop();
            if (scroll_bottom < 40 && !load_more) {
                load_more = true;
                $('.load-more').removeClass('hidden');
                $.get(
                    '<?= Url::to(['/video/default/load-more/']); ?>?offset=' + countShowElements,
                    function (data) {
                        countShowElements = parseInt(countShowElements) + parseInt(pageSize);

                        data = $.trim(data);
                        if (data) {
                            $(selector).append($.trim(data));
                            load_more = false;
                            $('body').trigger('scroll');
                        } else {
                            $('body').off('scroll');
                        }
                        $('.load-more').addClass('hidden');
                    }
                );
            }
        });

        $("[data-fancybox]").fancybox({
            youtube : {
                controls : 0,
                showinfo : 0,
                autoplay : true
            }
        });

        //$("a.video__items__item").fancybox();
    </script>
    <?php $script = str_replace(['<script>', '</script>'], '', ob_get_contents()); ?>
    <?php ob_end_clean(); ?>

    <?php $this->registerJs($script); ?>

</section>