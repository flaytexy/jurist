<?php
/**
 * Created by PhpStorm.
 * User: Vitaliy
 * Date: 07.02.2017
 * Time: 2:14
 */

namespace frontend\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use common\models\country\Country;

class CountryController extends Controller
{
    public function actionIndex()
    {
        $query = Country::find();

        $pagination = new Pagination([
            'defaultPageSize' => 50,
            'totalCount' => $query->count(),
        ]);

        $countries = $query
            //->select('country_data.*, country.*')
            //->leftJoin('country_data', '`country_data`.`country_id` = `country`.`id`')
            ->joinWith('countryData')
            ->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'countries' => $countries,
            'pagination' => $pagination,
        ]);
    }
}