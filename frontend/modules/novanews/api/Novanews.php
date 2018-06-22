<?php

namespace frontend\modules\novanews\api;


use frontend\modules\novanews\models\NovanewsTranslation;
use Yii;
use yii\data\ActiveDataProvider;
use frontend\models\Tag;
use frontend\widgets\Fancybox;
use yii\widgets\LinkPager;
use frontend\modules\novanews\models\Novanews as NovanewsModel;

/**
 * Page module API
 * @package frontend\modules\novanews\api
 *
 * @property ActiveDataProvider $_adp
 * @method static NovanewsObject get(mixed $id_slug) Get page object by id or slug
 * @method static array items(array $options = []) Get list of page as NovanewsObject objects
 * @method static mixed last(int $limit = 1) Get last page
 * @method static void plugin() Applies FancyBox widget on photos called by box() function
 * @method static string pages() returns pagination html generated by yii\widgets\LinkPager widget.
 * @method static \stdClass pagination() returns yii\data\Pagination object.
 */
class Novanews extends \common\components\API
{
    private $_adp;
    private $_last;
    private $_items;
    private $_item = [];

    public function api_items($options = [])
    {
        $this->_items = [];

        $with[] = 'seo';
        if (Yii::$app->getModule('admin')->activeModules['page']->settings['enableTags']) {
            $with[] = 'tags';
        }
        $query = NovanewsModel::find()
            ->joinWith('translation')
            ->with($with)
            ->andWhere([NovanewsTranslation::tableName() . '.public_status' => NovanewsTranslation::STATUS_ON])
            ->status(NovanewsModel::STATUS_ON);


        if (!empty($options['where'])) {
            $query->andFilterWhere($options['where']);
        }

        if (!empty($options['tags'])) {
            $query
                ->innerJoinWith('tags', false)
                ->andWhere([Tag::tableName() . '.name' => (new NovanewsModel)->filterTagValues($options['tags'])])
                ->addGroupBy('id');
        }

        if (!empty($options['orderBy'])) {
            $query->orderBy($options['orderBy']);
        } else {
            $query->sortDate();
        }

        $this->_adp = new ActiveDataProvider([
            'query' => $query,
            'pagination' => !empty($options['pagination']) ? $options['pagination'] : []
        ]);

        /**
         * @var \frontend\modules\novanews\models\Novanews  $model
         */
        foreach ($this->_adp->models as $model) {
            $oneItem = new NovanewsObject($model);
            $this->_items[] = $oneItem;
        }

        return $this->_items;
    }

    public function api_get($id_slug)
    {
        if (!isset($this->_item[$id_slug])) {
            $this->_item[$id_slug] = $this->findPage($id_slug);
        }
        return $this->_item[$id_slug];
    }

    public function api_last($limit = 1)
    {
        if ($limit === 1 && $this->_last) {
            return $this->_last;
        }

        $with = ['seo'];
        if (Yii::$app->getModule('admin')->activeModules['page']->settings['enableTags']) {
            $with[] = 'tags';
        }

        $result = [];
        foreach (NovanewsModel::find()->with($with)->status(NovanewsModel::STATUS_ON)->sortDate()->limit($limit)->all() as $item) {
            $result[] = new NovanewsObject($item);
        }

        if ($limit > 1) {
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

        if ($this->_adp) {
            return LinkPager::widget(['pagination' => $this->_adp->pagination]);
        }
        return '';
    }

    private function findPage($id_slug)
    {
        $page = NovanewsModel::find()
            ->joinWith('translation')
            ->where(['or', NovanewsModel::tableName().'.id=:id_slug', NovanewsModel::tableName().'.slug=:id_slug'], [':id_slug' => $id_slug])
            ->status(NovanewsModel::STATUS_ON)
            ->one();

        if(!$page){

            $errorMessage = 'Страница без перевода!!!: '. $id_slug .'  .#36561';

            if (!$this->mailApi($errorMessage)) {
                //header("HTTP/1.0 404 Not Found");
                //header("Location: " . Url::to(['/404/error/mailsend'], true));
                //exit;s
            }

            $page = NovanewsModel::find()
                //->joinWith('translation')
                ->where(['or', NovanewsModel::tableName().'.id=:id_slug', NovanewsModel::tableName().'.slug=:id_slug'], [':id_slug' => $id_slug])
                ->status(NovanewsModel::STATUS_ON)
                ->one();
        }

        if ($page) {
            $page->updateCounters(['views' => 1]);
            $page = new NovanewsObject($page);

            return $page;
        } else {
            return false;
        }
    }

    private function notFound($id_slug)
    {
        $page = new NovanewsModel([
            'slug' => $id_slug
        ]);
        return new NovanewsObject($page);
    }


}