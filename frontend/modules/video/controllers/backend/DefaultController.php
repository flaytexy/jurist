<?php

namespace frontend\modules\video\controllers\backend;

use common\models\ContentImage;
use common\models\Language;
use common\modules\attachment\models\Attachment;
use frontend\modules\video\models\Video;
use frontend\modules\video\models\VideoTranslation;
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
        $this->view->title = 'Новости – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Video::find()
            ->joinWith('translations')
            ->where(['type' => Video::$_type])
            ->groupBy(Video::tableName() . '.id');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->orderBy([Video::tableName() . '.publish_date' => SORT_DESC])
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
         * @var Video $model
         * @var VideoTranslation|array $translation_models
         * @var VideoTranslation $translation_model
         */

        $model = Video::find()
            ->where([Video::tableName() . '.id' => $id])
            ->with('translations')
            ->with('images')
            ->one();

        if ($model instanceof Video) {
            $translation_models = $model->translations;
        } else {

            if ($id) {
                return $this->redirect(['/admin/video/default/index']);
            }

            $model = new Video;

            $translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $translation_model = new VideoTranslation;
                $translation_model->loadDefaultValues();
                $translation_models[$language['local']] = $translation_model;
            }
        }

        $model->language = $request->get('language', $model->language);

        $model->publish_date = date('d.m.Y', ($model->publish_date ? $model->publish_date : time()));

        if ($model->load($request->post()) && Model::loadMultiple($translation_models, $request->post())) {

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

            foreach ($translation_models as $language => $translation_model) {
                $translation_model->language = $language;

                if (!Inflector::slug($translation_model->slug)) {
                    $translation_model->slug = Inflector::slug($translation_model->title);
                }

                if ($language !== $model->language && !$translation_model->validate()) {
                    $translation_model->status = Video::STATUS_DRAFT;
                }

                $translation_model->clearErrors();
            }

            $model->publish_date = strtotime($model->publish_date);

            $model->validate();

            $is_new_record = $model->isNewRecord;

            if ($translation_models[$model->language]->validate() && $model->save(false)) {
                foreach ($translation_models as $language => $translation_model) {
                    $translation_model->content_id = $model->id;
                    $translation_model->save(false);
                }

                Yii::$app->session->setFlash('flash-admin-message-success', $is_new_record ? 'Операция по созданию успешна.' : 'Операция по обновлению успешна.');

                return $this->redirect(Url::to(['/admin/video/default/edit', 'id' => $model->id, 'language' => $model->language]));
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
         * @var Video $model
         * @var VideoTranslation $translation
         */

        $model = Video::find()
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

        return $this->redirect(Url::to(['/admin/video/default/index']));
    }
}
