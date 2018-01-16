<?php

namespace app\modules\currency\controllers\backend;

use app\models\Language;
use app\modules\currency\models\Currency;
use app\modules\currency\models\CurrencyTranslation;
use Yii;
use yii\base\Model;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Валюты – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Currency::find()
            ->joinWith('translations')
            ->groupBy(Currency::tableName() . '.id');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->orderBy([Currency::tableName() . '.created_at' => SORT_ASC])
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionEdit($id)
    {
        /**
         * @var Currency $model
         * @var CurrencyTranslation|array $translation_models
         * @var CurrencyTranslation $translation_model
         */

        $model = Currency::find()
            ->where([Currency::tableName() . '.id' => $id])
            ->with('translations')
            ->one();

        if ($model instanceof Currency) {
            $translation_models = $model->translations;
        } else {

            if ($id) {
                return $this->redirect(['/admin/currency/default/index']);
            }

            $model = new Currency;

            $translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $translation_model = new CurrencyTranslation;
                $translation_model->loadDefaultValues();
                $translation_models[$language['local']] = $translation_model;
            }
        }

        $model->language = Yii::$app->request->get('language', $model->language);

        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($translation_models, Yii::$app->request->post())) {

            $model->validate();

            $is_new_record = $model->isNewRecord;

            if ($translation_models[$model->language]->validate() && $model->save(false)) {
                foreach ($translation_models as $language => $translation_model) {
                    $translation_model->language = $language;
                    $translation_model->currency_id = $model->id;
                    $translation_model->save(false);
                }

                Yii::$app->session->setFlash('flash-admin-message-success', $is_new_record ? 'Валюта создана.' : 'Валюта обновлена.');

                return $this->redirect(Url::to(['/admin/currency/default/edit', 'id' => $model->id, 'language' => $model->language]));
            }
        }

        return $this->render('edit', [
            'model' => $model,
            'translation_models' => $translation_models,
        ]);
    }

    public function actionDefault($id)
    {
        /**
         * @var Currency $model
         */

        $model = Currency::find()
            ->where(['id' => $id])
            ->one();

        if ($model) {
            Currency::updateAll(['default' => 0]);

            $model->default = 1;
            $model->save(false);

            Yii::$app->session->setFlash('flash-admin-message-success', 'Установлена валюта по умолчанию - ' . $model->getTitle() . '.');
        }

        return $this->redirect(Url::to(['/admin/currency/default/index']));
    }
}
