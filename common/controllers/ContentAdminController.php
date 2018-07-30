<?php

namespace common\controllers;

use common\components\ActiveRecord;
use common\components\CategoryController;
use common\helpers\Telegram;
use frontend\helpers\Image;
use Yii;

use common\helpers\InflectorTextTranslate;
use common\models\ContentTranslation;

use yii\base\Model;
use yii\helpers\Url;
use yii\web\UploadedFile;


/**
 * Class ContentAdminController
 * @package common\controllers
 */
class ContentAdminController extends CategoryController
{
    /**
     * @param \common\models\Content $model
     * @param \yii\web\Request $request
     * @param ContentTranslation[] $translation_models
     * @param ActiveRecord $child
     * @return \yii\web\Response
     * @throws \yii\web\HttpException
     */
    protected function _saveItem($model, $request, $translation_models, $child = false){

        if ($model->load($request->post()) && Model::loadMultiple($translation_models, $request->post()) && $model->validate()) {

            //$model->category_detail =  $model->type_id . ":" . $model->category_id;
            $model->time = time();

            $model->language = $request->get('language', $model->language);
            $model->publish_date = date('d.m.Y', ($model->publish_date ? $model->publish_date : time()));

            foreach ($translation_models as $language => $translation_model) {
                $translation_model->language = $language;

                if (!InflectorTextTranslate::slug($translation_model->slug)) {
                    $translation_model->slug = InflectorTextTranslate::slug($translation_model->name);
                    if($model->slug==false && $translation_model->slug!=false){
                        $model->slug = $translation_model->slug;
                    }
                }

                if ($language !== $model->language && !$translation_model->validate()) {
                    $translation_model->public_status = $model::STATUS_OFF;
                }

                $translation_model->clearErrors();
            }

            $model->publish_date = strtotime($model->publish_date);

            if(isset($child) && $child!=false){
                $child->load($request->post());
                //$child->content_id = $model->primaryKey;
                if ($child->validate()) {
                    $child->save();
                }
            }

            if(isset($_FILES)){
                $model->image = UploadedFile::getInstance($model, 'image');
                if($model->image && $model->validate(['image'])){
                    $model->image = Image::upload($model->image, 'page');
                }
                else{
                    $model->image = $model->oldAttributes['image'];
                }

                $model->pre_image = UploadedFile::getInstance($model, 'pre_image');
                if($model->pre_image && $model->validate(['image'])){
                    $model->pre_image = Image::upload($model->pre_image, 'page');
                }
                else{
                    $model->pre_image = $model->oldAttributes['pre_image'];
                }
            }

            $is_new_record = $model->isNewRecord;

            if($model->save()){ //@todo true  #langValidAndAddidional

                if(isset($child) && $child!=false){
                    if($child->validate()){
                        $model->link('child', $child);
                    }else{
                        Yii::$app->session->setFlash('error', Yii::t('easyii','Update error. {0}', $child->formatErrors()));
                    }
                }

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


                //$item = $translation_models[$model->language];


                //e_print($model->language, 'saddsaads222');

                if ($translation_models[$model->language]->validate()) {
                    foreach ($translation_models as $language => $translation_model) {
                        //if ($translation_model->validate()) {
                            $translation_model->content_id = $model->id;
                            $translation_model->save(false);
                        //}else{
                            //ex_print($translation_model->errors,'$errors');
                        //}
                    }
                    Yii::$app->session->setFlash('flash-admin-message-success', $is_new_record ? 'Операция по созданию успешна.' : 'Операция по обновлению успешна.');

                    if($is_new_record){
                        if($model->type_id==2){
                            $title = $model->translation->name;
                            $description = (!empty($model->translation->meta_description)) ? $model->translation->meta_description : '';

                            //$img = (isset($model->image) && !empty($model->image)) ? Image::thumb($model->image, 800, 200) : Image::thumb($model->pre_image, 800, 450);
                            $img = Image::thumb($model->pre_image, 800, 450);
                            $img = Url::base('https') . $img;
                            //$img = 'https://iq-offshore.com/uploads/thumbs/111-afbbfee65b-800x200-80-50245eca5453a2d9047285d801ff7d28.jpg';
                            //echo $img;
                            //https://iq-offshore.com/uploads/thumbs/111-afbbfee65b-800x200-80-50245eca5453a2d9047285d801ff7d28.jpg
                            //file_get_contents($img);
                            //echo "<img src='".$img."' />";
                            //usleep(8000000);
                            //https://iq-offshore.com/uploads/thumbs/newcomp-2-9847220052-800x200-80-0829a67cc9c0e438aa80084e8cf6fa3a.jpg
                            //https://iq-offshore.com/uploads/thumbs/c59ec6a9eb1e7e0c849895c48ffecd53-eef9e3e417-800x450-80-5fce77536ff4da9920e9f8c78e63b9ea.jpg
                            //https://iq-offshore.com/uploads/thumbs/c59ec6a9eb1e7e0c849895c48ffecd53-e91adb8372-800x200-80-501fb6a37f3f9a35e9fef09ebad947e0.jpg

                            //https://iq-offshore.com/uploads/thumbs/lqdcusv5zw4a5q3xo8vtjz2whxu-3a888c3f1e-800x200-80-dd1c7b969e2135235df3899a8b9f479a.jpeg
                            //https://iq-offshore.com/uploads/thumbs/lqdcusv5zw4a5q3xo8vtjz2whxu-3a888c3f1e-800x200-80-dd1c7b969e2135235df3899a8b9f479a.jpeg

                            //https://iq-offshore.com/uploads/thumbs/111-ab56cf4a99-800x200-80-4640aeb9bcd6de20fbfebbac116ab68d.jpg
                            //https://iq-offshore.com/uploads/thumbs/111-ab56cf4a99-800x200-80-4640aeb9bcd6de20fbfebbac116ab68d.jpg

                            $link = Url::base('https') . '/news/'. $model->slug ;

                            $text = "<a href='".trim($img)."'>✉</a>\n<a href='".$link."'>".trim($title)."</a>\n".trim($description);

                            Telegram::sendMessage($text);

                            //echo $text;exit;
                        }
                    }

                    return $this->redirect(Url::to(['/admin/'.$model->type.'/default/edit', 'id' => $model->id, 'language' => $model->language]));
                }else{
                    //Yii::$app->session->setFlash('error', Yii::t('easyii','Update error. {0}', serialize($translation_models[$model->language]->errors)));
                    Yii::$app->session->setFlash('error', Yii::t('easyii','Update error. {0}', $translation_models[$model->language]->formatErrors()));
                }
            }
        }

        if($model->errors){
            //ex_print($model->errors, '$errors');
            Yii::$app->session->setFlash('error', Yii::t('easyii','Update error. {0}', $model->formatErrors()));
        }
    }
}
