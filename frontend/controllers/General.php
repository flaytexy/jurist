<?php
/**
 * Created by PhpStorm.
 * User: ETREX
 * Date: 30.06.2018
 * Time: 17:32
 */

namespace frontend\controllers;


use frontend\modules\novabanks\api\Novabanks as Banks;
use frontend\modules\novabanks\api\Novabanks;
use frontend\modules\novabanks\api\NovabanksObject;
use frontend\modules\novabanks\models\NovabanksTranslation;
use frontend\modules\novanews\models\Novanews;
use frontend\modules\novanews\api\NovanewsObject as PageObject;
use frontend\modules\novabanks\models\Novabanks as NovabanksModel;
use frontend\modules\novanews\models\NovanewsTranslation;
use frontend\modules\novaoffers\api\NovaoffersObject;
use frontend\modules\novaoffers\models\Novaoffers;
use frontend\modules\novaoffers\models\NovaoffersTranslation;

class General extends \yii\web\Controller
{
    public function getLefModulesData()
    {
        return array(
            $this->getTopNews(),
            $this->getTopBanks(),
            $this->getTopOffers()
        );
    }

    /**
     * @return Novanews[]
     */
    public function getTopNews()
    {
        // Top News
        $rows = Novanews::find()
            ->joinWith('translation')
            ->andWhere([NovanewsTranslation::tableName() . '.public_status' => NovanewsTranslation::STATUS_ON])
            ->andWhere(['type_id' => Novanews::TYPE_ID])
            ->status(Novanews::STATUS_ON)
            ->sortDate()->limit(5)->all();

        $topNews = [];
        foreach ($rows as $item) {
            $obj = new PageObject($item);
            $topNews[] = $obj;
        }

        return $topNews;
    }

    /**
     * @param bool $limit
     * @return NovabanksObject[]
     */
    public function getTopBanks($limit = false)
    {
        if ($limit == false) {
            $limit = 3;
        }

        $rows = NovabanksModel::find()
            //->select([NovabanksModel::tableName().'.*', NovabanksTranslation::tableName().'.*'])
            ->joinWith('translation')
            ->joinWith('bank')
            ->andWhere([NovabanksModel::tableName() . '.type_id' => NovabanksModel::TYPE_ID])
            ->andWhere([NovabanksTranslation::tableName() . '.public_status' => NovabanksTranslation::STATUS_ON])
            ->status(NovabanksModel::STATUS_ON)
            ->orderBy(['rating' => SORT_DESC])
            ->limit(3)
            //->asArray()
            ->all();

        foreach ($rows as $item) {
            $obj = new NovabanksObject($item);

            $topBanks[] = $obj;
        }

        return $topBanks;
    }

    /**
     * @return NovaOffersObject[]
     */
    public function getTopOffers()
    {
        $query = Novaoffers::find()
            //->select([NovabanksModel::tableName().'.*', NovabanksTranslation::tableName().'.*'])
            ->joinWith('translation')
            ->joinWith('offer')
            ->andWhere([Novaoffers::tableName() . '.type_id' => Novaoffers::TYPE_ID])
            ->andWhere([NovaoffersTranslation::tableName() . '.public_status' => NovaoffersTranslation::STATUS_ON])
            ->status(Novaoffers::STATUS_ON)
            //->orderBy([NovaoffersTranslation::tableName() .'.name' => SORT_ASC])
            ->orderBy(['views' => SORT_DESC])
            ->limit(4);
            //->asArray()
            //->all();
        $rows = $query->all();

        foreach ($rows as $item) {
            $obj = new NovaoffersObject($item);
            $topBanks[] = $obj;
        }

        return $topBanks;
    }

}