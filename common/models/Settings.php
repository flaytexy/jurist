<?php

namespace common\models;

use Yii;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "settings".
 *
 * @property int $id
 * @property string $key
 * @property string $title
 * @property string $value
 *
 * @method get
 * @method set
 */
class Settings extends ActiveRecord
{
    /**
     * @param bool $forDropDown if false - return array or validators, true - key=>value for dropDown
     * @return array
     */
    public function getTypes($forDropDown = true)
    {
        $values = [
            'string' => ['value', 'string'],
            'integer' => ['value', 'integer'],
            'boolean' => ['value', 'boolean', 'trueValue' => "1", 'falseValue' => "0", 'strict' => true],
            'float' => ['value', 'number'],
            'email' => ['value', 'email'],
            'ip' => ['value', 'ip'],
            'url' => ['value', 'url'],
            'object' => [
                'value',
                function ($attribute, $params) {
                    $object = null;
                    try {
                        Json::decode($this->$attribute);
                    } catch (InvalidParamException $e) {
                        $this->addError($attribute, '"{attribute}" must be a valid JSON object');
                    }
                }
            ],
        ];

        if (!$forDropDown) {
            return $values;
        }

        $return = [];
        foreach ($values as $key => $value) {
            $return[$key] = $key;
        }

        return $return;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'value_en', 'value_ua'], 'string'],
            //[['key', 'title', 'value'], 'required', 'message' => 'Необходимо заполнить'],
            //[['section', 'key'], 'string', 'max' => 255],
            [
                ['key'],
                'unique',
                'targetAttribute' => ['section', 'key'],
                'message' =>
                    '{attribute} "{value}" already exists for this section.'
            ],
            //['type', 'in', 'range' => array_keys($this->getTypes(false))],
            //[['created', 'modified'], 'safe'],
            //[['active'], 'boolean'],
        ];
    }

    public function beforeSave($insert)
    {
//        $validators = $this->getTypes(false);
//        if (!array_key_exists($this->type, $validators)) {
//            $this->addError('type', 'Please select correct type');
//            return false;
//        }
//
//        $model = DynamicModel::validateData([
//            'value' => $this->value
//        ], [
//            $validators[$this->type],
//        ]);
//
//        if ($model->hasErrors()) {
//            $this->addError('value', $model->getFirstError('value'));
//            return false;
//        }
//
//        if ($this->hasErrors()) {
//            return false;
//        }

        return parent::beforeSave($insert);
    }

    public function generateAttributeLabel($name)
    {
        return $this->title ?: parent::generateAttributeLabel($name);
    }
}
