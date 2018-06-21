<?php

namespace common\controllers;

use Yii;

use common\models\ContentImage;
use common\models\Language;
use common\modules\attachment\models\Attachment;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Request;


class ContentAdminController extends Controller
{
    /**
     * @param $model \common\models\Content
     * @param $request Request
     * @return \yii\web\Response
     */
    protected function _saveItem($model, $request, $translation_models){



        $model->language = $request->get('language', $model->language);
        $model->publish_date = date('d.m.Y', ($model->publish_date ? $model->publish_date : time()));

        if ($model->load($request->post()) && Model::loadMultiple($translation_models, $request->post()) && $model->validate()) {

            foreach ($translation_models as $language => $translation_model) {
                $translation_model->language = $language;

                if (!Inflector::slug($translation_model->slug)) {
                    $translation_model->slug = Inflector::slug($translation_model->name);
                }

                if ($language !== $model->language && !$translation_model->validate()) {
                    $translation_model->status = $model::STATUS_DRAFT;
                }

                $translation_model->clearErrors();
            }

            $model->publish_date = strtotime($model->publish_date);

            if($model->save(false)){

//                ContentImage::deleteAll(['content_id' => $model->id]);
//                if ($content_images = $request->post('Images', [])) {
//                    $order_by = new Expression('FIELD (id, ' . implode(', ', $content_images) . ')');
//                    $newImages = Attachment::find()->where(['id' => $content_images])->orderBy($order_by)->all();
//                    foreach ($newImages as $newImage) {
//                        $content_image_model = new ContentImage;
//                        $content_image_model->setAttributes([
//                            'content_id' => $model->id,
//                            'attachment_id' => $newImage->id,
//                        ]);
//
//                        $content_image_model->save();
//                    }
//                }

                $is_new_record = $model->isNewRecord;
                e_print($model->language, 'save');
                if ($translation_models[$model->language]->validate()) {
                    e_print('save2');
                    foreach ($translation_models as $language => $translation_model) {
                        $translation_model->content_id = $model->id;
                        $translation_model->save(false);
                    }

                    Yii::$app->session->setFlash('flash-admin-message-success', $is_new_record ? 'Операция по созданию успешна.' : 'Операция по обновлению успешна.');
                    ex_print('save3');
                    return $this->redirect(Url::to(['/admin/'.$model->type.'/default/edit', 'id' => $model->id, 'language' => $model->language]));
                }else{
                    $errors = $model->errors;
                    ex_print($errors,'$errors');
                }
            }

            ex_print('adsdsadas2');
        }
    }
}
