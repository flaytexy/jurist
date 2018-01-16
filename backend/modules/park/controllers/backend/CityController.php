<?php

namespace app\modules\park\controllers\backend;

use app\models\Language;
use app\modules\park\models\CarPrices;
use app\modules\park\models\City;
use app\modules\park\models\CityTranslation;
use Yii;
use yii\base\Model;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\web\Controller;

class CityController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Города – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = City::find()
            ->joinWith('translations')
            ->groupBy(City::tableName() . '.id');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->orderBy([City::tableName() . '.created_at' => SORT_ASC])
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
         * @var City $model
         * @var CityTranslation|array $translation_models
         * @var CityTranslation $translation_model
         */

        $model = City::find()
            ->where([City::tableName() . '.id' => $id])
            ->with('translations')
            ->one();

        if ($model instanceof City) {
            $translation_models = $model->translations;
        } else {

            if ($id) {
                return $this->redirect(['/admin/park/city/index']);
            }

            $model = new City;

            $model->loadDefaultValues();

            $translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $translation_model = new CityTranslation;
                $translation_model->loadDefaultValues();
                $translation_models[$language['local']] = $translation_model;
            }
        }

        $model->language = Yii::$app->request->get('language', $model->language);

        $model->_phones = Yii::$app->request->post('_phones', $model->phones ? unserialize($model->phones) : $model->_phones);

        if (empty($model->_phones)) {
            $model->_phones = [''];
        }

        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($translation_models, Yii::$app->request->post())) {

            foreach ($translation_models as $language => $translation_model) {
                $translation_model->language = $language;

                if ($language !== $model->language && !$translation_model->validate()) {
                    $translation_model->status = CityTranslation::STATUS_DRAFT;
                }

                $translation_model->clearErrors();
            }

            $model->validate();

            $is_new_record = $model->isNewRecord;

            $model->phones = serialize(array_filter($model->_phones));

            if ($translation_models[$model->language]->validate() && $model->save()) {
                foreach ($translation_models as $language => $translation_model) {
                    $translation_model->city_id = $model->id;
                    $translation_model->save(false);
                }

                Yii::$app->session->setFlash('flash-admin-message-success', $is_new_record ? 'Город добавлен.' : 'Город обновлен.');

                return $this->redirect(Url::to(['/admin/park/city/edit', 'id' => $model->id, 'language' => $model->language]));
            }
        }

        return $this->render('edit', [
            'model' => $model,
            'translation_models' => $translation_models,
        ]);
    }

    public function actionDelete($id)
    {
        /**
         * @var City $model
         * @var CityTranslation $translation
         * @var CarPrices $price
         */

        $model = City::find()
            ->where(['id' => $id])
            ->with('translations')
            ->one();

        if ($model) {
            foreach ($model->translations as $translation) {
                $translation->delete();
            }

            foreach ($model->prices as $price) {
                $price->delete();
            }

            $model->delete();

            Yii::$app->session->setFlash('flash-admin-message-success', 'Город удален.');
        }

        return $this->redirect(Url::to(['/admin/park/city/index']));
    }

    public function actionDefault($id)
    {
        /**
         * @var City $model
         */

        $model = City::find()
            ->where(['id' => $id])
            ->one();

        if ($model) {
            City::updateAll(['default' => 0]);

            $model->default = 1;
            $model->save(false);

            Yii::$app->session->setFlash('flash-admin-message-success', 'Установлен город по умолчанию - ' . $model->getTitle() . '.');
        }

        return $this->redirect(Url::to(['index']));
    }
}
