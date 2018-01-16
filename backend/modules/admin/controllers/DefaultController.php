<?php

namespace app\modules\admin\controllers;




use Yii;
use app\modules\user\forms\LoginForm;
use app\models\Settings;
use yii\base\Model;
use yii\validators\Validator;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $this->view->title = '' . Yii::$app->params['sitePrefix'];

        return $this->render('index');
    }

    public function actionSettinger()
    {
        if (\Yii::$app->user->isGuest) {
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->refresh();
            }

            $this->layout = 'main';

            return $this->render('login', [ //@todo fix maybe
                'model' => $model,
            ]);
        } else {
            $models = Settings::find()->indexBy('key')->all();

            if (Model::loadMultiple($models, Yii::$app->request->post())) {
                $valid = true;

                foreach ($models as $model) {
                    $model->validate();


                    if ($valid) {
                        switch ($model->key) {
                            case 'facebook':
                            case 'medium':
                            case 'twitter':
                            case 'telegram':
                            case 'youtube_link':
                                $validator = Validator::createValidator('url', $model, ['value'], ['message' => 'Ссылка введена неверно']);
                                if (!$validator->validate($model->value, $error)) {
                                    $model->addError('value', $error);
                                    $valid = false;
                                }
                                break;
                            case 'email':
                                $validator = Validator::createValidator('email', $model, ['value'], ['message' => 'E-mail введен неверно']);
                                if (!$validator->validate($model->value, $error)) {
                                    $model->addError('value', $error);
                                    $valid = false;
                                }
                                break;
                            case 'next_phase':
                                $validator = Validator::createValidator('datetime', $model, ['value'], ['format' => 'php:d.m.Y H:i', 'message' => 'Введите дату в формате ДД.ММ.ГГГГ ЧЧ:ММ']);
                                if (!$validator->validate($model->value, $error)) {
                                    $model->addError('value', $error);
                                    $valid = false;
                                }
                                break;
                            case 'evolution':
                                $validator = Validator::createValidator('number', $model, ['value'], ['min' => 0, 'max' => 50000000, 'integerOnly' => true, 'message' => 'Значение должно быть целым числом', 'tooSmall' => 'Значение должно быть не меньше 0', 'tooBig' => 'Значение должно быть не больше 50 000 000']);
                                if (!$validator->validate($model->value, $error)) {
                                    $model->addError('value', $error);
                                    $valid = false;
                                }
                                break;
                            case 'token_sale':
                                $validator = Validator::createValidator('number', $model, ['value'], ['min' => 0, 'max' => 100, 'integerOnly' => true, 'message' => 'Значение должно быть целым числом', 'tooSmall' => 'Значение должно быть не меньше 0', 'tooBig' => 'Значение должно быть не больше 100']);
                                if (!$validator->validate($model->value, $error)) {
                                    $model->addError('value', $error);
                                    $valid = false;
                                }
                                break;
                            case 'pre_sale':
                                $validator = Validator::createValidator('number', $model, ['value'], ['min' => 0, 'max' => 750000, 'integerOnly' => true, 'message' => 'Значение должно быть целым числом', 'tooSmall' => 'Значение должно быть не меньше 0', 'tooBig' => 'Значение должно быть не больше 750000']);
                                if (!$validator->validate($model->value, $error)) {
                                    $model->addError('value', $error);
                                    $valid = false;
                                }
                                break;
                        }
                    }
                }

                if ($valid) {
                    foreach ($models as $model) {
                        $model->save(false);
                    }

                    Yii::$app->session->setFlash('flash-admin-message-success', 'Настройки сохранены');

                    $this->refresh();
                }
            }


            return $this->render('settings', [
                'models' => $models,
            ]);
        }
    }
}
