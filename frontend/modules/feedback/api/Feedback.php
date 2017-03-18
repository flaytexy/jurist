<?php
namespace frontend\modules\feedback\api;

use Yii;
use frontend\modules\feedback\models\Feedback as FeedbackModel;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\widgets\ReCaptcha;


/**
 * Feedback module API
 * @package frontend\modules\feedback\api
 *
 * @method static string form(array $options = []) Returns fully worked standalone html form.
 * @method static array save(array $attributes) If you using your own form, this function will be useful for manual saving feedback's.
 */

class Feedback extends \frontend\components\API
{
    const SENT_VAR = 'feedback_sent';

    private $_defaultFormOptions = [
        'errorUrl' => '',
        'successUrl' => ''
    ];

    public function api_form($options = [])
    {
        $model = new FeedbackModel;
        $settings = Yii::$app->getModule('admin')->activeModules['feedback']->settings;
        $options = array_merge($this->_defaultFormOptions, $options);

        ob_start();
        $form = ActiveForm::begin([
            'enableClientValidation' => true,
            'action' => Url::to(['/admin/feedback/send'])
        ]);

        echo Html::hiddenInput('errorUrl', $options['errorUrl'] ? $options['errorUrl'] : Url::current([self::SENT_VAR => 0]));
        echo Html::hiddenInput('successUrl', $options['successUrl'] ? $options['successUrl'] : Url::current([self::SENT_VAR => 1]));

        echo Html::beginTag('div',['class'=>'row']);
        echo Html::beginTag('div',['class'=>'col-md-4']);
        //echo $form->field($model, 'name');
        echo $form->field($model, 'name')->textInput(['placeholder' => Yii::t('easyii', 'Name')])->label(false);
        echo Html::endTag('div');

        echo Html::beginTag('div',['class'=>'col-md-4']);
        //echo $form->field($model, 'email')->input('email');
        echo $form->field($model, 'name')->textInput(['placeholder' => Yii::t('easyii', 'E-mail')])->label(false);
        echo Html::endTag('div');

        if($settings['enablePhone']){
            echo Html::beginTag('div',['class'=>'col-md-4']);
            //echo $form->field($model, 'phone');
            echo $form->field($model, 'name')->textInput(['placeholder' => Yii::t('easyii', 'Phone')])->label(false);
            echo Html::endTag('div');
        }
        if($settings['enableTitle']){
            echo Html::beginTag('div',['class'=>'col-md-4']);
            echo $form->field($model, 'title')->textInput(['placeholder' => Yii::t('easyii', 'Title')])->label(false);
            echo Html::endTag('div');
        }

        echo Html::beginTag('div',['class'=>'col-md-12']);
        echo $form->field($model, 'text')->textarea(['placeholder' => $model->getAttributeLabel( 'text' ), 'rows'=>4 ])->label(false);
        echo Html::endTag('div');

        echo Html::endTag('div');

        if($settings['enableCaptcha']) echo $form->field($model, 'reCaptcha')->widget(ReCaptcha::className());

        echo Html::submitButton(Yii::t('easyii', 'Send'), ['class' => 'btn btn-primary center-block']);
        ActiveForm::end();

        return ob_get_clean();
    }

    public function api_form_vertical($options = [])
    {
        $model = new FeedbackModel;
        $settings = Yii::$app->getModule('admin')->activeModules['feedback']->settings;
        $options = array_merge($this->_defaultFormOptions, $options);

        ob_start();
        $form = ActiveForm::begin([
            'enableClientValidation' => true,
            'action' => Url::to(['/admin/feedback/send'])
        ]);

        echo Html::hiddenInput('errorUrl', $options['errorUrl'] ? $options['errorUrl'] : Url::current([self::SENT_VAR => 0]));
        echo Html::hiddenInput('successUrl', $options['successUrl'] ? $options['successUrl'] : Url::current([self::SENT_VAR => 1]));

        echo $form->field($model, 'name');
        echo $form->field($model, 'email')->input('email');

        if($settings['enablePhone']) echo $form->field($model, 'phone');
        if($settings['enableTitle']) echo $form->field($model, 'title');

        echo $form->field($model, 'text')->textarea();

        if($settings['enableCaptcha']) echo $form->field($model, 'reCaptcha')->widget(ReCaptcha::className());

        echo Html::submitButton(Yii::t('easyii', 'Send'), ['class' => 'btn btn-primary']);
        ActiveForm::end();

        return ob_get_clean();
    }

    public function api_save($data)
    {
        $model = new FeedbackModel($data);
        if($model->save()){
            return ['result' => 'success'];
        } else {
            return ['result' => 'error', 'error' => $model->getErrors()];
        }
    }
}