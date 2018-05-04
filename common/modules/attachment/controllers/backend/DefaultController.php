<?php

namespace common\modules\attachment\controllers\backend;

use common\models\Language;
use common\modules\attachment\models\Attachment;
use common\modules\attachment\models\AttachmentTranslation;
use Imagine\Image\Box;
use Yii;
use yii\base\ErrorException;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\components\Image;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Медиафайлы – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionUpload()
    {
        if (Yii::$app->request->isPost) {
            

            
            $model = new Attachment;
            $model->file = UploadedFile::getInstanceByName('file');

            if ($model->hasErrors()) {
                $result = [
                    'error' => Html::encode($model->getFirstError('file')),
                ];
            } else {
                $model_file_name = uniqid() . '.' . $model->file->extension;

                $model->setTitle(substr($model->file->name, 0, (strlen($model->file->name) - strlen($model->file->extension) - 1)));
                $model->name = $model_file_name;
                $model->type = $model->file->type;

                //Attachment::setImageMaxLength(1024);

                if ($model->save()) {

                    foreach (Language::getLanguages() as $language) {
                        $model_translate = new AttachmentTranslation;

                        $model_translate->setAttributes([
                            'attachment_id' => $model->id,
                            'language' => $language['local'],
                            'title' => $model->getTitle(),
                        ]);

                        $model_translate->save();
                    }
                    $result = [
                        'id' => $model->id,
                        'title' => $model->file->name,
                        'name' => $model_file_name,
                        'type' => $model->file->type,
                        'url' => Yii::getAlias('@web/uploads' . DIRECTORY_SEPARATOR. $model_file_name)
                    ];
                } else {
                    $result = ['error' => 'Файл не загружен!'];
                }
            }
            Yii::$app->response->format = Response::FORMAT_JSON;

            return $result;
        } else {
            throw new BadRequestHttpException('Only POST is allowed');
        }
    }

    public function actionIndex()
    {
        $models = Attachment::find()
            ->with('translations')
            ->orderBy([Attachment::tableName() . '.created_at' => SORT_DESC])
            ->limit(Attachment::ADMIN_PAGE_LIMIT)
            ->offset(0);

        if (Yii::$app->request->get('modal')) {

            if (Yii::$app->request->get('onlyImages')) {
                $models->andWhere(['like', Attachment::tableName() . '.type', 'image/%', false]);
            }

            return $this->renderAjax('index-modal', [
                'models' => $models->all(),
            ]);
        } else {
            return $this->render('index', [
                'models' => $models->all(),
            ]);
        }
    }

    public function actionLoadMore()
    {
        $offset = Yii::$app->request->get('offset', 0);

        $models = Attachment::find()
            ->with('translations')
            ->orderBy([Attachment::tableName() . '.created_at' => SORT_DESC])
            ->limit(Attachment::ADMIN_PAGE_LIMIT)
            ->offset($offset)
            ->all();

        return $this->renderAjax('items', [
            'models' => $models,
        ]);
    }

    public function actionEdit($id)
    {
        /**
         * @var Attachment $model
         * @var AttachmentTranslation|array $translation_models
         * @var AttachmentTranslation $translation_model
         */

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $model = Attachment::find()
                ->where([Attachment::tableName() . '.id' => $id])
                ->with('translations')
                ->one();

            if ($model instanceof Attachment) {
                $translation_models = $model->translations;

                if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($translation_models, Yii::$app->request->post())) {

                    if ($model->save()) {
                        foreach ($translation_models as $language => $translation_model) {
                            $translation_model->save();
                        }

                        return ['success' => true];
                    }

                }

                return [
                    'response' =>
                        $this->renderAjax('edit', [
                            'model' => $model,
                            'translation_models' => $translation_models,
                        ])
                ];
            } else {
                throw new NotFoundHttpException;
            }
        } else {
            throw new BadRequestHttpException('Only AJAX is allowed');
        }
    }

    public function actionDelete($id)
    {
        /**
         * @var Attachment $model
         * @var AttachmentTranslation $translation
         */

        $model = Attachment::find()
            ->where(['id' => $id])
            ->with('translations')
            ->one();

        if ($model) {
            foreach ($model->translations as $translation) {
                $translation->delete();
            }

            $path = Yii::getAlias('@webroot/uploads/' . $model->name);

            try {
                unlink($path);
            } catch (ErrorException $e) {
                if (DIRECTORY_SEPARATOR === '\\') {
                    // last resort measure for Windows
                    $lines = [];
                    exec("DEL /F/Q \"$path\"", $lines, $deleteError);
                } else {
                    throw $e;
                }
            }

            $model->delete();

            Yii::$app->session->setFlash('flash-admin-message-success', 'Файл удален.');
        }

        return $this->redirect(Url::to(['/admin/attachment/default/index']));
    }
}
