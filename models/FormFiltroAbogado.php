<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FormFiltroAbogado extends Model
{
    public $documento;
    public $nombrecompleto;

    public function rules()
    {
        return [

            ['documento', 'match', 'pattern' => '/^[0-9\s]+$/i', 'message' => 'Sólo se aceptan números'],
            ['nombrecompleto', 'match', 'pattern' => '/^[a-z\s]+$/i', 'message' => 'Sólo se aceptan letras'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'documento' => 'Documento:',
            'nombrecompleto' => 'Nombre abogados:',
        ];
    }
}
