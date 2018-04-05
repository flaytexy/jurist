<?php

namespace frontend\modules\slidemain\api;

use frontend\models\Option;
use Yii;
use yii\data\ActiveDataProvider;
use frontend\models\Tag;
use frontend\widgets\Fancybox;
use yii\db\Query;
use yii\widgets\LinkPager;

use frontend\modules\slidemain\models\Slidemain as SlidemainModel;

/**
 * Slidemain module API
 * @package frontend\modules\slidemain\api
 *
 * @property \frontend\modules\slidemain\models\Slidemain $model
 *
 * @method static SlidemainObject get(mixed $id_slug) Get slidemain object by id or slug
 * @method static array items(array $options = []) Get list of slidemain as SlidemainObject objects
 * @method static mixed clear() Clear all items
 * @method static mixed last(int $limit = 1) Get last slidemain
 * @method static void plugin() Applies FancyBox widget on photos called by box() function
 * @method static string pages() returns pagination html generated by yii\widgets\LinkPager widget.
 * @method static \stdClass pagination() returns yii\data\Pagination object.
 */
class Slidemain extends \frontend\components\API
{
    private $_adp;
    private $_last;
    private $_items;
    private $_item = [];
    private $_default_model = 'SlidemainModel';

    public function api_items($options = [])
    {
        //e_print('api_items_start');

        $key = md5(serialize($options)).'44552fds';
        $cache = Yii::$app->cache;
        //e_print('get0');
        $this->_items = $cache->get($key.'_items');
        //e_print('get_items');
        $this->_adp = $cache->get($key.'_adp');
        //e_print('get_adp');
        //e_print('start_print');
        //e_print(isset($this->_items[0]),'_items_is_true');
        //e_print( !empty($this->_adp),'_adp_is_true');
        //e_print('end_print');

        if (!($this->_items && $this->_adp)) {
            //e_print('SET');
            $this->_items = [];

            $with = ['seo']; //['seo', 'properties'];
            if (Yii::$app->getModule('admin')->activeModules['slidemain']->settings['enableTags']) {
                $with[] = 'tags';
            }

            $query = SlidemainModel::find()
                ->with($with)
                ->status(SlidemainModel::STATUS_ON);

            if (!empty($options['list'])) {

                $query->select(" " . SlidemainModel::tableName() . ".*, cdt.* , ca.`country_id` as ca_id, cra.*, cr.name as region_name  ");

                $query->join(
                    'LEFT JOIN',
                    'country_assign as ca',
                    " `ca`.`item_id` = `" . SlidemainModel::primaryKey()[0] . "` AND `ca`.`class` LIKE '" . addslashes(addslashes(SlidemainModel::className())) . "'  "
                );

                $query->join(
                    'LEFT JOIN',
                    'country_data as cdt',
                    ' cdt.`country_id` = ca.`country_id` '
                );

                $query->join(
                    'LEFT JOIN',
                    'country_region_assign as cra',
                    ' cra.`country_id` = ca.`country_id` '
                );

//                $query->join(
//                    'LEFT JOIN',
//                    'country_region as cr',
//                    " `cr`.`id` = `cra`.`region_id`  "
//                )->andWhere(" `cr`.`is_unep` = '1' ");

                $query->join(
                    'LEFT JOIN',
                    'country_region as cr',
                    " `cr`.`id` = `cra`.`region_id`  "
                );
            }

            if (!empty($options['where'])) {
                $query->andFilterWhere($options['where']);
            }

            if (!empty($options['tags'])) {
                $query
                    ->innerJoinWith('tags', false)
                    ->andWhere([Tag::tableName() . '.name' => (new SlidemainModel)->filterTagValues($options['tags'])])
                    ->addGroupBy('slide_main_id');
            }

            if (!empty($options['type_id'])) {
                $query
                    ->andWhere(['type_id' => $options['type_id']]);
            }

            //$query->groupBy('slide_main_id');
            if (!empty($options['list'])) {
                $query->orderBy(' `cr`.`sort_order` ASC, `cdt`.`country_id` DESC ');
            } elseif (!empty($options['orderBy'])) {
                $query->orderBy($options['orderBy']);
            } else {
                $query->sortDate();
            }

            $this->_adp = new ActiveDataProvider([
                'query' => $query,
                'pagination' => !empty($options['pagination']) ? $options['pagination'] : []
            ]);

            /**
             * @var SlidemainModel $model
             */
            foreach ($this->_adp->models as $model) {
                $item = new SlidemainObject($model);
                //$item->countries = isset($countries[$model->slide_main_id]) ? $countries[$model->slide_main_id] : $model->countries;
                $this->_items[] = $item;
            }

            $cache->set($key.'_adp', $this->_adp, 40);
            $cache->set($key.'_items', $this->_items, 40);

            //e_print('SET END');
        } else {
             ////e_print($options, '$options');
             ////e_print($this->_items, '$dataGet');
             //ex_print('GET');
        }

        //ex_print('api_items_end');

        return $this->_items;
    }

    public function api_get($id_slug)
    {
        if (!isset($this->_item[$id_slug])) {
            $this->_item[$id_slug] = $this->findSlidemain($id_slug);
        }
        return $this->_item[$id_slug];
    }

    public function api_last($limit = 1)
    {
        if ($limit === 1 && $this->_last) {
            return $this->_last;
        }

        $with = ['seo'];
        if (Yii::$app->getModule('admin')->activeModules['slidemain']->settings['enableTags']) {
            $with[] = 'tags';
        }

        $result = [];
        foreach (SlidemainModel::find()->with($with)->status(SlidemainModel::STATUS_ON)->sortDate()->limit($limit)->all() as $item) {
            $result[] = new SlidemainObject($item);
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

    private function findSlidemain($id_slug)
    {
        $slidemain = SlidemainModel::find()
            ->where(['or', 'slide_main_id=:id_slug', 'slug=:id_slug'], [':id_slug' => $id_slug])
            ->status(SlidemainModel::STATUS_ON)
            ->one();
        if ($slidemain) {
            $slidemain->updateCounters(['views' => 1]);
            return new SlidemainObject($slidemain);
        } else {
            return null;
        }
    }

    public function api_clear()
    {
        $this->_adp = false;
        $this->_last = false;
        $this->_items = false;
        $this->_item = [];
    }
}