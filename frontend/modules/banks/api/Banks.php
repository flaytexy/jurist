<?php
namespace frontend\modules\banks\api;

use frontend\models\Option;
use frontend\modules\banks\models\BanksProperties;
use Yii;
use yii\data\ActiveDataProvider;
use frontend\models\Tag;
use frontend\widgets\Fancybox;
use yii\db\Query;
use yii\widgets\LinkPager;

use frontend\modules\banks\models\Banks as BanksModel;

/**
 * Banks module API
 * @package frontend\modules\banks\api
 *
 * @method static BanksObject get(mixed $id_slug) Get banks object by id or slug
 * @method static array items(array $options = []) Get list of banks as BanksObject objects
 * @method static mixed last(int $limit = 1) Get last banks
 * @method static void plugin() Applies FancyBox widget on photos called by box() function
 * @method static string pages() returns pagination html generated by yii\widgets\LinkPager widget.
 * @method static \stdClass pagination() returns yii\data\Pagination object.
 */
class Banks extends \frontend\components\API
{
    private $_adp;
    private $_last;
    private $_items;
    private $_item = [];

    public function api_items($options = [])
    {
        //dsadas
        if (!$this->_items) {
            $this->_items = [];

/*            $subQuery = (new Query())
                ->select(['GROUP_CONCAT(op.title SEPARATOR ":: " )'])
                ->from('easyii_banks_properties_relations as opr')
                ->join('INNER JOIN', 'easyii_banks_properties as op', 'op.property_id = opr.property_id')
                ->where('opr.bank_id=easyii_banks.bank_id');*/

            $with = ['seo'];
            if (Yii::$app->getModule('admin')->activeModules['banks']->settings['enableTags']) {
                $with[] = 'tags';
            }
            $query = BanksModel::find()
                ->with($with)
                ->status(BanksModel::STATUS_ON);

            if (!empty($options['where'])) {
                $query->andFilterWhere($options['where']);
            }
            if (!empty($options['tags'])) {
                $query
                    ->innerJoinWith('tags', false)
                    ->andWhere([Tag::tableName() . '.name' => (new BanksModel)->filterTagValues($options['tags'])])
                    ->addGroupBy('bank_id');
            }
            if (!empty($options['type_id'])) {
                $query
                    ->andWhere([ 'type_id' => $options['type_id'] ]);
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

            foreach ($this->_adp->models as $model) {
                $item = new BanksObject($model);
                $item->properties = Option::find()
                    ->join(
                        'LEFT JOIN',
                        'easyii_options_assign as oa',
                        ' oa.`option_id` = `easyii_options`.`option_id`'
                    )
                    ->andWhere([
                        'item_id'  => (int)$model->bank_id,
                        'class'  => \frontend\modules\banks\models\Banks::className()
                    ])->all();

                $this->_items[] = $item;
            }
        }

        return $this->_items;
    }

    public function api_get($id_slug)
    {
        if (!isset($this->_item[$id_slug])) {
            $this->_item[$id_slug] = $this->findBanks($id_slug);
        }
        return $this->_item[$id_slug];
    }

    public function api_last($limit = 1)
    {
        if ($limit === 1 && $this->_last) {
            return $this->_last;
        }

        $with = ['seo'];
        if (Yii::$app->getModule('admin')->activeModules['banks']->settings['enableTags']) {
            $with[] = 'tags';
        }

        $result = [];
        foreach (BanksModel::find()->with($with)->status(BanksModel::STATUS_ON)->sortDate()->limit($limit)->all() as $item) {
            $result[] = new BanksObject($item);
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
        return $this->_adp ? LinkPager::widget(['pagination' => $this->_adp->pagination]) : '';
    }

    private function findBanks($id_slug)
    {
        $banks = BanksModel::find()
            ->where(['or', 'bank_id=:id_slug', 'slug=:id_slug'], [':id_slug' => $id_slug])
            ->status(BanksModel::STATUS_ON)
            ->one();
        if ($banks) {
            $banks->updateCounters(['views' => 1]);
            return new BanksObject($banks);
        } else {
            return null;
        }
    }
}