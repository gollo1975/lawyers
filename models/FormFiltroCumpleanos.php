<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FormFiltroCumpleanos extends Model
{
    public $mes;

    public function rules()
    {
        return [

            ['mes', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'mes' => 'Mes:',
            
        ];
    }
}
