<?php

namespace app\modules\menu\controllers\backend;

use app\modules\menu\models\MenuItem;
use app\modules\menu\models\MenuItemTranslation;
use Yii;
use app\modules\menu\models\Menu;
use yii\filters\VerbFilter;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $this->view->registerJsFile('/js/jquery-ui.min.js', ['depends' => 'yii\web\JqueryAsset']);
        $this->view->registerJsFile('/js/jquery.mjs.nestedSortable.js', ['depends' => 'yii\web\JqueryAsset']);

        $menus = Menu::find()
            ->orderBy('name')
            ->indexBy('id')
            ->all();

        $id = Yii::$app->request->get('menu_id', $menus ? reset($menus)->id : 0);
        $menu = isset($menus[$id]) ? $menus[$id] : new Menu;

        $menu_items = MenuItem::getHierarchical($menu->id);

        if ($menu->load(Yii::$app->request->post()) && $menu->save()) {
            $to_delete = array_diff(array_keys($menu_items), array_keys(Yii::$app->request->post('MenuItem', [])));

            if (!empty($to_delete)) {
                foreach ($to_delete as $delete_id) {
                    MenuItem::deleteItem($delete_id);
                }
            }

            $menu_items_ids = [];
            foreach (Yii::$app->request->post('MenuItem', []) as $menu_item_id => $menu_item_data) {
                $menu_item_data['menu_id'] = $menu->id;
                if ($menu_item_data['parent_id'] < 0) {
                    $menu_item_data['parent_id'] = $menu_items_ids[$menu_item_data['parent_id']];
                }

                if ($menu_item_id > 0) {
                    $menu_item = MenuItem::findOne($menu_item_id);
                } else {
                    $menu_item = new MenuItem;
                }

                if ($menu_item->load($menu_item_data, '') && $menu_item->save()) {
                    $menu_items_ids[$menu_item_id] = $menu_item->id;
                }
            }

            foreach (Yii::$app->request->post('MenuItemTranslation', []) as $menu_item_translation_id => $menu_item_translation_data) {
                $menu_item_translation_data['menu_item_id'] = $menu_items_ids[$menu_item_translation_data['menu_item_id']];

                if ($menu_item_translation_id > 0) {
                    $menu_item_translation = MenuItemTranslation::findOne($menu_item_translation_id);
                } else {
                    $menu_item_translation = new MenuItemTranslation;
                }

                $menu_item_translation->load($menu_item_translation_data, '');
                $menu_item_translation->save();
            }

            return $this->refresh();
        }

        $this->view->title = 'Меню – ' . Yii::$app->params['sitePrefix'];

        return $this->render('index', [
            'menus' => $menus,
            'menu' => $menu,
            'menu_items' => $menu_items,
        ]);
    }

    public function actionDelete($id)
    {
        $menu = Menu::findOne($id);

        if ($menu) {
            $menu_items = MenuItem::find()->where(['menu_id' => $menu->id])->all();
            foreach ($menu_items as $menu_item) {
                MenuItem::deleteItem($menu_item->id);
            }

            $menu->delete();
        }

        return $this->redirect(['/admin/menu/default/index']);
    }
}
