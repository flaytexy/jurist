<?php

namespace backend\modules\album\controllers\backend;

use backend\models\ContentImage;
use backend\models\Language;
use backend\modules\attachment\models\Attachment;
use backend\modules\album\models\Album;
use backend\modules\album\models\AlbumTranslation;
use Yii;
use yii\base\Model;
use yii\db\Expression;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Галереи – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Album::find()
            ->joinWith('translations')
            ->where(['type' => Album::$_type])
            ->groupBy(Album::tableName() . '.id');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->orderBy([Album::tableName() . '.publish_date' => SORT_DESC])
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionEdit($id)
    {

        $request = Yii::$app->request;

        /**
         * @var Album $model
         * @var AlbumTranslation|array $translation_models
         * @var AlbumTranslation $translation_model
         */

        $model = Album::find()
            ->where([Album::tableName() . '.id' => $id])
            ->with('translations')
            ->with('images')
            ->one();

        if ($model instanceof Album) {
            $translation_models = $model->translations;
        } else {

            if ($id) {
                return $this->redirect(['/admin/album/default/index']);
            }

            $model = new Album;

            $translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $translation_model = new AlbumTranslation;
                $translation_model->loadDefaultValues();
                $translation_models[$language['local']] = $translation_model;
            }
        }

        $model->language = $request->get('language', $model->language);

        $model->publish_date = date('d.m.Y', ($model->publish_date ? $model->publish_date : time()));

        if ($model->load($request->post()) && Model::loadMultiple($translation_models, $request->post())) {
            foreach ($translation_models as $language => $translation_model) {
                $translation_model->language = $language;

                if (!Inflector::slug($translation_model->slug)) {
                    $translation_model->slug = Inflector::slug($translation_model->title);
                }

                if ($language !== $model->language && !$translation_model->validate()) {
                    $translation_model->status = Album::STATUS_DRAFT;
                }

                $translation_model->clearErrors();
            }

            $model->publish_date = strtotime($model->publish_date);

            if($model->validate()){
                $model->save();

                ContentImage::deleteAll(['content_id' => $model->id]);
                if ($content_images = $request->post('Images', [])) {
                    $order_by = new Expression('FIELD (id, ' . implode(', ', $content_images) . ')');
                    $newImages = Attachment::find()->where(['id' => $content_images])->orderBy($order_by)->all();
                    foreach ($newImages as $newImage) {
                        $content_image_model = new ContentImage;
                        $content_image_model->setAttributes([
                            'content_id' => $model->id,
                            'attachment_id' => $newImage->id,
                        ]);

                        $content_image_model->save();
                    }
                }
            }

            $is_new_record = $model->isNewRecord;

            if ($translation_models[$model->language]->validate() && $model->save(false)) {
                foreach ($translation_models as $language => $translation_model) {
                    $translation_model->content_id = $model->id;
                    $translation_model->save(false);
                }

                Yii::$app->session->setFlash('flash-admin-message-success', $is_new_record ? 'Операция по созданию успешна.' : 'Операция по обновлению успешна.');

                return $this->redirect(Url::to(['/admin/album/default/edit', 'id' => $model->id, 'language' => $model->language]));
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
         * @var Album $model
         * @var AlbumTranslation $translation
         */

        $model = Album::find()
            ->where(['id' => $id])
            ->with('translations')
            ->one();

        if ($model) {
            foreach ($model->translations as $translation) {
                $translation->delete();
            }

            $model->delete();

            Yii::$app->session->setFlash('flash-admin-message-success', 'Новость удалена.');
        }

        return $this->redirect(Url::to(['/admin/album/default/index']));
    }
}
