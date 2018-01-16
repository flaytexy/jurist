<?php

namespace app\modules\park\controllers\backend;

use app\models\Language;
use app\modules\park\models\CarPrices;
use app\modules\park\models\Place;
use app\modules\park\models\PlaceTranslation;
use Yii;
use yii\base\Model;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\web\Controller;

class PlaceController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Местоположения – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Place::find()
            ->joinWith('translations', false)
            ->joinWith('city', false)
            ->groupBy(Place::tableName() . '.id')
            ->orderBy([
                Place::tableName() . '.city_id' => SORT_ASC,
                Place::tableName() . '.id' => SORT_ASC,
            ]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

//        vd($models = $query->offset($pages->offset)
//            ->limit($pages->limit)->createCommand()->rawSql);

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionEdit($id)
    {
        /**
         * @var Place $model
         * @var PlaceTranslation|array $translation_models
         * @var PlaceTranslation $translation_model
         */

        $model = Place::find()
            ->where([Place::tableName() . '.id' => $id])
            ->with('translations')
            ->one();

        if ($model instanceof Place) {
            $translation_models = $model->translations;
        } else {

            if ($id) {
                return $this->redirect(['/admin/park/place/index']);
            }

            $model = new Place;

            $model->loadDefaultValues();

            $translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $translation_model = new PlaceTranslation;
                $translation_model->loadDefaultValues();
                $translation_models[$language['local']] = $translation_model;
            }
        }

        $model->language = Yii::$app->request->get('language', $model->language);

        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($translation_models, Yii::$app->request->post())) {

            foreach ($translation_models as $language => $translation_model) {
                $translation_model->language = $language;

                if ($language !== $model->language && !$translation_model->validate()) {
                    $translation_model->status = PlaceTranslation::STATUS_DRAFT;
                }

                $translation_model->clearErrors();
            }

            $model->validate();

            $is_new_record = $model->isNewRecord;

            if ($translation_models[$model->language]->validate() && $model->save()) {
                foreach ($translation_models as $language => $translation_model) {
                    $translation_model->place_id = $model->id;
                    $translation_model->save(false);
                }

                Yii::$app->session->setFlash('flash-admin-message-success', $is_new_record ? 'Местоположение добавлено.' : 'Местоположение обновлено.');

                return $this->redirect(Url::to(['/admin/park/place/edit', 'id' => $model->id, 'language' => $model->language]));
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
         * @var Place $model
         * @var PlaceTranslation $translation
         */

        $model = Place::find()
            ->where(['id' => $id])
            ->with('translations')
            ->one();

        if ($model) {
            foreach ($model->translations as $translation) {
                $translation->delete();
            }

            $model->delete();

            Yii::$app->session->setFlash('flash-admin-message-success', 'Местоположение удалено.');
        }

        return $this->redirect(Url::to(['/admin/park/place/index']));
    }
}
