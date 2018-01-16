<?php

namespace app\modules\seo\components;

use app\components\ArrayHelper;
use yii\base\Object;
use yii\helpers\Json;
use yii\web\UrlRuleInterface;
use app\modules\seo\models\Seo;

class SeoUrlRule extends Object implements UrlRuleInterface
{
    public function createUrl($manager, $route, $params)
    {
        $params = array_filter($params);
        $params = ArrayHelper::strval($params);

        $query_params = [
            'page' => null,
        ];

        foreach ($query_params as $key => $value) {
            if (isset($params[$key])) {
                $query_params[$key] = $params[$key];
                unset($params[$key]);
            } else {
                unset($query_params[$key]);
            }
        }

        $seo_page = Seo::find()
            ->where([
                'view' => $route,
                'action_params' => Json::encode($params),
            ])->one();

        if ($seo_page && $seo_page->uri) {
            return $seo_page->uri . ($query_params ? '?' . http_build_query($query_params) : '');
        }

        return false;
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();

        $seo_page = Seo::find()
            ->where(['uri' => $pathInfo])
            ->one();

        if ($seo_page) {
            return [$seo_page->view, Json::decode($seo_page->action_params)];
        }

        return false;
    }
}