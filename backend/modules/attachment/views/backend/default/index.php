<?php

/**
 * @var \yii\web\View $this
 * @var \app\modules\news\models\News|array $models
 * @var \app\modules\news\models\News $model
 * @var \yii\data\Pagination $pages
 */

use yii\helpers\Url;

\vova07\fileapi\Asset::register($this);

?>

<div class="items-list-page">

    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title">
                        Библиотека файлов
                        <a href="#" class="btn btn-primary btn-sm rounded-s b-upload__add">
                            добавить
                        </a>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <div id="dnd" class="b-upload b-upload_dnd">
        <div class="b-upload__form" style="display: none">
            <div class="b-upload__close fa fa-times"></div>

            <div class="b-upload__dnd">
                Перетащите файлы сюда
                <p>
                    <small>или</small>
                </p>
                <div class="btn btn-secondary js-fileapi-button">
                    <span>Выберите файлы</span>
                </div>
            </div>

            <div class="js-fileapi-wrapper b-upload__dnd-not-supported" style="display:none">
                <div class="btn btn-secondary js-fileapi-button">
                    <span>Выберите файлы</span>
                    <input type="file" name="filedata" multiple="">
                </div>
            </div>
        </div>

        <div class="b-upload__wrapper">

            <div id="js-files" class="js-files" style="display:none">
                <div class="js-file-tpl b-thumb" data-id="">
                    <div class="b-thumb__preview">
                        <div class="b-thumb__preview__pic"></div>
                    </div>
                </div>
            </div>

            <div class="b-upload__files">
                <?= $this->render('items', ['models' => $models]); ?>
            </div>

            <div class="load-more hidden">
                <i class="fa fa-refresh fa-spin"></i>
            </div>

        </div>

    </div>

    <?php ob_start(); ?>
    <script>
        $('.b-upload__add').on('click', function (e) {
            e.preventDefault();
            $('.b-upload__form').toggle();
        });
        $('.b-upload__close').on('click', function () {
            $('.b-upload__form').toggle();
        });

        $('.js-fileapi-button').on('click', function (e) {
            if (e.originalEvent) {
                $('input[type="file"]', '.js-fileapi-button').trigger('click');
            }
        });

        $('#dnd').fileapi({
            url: '<?= Url::to(['/admin/attachment/default/upload']) ?>',
            data: {
                '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken(); ?>'
            },
            accept: $('#modal-select-attachment').length ? 'image/*' : '*',
            paramName: 'file',
            autoUpload: true,
            multiple: true,
            elements: {
                list: '#js-files', //js-files
                file: {
                    tpl: '.js-file-tpl',
                    preview: {
                        //el: '.bbbvvv',
                        width: 200,
                        height: 200//,
                    }//,
                    //upload: { show: '.progress', hide: '.b-thumb__rotate' },
                    //complete: { hide: '.progress' },
                    //progress: '.progress .bar'
                },
                dnd: {
                    el: '.b-upload__dnd',
                    hover: 'b-upload__dnd_hover',
                    fallback: '.b-upload__dnd-not-supported'
                }
            },
            onBeforeUpload: function (evt, uiEvt){
                $(evt.widget.options.elements.list).show();
                $('.card.items').remove();
            },
            onFileComplete: function (evt, uiEvt) {
                if (uiEvt.result.type) {
                    uiEvt.file.$el.attr('data-id', uiEvt.result.id);

                    if (/image\/(jpe?g|png|bmp|gif|tiff?)/.test(uiEvt.result.type)) {
                        uiEvt.file.$el.find('.b-thumb__preview__pic').append('<div class="b-thumb__preview__centered"><img src="' + uiEvt.result.url + '"></div>');


                        $('.b-upload__files').prepend( uiEvt.file.$el );
                        $('#js-files').html('');

                        uiEvt.file.$el.find('.fa').remove();
                    } else {
                        uiEvt.file.$el.find('.fa').attr('class', 'fa fa-file fa-3x');
                    }

                }

            }//,
//            onComplete: function (evt, uiEvt){
//                console.log('asdsda');
//                //
//                //
//                //evt.widget.options.elements.list.remove();
//                //getModalSelectAttachment();
//            },
//            onUpload: function (evt, uiEvt){
//                    alert('sdasdaasd');
//            }
        });


        $(document).on('click', '.b-thumb__preview__pic', function (e) {
            var attachment_id = $(this).closest('.b-thumb').data('id');

            if ($('#modal-select-attachment').length) {
                if (!e.ctrlKey || !$('#attachment-select').data('gallery')) {
                    $('.b-thumb').removeClass('active');
                }
                $(this).closest('.b-thumb').addClass('active');
                $('#attachment-select').removeAttr('disabled');
            } else {
                $.get(
                    '<?= Url::to(['/admin/attachment/default/edit/']); ?>',
                    {
                        id: attachment_id
                    },
                    function (data) {
                        if (data.response) {
                            $('#modal-attachment').remove();
                            $('body').append(data.response);
                            $('#modal-attachment').modal('show');
                        }
                    }
                );
            }
        });

        $(document).on('click', '#attachment-save', function () {
            $.post(
                '<?= Url::to(['/admin/attachment/default/edit/']); ?>?id=' + $('input[type="hidden"]', '#modal-attachment').val(),
                $('input', '#modal-attachment'),
                function (data) {
                    if (data.success) {
                        $('#modal-attachment').modal('hide');
                    }
                }
            );
        });

        $(document).on('click', '#attachment-delete', function () {
            $.post(
                '<?= Url::to(['/admin/attachment/default/delete/']); ?>?id=' + $('input[type="hidden"]', '#modal-attachment').val(),
                function (data) {
                    if (data.success) {
                        $('#modal-attachment').modal('hide');
                    }
                }
            );
        });

        var load_more = false;
        $('.main-wrapper').on('scroll', function() {
            var scroll_bottom = $(this).get(0).scrollHeight - $(this).outerHeight(true) - $(this).scrollTop();
            if (scroll_bottom < 100 && !load_more) {
                load_more = true;
                $('.load-more').removeClass('hidden');
                $.get(
                    '<?= Url::to(['/admin/attachment/default/load-more/']); ?>?offset=' + $('.b-thumb').length,
                    function (data) {
                        data = $.trim(data);
                        if (data) {
                            $('.b-upload__files').append($.trim(data));
                            load_more = false;
                            $('.main-wrapper').trigger('scroll');
                        } else {
                            $('.main-wrapper').off('scroll');
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

    <?php if (empty($models)) { ?>
        <div class="card items">
            <ul class="item-list striped">
                <li class="item item-list-header hidden-sm-down">
                    <div class="item-row">
                        <div class="item-col item-col-header item-col-title">
                            <div> <span>Медиафайлы</span> </div>
                        </div>
                        <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
                    </div>
                </li>

                <li class="item">
                    <div class="item-row py-1">
                        <small><em>список файлов пуст...</em></small>
                    </div>
                </li>
            </ul>
        </div>
    <?php } ?>
</div>