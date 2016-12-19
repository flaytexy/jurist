<?php
namespace frontend\widgets;

use dosamigos\selectize\SelectizeTextInput;

class OptionsInput extends SelectizeTextInput
{
    public $options = ['class' => 'form-control'];
    public $loadUrl = ['/admin/options/list'];
    public $clientOptions = [
        'plugins' => ['remove_button'],
        'valueField' => 'name',
        'labelField' => 'name',
        'searchField' => ['name'],
        'create' => true,
    ];
}