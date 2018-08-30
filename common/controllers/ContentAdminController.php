<?php

namespace common\controllers;

use common\components\ActiveRecord;
use common\components\CategoryController;
use common\helpers\Telegram;
use frontend\helpers\Image;
use frontend\models\Setting;
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

        //if($request->post()['id']!=false && $model->id==false){ }

        $model->loadDefaultValues();

        if ($model->load($request->post()) && Model::loadMultiple($translation_models, $request->post())) {

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

            $slugError = false;
            if(!$model->validate(['slug'])){
                $model->slug .= '-' . substr(md5(time()), 0, 2);
                $slugError = true;
            }



            if($model->save(false)){ //@todo true  #langValidAndAddidional

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

                    if($model->validate() && !$model->post_telegram){
                        if($model->type_id==2){
                            $title = $model->translation->name;
                            $description = (!empty($model->translation->meta_description)) ? $model->translation->meta_description : '';

                            //$img = (isset($model->image) && !empty($model->image)) ? Image::thumb($model->image, 800, 200) : Image::thumb($model->pre_image, 800, 450);
                            $img = Image::thumb($model->pre_image, 800, 450);
                            $img = Url::base('https') . $img;

                            $link = Url::base('https') . '/news/'. $model->slug ;
                            $text = "<a href='".trim($img)."'>✉</a>\n<a href='".$link."'>".trim($title)."</a>\n".trim($description);

                            Telegram::sendMessage($text);

                            $model->post_telegram = 1;
                            $model->save(false);
                            //echo $text;exit;
                        }
                    }

                    if($model->validate()){
                        return $this->redirect(Url::to(['/admin/'.$model->type.'/default/edit', 'id' => $model->id, 'language' => $model->language]));
                    }
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

        if($slugError){
            try {
                $mail =  Yii::$app->mailer->compose()
                    ->setFrom(Setting::get('robot_email'))
                    //->setFrom('itc@iq-offshore.com')
                    ->setTo('akvamiris@gmail.com')
                    ->setSubject('Рапорт об ошибке 5 - Slug Error')
                    ->setHtmlBody('
                        <b>Name: ' . $model->name . '</b><br />
                        <span>Slug: ' . $model->slug . '</span><br />
                        <span>ID: ' . $model->id  . '</span><br />
                        <span>'.Url::to(['https://iq-offshore.com'.'/admin/'.$model->type.'/default/edit', 'id' => $model->id, 'language' => $model->language]).'</span>
            '       )//Url::to()
                    //->setReplyTo(Setting::get('admin_email'))
                    ->send();
            } catch (\Exception $e) {
                //throw new ErrorException('xxxxxxxxxxfjjidshghadfg');
                //@to
            }
        }
    }
}
