<?php
namespace common\components;

use frontend\helpers\Mail;
use Yii;
use frontend\models\Setting;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * Base API component. Used by all modules
 * @package frontend\components
 */
class API extends \yii\base\Object
{
    /** @var  array */
    static $classes;
    /** @var  string module name */
    public $module;

    public function init()
    {
        parent::init();

        $this->module = Module::getModuleName(self::className());
        Module::registerTranslations($this->module);
    }

    public static function __callStatic($method, $params)
    {
        $name = (new \ReflectionClass(self::className()))->getShortName();
        if (!isset(self::$classes[$name])) {
            self::$classes[$name] = new static();
        }
        return call_user_func_array([self::$classes[$name], 'api_' . $method], $params);
    }

    /**
     * Wrap text with liveEdit tags, which later will fetched by jquery widget
     * @param $text
     * @param $path
     * @param string $tag
     * @return string
     */
    public static  function liveEdit($text, $path, $tag = 'span')
    {
        return $text ? '<'.$tag.' class="easyiicms-edit" data-edit="'.$path.'">'.$text.'</'.$tag.'>' : '';
    }

    public function mailApi($errorMessage = ''){
//        return Mail::send(
//            Setting::get('admin_email'),
//            'Рапорт об ошибке',
//            false,
//            ['orders' => $this, 'link' => Url::to(['/admin/orders/a/view', 'id' => $this->primaryKey], true)]
//        );

          try {
              $mail =  Yii::$app->mailer->compose()
                  ->setFrom(Setting::get('robot_email'))
                  //->setFrom('itc@iq-offshore.com')
                  ->setTo('akvamiris@gmail.com')
                  ->setSubject('Рапорт об ошибке')
                  ->setHtmlBody('
                <h1>'.$errorMessage.'</h1>
                <b>404: ' . Url::base('https') . Yii::$app->request->url . '</b><br />
                <span>Referrer: ' . Yii::$app->request->referrer . '</span><br />
                <span>IP: ' . Yii::$app->request->remoteIP . '</span><br />
            ')//Url::to()
                  //->setReplyTo(Setting::get('admin_email'))
                  ->send();
          } catch (\Exception $e) {
             //throw new NotFoundHttpException($e->getMessage());
          }

        return ;
    }
}
