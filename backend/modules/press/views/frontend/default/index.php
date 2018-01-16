<?php
/**
 * @var \yii\web\View $this
 * @var \app\modules\video\models\Video|array $models
 * @var \app\modules\video\models\Video $model
 * @var \yii\data\Pagination $pages
 */

use app\modules\attachment\models\Attachment;
use yii\helpers\Url;

?>
<section class="news gl-section">
    <div class="news__title">
        <p><?= Yii::t('app', 'press') ?></p>
    </div>

    <div class="grid add-ajax-content" id="grid">
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

        function loadImages(data){
            $(data).find('img').each(function( index, val ) {
                console.log( index + ": " + $( this ).attr('src') );
               //alert( index + ": " + $( this ).attr('src') );

                var image = $('<img />').attr('src', $( this ).attr('src'));
            });
        }

        var $masonry_bricks = $('#grid');
        var $grid = $masonry_bricks.masonry({});
        $grid.on( 'layoutComplete', function( laidOutItems ) {
            if (!$masonry_bricks.hasClass('loaded')) {
                //var $images = $('#grid img:not(.loaded)'),
                var $images = $('#grid .grid-item img'),
                    images_count = $images.length,
                    images_loaded = 0;

                $images.each(function(index) {
                    console.log('index: ' + index);
                    //alert(index);
                    var i = new Image();

                    i.onload = function () {
                        images_loaded++;
                        if(images_loaded == images_count) {
                            var msnry = new Masonry( '#grid', {});
                            msnry.layout();
                            //$grid.masonry('layout');
                            $masonry_bricks.addClass('loaded');
                        }
                    };

                    i.src = $(this).attr('src');
                });
            }
            console.log( 'Masonry layout complete with ' + laidOutItems.length + ' items' );
        });


        $(window).on('scroll', function () {
            var scroll_bottom = $(document).height() - $(this).outerHeight(true) - $(this).scrollTop();
            if (scroll_bottom < 40 && !load_more) {
                load_more = true;
                $('.load-more').removeClass('hidden');
                $.get(
                    '<?= Url::to(['/press/default/load-more/']); ?>?offset=' + countShowElements,
                    function (data) {
                        countShowElements = parseInt(countShowElements) + parseInt(pageSize);
                        data = $.trim(data);
                        if (data) {
                            //loadImages(data);
                            console.log('scroll!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!');
                            $('#grid').removeClass('loaded');

                            $(selector).append(data);
                            //$grid.masonry('layout');
                            var msnry = new Masonry( '#grid', {});
                            msnry.layout();

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
    </script>
    <?php $script = str_replace(['<script>', '</script>'], '', ob_get_contents()); ?>
    <?php ob_end_clean(); ?>

    <?php $this->registerJs($script); ?>

</section>