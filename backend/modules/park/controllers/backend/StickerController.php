<?php

namespace app\modules\park\controllers\backend;

use app\models\Language;
use app\modules\park\models\CarPrices;
use app\modules\park\models\Sticker;
use app\modules\park\models\StickerTranslation;
use Yii;
use yii\base\Model;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\web\Controller;

class StickerController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Стикеры – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Sticker::find()
            ->joinWith('translations')
            ->groupBy(Sticker::tableName() . '.id');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->orderBy([StickerTranslation::tableName() . '.title' => SORT_ASC])
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
         * @var Sticker $model
         * @var StickerTranslation|array $translation_models
         * @var StickerTranslation $translation_model
         */

        $model = Sticker::find()
            ->where([Sticker::tableName() . '.id' => $id])
            ->with('translations')
            ->one();

        if ($model instanceof Sticker) {
            $translation_models = $model->translations;
        } else {

            if ($id) {
                return $this->redirect(['/admin/park/sticker/index']);
            }

            $model = new Sticker;

            $model->loadDefaultValues();

            $translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $translation_model = new StickerTranslation;
                $translation_model->loadDefaultValues();
                $translation_models[$language['local']] = $translation_model;
            }
        }

        $model->language = Yii::$app->request->get('language', $model->language);

        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($translation_models, Yii::$app->request->post())) {

            foreach ($translation_models as $language => $translation_model) {
                $translation_model->language = $language;

                if ($language !== $model->language && !$translation_model->validate()) {
                    $translation_model->status = StickerTranslation::STATUS_DRAFT;
                }

                $translation_model->clearErrors();
            }

            $model->validate();

            $is_new_record = $model->isNewRecord;

            if ($translation_models[$model->language]->validate() && $model->save()) {
                foreach ($translation_models as $language => $translation_model) {
                    $translation_model->sticker_id = $model->id;
                    $translation_model->save(false);
                }

                Yii::$app->session->setFlash('flash-admin-message-success', $is_new_record ? 'Стикер добавлен.' : 'Стикер обновлен.');

                return $this->redirect(Url::to(['/admin/park/sticker/edit', 'id' => $model->id, 'language' => $model->language]));
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
         * @var Sticker $model
         * @var StickerTranslation $translation
         */

        $model = Sticker::find()
            ->where(['id' => $id])
            ->with('translations')
            ->one();

        if ($model) {
            foreach ($model->translations as $translation) {
                $translation->delete();
            }

            $model->delete();

            Yii::$app->session->setFlash('flash-admin-message-success', 'Стикер удален.');
        }

        return $this->redirect(Url::to(['/admin/park/sticker/index']));
    }
}
