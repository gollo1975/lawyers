<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FormFiltroCliente extends Model
{
    public $cedulanit;
    public $nombre_completo;

    public function rules()
    {
        return [

            ['cedulanit', 'match', 'pattern' => '/^[0-9\s]+$/i', 'message' => 'Sólo se aceptan números'],
            ['nombre_completo', 'match', 'pattern' => '/^[a-z\s]+$/i', 'message' => 'Sólo se aceptan letras'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'cedulanit' => 'Nit / Cedula:',
            'nombre_completo' => 'Cliente:',
        ];
    }
}
