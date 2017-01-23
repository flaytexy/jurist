<?php
namespace frontend\widgets;

use frontend\modules\seo\models\Seo;
use Yii;
use yii\base\Widget;



class ScriptsFooter extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        //$this->view->registerAssetBundle(FancyboxAsset::className());
        //$this->view->registerJs('$("'.$this->selector.'").fancybox('.$clientOptions.');');
        $model = Seo::findOne(1);
        if($model){
            echo $this->render('scripts_footer', [
                'scripts_footer' => $model->scripts_footer
            ]);
        }
    }

}