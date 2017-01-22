<?php
namespace frontend\modules\page\api;

use Yii;
use yii\data\ActiveDataProvider;
use frontend\models\Tag;
use frontend\widgets\Fancybox;
use yii\widgets\LinkPager;

use frontend\modules\page\models\Page as PageModel;
use yii\helpers\Html;

/**
 * Page module API
 * @package frontend\modules\page\api
 *
 * @property ActiveDataProvider $_adp
 * @method static PageObject get(mixed $id_slug) Get page object by id or slug
 * @method static array items(array $options = []) Get list of page as PageObject objects
 * @method static mixed last(int $limit = 1) Get last page
 * @method static void plugin() Applies FancyBox widget on photos called by box() function
 * @method static string pages() returns pagination html generated by yii\widgets\LinkPager widget.
 * @method static \stdClass pagination() returns yii\data\Pagination object.
 */
class Page extends \frontend\components\API
{
    private $_adp;
    private $_last;
    private $_items;
    private $_item = [];

    public function api_items($options = [])
    {
        //if(!$this->_items){
            $this->_items = [];

            $with = ['seo'];
            if(Yii::$app->getModule('admin')->activeModules['page']->settings['enableTags']){
                $with[] = 'tags';
            }
            $query = PageModel::find()->with($with)->status(PageModel::STATUS_ON);

            if(!empty($options['where'])){
                $query->andFilterWhere($options['where']);
            }

            if(!empty($options['tags'])){
                $query
                    ->innerJoinWith('tags', false)
                    ->andWhere([Tag::tableName() . '.name' => (new PageModel)->filterTagValues($options['tags'])])
                    ->addGroupBy('page_id');
            }

            if(!empty($options['orderBy'])){
                $query->orderBy($options['orderBy']);
            } else {
                $query->sortDate();
            }

            $this->_adp = new ActiveDataProvider([
                'query' => $query,
                'pagination' => !empty($options['pagination']) ? $options['pagination'] : []
            ]);

            foreach($this->_adp->models as $model){
                $this->_items[] = new PageObject($model);
            }
        //}
        return $this->_items;
    }

    public function api_get($id_slug)
    {
        if(!isset($this->_item[$id_slug])) {
            $this->_item[$id_slug] = $this->findPage($id_slug);
        }
        return $this->_item[$id_slug];
    }

    public function api_last($limit = 1)
    {
        if($limit === 1 && $this->_last){
            return $this->_last;
        }

        $with = ['seo'];
        if(Yii::$app->getModule('admin')->activeModules['page']->settings['enableTags']){
            $with[] = 'tags';
        }

        $result = [];
        foreach(PageModel::find()->with($with)->status(PageModel::STATUS_ON)->sortDate()->limit($limit)->all() as $item){
            $result[] = new PageObject($item);
        }

        if($limit > 1){
            return $result;
        } else {
            $this->_last = count($result) ? $result[0] : null;
            return $this->_last;
        }
    }

    public function api_plugin($options = [])
    {
        Fancybox::widget([
            'selector' => '.easyii-box',
            'options' => $options
        ]);
    }

    public function api_pagination()
    {
        return $this->_adp ? $this->_adp->pagination : null;
    }

    public function api_pages()
    {
        $this->_adp->pagination->pageSizeParam = false;

        if($this->_adp){
            return LinkPager::widget(['pagination' => $this->_adp->pagination]);
        }
        return '';
    }

    private function findPage($id_slug)
    {
        $page = PageModel::find()->where(['or', 'page_id=:id_slug', 'slug=:id_slug'], [':id_slug' => $id_slug])->status(PageModel::STATUS_ON)->one();
        if($page) {
            $page->updateCounters(['views' => 1]);
            return new PageObject($page);
        } else {
            return null;
        }
    }

    private function notFound($id_slug)
    {
        $page = new PageModel([
            'slug' => $id_slug
        ]);
        return new PageObject($page);
    }
}