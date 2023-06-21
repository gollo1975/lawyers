<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FormTipoReciboCuentaNuevo extends Model
{
    public $nombre;
    public $cuenta;

    public function rules()
    {
        return [
            ['nombre', 'match', 'pattern' => '/^[a-z0-9\s]+$/i', 'message' => 'Sólo se aceptan números y letras'],            
            ['cuenta', 'match', 'pattern' => '/^[a-z0-9\s]+$/i', 'message' => 'Sólo se aceptan números y letras'],            
        ];
    }

    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre Cuenta:', 
            'cuenta' => 'N° Cuenta:', 
        ];
    }
}
