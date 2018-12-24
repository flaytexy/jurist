<?php
/**
 * Created by IntelliJ IDEA.
 * User: Dangel
 * Date: 21.09.2018
 * Time: 16:05
 */

namespace frontend\widgets;
use yii\base\Widget;


class TopBanks extends Widget
{

    public $banks;
    public $bankNum;

    public function run (){
        return $this->render('TopBanks',array('banks'=>$this->banks, 'bankNum'=>$this->bankNum));
    }
}