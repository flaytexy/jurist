<?php
namespace backend\modules\seo\components;

use Yii;
use yii\base\Object;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\View;

class Seo extends Object
{
    protected $_page;

    public $actions = [];
    protected $meta = [
        'keywords' => 'Meta Keywords',
        'description' => 'Meta Description',
    ];
    protected $seoBlock = [];
    protected $metaBlock = [];

    protected $block = [
        'title' => 'Page Title',
        'h1' => 'H1',
        'text' => 'SEO text',
    ];

    protected $initialized = false;

    public function init()
    {
        Yii::$app->on(Controller::EVENT_AFTER_ACTION, [$this, '_meta_init']);
    }

    public function initialize()
    {
//        Yii::$app->on(Controller::EVENT_AFTER_ACTION, [$this, '_meta_init']);
//        Yii::$app->view->on(View::EVENT_AFTER_RENDER, [$this, '_meta_page']);
//        Yii::$app->view->on(View::EVENT_END_BODY, [$this, '_link']);
        $this->_meta_page();
        $this->_link();
    }

    public function _link()
    {
        if (Yii::$app->controller->module->module->id !== 'admin' && Yii::$app->controller->module->id !== 'admin') {
            Yii::$app->view->on(View::EVENT_END_BODY, function () {
                echo Html::tag(
                    'div',
                    Html::a(
                        'SEO - ' . (!is_null($this->_page) ? 'Edit' : 'Add'),
                        (!is_null($this->_page) ? Url::to(['/admin/seo/default/edit', 'id' => $this->_page['id']]) : Url::to(['', 'seo_add' => true] + Yii::$app->request->queryParams)),
                        ['style' => 'padding:10px 20px;display:inline-block;background-color:#fdb713;color:#333']
                    ),
                    ['style' => 'font-size:14px;z-index:9999;position:fixed;bottom:0;right:0;']
                );
            });
        }
    }

    public function _meta_page()
    {
        if (!$this->initialized) {
            $this->initialized = true;
            $where['view'] = $this->_view();
            $where['action_params'] = $this->_action_params();

            $this->_page = \backend\modules\seo\models\Seo::find()
                ->where($where)
                ->limit(1)
                ->asArray()
                ->one();

            if (!is_null($this->_page) && ($where['view']) && Yii::$app->controller->module->id !== 'admin' && Yii::$app->controller->module->module->id !== 'admin') {
                $this->_page['meta'] = [
                    'title' => $this->_page['title'],
                    'keywords' => $this->_page['keywords'],
                    'description' => $this->_page['description'],
                    'h1' => $this->_page['h1'],
                    'text' => $this->_page['text'],
                ];
                $this->renderMeta();
            }
        }
    }

    public function _meta_init()
    {
        if (
            Yii::$app->request->get('seo_add') &&
            Yii::$app->controller->module->module->id !== 'admin' &&
            Yii::$app->controller->module->id !== 'admin'
        ) {
            $page = new \backend\modules\seo\models\Seo;
            $page->view = $this->_view();
            $page->action_params = $this->_action_params();
            $page->save();
            $this->_page = $page;

            Yii::$app->response->redirect(['/admin/seo/default/edit', 'id' => $this->_page['id']]);
        }
    }

    protected function renderMeta()
    {
        $p = [
            '{page_name}' => Yii::$app->view->title,
        ];

        $iteration = 0;
        $max_iteration = 1000;

        do {
            $need_replace = [];

            foreach($this->_page['meta'] as $meta_name => $meta_content) {
                $p['{' . $meta_name . '}'] = strtr(str_replace('{' . $meta_name . '}' , '', $meta_content), $p);

                if (preg_match('~{title|h1|page_name}~', $p['{' . $meta_name . '}'])) {
                    $need_replace[] = $p;
                }
            }

            $iteration++;
            $max_iteration--;
        } while (!empty($need_replace) && $max_iteration);

        foreach($this->_page['meta'] as $meta_name => $meta_content) {
            if (preg_match('~{title|h1|page_name}~', $meta_content)) {
                $meta_content = strtr(str_replace('{' . $meta_name . '}' , '', $meta_content), $p);
            }

            if (isset($this->meta[$meta_name])) {
                Yii::$app->view->registerMetaTag([
                    'name' => $meta_name,
                    'content' => $meta_content
                ], $meta_name);
                $this->metaBlock[$meta_name] = $meta_content;
            } else if (isset($this->block[$meta_name])) {
                $this->seoBlock[$meta_name] = $meta_content;
            }
        }
    }

    protected function _view()
    {
        $view = Yii::$app->controller->route;
        if (strpos($view, 'debug') !== false || strpos($view, 'error') !== false) {
            return false;
        }
        return $view;
    }

    protected function _action_params()
    {
        $action_params = Yii::$app->request->queryParams;
        if ($this->_view() && isset($this->actions[$this->_view()])) {
            $action_param = $this->actions[$this->_view()];
            foreach($action_params as $key => $value) {
                if (is_null($value) || $value == '' || !ArrayHelper::isIn($key, $action_param)) {
                    unset($action_params[$key]);
                }
            }
        }
        unset($action_params['seo_add']);
        $action_params = array_filter($action_params);
        $action_params = \common\components\ArrayHelper::strval($action_params);
        $action_params = Json::encode($action_params);
        return $action_params;
    }

    public function block($name)
    {
        if ($this->initialized === false) {
            $this->initialize();
        }

        if (ArrayHelper::keyExists($name, $this->seoBlock)) {
            return $this->seoBlock[$name];
        }
        return null;
    }

    public function meta($name)
    {
        if ($this->initialized === false) {
            $this->initialize();
        }

        if (ArrayHelper::keyExists($name, $this->metaBlock)) {
            return $this->metaBlock[$name];
        }
        return null;
    }
}