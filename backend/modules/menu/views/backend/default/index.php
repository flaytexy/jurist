<?php

/**
 * @var \yii\web\View $this
 * @var \app\modules\menu\models\Menu|array $menus
 * @var \app\modules\menu\models\Menu $menu
 */

use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Language;
use yii\widgets\ActiveForm;
use app\modules\menu\Module;
use yii\helpers\ArrayHelper;

?>

<div class="items-list-page">

    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"><?= Module::t('module', 'MODULE_TITLE'); ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card menu-manage">
        <div class="card-block">
            <form action="<?= Url::to(['/admin/menu/default/index']); ?>">
                <?php if (count($menus) > 1 || $menu->isNewRecord) { ?>
                    Выберите меню для изменения:
                    <?=
                        Html::dropDownList(
                            'menu_id',
                            null,
                            ($menu->isNewRecord ? [0 => '— Выбрать —'] : []) + ArrayHelper::map($menus, 'id', 'name'),
                            ['options' => [Yii::$app->request->get('menu_id') => ['selected' => true]]]
                        );
                    ?>
                    <?= Html::submitInput('Выбрать', ['class' => 'btn btn-secondary']) ?>
                <?php } else { ?>
                    Отредактируйте меню ниже
                <?php } ?>
                или <?= Html::a('создайте новое меню', ['/admin/menu/default/index', 'menu_id' => 0]) ?>.
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <div class="card menu-manage">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title">Произвольные ссылки</p>
                    </div>
                </div>
                <div class="card-block">
                    <div class="form-group">
                        <div class="form-group">
                            <label class="control-label">URL</label>
                            <input type="text" id="permalink-url" class="form-control boxed">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label class="control-label">Текст ссылки</label>
                            <input type="text" id="permalink-text" class="form-control boxed">
                        </div>
                    </div>
                    <div class="pull-right">
                        <?= Html::button('Добавить в меню', ['id' => 'permalink-add', 'class' => 'btn btn-secondary']); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="card menu-manage">
                <?php $form = ActiveForm::begin(); ?>
                <div class="card-header">
                    <div class="header-block">
                        <em>Название меню</em>
                        <input type="text" name="<?= Html::getInputName($menu, 'name') ?>" value="<?= $menu->name; ?>">

                        <div class="pull-right">
                            <?= Html::submitInput($menu->isNewRecord ? 'Создать меню' : 'Сохранить меню', ['class' => 'btn btn-primary']) ?>
                        </div>

                        <p style="margin: 0;">
                            <small class="text-danger"><?= implode('<br>', $menu->getErrors('name')); ?></small>
                        </p>
                    </div>
                </div>

                <div class="card-block">
                    <?php if ($menu->isNewRecord) { ?>
                        <p>Введите название меню, затем нажмите «Создать меню».</p>
                    <?php } else { ?>
                        <h6>Структура меню</h6>
                        <p>
                            <small id="menu-description">
                                <?php if (!empty($menu_items)) { ?>
                                Расположите элементы в желаемом порядке путём перетаскивания. Можно также щёлкнуть на стрелку справа от элемента, чтобы открыть дополнительные настройки.
                                <?php } else { ?>
                                Добавьте элементы меню из столбца слева.
                                <?php } ?>
                            </small>
                        </p>
                    <?php } ?>
                    <div id="menu-items">
                        <?php if (!empty($menu_items)) { ?>
                        <ul class="menu-items-list">
                            <?php foreach ($menu_items as $menu_item) { ?>
                                <li class="item" id="menu-item-<?= $menu_item->id ?>">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="header-block">
                                                <p class="title"><?= $menu_item->translations[Language::getDefaultLanguage()['local']]->title ?></p>
                                                <div class="menu-items-control">
                                                    <small>Произвольная ссылка</small>
                                                    <i class="fa arrow card-toggle"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-collapse">
                                            <div class="card-tabs">
                                                <?php foreach (Language::getLanguages() as $language) { ?>
                                                    <div class="card-tab<?= $language['id'] == Language::getDefaultLanguage()['id'] ? ' active' : '' ?>" data-language="<?= $language['local']; ?>"><img src="/img/flags/<?= $language['local']; ?>.png" alt="<?= $language['title']; ?>" width="16" height="11"><?= $language['title']; ?></div>
                                                <?php } ?>
                                            </div>
                                            <div class="card-block">
                                                <?php foreach (Language::getLanguages() as $language) { ?>
                                                    <div class="language-row<?= $language['id'] != Language::getDefaultLanguage()['id'] ? ' hidden' : '' ?>" data-language="<?= $language['local']; ?>">
                                                        <div class="form-group">
                                                            <label class="control-label">URL</label>
                                                            <input type="text" name="MenuItemTranslation[<?= $menu_item->translations[$language['local']]->id ?>][link]" value="<?= $menu_item->translations[$language['local']]->link ?>" class="form-control boxed">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Текст ссылки</label>
                                                            <input type="text" name="MenuItemTranslation[<?= $menu_item->translations[$language['local']]->id ?>][title]" value="<?= $menu_item->translations[$language['local']]->title ?>" class="form-control boxed">
                                                        </div>
                                                        <input type="hidden" name="MenuItemTranslation[<?= $menu_item->translations[$language['local']]->id ?>][menu_item_id]" value="<?= $menu_item->translations[$language['local']]->menu_item_id ?>">
                                                        <input type="hidden" name="MenuItemTranslation[<?= $menu_item->translations[$language['local']]->id ?>][language]" value="<?= $menu_item->translations[$language['local']]->language ?>">
                                                    </div>
                                                <?php } ?>
                                                <input type="hidden" name="MenuItem[<?= $menu_item->id ?>][parent_id]" value="<?= $menu_item->parent_id ?>">
                                                <input type="hidden" name="MenuItem[<?= $menu_item->id ?>][order_num]" value="<?= $menu_item->order_num ?>">
                                                <a class="card-remove" href="#">Удалить</a> | <a class="card-close" href="#">Отмена</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($menu_item->children) { ?>
                                        <ul>
                                            <?php foreach ($menu_item->children as $sub_menu_item) { ?>
                                                <li class="item" id="menu-item-<?= $sub_menu_item->id ?>">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="header-block">
                                                                <p class="title"><?= $sub_menu_item->translations[Language::getDefaultLanguage()['local']]->title ?></p>
                                                                <div class="menu-items-control">
                                                                    <small>Произвольная ссылка</small>
                                                                    <i class="fa arrow card-toggle"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-collapse">
                                                            <div class="card-tabs">
                                                                <?php foreach (Language::getLanguages() as $language) { ?>
                                                                    <div class="card-tab<?= $language['id'] == Language::getDefaultLanguage()['id'] ? ' active' : '' ?>" data-language="<?= $language['local']; ?>"><img src="/img/flags/<?= $language['local']; ?>.png" alt="<?= $language['title']; ?>" width="16" height="11"><?= $language['title']; ?></div>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="card-block">
                                                                <?php foreach (Language::getLanguages() as $language) { ?>
                                                                    <div class="language-row<?= $language['id'] != Language::getDefaultLanguage()['id'] ? ' hidden' : '' ?>" data-language="<?= $language['local']; ?>">
                                                                        <div class="form-group">
                                                                            <label class="control-label">URL</label>
                                                                            <input type="text" name="MenuItemTranslation[<?= $sub_menu_item->translations[$language['local']]->id ?>][link]" value="<?= $sub_menu_item->translations[$language['local']]->link ?>" class="form-control boxed">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="control-label">Текст ссылки</label>
                                                                            <input type="text" name="MenuItemTranslation[<?= $sub_menu_item->translations[$language['local']]->id ?>][title]" value="<?= $sub_menu_item->translations[$language['local']]->title ?>" class="form-control boxed">
                                                                        </div>
                                                                        <input type="hidden" name="MenuItemTranslation[<?= $sub_menu_item->translations[$language['local']]->id ?>][menu_item_id]" value="<?= $sub_menu_item->translations[$language['local']]->menu_item_id ?>">
                                                                        <input type="hidden" name="MenuItemTranslation[<?= $sub_menu_item->translations[$language['local']]->id ?>][language]" value="<?= $sub_menu_item->translations[$language['local']]->language ?>">
                                                                    </div>
                                                                <?php } ?>
                                                                <input type="hidden" name="MenuItem[<?= $sub_menu_item->id ?>][parent_id]" value="<?= $sub_menu_item->parent_id ?>">
                                                                <input type="hidden" name="MenuItem[<?= $sub_menu_item->id ?>][order_num]" value="<?= $sub_menu_item->order_num ?>">
                                                                <a class="card-remove" href="#">Удалить</a> | <a class="card-close" href="#">Отмена</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </div>
                </div>

                <div class="card-footer">
                    <?= $menu->isNewRecord ? '' : Html::a('Удалить меню', ['/admin/menu/default/delete', 'id' => $menu->id], ['data' => ['method' => 'post']]) ?>
                    <div class="pull-right">
                        <?= Html::submitInput($menu->isNewRecord ? 'Создать меню' : 'Сохранить меню', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<div id="menu-item-template" class="hidden">
    <li class="item created">
        <div class="card">
            <div class="card-header">
                <div class="header-block">
                    <p class="title"></p>
                    <div class="menu-items-control">
                        <small></small>
                        <i class="fa arrow card-toggle"></i>
                    </div>
                </div>
            </div>
            <div class="card-collapse">
                <div class="card-tabs">
                    <?php foreach (Language::getLanguages() as $language) { ?>
                        <div class="card-tab<?= $language['id'] == Language::getDefaultLanguage()['id'] ? ' active' : '' ?>" data-language="<?= $language['local']; ?>"><img src="/img/flags/<?= $language['local']; ?>.png" alt="<?= $language['title']; ?>" width="16" height="11"><?= $language['title']; ?></div>
                    <?php } ?>
                </div>
                <div class="card-block">
                    <?php foreach (Language::getLanguages() as $language) { ?>
                    <div class="language-row<?= $language['id'] != Language::getDefaultLanguage()['id'] ? ' hidden' : '' ?>" data-language="<?= $language['local']; ?>">
                        <div class="form-group">
                            <label class="control-label">URL</label>
                            <input type="text" name="MenuItemTranslation[-0][link]" class="form-control boxed">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Текст ссылки</label>
                            <input type="text" name="MenuItemTranslation[-0][title]" class="form-control boxed">
                        </div>
                        <input type="hidden" name="MenuItemTranslation[-0][menu_item_id]" value="-0">
                        <input type="hidden" name="MenuItemTranslation[-0][language]" value="<?= $language['local']; ?>">
                    </div>
                    <?php } ?>
                    <input type="hidden" name="MenuItem[-0][parent_id]" value="0">
                    <input type="hidden" name="MenuItem[-0][order_num]" value="0">
                    <a class="card-remove" href="#">Удалить</a> | <a class="card-close" href="#">Отмена</a>
                </div>
            </div>
        </div>
    </li>
</div>

<?php ob_start(); ?>
    <script>
        $(document).on('click', '.card-toggle', function () {
            $(this).toggleClass('opened').closest('.item').find('.card-collapse:first').stop().slideToggle();
        });
        $(document).on('click', '.card-close', function (e) {
            $(this)
                .closest('.item')
                .find('.card-toggle:first')
                .toggleClass('opened')
                .closest('.item')
                .find('.card-collapse:first')
                .stop()
                .slideUp();

            e.preventDefault();
        });
        $(document).on('click', '.card-remove', function (e) {
            $(this)
                .closest('.item')
                .remove();

            if (!$('.menu-items-list .item', '#menu-items').length) {
                $('.menu-items-list').remove();
                $('#menu-description').text('Добавьте элементы меню из столбца слева.');
            }

            e.preventDefault();
        });

        $(document).on('click', '.card-tab', function () {
            $(this).closest('.item').find('.card-tabs:first .card-tab').removeClass('active');
            $(this).addClass('active');

            $(this).closest('.item').find('.card-block:first .language-row').addClass('hidden');
            $(this).closest('.item').find('.card-block:first .language-row[data-language="' + $(this).data('language') + '"]').removeClass('hidden');
        });

        $(document).on('click', '#permalink-add', function () {
            if (!$('.menu-items-list', '#menu-items').length) {
                $('#menu-items').append('<ul class="menu-items-list" />');
                $('#menu-description').text('Расположите элементы в желаемом порядке путём перетаскивания. Можно также щёлкнуть на стрелку справа от элемента, чтобы открыть дополнительные настройки.');
            }

            var $item = $($('#menu-item-template').html()),
                permalink_url = $('#permalink-url'),
                permalink_text = $('#permalink-text');

            $item.find('.title').html(permalink_text.val() || '<em>текст ссылки</em>');
            $item.find('.language-row:not(.hidden) input[name$="[link]"]').val(permalink_url.val());
            $item.find('.language-row:not(.hidden) input[name$="[title]"]').val(permalink_text.val());
            $item.find('.menu-items-control small').html('Произвольная ссылка');

            $('.menu-items-list').append($item);

            permalink_url.val('');
            permalink_text.val('');

            reindex();
            card_sortable();
        });

        function reindex() {
            var stored_MenuItemTranslationIndex = 0;
            $('.item.created', '.menu-items-list').each(function (MenuItemIndex) {
                var _MenuItemIndex = MenuItemIndex + 1;
                $(this).attr('id', 'menu-item-0' + _MenuItemIndex);
                $('.card-block:first input[name^="MenuItem["]', this).each(function () {
                    $(this).attr('name', $(this).attr('name').replace(/-\d+/, '-' + _MenuItemIndex));
                });

                $('.card-block:first .language-row', this).each(function () {
                    $('input[name^="MenuItemTranslation["]', this).each(function () {
                        $(this).attr('name', $(this).attr('name').replace(/-\d+/, '-' + stored_MenuItemTranslationIndex));
                    });
                    $('input[name="MenuItemTranslation[-' + stored_MenuItemTranslationIndex + '][menu_item_id]"]', this).val('-' + _MenuItemIndex);

                    stored_MenuItemTranslationIndex++;
                });
            });
        }

        function card_sortable() {
            $('.menu-items-list')
                .nestedSortable({
                    listType: 'ul',
                    handle: '.card-header',
                    items: 'li.item',
                    toleranceElement: '> div.card',
                    maxLevels: 2,
                    isTree: true,
                    startCollapsed: false,
                    relocate: function(e) {
                        var sort = $('.menu-items-list').nestedSortable('toArray');
                        for (var i in sort) {
                            if (sort.hasOwnProperty(i) && sort[i].id) {
                                var id = sort[i].id.charAt(0) === '0' ? '-' + sort[i].id.slice(1) : sort[i].id,
                                    parent_id = sort[i].parent_id ? (sort[i].parent_id.charAt(0) === '0' ? '-' + sort[i].parent_id.slice(1) : sort[i].parent_id) : 0;
                                $('input[name="MenuItem[' + id + '][order_num]"]').val(i);
                                $('input[name="MenuItem[' + id + '][parent_id]"]').val(parent_id);
                            }
                        }
                    }
                })
                .nestedSortable('relocate');
        }
        card_sortable();
    </script>
<?php $script = str_replace(['<script>', '</script>'], '', ob_get_contents()); ?>
<?php ob_end_clean(); ?>

<?php $this->registerJs($script); ?>